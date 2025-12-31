<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService; // Dependency injection
    }
    
    public function showLoginForm()
    {  
        if (session('authenticated')) {
        // Redirect to dashboard if already logged in
        return redirect()->route('dashboard');
    }
        return view('auth.admin-login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'device_token' => 'nullable|string'
        ]);
       //print_r($request->all()); die;
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

       try {
    $loginResponse = $this->apiAuthService->login($request->username, $request->password, $request->device_token);

    // Check if login was successful
    if (isset($loginResponse['success']) && $loginResponse['success']) {


        $userData = $loginResponse['data'] ?? null;
        $topic= 'company_'.$userData['company_uuid'].'_'.$userData['role'];
        // $firbaseResponse = $this->apiAuthService->subscribeToTopic($topic,$request->device_token);
        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: No user data received.'
            ], 401);
        }

        // Store in session
        session([
            'external_user'   => $userData,
            'authenticated'   => true,
            'login_time'      => now()
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Login successful',
            'data'        => $userData,
            'redirect_url'=> '/dashboard'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Login failed',
            'error'   => $loginResponse['message'] ?? 'Unknown error'
        ], 401);
    }
} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Login error: ' . $e->getMessage()
    ], 500);
}
    }

     public function logout()
    {
        session()->forget(['external_user', 'authenticated']);
        session()->flush();
        
        return redirect()->route('login');
    }

      public function showForgotpassword()
    {
        return view('auth.admin-forgotpassword');
    }

       public function Forgotpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string'
        ]);
       //print_r($request->all()); die;
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

       try {
    $Response = $this->apiAuthService->requestotp($request->email);

    // Check if login was successful
    if (isset($Response['success']) && $Response['success']) {

        $Data = $Response['data'] ?? null;

        if (!$Data) {
            return response()->json([
                'success' => false,
                'message' => 'Request failed: No user data received.'
            ], 401);
        }

        

         // Store in session with expiration (10 minutes)
                session([
                    'otp_details' => $Data,
                    'requested' => true,
                    'otp_email' => $request->email,
                    'sent_time' => now(),
                    'otp_attempts' => 0 // Track OTP verification attempts
                ]);


        return response()->json([
            'success'     => true,
            'message'     => 'Otp Sent successful',
            'data'        => $Data,
            'redirect_url'=> '/verify-otp'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => $Response['message'],
            'error'   => $Response['message'] ?? 'Unknown error'
        ], 401);
    }
} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Otp sent error: ' . $e->getMessage()
    ], 500);
}
    }

     public function showVerfiyotp()
    {
        $email = session('otp_email');
        return view('auth.admin-verifyotp', compact('email'));
    }

   /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6' // Assuming 6-digit OTP
        ]);
       //print_r($request->all()); die;
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

         // Check if OTP was requested for this email
        if (session('otp_email') !== $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Please request OTP for this email first.'
            ], 403);
        }

        // Check OTP attempts to prevent brute force
        $attempts = session('otp_attempts', 0);
        if ($attempts >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Too many OTP attempts. Please request a new OTP.'
            ], 429);
        }

       try {
    $Response = $this->apiAuthService->verifyotp($request->email, $request->otp);
       
    // Increment attempts
            session(['otp_attempts' => $attempts + 1]);
    // Check if login was successful
    if (isset($Response['success']) && $Response['success']) {

        $Data = $Response['data'] ?? null;

      

        // Store in session
        session([
                    'otp_verified' => true,
                    'reset_token' => Str::random(32),
                    'verified_email' => $request->email,
                    'otp_verified_time' => now()
                ]);
         
                 // Clear OTP attempts
                session()->forget('otp_attempts');

       return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'redirect_url' => route('reset.password')
                ]);
    } else {
         $attemptsLeft = 5 - ($attempts + 1);
        return response()->json([
            'success' => false,
            'message' => $Response['message'],
            'attempts_left' => $attemptsLeft,
            'error'   => $Response['message'] ?? 'Unknown error'
        ], 401);
    }
} catch (\Exception $e) {
    return response()->json([
                'success' => false,
                'message' => 'OTP verification error: ' . $e->getMessage()
            ], 500); 
}
       }

       /**
     * Show reset password page (protected)
     */
    public function showResetPassword()
    {
        if (!session('otp_verified')) {
            return redirect()->route('forgot-password')->with('error', 'Please verify OTP first.');
        }
        
        $email = session('verified_email');
        return view('auth.admin-reset-password', compact('email'));
    }

     /**
     * Reset password after OTP verification
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if OTP was verified
        if (!session('otp_verified')) {
            return response()->json([
                'success' => false,
                'message' => 'OTP verification required.'
            ], 403);
        }

        try {
             $email = session('verified_email');
            $resetToken = session('reset_token');
              
             $resetResponse = $this->apiAuthService->resetpassword($email, $request->password, $request->password_confirmation, $request->otp);
          
           if (isset($resetResponse['success']) && $resetResponse['success']) {
                
                 $responseData  = $resetResponse['data'] ?? null;
                // Clear all reset-related session data
                session()->forget([
                    'otp_details', 'requested', 'otp_email', 'sent_time',
                    'otp_attempts', 'otp_verified', 'reset_token', 'verified_email'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully',
                    'data' => $responseData,
                    'redirect_url' => '/login'
                ]);
                
            } else {
               
                return response()->json([
                    'success' => false,
                    'message' => $resetResponse['message'] ?? 'Failed to reset password',
                    'error' => $resetResponse['message'] ?? 'Unknown error'
                ], 400);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password reset error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $email = session('otp_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'No email found in session. Please request OTP again.'
            ], 400);
        }
        
        // Reuse the forgotPassword logic
        $request->merge(['email' => $email]);
        return $this->forgotPassword($request);
    }
}

