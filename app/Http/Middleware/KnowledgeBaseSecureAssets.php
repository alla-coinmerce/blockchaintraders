<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KnowledgeBaseSecureAssets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check())
        {
            abort(403);
        }

        /** @var \App\Models\User */
        $user = Auth::user();
        if(! ($user->isAdmin() || $user->isKnowledgeBaseSubscriber()))
        {
            abort(403);
        }

        return $next($request);
    }
}
