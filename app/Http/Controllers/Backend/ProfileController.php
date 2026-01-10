<?php
namespace App\Http\Controllers\Backend; // uppercase B

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Setting;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Country;
use App\Models\State;

class ProfileController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

          // Get active countries
    $countries = Country::where('status', 1)
        ->orderBy('name')
        ->get();

    // Get states based on user's country
    $states = [];
    if ($user->countryid) {
        $states = State::where('country_id', $user->countryid)
            ->orderBy('name')
            ->get();
    }

        return view('backend.Profile.profile', compact('user', 'countries', 'states'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'regionid' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'anniversary' => 'nullable|date',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->countryid = $request->countryid;
        $user->regionid = $request->regionid;
        $user->dob = $request->dob;
        $user->anniversary = $request->anniversary;

       // Handle the image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($user->image) {
            Storage::delete('public/' . $user->image);  // Remove old image from storage
        }

        // Store the new image in the 'profile_images' directory under 'public' disk
        $user->image = $request->file('image')->store('profile_images', 'public');
    }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    public function Companysetting()
{
    $settings = Setting::all();
    
    // Get company details from settings
    $companyLogo = $settings->where('name', 'company_logo')->first()?->value;
    $companyFavicon = $settings->where('name', 'company_favicon')->first()?->value;
    $companyName = $settings->where('name', 'company_name')->first()?->value;
    $companyEmail = $settings->where('name', 'company_email')->first()?->value;
    $companyPhone = $settings->where('name', 'company_phone')->first()?->value;
    $companyWebsite = $settings->where('name', 'company_website')->first()?->value;
    $companyAddress = $settings->where('name', 'company_address')->first()?->value;
    $companyCity = $settings->where('name', 'company_city')->first()?->value;
    $companyState = $settings->where('name', 'company_state')->first()?->value;
    $companyCountry = $settings->where('name', 'company_country')->first()?->value;
    $companyZip = $settings->where('name', 'company_zip')->first()?->value;
    $companyTaxId = $settings->where('name', 'company_tax_id')->first()?->value;
    
    return view('backend.Profile.companysetting', [
        'details' => $settings,
        'companyLogo' => $companyLogo,
        'companyFavicon' => $companyFavicon,
        'companyName' => $companyName,
        'companyEmail' => $companyEmail,
        'companyPhone' => $companyPhone,
        'companyWebsite' => $companyWebsite,
        'companyAddress' => $companyAddress,
        'companyCity' => $companyCity,
        'companyState' => $companyState,
        'companyCountry' => $companyCountry,
        'companyZip' => $companyZip,
        'companyTaxId' => $companyTaxId,
    ]);
}

  public function SaveCompanysetting(Request $request)
{
    $validated = $request->validate([
        // Company details validation
        'company_name' => 'required|string|max:255',
        'company_email' => 'required|email|max:255',
        'company_phone' => 'nullable|string|max:20',
        'company_website' => 'nullable|url|max:255',
        'company_address' => 'nullable|string|max:500',
        'company_city' => 'nullable|string|max:100',
        'company_state' => 'nullable|string|max:100',
        'company_country' => 'nullable|string|max:100',
        
        // File upload validation
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'company_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        
        // Dynamic settings validation
        'settings.*.value' => 'required|string|max:255',
    ]);

    // Handle company logo upload
    if ($request->hasFile('company_logo')) {
        $oldLogo = Setting::where('name', 'company_logo')->value('value');
        if ($oldLogo && Storage::exists('public/' . $oldLogo)) {
            Storage::delete('public/' . $oldLogo);
        }
        
        $logoPath = $request->file('company_logo')->store('company/logos', 'public');
        $this->saveSetting('company_logo', $logoPath);
    }

    // Handle favicon upload
    if ($request->hasFile('company_favicon')) {
        $oldFavicon = Setting::where('name', 'company_favicon')->value('value');
        if ($oldFavicon && Storage::exists('public/' . $oldFavicon)) {
            Storage::delete('public/' . $oldFavicon);
        }
        
        $faviconPath = $request->file('company_favicon')->store('company/favicons', 'public');
        $this->saveSetting('company_favicon', $faviconPath);
    }

      // Save company details
    $this->saveSetting('company_name', $validated['company_name']);
    $this->saveSetting('company_email', $validated['company_email']);
    $this->saveSetting('company_phone', $validated['company_phone'] ?? '');
    $this->saveSetting('company_website', $validated['company_website'] ?? '');
    $this->saveSetting('company_address', $validated['company_address'] ?? '');
    $this->saveSetting('company_city', $validated['company_city'] ?? '');
    $this->saveSetting('company_state', $validated['company_state'] ?? '');
    $this->saveSetting('company_country', $validated['company_country'] ?? '');

    // Save dynamic settings
    foreach ($validated['settings'] as $id => $data) {
        $setting = Setting::find($id);
        if ($setting) {
            $setting->value = $data['value'];
            $setting->save();
        }
    }

    return redirect()->route('profile.company-setting')->with('success', 'Company settings updated successfully!');
}

private function saveSetting($name, $value)
{
    // Convert null to empty string to avoid database constraint violation
    Setting::updateOrCreate(
        ['name' => $name],
        ['value' => $value ?? '']
    );
}

// Additional method to delete company logo
public function deleteCompanyLogo()
{
    $logoSetting = Setting::where('name', 'company_logo')->first();
    
    if ($logoSetting && $logoSetting->value) {
        if (Storage::exists('public/' . $logoSetting->value)) {
            Storage::delete('public/' . $logoSetting->value);
        }
        $logoSetting->value = null;
        $logoSetting->save();
    }
    
    return redirect()->route('profile.company-setting')->with('success', 'Company logo removed successfully!');
}

    public function Emailsetting()
    {
        $emailSettings = EmailSetting::first();
        return view('backend.Profile.emailsetting', [
            'settings' => $emailSettings
        ]);
    }
 public function deleteCompanyFavicon()
{
    $faviconSetting = Setting::where('name', 'company_favicon')->first();
    
    if ($faviconSetting && $faviconSetting->value) {
        // Delete from storage
        if (Storage::disk('public')->exists($faviconSetting->value)) {
            Storage::disk('public')->delete($faviconSetting->value);
        }
        
        // Update setting
        $faviconSetting->value = null;
        $faviconSetting->save();
    }
    return redirect()->route('profile.company-setting')->with('success', 'Company favicon removed successfully!');
}
}