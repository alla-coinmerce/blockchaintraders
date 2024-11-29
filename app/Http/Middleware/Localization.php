<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $forcedLanguage = null): Response
    {
        if($forcedLanguage)
        {
            Session::put('locale', $forcedLanguage);
        }
        elseif(!Session::has('locale'))
        {
            $language = 'nl';

            try
            {
                $language = $request->getPreferredLanguage(config('app.available_locales'));
            }
            catch(\Exception $e)
            {
                // Log::debug('getPreferredLanguage Exception: '.$e->getMessage());
            }

            Session::put('locale', $language);
        }

        App::setLocale(Session::get('locale'));

        return $next($request);
    }
}
