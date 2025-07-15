<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class NotAdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user doesn't have Administrator role
        if (Auth::check() && Auth::user()->role !== 'Administrator') {
            Alert::warning('Akses Ditolak', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            return redirect()->back()->with('warning', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        return $next($request);
    }
}
