<?php
// app/Services/ApiAuthService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Setting; // You can create a model for settings, or just use DB directly
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
class ApiAuthService
{
    private $apiBaseUrl;
    private $apiKey;
    private $appid;
    private $username;
    private $password;
    private $emailid;
    protected $messaging;

    public function __construct()
    {
        // Fetch values from the database
        $this->apiBaseUrl = $this->getSetting('api_base_url');
        $this->apiKey = $this->getSetting('x-apikey');
        $this->appid = $this->getSetting('appid');
        $this->username = $this->getSetting('username');
        $this->password = $this->getSetting('password');
        $this->emailid = $this->getSetting('emailid');

         $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials.file'));

        $this->messaging = $factory->createMessaging();
    }

    // Helper function to fetch the settings from the database
    private function getSetting($key)
    {
        // Assuming you have a Setting model, if not, use DB::table('settings')->where('name', $key)->first()->value;
        $setting = Setting::where('name', $key)->first();
        return $setting ? $setting->value : null;  // Return value or null if not found
    }

    public function generateToken()
    {
        // Return cached token if available
        if (Cache::has('external_api_token')) {
            return Cache::get('external_api_token');
        }

        // Call external API to generate token
        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'text/plain',
            ])
            ->get($this->apiBaseUrl . 'GenerateToken', [
                'appid'    => $this->appid,
                'mailid'   => $this->emailid,
                'username' => $this->username,
                'password' => $this->password,
            ]);

        if ($response->successful()) {
            $data = json_decode($response->body(), true);

            if (isset($data['success']) && $data['success'] === true && isset($data['data']['access_token'])) {
                $token = $data['data']['access_token'];
                $expiresIn = $data['data']['expires_in'] ?? 180;

                // Cache the token slightly less than its expiry
                Cache::put('external_api_token', $token, $expiresIn - 10);

                return $token;
            } else {
                Log::error('Token generation response invalid', ['body' => $response->body()]);
            }
        } else {
            Log::error('Token generation failed', ['response' => $response->body()]);
        }

        return null;
    }


    public function login($username, $password, $deviceToken = null)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'login', [
            'username'     => $username,
            'password'     => $password,
            'device_token' => $deviceToken ?? 'web-' . Str::random(10)
        ]);


        return $response->json();
    }

    public function requestotp($emailid)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'request_otp', [
            'emailid'     => $emailid
        ]);


        return $response->json();
    }

    public function verifyotp($emailid, $otp)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'verify_otp', [
            'emailid' => $emailid,
            'otp' => $otp
        ]);


        return $response->json();
    }

    public function resetpassword($email, $password, $confpassword, $otp)
    {

        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'reset_password', [
            'emailid' => $email,
            'otp' => $otp,
            'password' => $password,
        ]);


        return $response->json();
    }
    
    public function Gethomeclient($requestdata){
      
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'admin_home', $requestdata);
        return $response->json();
    }
    public function Getcustomermaster($companyid)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $companyid; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }
      //echo $this->apiKey;die;
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'customer_master', [
            'companyid'     => $companyid
        ]);


        return $response->json();
    }

   public function Customersave($customerdata)
{
    // Get token from generateToken (uses cache)
    $token = $this->generateToken();
    if (!$token) {
        return null; // Cannot proceed without token
    }

    // Prepare the form data for multipart request
    $formData = [
        'companyid' => $customerdata['companyid'] ?? '',
        'customerid' => $customerdata['customerid'] ?? '',
        'userid' => $customerdata['userid'] ?? '',
        'templateid' => $customerdata['templateid'] ?? '',
        'groupid' => $customerdata['groupid'] ?? '',
        'currencyid' => $customerdata['currencyid'] ?? '',
        'first_name' => $customerdata['first_name'] ?? '',
        'last_name' => $customerdata['last_name'] ?? '',
        'gender' => $customerdata['gender'] ?? '',
        'buildingno' => $customerdata['buildingno'] ?? '',
        'address1' => $customerdata['address1'] ?? '',
        'address2' => $customerdata['address2'] ?? '',
        'zip' => $customerdata['zip'] ?? '',
        'city' => $customerdata['city'] ?? '',
        'countryid' => $customerdata['countryid'] ?? '',
        'regionid' => $customerdata['regionid'] ?? '',
        'email' => $customerdata['email'] ?? '',
        'mobile' => $customerdata['mobile'] ?? '',
        'dob' => $customerdata['dob'] ?? null,
        'anniversary' => $customerdata['anniversary'] ?? null,
        'note' => $customerdata['note'] ?? '',
        'card_no' => $customerdata['card_no'] ?? '',
        'card_issue' => $customerdata['card_issue'] ?? null,
        'card_expiry' => $customerdata['card_expiry'] ?? null,
    ];


    // Perform the API request
    $response = Http::withoutVerifying()->withHeaders([
        'accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'x-apikey' => $this->apiKey
    ])->asMultipart();  // Set as multipart form-data


    // Attach the image if present
    if (!empty($customerdata['image'])) {
        $response->attach('image', file_get_contents($customerdata['image']->getRealPath()), $customerdata['image']->getClientOriginalName());
    }

    $response = $response->post($this->apiBaseUrl . 'add_customer', $formData);

    // Output the response for debugging
    //print_r($response->json()); die;

    return $response->json();
}


    public function Getcustomerlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'customer_list', $requestdata);

      //print_r($response->json()); die;
        return $response->json();
    }
    
     public function Addaddress($requestData)
    {
        $token = $this->generateToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'x-apikey' => $this->apiKey
            ])->post($this->apiBaseUrl . 'add_address', $requestData);

        return $response->json();
    }

    public function Address_list($requestData)
    {
        $token = $this->generateToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'x-apikey' => $this->apiKey
            ])->post($this->apiBaseUrl . 'address_list', $requestData);

        return $response->json();
    }
    public function Getaddress($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'shipping_detail', $requestdata);

        return $response->json();
    }
    public function Getcustomer($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'customer_detail', $requestdata);

        return $response->json();
    }

    public function getClientProfile($id)
    {
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'client_profile', ['userid' => $id]);

        return $response->json();
    }

    public function updateClientProfile($id, $request)
    {
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $formData = [
            'Userid' => $id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'emailid' => $request->emailid,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'zip' => $request->zip,
            'regionid' => $request->regionid,
            'dob' => $request->dob,
            'anniversary' => $request->anniversary,
        ];
       // print_r($formData);die;
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->asMultipart();
        
        if($request->hasFile('image')){
            $response->attach('image', file_get_contents($request->image->getRealPath()),$request->image->getClientOriginalName());
        }   
        
        $response = $response->post($this->apiBaseUrl . 'profile_update', $formData);
        //print_r($response->json()); die;
        return $response->json();
    }

    public function getClientAnal($data){
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'client_analytics', $data);

        return $response->json();
    }


    /* Product Service Methods Start */
        public function Getfilteritems($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'filter_list', $requestdata);

        return $response->json();
    }

     public function Getproductlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'product_list', $requestdata);


        return $response->json();
    }

      public function Getproduct($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'product_detail', $requestdata);


        return $response->json();
    }

    public function Addtocart($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'add_cart', $requestdata);


        return $response->json();
    }   
    
      public function Updatetocart($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'update_cart', $requestdata);


        return $response->json();
    }   

      public function Addtowishlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'add_wishlist', $requestdata);


        return $response->json();
    }   
    
  
    /* Product Service Methods End */

    /* Cart list Service Methods start */

    public function Getcartlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'cart_list', $requestdata);


        return $response->json();
    }

    public function Updatecart($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'update_cart', $requestdata);


       return $response->json();
    }
   
       public function Removecart($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }
    
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'remove_list', $requestdata);


        return $response->json();
    }
      public function Movecart($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }
    
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'move_cart', $requestdata);


        return $response->json();
    }
    /* Cart list Service Methods End */

    /* Wishlist list Service Methods start */

    public function Getwishlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'wish_list', $requestdata);


        return $response->json();
    }

    public function Movewishlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }
    
        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'move_wishlist', $requestdata);


        return $response->json();
    }
       

    /* Wishlist list Service Methods End */

    /*Order list Service Methods Start */
     
      public function Getorderlist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'order_list', $requestdata);


        return $response->json();
    }

      public function Getorderdetails($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'order_detail', $requestdata);


        return $response->json();
    }

     public function Cancelorder($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'cancel_order', $requestdata);

       
        return $response->json();
    }

       public function Getshippinglist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();

        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->get($this->apiBaseUrl . 'shipping_list', $requestdata);
          //print_r($response->json()); die;
        return $response->json();
    }
    /* Order lisr Service Methods End */

    /**
     * Create Order (Quotation)
     */
    public function createOrder($requestData)
    {
        $token = $this->generateToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'x-apikey' => $this->apiKey
            ])->post($this->apiBaseUrl . 'checkout', $requestData);

        return $response->json();
    }

    /**
     * Create Estimate
     */

     public function Getestimatelist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'estimate_list', $requestdata);


        return $response->json();
    }

    public function createEstimate($requestData)
    {
        $token = $this->generateToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'x-apikey' => $this->apiKey
            ])->post($this->apiBaseUrl . 'estimate', $requestData);

        return $response->json();
    }

     public function Getestimatdetails($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'estimate_detail', $requestdata);


        return $response->json();
    }

     public function Convertorder($requestData)
    {
        $token = $this->generateToken();
        if (!$token) {
            return ['success' => false, 'message' => 'Authentication failed'];
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'x-apikey' => $this->apiKey
            ])->post($this->apiBaseUrl . 'convert_order', $requestData);

        return $response->json();
    }

       public function Getinvoicelist($requestdata)
    {
        // Get token from generateToken (uses cache)
        $token = $this->generateToken();
        //echo $token; die;
        if (!$token) {
            return null; // Cannot proceed without token
        }

        $response = Http::withoutVerifying()->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'x-apikey' => $this->apiKey
        ])->post($this->apiBaseUrl . 'invoice_list', $requestdata);


        return $response->json();
    }

      //  Subscribe single token to a single topic
    public function subscribeToTopic($topic, $token)
    {
        try {
            $result = $this->messaging->subscribeToTopic($topic, [$token]);
            
            \Log::info("Token subscribed to topic", [
                'topic' => $topic,
                'token_prefix' => substr($token, 0, 10) . '...',
                //'success_count' => $result->successCount(),
                //'failure_count' => $result->failureCount()
            ]);

            return [
                'success' => true,
                'success_count' => 1,
                'failure_count' => 0,
                'errors' => $result->errors()
            ];

        } catch (\Exception $e) {
            \Log::error("Topic subscription failed", [
                'topic' => $topic,
                'token_prefix' => substr($token, 0, 10) . '...',
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Unsubscribe single token from a single topic
    public function unsubscribeFromTopic($topic, $token)
    {
        try {
            $result = $this->messaging->unsubscribeFromTopic($topic, [$token]);
            
            \Log::info("Token unsubscribed from topic", [
                'topic' => $topic,
                'token_prefix' => substr($token, 0, 10) . '...',
                'success_count' => $result->successCount(),
                'failure_count' => $result->failureCount()
            ]);

            return [
                'success' => $result->successCount() > 0,
                'success_count' => $result->successCount(),
                'failure_count' => $result->failureCount(),
                'errors' => $result->errors()
            ];

        } catch (\Exception $e) {
            \Log::error("Topic unsubscription failed", [
                'topic' => $topic,
                'token_prefix' => substr($token, 0, 10) . '...',
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}