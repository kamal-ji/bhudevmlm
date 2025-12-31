<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\Setting;
use App\Services\ApiAuthService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService; // Dependency injection
    }
    
    public function index()
    {
        // Get user data from session (external API)
        $externalUser = session('external_user');

        $id = $externalUser['id'];

        $response = $this->apiAuthService->Getcustomer([
            'customerid' => $id
        ]);

        if (isset($response['success']) && $response['success'] && isset($response['data'])) {
            $user = $response['data'];
        } else {
            throw new \Exception($response['message']);
        }
          //print_r($user); die;
        $countries = $states = [];
        $data = file_get_contents(storage_path('app/country_region_data.json'));
        $data = json_decode($data, true);

        foreach ($data as $country) {
            $countries[] = $country['country'];

            if( $country['country']['id'] == $user['countryid'] ) {
                $states = $country['regions'];
            }
        }

        return view('backend.Profile.profile', compact('user', 'countries', 'states'));
    }

    public function update(Request $request)
    {
        $externalUser = session('external_user');

        $id = $externalUser['id'];

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile' => 'required|string|max:255',
            'emailid' => 'required|email|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'regionid' => 'required|string|max:255',
            'dob' => 'required|string|max:255',
            'anniversary' => 'required|string|max:255',
        ]);

        $response = $this->apiAuthService->updateClientProfile($id, $request);

        if (isset($response['success']) && $response['success'] && isset($response['data'])) {
            // ok
        } else {
            return response()->json([
                'success' => false,
                'message' => $response['message']
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ], 200);
    }

    public function Companysetting()
    {

        // You can fetch additional data from external API if needed
        $settings = Setting::all();
        
        return view('backend.Profile.companysetting', [
            'details' => $settings

        ]);
    }

    public function SaveCompanysetting(Request $request)
    {

        // Validate the incoming request
        $validated = $request->validate([
            'settings.*.value' => 'required|string|max:255', // Validate the value field
        ]);

        // Loop through settings and update values
        foreach ($validated['settings'] as $id => $data) {
            $setting = Setting::find($id);
            if ($setting) {
                $setting->value = $data['value'];
                $setting->save();
            }
        }

        // Redirect with a success message
        return redirect()->route('profile.company-setting')->with('success', 'Settings updated successfully!');
    }

    public function Emailsetting()
    {
        // Get user data from session (external API)

        $emailSettings = EmailSetting::first();
        // You can fetch additional data from external API if needed

        return view('backend.Profile.emailsetting', [
            'settings' => $emailSettings

        ]);
    }
}
