<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExternalAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated via external API session
        if (!session('authenticated')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login again.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        // Optional: Verify session is still valid with external API
        if (!$this->validateExternalSession()) {
            session()->forget(['external_user', 'authenticated']);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Session expired.');
        }
        
        return $next($request);
    }
    
    /**
     * Validate session with external API (optional)
     */
    private function validateExternalSession()
    {
        // You can call external API to validate token if needed
        // For now, we'll just check session expiration
        return session('authenticated') && session('login_time') > now()->subHours(8);
    }
}
