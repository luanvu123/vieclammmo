<?php
// app/Http/Middleware/Require2FA.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Require2FA
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $user = Auth::guard($guard)->user();

        if ($user && $user->is2Fa && !$request->session()->has('2fa_verified')) {
            // Chuyển hướng đến trang xác thực 2FA
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
