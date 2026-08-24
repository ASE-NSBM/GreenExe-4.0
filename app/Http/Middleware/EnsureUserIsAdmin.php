<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Restrict dashboard access using authentication and authorization (FR-71).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->isAdmin()) {
            abort(403, 'You are not authorised to access the GreenExE administration area.');
        }

        return $next($request);
    }
}
