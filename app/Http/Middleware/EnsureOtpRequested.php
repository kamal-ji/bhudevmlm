<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpRequested
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Check if OTP was requested and stored in session
        if (!session('requested')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please request OTP first.'
                ], 403);
            }
            
            return redirect()->route('forgot-password')->with('error', 'Please request OTP first.');
        }
        
        // Optional: Check if OTP is still valid (e.g., within 10 minutes)
        $sentTime = session('sent_time');
        if ($sentTime && $sentTime->diffInMinutes(now()) > 10) {
            session()->forget(['requested', 'sent_time']);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new one.'
                ], 403);
            }
            
            return redirect()->route('forgot-password')->with('error', 'OTP has expired. Please request a new one.');
        }
        
        return $next($request);
    }
    }

