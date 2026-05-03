<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureEmployerVerified
 *
 * Redirects employer users to the pending page if their account
 * has not been verified yet. Attach to any employer route that
 * requires a fully active account.
 *
 * Usage in web.php:
 *   ->middleware(['auth', 'employer.verified'])
 *
 * Or register in bootstrap/app.php (Laravel 11):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['employer.verified' => EnsureEmployerVerified::class]);
 *   })
 *
 * Or in Kernel.php (Laravel 10):
 *   protected $middlewareAliases = [
 *       'employer.verified' => \App\Http\Middleware\EnsureEmployerVerified::class,
 *   ];
 */
class EnsureEmployerVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Only apply logic to employer-role users
        if ($user->role !== 'employer') {
            return $next($request);
        }

        $employer = $user->employer;

        // No employer profile → send to register
        if (! $employer) {
            return redirect()->route('employer.register')
                ->with('info', 'Please complete your employer registration.');
        }

        // Suspended
        if ($employer->isSuspended()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your employer account has been suspended. Contact support.');
        }

        // Pending — allow access to pending page only
        if ($employer->isPending()) {
            $allowedRoutes = ['employer.pending', 'logout'];

            if (! in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('employer.pending')
                    ->with('info', 'Your account is pending verification.');
            }
        }

        return $next($request);
    }
}