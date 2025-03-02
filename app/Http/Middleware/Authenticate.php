<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = ['web'];
        }

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::shouldUse($guard);
            }
        }

        throw new \Illuminate\Auth\AuthenticationException();
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('customer/*')) {
                return route('login.customer'); // Định tuyến riêng cho khách hàng
            }
            return route('login');
        }
    }
}
