<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login — resolved per role.
     */
    protected function redirectTo(): string
    {
        return match (auth()->user()->role) {
            'employee'   => route('employee.dashboard'),
            'employer'   => route('employer.dashboard'),
            'government' => route('gov.dashboard'),
            'admin'      => route('admin.dashboard'),
            default      => '/',
        };
    }

    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }
}