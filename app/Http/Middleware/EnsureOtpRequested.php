<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class EnsureOtpRequested
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if OTP was requested
        if (!session('requested') || !session('otp_email')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please request OTP first.'
                ], 403);
            }

            return redirect()
                ->route('forgot-password')
                ->with('error', 'Please request OTP first.');
        }

        // Check OTP expiry (10 minutes)
        $sentTime = session('sent_time');

        if ($sentTime && Carbon::parse($sentTime)->diffInMinutes(now()) > 10) {
            session()->forget([
                'requested',
                'sent_time',
                'otp_email',
                'otp_attempts'
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new one.'
                ], 403);
            }

            return redirect()
                ->route('forgot-password')
                ->with('error', 'OTP has expired. Please request a new one.');
        }

        return $next($request);
    }
}
