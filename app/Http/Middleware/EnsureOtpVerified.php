<?php 
// app/Http/Middleware/EnsureOtpVerified.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('otp_verified') || !session('verified_email')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP verification required.'
                ], 403);
            }

            return redirect()
                ->route('forgot-password')
                ->with('error', 'OTP verification required.');
        }

        return $next($request);
    }
}

?>