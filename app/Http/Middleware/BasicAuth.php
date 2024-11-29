<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( ('staging' === App::environment()) &&
            (empty(session('basic_authenticated'))) )
        {
            if( ('tester' === $request->getUser()) &&
                ('b10ckch@intr@d3rs' === $request->getPassword()) )
            {
                $request->session()->put('basic_authenticated', time());

                return $next($request);
            }

            $headers = array('WWW-Authenticate' => 'Basic');
            return Response::make('Invalid credentials.', 401, $headers);
        }

        return $next($request);
    }
}
