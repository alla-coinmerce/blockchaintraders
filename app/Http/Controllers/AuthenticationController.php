<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\PasswordResetLinkRequest;
use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\StorePasswordResetRequest;
use App\Models\User;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laragear\TwoFactor\Facades\Auth2FA;

class AuthenticationController extends Controller
{
    /**
     * Verifies the set password link and shows the set password form if okay
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function verifyAccount(Request $request, User $user)
    {
        if(!$request->hasValidSignature())
        {
            // The welcome link does not have a valid signature or is expired
            return view('auth.set-password-expired', [
                'user' => $user,
                'hash' => $request->hash,
                'newSetPasswordLinkRoute' => $user->isAdmin() ? 
                    route('admin.newSetPasswordLink', ['user' => $user]) :
                    route('newSetPasswordLink', ['user' => $user])
            ]);
        }

        if(!$user)
        {
            abort(401, 'Could not find a user to be welcomed.');
        }

        if(!hash_equals((string) $request->hash, sha1($user->getEmailForVerification())))
        {
            abort(401, 'Request not valid.');
        }

        if(is_null($user->welcome_valid_until))
        {
            return view('auth.account-already-activated');
        }

        // dd(Carbon::createFromTimestamp($user->welcome_valid_until), $user->welcome_valid_until);
        if(Carbon::create($user->welcome_valid_until)->isPast())
        {
            // The welcome link is expired
            return view('auth.set-password-expired', [
                'user' => $user,
                'hash' => $request->hash,
                'newSetPasswordLinkRoute' => $user->isAdmin() ? 
                    route('admin.newSetPasswordLink', ['user' => $user]) :
                    route('newSetPasswordLink', ['user' => $user])
            ]);
        }

        if(! $user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return view('auth.set-password', [
            'user' => $user,
            'hash' => $request->hash,
            'setPasswordRoute' => $user->isAdmin() ? 
                route('admin.setPassword', ['user' => $user]) :
                route('setPassword', ['user' => $user])
        ]);
    }

    /**
     * Send a new password link if the request is valid
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function sendNewSetPassWordLink(Request $request, User $user)
    {
        // dd($request->hash, sha1($user->getEmailForVerification()), $user->getEmailForVerification());
        if(!hash_equals((string) $request->hash, sha1($user->getEmailForVerification())))
        {
            return back()->with('status', 'Ongeldig verzoek. Neem contact op.');
        }

        $user->sendWelcomeNotification();

        return back()->with('status', 'Een nieuwe link is verstuurd.');
    }

    /**
     * Sets the users initial password and redirects to the login page
     * 
     * @param \App\Http\Requests\StorePasswordRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function setPassword(StorePasswordRequest $request, User $user)
    {
        if(strtolower($request->email) !== strtolower($user->email))
        {
            return back()->withErrors([
                'email' => 'De verstrekte gegevens komen niet overeen met onze gegevens.'
            ]);
        }

        $user->welcome_valid_until = null;
        $user->password = Hash::make($request->password);
        $user->last_login = Carbon::now();

        $user->save();

        // Login and go to dashboard
        Auth::login($user);
        $request->session()->regenerate();
 
        return redirect('/');
    }

    /**
     * Handle an authentication attempt.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = Array();

        // If the user is trying for the first time, ensure both email and the password are
        // required to log in. If it's not, then he would issue its 2FA code. This ensures
        // the credentials are not required again when is just issuing his 2FA code alone.
        if($request->isNotFilled('2fa_code'))
        {
            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'remember' => ['boolean', 'nullable']
            ]);

            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'active' => true
            ];
        }

        $remember = isset($validated['remember']) ? $validated['remember'] : false;

        $attempt = Auth2FA::attempt($credentials, $remember);
 
        if($attempt)
        {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'De verstrekte inloggegevens komen niet overeen met onze gegevens.',
        ])->onlyInput('email');
    }

    /**
     * Handle an authentication attempt.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function adminAuthenticate(Request $request): RedirectResponse
    {
        $credentials = Array();
        
        // If the user is trying for the first time, ensure both email and the password are
        // required to log in. If it's not, then he would issue its 2FA code. This ensures
        // the credentials are not required again when is just issuing his 2FA code alone.
        if($request->isNotFilled('2fa_code'))
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
        }

        $attempt = Auth2FA::attempt($credentials + ['active' => true, 'role' => Role::ADMIN->value]);
 
        if($attempt)
        {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'De verstrekte inloggegevens komen niet overeen met onze gegevens.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }

    /**
     * Verify email
     * 
     * @param \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill(); 
 
        return redirect('/');
    }

    /**
     * Verify email
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('status', 'verification-link-sent');
    }

    /**
     * Send a reset password link if the user exists
     * 
     * @param  \App\Http\Requests\PasswordResetLinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function sendPasswordResetLink(PasswordResetLinkRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email') + ['active' => true]
        );

        return back()->with('status', 'Indien het e-mailadres bij ons bekend is is er een nieuwe link is verstuurd.');
    }

    /**
     * Send a reset password link if the user exists
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showPasswordResetView(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token]);
    }

    /**
     * Resets the user's password
     * 
     * @param \App\Http\Requests\StorePasswordResetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(StorePasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
