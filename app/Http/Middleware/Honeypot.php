<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class Honeypot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next)
    {
        if (! $request->isMethod('POST')) {
            return $next($request);
        }

        $this->logRequestData();

        $post = $request->all();

        if(! isset($post['allow-contact-by-mobile-phone']))
        {
            Log::warning('Honeypot: field allow-contact-by-mobile-phone not set');

            return back()->withErrors([
                'allow-contact-by-mobile-phone' => __("Registration failed. Please refresh the page and try again. If the error keeps occuring please contact us.")
            ]);
        }

        if(! isset($post['keep-informed-about-updates']))
        {
            Log::warning('Honeypot: field keep-informed-about-updates not set');

            return back()->withErrors([
                'keep-informed-about-updates' => __("Registration failed. Please refresh the page and try again. If the error keeps occuring please contact us.")
            ]);
        }

        $spamScore = 0;

        if('no' !== $post['allow-contact-by-mobile-phone'])
        {
            Log::warning('Honeypot: field allow-contact-by-mobile-phone spoofed. Value: '.$post['allow-contact-by-mobile-phone']);

            $spamScore++;
        }

        if('yes' !== $post['keep-informed-about-updates'])
        {
            Log::warning('Honeypot: field keep-informed-about-updates spoofed. Value: '.$post['keep-informed-about-updates']);

            $spamScore++;
        }

        if($spamScore > 1)
        {
            return back()->withErrors([
                'keep-informed-about-updates' => __("Registration failed. Please refresh the page and try again. If the error keeps occuring please contact us.")
            ]);
        }

        return $next($request);
    }

    private function logRequestData()
    {
        $postedData = request()->all();

        Log::info("URL: ".URL::full());

        Log::info("Posted data:");

        $excludedKeys = [
            '_token',
            'allow-contact-by-mobile-phone',
            'keep-informed-about-updates'
        ];
        
        foreach($postedData as $key => $value)
        {
            if(!in_array($key, $excludedKeys))
            {
                Log::info($key.": ".$value);
            }
        }
    }
}
