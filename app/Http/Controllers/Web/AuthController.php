<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
   

    public function __construct()
    {
       
    }

   public function showLoginForm()
{
    // If user is already logged in, redirect to dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.admin-login');
}


      public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user=Auth::user();
           
           if (!$user->role || $user->role->name !== 'admin') {
            Auth::logout();

            return response()->json([
                'success' => false,
                'message' => 'You do not have admin privileges.'
            ], 403);
        }
            // Optional: save device token in session or database
            if ($request->filled('device_token')) {
                session(['device_token' => $request->device_token]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect_url' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function showForgotPassword()
{
    return view('auth.admin-forgotpassword');
}
   
    public function Forgotpassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    // Only admin users
    if (!$user->role || $user->role->name !== 'admin') {
        return response()->json([
            'success' => false,
            'message' => 'You do not have admin privileges.'
        ], 403);
    }

    // Generate 6-digit OTP
    $otp = rand(100000, 999999);

    // Save OTP and expiration
    $user->otp = $otp;
    $user->otp_expires_at = Carbon::now()->addMinutes(10);
    $user->save();

    //  REQUIRED SESSION DATA
    session([
        'requested'    => true,
        'otp_email'    => $user->email,
        'sent_time'    => now(),
        'otp_attempts' => 0
    ]);

    // Send OTP email
    Mail::raw("Your OTP is: $otp. It expires in 10 minutes.", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Admin Password Reset OTP');
    });

    return response()->json([
        'success' => true,
        'message' => 'OTP sent successfully',
        'redirect_url' => route('verify-otp',['email'=>$user->email]),
    ]);
}


public function showVerifyOtp(Request $request)
{
    $email = $request->query('email');
    return view('auth.admin-verifyotp', compact('email'));
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|digits:6'
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user->otp || $user->otp !== $request->otp) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.'
        ], 400);
    }

    if (Carbon::now()->gt($user->otp_expires_at)) {
        return response()->json([
            'success' => false,
            'message' => 'OTP has expired.'
        ], 400);
    }

    // OTP is valid, create a reset session token
    session([
        'otp_verified' => true,
        'verified_email' => $user->email
    ]);

    return response()->json([
        'success' => true,
        'message' => 'OTP verified successfully',
        'redirect_url' => route('reset.password')
    ]);
}

public function showResetPassword()
{
    if (!session('otp_verified') || !session('verified_email')) {
        return redirect()
            ->route('forgot-password')
            ->with('error', 'Please verify OTP first.');
    }

    $email = session('verified_email');
    return view('auth.admin-reset-password', compact('email'));
}

 public function resetPassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:4|confirmed',
        'password_confirmation' => 'required',
    ]);

    if (!session('otp_verified') || !session('verified_email')) {
        return response()->json([
            'success' => false,
            'message' => 'OTP verification required.'
        ], 403);
    }

    $user = \App\Models\User::where('email', session('verified_email'))->first();
    $user->password = bcrypt($request->password);

    // Clear OTP fields
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();

    // Clear session
    session()->forget(['otp_verified', 'verified_email']);

    return response()->json([
        'success' => true,
        'message' => 'Password reset successfully',
        'redirect_url' => route('login')
    ]);
}



    public function logout(Request $request)
    {
        Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
    }
}
