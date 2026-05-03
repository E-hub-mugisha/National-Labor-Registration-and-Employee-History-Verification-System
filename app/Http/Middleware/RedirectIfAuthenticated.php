<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->homeForRole(Auth::guard($guard)->user()->role));
            }
        }

        return $next($request);
    }

    private function homeForRole(?string $role): string
    {
        return match ($role) {
            'employee'   => route('employee.dashboard'),
            'employer'   => route('employer.dashboard'),
            'government' => route('gov.dashboard'),
            'admin'      => route('admin.dashboard'),
            default      => '/',
        };
    }
}
