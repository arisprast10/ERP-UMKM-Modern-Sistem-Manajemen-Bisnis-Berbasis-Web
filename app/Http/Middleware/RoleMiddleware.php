<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        if (!$user->active) {
            auth()->logout();
            return redirect('/login')->with('error', 'Akun Anda nonaktif.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if (!in_array($user->role->slug, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
