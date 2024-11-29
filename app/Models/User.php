<?php

namespace App\Models;

use App\Enums\Role;
use App\Notifications\AdminWelcomeNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;
use Laragear\TwoFactor\TwoFactorAuthentication;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Order\Contracts\ProvidesInvoiceInformation;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword, TwoFactorAuthenticatable, HasLocalePreference, ProvidesInvoiceInformation
{
    use HasFactory, Notifiable, PasswordsCanResetPassword, TwoFactorAuthentication, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'firstname',
        'lastname',
        'email',
        'password',
        'active',

        'registration_type',
        'company_name',
        'address',
        'zipcode',
        'city',
        'country_code',
        'nationality_code',
        'phone',
        'birthdate',
        'birth_country_code',
        'living_in_netherlands',
        'source_of_income',
        'taxable_countries',
        'bsn',
        'coc_number',
        'bank_account_number',
        'notes',
        'last_login',
        'demo_account'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'demo_account' => false,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => 'integer',
        'welcome_valid_until' => 'datetime',
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'demo_account' => 'boolean'
    ];

    protected static function booted () {
        parent::booted();

        static::updating(function (User $user) {
            if (in_array('email', $user->getChanges()))
            {
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
            }
        });

        static::deleting(function(User $user) { 
            $user->documents()->delete();
            $user->annualFinancialOverviews()->delete();
            $user->participations()->delete();
        });
    }

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        if($this->country_code === 'NL')
        {
            return 'nl';
        }
        else
        {
            return 'en';
        }
    }

    /**
     * Check if the user is an administrator
     * 
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role === Role::ADMIN->value;
    }

    /**
     * Send a welcome notification with a link to setup the password
     */
    public function sendWelcomeNotification()
    {
        if($this->role === Role::ADMIN->value)
        {
            $this->notify(new AdminWelcomeNotification());
        }
        else
        {
            $this->notify(new WelcomeNotification());
        }
    }

    /**
     * Send an email verification notification
     */
    public function sendEmailVerificationNotification()
    {
        $user = User::find($this->id);

        if(! $user->hasVerifiedEmail())
        {
            $user->notify(new VerifyEmail());
        }
    }

    /**
     * Send a password reset notification
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the annualfinancialoverviews for this user.
     */
    public function annualFinancialOverviews()
    {
        return $this->hasMany(AnnualFinancialOverview::class)
            ->orderBy('year', 'desc');
    }

    /**
     * Get the participations for this user.
     */
    public function participations(): MorphMany
    {
        return $this->morphMany(Participation::class, 'participant');
    }

    /**
     * 
     */
    public function getParticipationsQtyForFund(Fund $fund)
    {
        return $this->participations->where('fund_id', $fund->id)->sum('qty');
    }

    /**
     * 
     */
    public function getTotalParticipationValueInEuroCentsForFund(Fund $fund)
    {
        $totalNumberOfParticipations = $this->getParticipationsQtyForFund($fund);

        $lastDayValue = $fund->current_fund_value->value_eurocents;

        return $totalNumberOfParticipations * $lastDayValue;
    }

    /**
     * Check if the user is a participant
     */
    public function isParticipant(): bool
    {
        return ($this->role == Role::PARTICPANT->value) ||
                    ($this->role == Role::BOTH->value);
    }

    /**
     * Check if the user has an active subscription for the knowledge base
     */
    public function isKnowledgeBaseSubscriber(): bool
    {
        return $this->subscribed('knowlegde_base');
    }

    /**
     * Get the participations for this user.
     */
    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithFundParticipations($query, $user_id)
    {
        return $query->with(['funds.participations' => function($query) use ($user_id) {
            $query->orderBy('purchase_date')->where('participant_id', $user_id)->where('participant_type', User::class);
        }]);
    }

    /**
     * The funds that this user is participating in.
     */
    public function funds(): MorphToMany
    {
        return $this->morphToMany(Fund::class, 'participant', 'participations', 'participant_id', 'fund_id')->distinct();
    }

    /**
     * Returns the label for TOTP URI.
     *
     * @return string
     */
    protected function twoFactorLabel(): string
    {
        return config('app.name') . ' - '. $this->getAttribute('email');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function mollieCustomerFields() {
        return [
            'email' => $this->email,
            'name' => $this->firstname.' '.$this->lastname,
        ];
    }

    /**
    * Get the receiver information for the invoice.
    * Typically includes the name and some sort of (E-mail/physical) address.
    *
    * @return array An array of strings
    */
    public function getInvoiceInformation()
    {
        return [
            $this->firstname.' '.$this->lastname,
            $this->email
        ];
    }
    
    /**
    * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
    *
    * @return string|null
    */
    public function getExtraBillingInformation()
    {
        return null;
    }

    public function taxPercentage()
    {
        return 21;
    }
}
