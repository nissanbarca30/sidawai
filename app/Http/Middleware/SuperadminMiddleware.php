<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan HANYA jika role adalah Superadmin
        if (Auth::check() && Auth::user()->isSuperadmin()) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Akses khusus Superadmin.');
    }
}
