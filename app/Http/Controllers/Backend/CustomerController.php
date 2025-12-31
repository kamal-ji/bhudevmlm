<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiAuthService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService; // Dependency injection
    }

   public function index(Request $request)
{
    $externalUser = session('external_user');

    $filters = [
        'search_text' => $request->input('search_text', ''),
        'countryid' => $request->input('countryid', ''),
        'regionid' => $request->input('regionid', ''),
        'characters' => $request->input('characters', ''),
        'page' => ($request->input('start', 0) / $request->input('length', 50)) + 1,  // Calculate page number
        'count' => $request->input('length', 50),  // Items per page
    ];

    $globalSearch = $request->input('search.value');
    
    // Sorting
    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir', 'asc');
    $orderColumnKey = $request->input("columns.$orderColumnIndex.data");

    // Map frontend column keys to actual data keys
    $sortableColumns = [
        'customer' => 'name',
        'email' => 'emailid',
        'mobile' => 'mobile',
        'country' => 'country'
    ];
    $sortKey = $sortableColumns[$orderColumnKey] ?? null;
    
    if ($externalUser && isset($externalUser['companyid'])) {
        // Fetch customer data from the API
        $searchText = $globalSearch ?: $filters['search_text'];
        $masterResponse = $this->apiAuthService->Getcustomerlist([
            'companyid' => $externalUser['companyid'],
            'userid' => $externalUser['id'],
            'search_text' => $searchText,
            'countryid' => $filters['countryid'],
            'regionid' => $filters['regionid'],
            'characters' => $filters['characters'],
            'page' => $filters['page'],
            'count' => $filters['count'],
        ]);

        // Process the API response
        if (isset($masterResponse['success']) && $masterResponse['success'] && isset($masterResponse['data'])) {
            $data = $masterResponse['data'];
            $totalCount = $masterResponse['count'] ?? count($masterResponse['data']);

            // Convert to collection for sorting
            $data = collect($data);

            // Apply sorting
            if ($sortKey) {
                $data = $orderDir === 'asc'
                    ? $data->sortBy($sortKey)->values()
                    : $data->sortByDesc($sortKey)->values();
            }

            // Manual pagination
            $currentPage = $filters['page'];
            $perPage = $filters['count'];
            $currentPageItems = $data;
            
        } else {
            $currentPageItems = collect();
            $totalCount = 0;
        }
    } else {
        $currentPageItems = collect();
        $totalCount = 0;
    }

    if ($request->ajax()) {
        $formattedData = [];
        $i = 1;
        foreach ($currentPageItems as $customer) {
            $cunt = (($filters['page'] - 1) * $filters['count']) + $i;
            $formattedData[] = [
                'checkbox' => '<div class="form-check form-check-md">' . $cunt . ' <input class="form-check-input" type="checkbox"></div>',
                'customer' => '
                <div class="d-flex align-items-center">
                    <a href="'.route('customers.view', $customer['customerid']).'" class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                        <img src="' . ($customer['image'] ? get('image_url') . $customer['image'] : asset('assets/backend/img/profiles/avatar-01.jpg')) . '" 
                             class="rounded-circle" alt="' . $customer['name'] . '">
                    </a>
                    <div>
                        <h6 class="fs-14 fw-medium mb-0"><a href="'.route('customers.view', $customer['customerid']).'">' . $customer['name'] . '</a></h6>
                    </div>
                </div>',
                'email' => $customer['emailid'] ?? 'Unknown',
                'mobile' => $customer['mobile'] ?? 'Unknown',
                'country' => $customer['country'] ?? 'Unknown',
                'actions' => '
                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="isax isax-more"></i>
                    </a>
                    <ul class="dropdown-menu">
                     <li>
                            <a href="'.route('customers.address_list', $customer['customerid']).'" class="dropdown-item d-flex align-items-center"><i class="isax isax-eye me-2"></i>Address List</a>
                        </li>
                        <li>
                            <a href="'.route('customers.view', $customer['customerid']).'" class="dropdown-item d-flex align-items-center"><i class="isax isax-eye me-2"></i>View</a>
                        </li>
                        <li>
                            <a href="'.route('customers.edit', $customer['customerid']).'" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a>
                        </li>
                        <li>
                            <a href="'.route('customers.destroy', $customer['customerid']).'" class="dropdown-item d-flex align-items-center"><i class="isax isax-trash me-2"></i>Delete</a>
                        </li>
                    </ul>
                ',
                'status' => $customer['status'] ? '<span class="badge badge-soft-success d-inline-flex align-items-center">Active <i class="isax isax-tick-circle ms-1"></i></span>' : '<span class="badge badge-soft-danger d-inline-flex align-items-center">Inactive <i class="isax isax-close-circle ms-1"></i></span>'

            ];
            $i++;
        }

        // Return JSON response for DataTables
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount,
            'data' => $formattedData,
        ]);
    }

    $countries = [];

    if ($externalUser && isset($externalUser['companyid'])) {
        $masterResponsedata = $this->apiAuthService->Getcustomermaster($externalUser['companyid']);

        if (isset($masterResponsedata['success']) && $masterResponsedata['success'] && isset($masterResponsedata['data'])) {
            $datamaster = $masterResponsedata['data'];
            $countries  = $datamaster['country']   ?? [];
        }
    }

    return view('backend.customer.index', compact('countries'));
}

    public function create()
    {
        $externalUser = session('external_user');

        $country = $region = $group = $currency = $template = [];

        if ($externalUser && isset($externalUser['companyid'])) {
            $masterResponse = $this->apiAuthService->Getcustomermaster($externalUser['companyid']);

            if (isset($masterResponse['success']) && $masterResponse['success'] && isset($masterResponse['data'])) {
                $data = $masterResponse['data'];

                $countries  = $data['country']   ?? [];
                $regions   = $data['region']    ?? [];
                $group    = $data['group']     ?? [];
                $currency = $data['currency']  ?? [];
                $template = $data['template']  ?? [];


                $filteredData = [];
                foreach ($countries as $country) {
                    $countryId = $country['id'];
                    $countryRegions = array_filter($regions, function ($region) use ($countryId) {
                        return $region['countryid'] === $countryId;
                    });

                    // Re-index the filtered regions
                    $countryRegions = array_values($countryRegions);

                    // Save the country with its respective regions
                    $filteredData[] = [
                        'country' => $country,
                        'regions' => $countryRegions
                    ];
                }
                // Save the data as a JSON file in the storage/app directory
                $filePath = storage_path('app/country_region_data.json');

                // Use File::put to write data into the file
                File::put($filePath, json_encode($filteredData, JSON_PRETTY_PRINT));
            }
        }

        return view('backend.customer.create', compact(
            'countries',
            'regions',
            'group',
            'currency',
            'template'
        ));
    }

    public function getStatesByCountry($countryId)
    {
        // Define the file path where the country_region_data.json is stored
        $filePath = storage_path('app/country_region_data.json');

        // Check if the file exists
        if (!File::exists($filePath)) {
            return response()->json(['error' => 'Data file not found'], 404);
        }

        // Read the JSON file
        $dataFromFile = json_decode(File::get($filePath), true);

        // Filter the regions based on the countryId
        $states = [];
        foreach ($dataFromFile as $countryData) {
            if ($countryData['country']['id'] == $countryId) {
                $states = $countryData['regions'];
                break;
            }
        }

        // If no states are found for the given countryId, return an empty array
        return response()->json(['states' => $states]);
    }

    public function store(Request $request)
    {
        $externalUser = session('external_user');
        // Step 1: Validate input
        $validator = Validator::make($request->all(), [
            // Personal Info
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'required|string|in:male,female,other', // You can restrict values like 'male', 'female', 'other' if needed
            'dob'           => 'nullable|date|before:today', // Ensure the date is before today (not a future date)
            'anniversary'   => 'nullable|date|after_or_equal:dob', // Anniversary must be on or after dob if available
            'currency'      => 'required|string|max:255',
            'group'         => 'required|string|max:255',
            'template'      => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'         => 'required|string|max:20|regex:/^[0-9]{10,15}$/', // Validates a 10-15 digit mobile number
            'notes'         => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
      
            // Billing & Shipping Address
            'address_1'  => 'required|string|max:255',
            'address_2'  => 'nullable|string|max:255',
            'countryid'   => 'required|integer', // Ensure the country ID exists in the countries table
            'regionid'     => 'required|integer',   // Ensure the region ID exists in the regions table
            'city'      => 'required|string|max:255',
            'zipcode'   => 'required|string|max:20',
            'buildingno'   => 'required|string|max:20',

            // Card Details
            'card_no'  => 'nullable|string|max:255|regex:/^\d{13,19}$/', // Validates a card number (13-19 digits)
            'card_issue'  => 'nullable|string|max:255',
            'card_expiry'   => 'nullable', // Ensures card expiry date is in 'MM/YY' format and in the future
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }
        //echo $request->dob; die;
        try {
            // Step 2: Create new Customer
            $customerdata = array();
            $customerdata['companyid'] = $externalUser['companyid'] ?? 0;
            $customerdata['customerid'] = 0;
            $customerdata['userid'] = $externalUser['id'] ?? 0;
            $customerdata['templateid'] = $request->template ?? 0;
            $customerdata['groupid'] = $request->group ?? 0;
            $customerdata['currencyid'] = $request->currency ?? 0;

            $customerdata['first_name'] = $request->first_name ?? '';
            $customerdata['last_name'] = $request->last_name ?? '';
            $customerdata['gender'] = $request->gender ?? '';
            $customerdata['buildingno'] = $request->buildingno ?? '';
            $customerdata['address1'] = $request->address_1 ?? '';
            $customerdata['address2'] = $request->address_2 ?? '';
            $customerdata['zip'] = $request->zipcode ?? 0;
            $customerdata['city'] = $request->city ?? '';
            $customerdata['countryid'] = $request->countryid ?? 0;
            $customerdata['regionid'] = $request->regionid ?? 0;
            $customerdata['email'] = $request->email;
            $customerdata['mobile'] = $request->mobile;
            $customerdata['dob'] = $request->dob ?? null;
            $customerdata['anniversary'] = $request->anniversary ?? null;
            $customerdata['note'] = $request->note ?? '';
            $customerdata['card_no'] = $request->card_no ?? '';
            $customerdata['card_issue'] = $request->card_issue ?? null;
            $customerdata['card_expiry'] = $request->card_expiry ?? null;


            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($image->isValid()) {

                    // echo $customerdata['image_base64']; die;
                    $customerdata['image'] = $image;
                } else {
                    
                    $customerdata['image'] = null;
                }
            } else {
                
                $customerdata['image'] = null;
            }
            //echo $imageBinary; die;
            Log::debug('Customer Data:', $customerdata);

            $Response = $this->apiAuthService->Customersave($customerdata);
            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully!',
                'redirect_url' => route('customers.create') // or wherever
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the customer.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $externalUser = session('external_user');
         
         $country = $group = $currency = $template = [];
       if($id){
        if ($externalUser && isset($externalUser['companyid'])) {
            $masterResponse = $this->apiAuthService->Getcustomermaster($externalUser['companyid']);

            if (isset($masterResponse['success']) && $masterResponse['success'] && isset($masterResponse['data'])) {
                $data = $masterResponse['data'];

                $countries  = $data['country']   ?? [];
                $group    = $data['group']     ?? [];
                $currency = $data['currency']  ?? [];
                $template = $data['template']  ?? [];


              
            }
        }


          $response1 = $this->apiAuthService->Getcustomer([
            'customerid' => $id
        ]);
        
        if($response1 && $response1['success']){
            $customer = $response1['data'];
        } else {
            throw new \Exception($response1['message']);
        }
        return view('backend.customer.edit', compact('customer', 'countries', 'group', 'currency', 'template'));
    }else{
        return redirect()->route('customers');
    }
    }

    public function view($id)
    {
        $externalUser = session('external_user');
    

        $response2   = $this->apiAuthService->getClientAnal([
            'userid' => $externalUser['id'],
            'clientid' => $id
        ]);

        if($response2 && $response2['success']){
            $analytics = $response2['data'];
        } else {
            throw new \Exception($response2['message']);
        }
        
        return view('backend.customer.customer-detail', compact('analytics'));
    }

    public function update($id,Request $request)
    {
       if($id){
           
       
        $externalUser = session('external_user');
        // Step 1: Validate input
        $validator = Validator::make($request->all(), [
            // Personal Info
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'required|string|in:male,female,other', // You can restrict values like 'male', 'female', 'other' if needed
            'dob'           => 'nullable|date|before:today', // Ensure the date is before today (not a future date)
            'anniversary'   => 'nullable|date|after_or_equal:dob', // Anniversary must be on or after dob if available
            'currency'      => 'required|string|max:255',
            'group'         => 'required|string|max:255',
            'template'      => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'         => 'required|string|max:20|regex:/^[0-9]{6,15}$/', // Validates a 10-15 digit mobile number
            'notes'         => 'nullable|string|max:1000',
            'image' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,image/avif|max:4096',
      
            // Billing & Shipping Address
            'address_1'  => 'required|string|max:255',
            'address_2'  => 'nullable|string|max:255',
            'countryid'   => 'required|integer', // Ensure the country ID exists in the countries table
            'regionid'     => 'required|integer',   // Ensure the region ID exists in the regions table
            'city'      => 'required|string|max:255',
            'zipcode'   => 'required|string|max:20',
            'buildingno'   => 'required|string|max:20',

            // Card Details
            'card_no'  => 'nullable|string|max:255', // Validates a card number (13-19 digits)
            'card_issue'  => 'nullable|string|max:255',
            'card_expiry'   => 'nullable', // Ensures card expiry date is in 'MM/YY' format and in the future
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }
        //echo $request->dob; die;
        try {
            // Step 2: Create new Customer
            $customerdata = array();
            $customerdata['companyid'] = $externalUser['companyid'] ?? 0;
            $customerdata['customerid'] = $id;
            $customerdata['userid'] = $externalUser['id'] ?? 0;
            $customerdata['templateid'] = $request->template ?? 0;
            $customerdata['groupid'] = $request->group ?? 0;
            $customerdata['currencyid'] = $request->currency ?? 0;

            $customerdata['first_name'] = $request->first_name ?? '';
            $customerdata['last_name'] = $request->last_name ?? '';
            $customerdata['gender'] = $request->gender ?? '';
            $customerdata['buildingno'] = $request->buildingno ?? '';
            $customerdata['address1'] = $request->address_1 ?? '';
            $customerdata['address2'] = $request->address_2 ?? '';
            $customerdata['zip'] = $request->zipcode ?? 0;
            $customerdata['city'] = $request->city ?? '';
            $customerdata['countryid'] = $request->countryid ?? 0;
            $customerdata['regionid'] = $request->regionid ?? 0;
            $customerdata['email'] = $request->email;
            $customerdata['mobile'] = $request->mobile;
            $customerdata['dob'] = $request->dob ?? '';
            $customerdata['anniversary'] = $request->anniversary ?? '';
            $customerdata['note'] = $request->note ?? '';
            $customerdata['card_no'] = $request->card_no ?? '';
            $customerdata['card_issue'] = $request->card_issue ?? '';
            $customerdata['card_expiry'] = $request->card_expiry ?? '';


            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($image->isValid()) {
                    
                    // echo $customerdata['image_base64']; die;
                    $customerdata['image'] = $image;
                } else {
                    
                    $customerdata['image'] = null;
                }
            } else {
                
                $customerdata['image'] = null;
            }
            //echo $imageBinary; die;
            Log::debug('Customer Data:', $customerdata);

            $Response = $this->apiAuthService->Customersave($customerdata);
            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully!',
                'redirect_url' => route('customers') // or wherever
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the customer.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }else{
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while saving the customer.',
            'error'   => 'Customer not found'
        ], 500);
    }
    }
    
    /*Address methods */
    
      public function Address_list(Request $request, $id)
    {
        if(empty($id)){
            return redirect()->route('customers');
        }
        
        // Get the external user session data
        $externalUser = session('external_user');
        
        // Fetch the filter items from the API
         if($request->ajax()){
        $filters = $request->all();
        
        // Prepare the API request data according to the required structure
        $apiRequestData = [
           'clientid' => $id
            
        ];

        // Call the API service
        $addressData = $this->apiAuthService->Address_list($apiRequestData);

        // Check if the data is returned successfully
        if ($addressData['success']) {
            return response()->json([
                'success' => true,
                'data' => $addressData['data'],
                'recordsTotal' => $addressData['count'] ?? count($addressData['data']),
                'recordsFiltered' => $addressData['count'] ?? count($addressData['data'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No list found',
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }
        return view('backend.customer.address_list', compact('id'));
    }

    public function CreateAddress($id)
    {
        if(empty($id)){
            return redirect()->route('customers');
        }
        // Get the external user session data
        $externalUser = session('external_user');
        //print_r($user); die;
        $countries = $states = [];
        $data = file_get_contents(storage_path('app/country_region_data.json'));
        $data = json_decode($data, true);

        foreach ($data as $country) {
            $countries[] = $country['country'];

           
        }

        return view('backend.customer.address_create', compact('id', 'countries'));
    }

    public function StoreAddress(Request $request)
    {
        if(empty($request->id)){
            return redirect()->route('customers');
        }
         $externalUser = session('external_user');
        // Step 1: Validate input
        $validator = Validator::make($request->all(), [
            // Personal Info
            'ship_name'    => 'required|string|max:255',
            'contact_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'         => 'required|string|max:20|regex:/^[0-9]{10,15}$/', // Validates a 10-15 digit mobile number
            'notes'         => 'nullable|string|max:1000',
           
          // Shipping Address
            'address_1'  => 'required|string|max:255',
            'address_2'  => 'nullable|string|max:255',
            'countryid'   => 'required|integer', // Ensure the country ID exists in the countries table
            'regionid'     => 'required|integer',   // Ensure the region ID exists in the regions table
            'city'      => 'required|string|max:255',
            'zipcode'   => 'required|string|max:20',
            'buildingno'   => 'required|string|max:20',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }
        //echo $request->dob; die;
        try {
            // Step 2: Create new Customer
            $addressdata = array();
            $addressdata['companyid'] = $externalUser['companyid'] ?? 0;
            $addressdata['shipping_id'] = 0;
            $addressdata['clientid'] = $request->id ?? 0;
            $addressdata['userid'] = $externalUser['id'] ?? 0;
            $addressdata['ship_name'] = $request->ship_name ?? '';
            $addressdata['contact_name'] = $request->contact_name ?? '';
            $addressdata['buildingno'] = $request->buildingno ?? '';
            $addressdata['address1'] = $request->address_1 ?? '';
            $addressdata['address2'] = $request->address_2 ?? '';
            $addressdata['zip'] = $request->zipcode ?? 0;
            $addressdata['city'] = $request->city ?? '';
            $addressdata['countryid'] = $request->countryid ?? 0;
            $addressdata['regionid'] = $request->regionid ?? 0;
            $addressdata['email'] = $request->email;
            $addressdata['mobile'] = $request->mobile;
            $addressdata['note'] = $request->note ?? '';


            $Response = $this->apiAuthService->Addaddress($addressdata);
            return response()->json([
                'success' => true,
                'message' => 'Address created successfully!',
                'redirect_url' => route('customers.address_list', ['customer' => $request->id]) // or wherever
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the address.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function EditAddress($id, $addressid)
    {
        
        if(empty($id) || empty($addressid)){
            return redirect()->route('customers');
        }
        $externalUser = session('external_user');
        $shippingdata = $this->apiAuthService->Getaddress([
            'shippingid' => $addressid,
        ]);
        if(empty($shippingdata)){
            return redirect()->route('customers');
        }
          $countries = $states = [];
        $data = file_get_contents(storage_path('app/country_region_data.json'));
        $data = json_decode($data, true);
      
        foreach ($data as $country) {
            $countries[] = $country['country'];

            if( $country['country']['id'] == $shippingdata['data']['countryid'] ) {
                $states = $country['regions'];
            }
        }
        return view('backend.customer.address_edit', compact('id', 'shippingdata', 'countries', 'states'));
    }

    public function UpdateAddress($id,$addressid, Request $request){
       
        $validator = Validator::make($request->all(), [
            // Personal Info
            'ship_name'    => 'required|string|max:255',
            'contact_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'         => 'required|string|max:20|regex:/^[0-9]{10,15}$/', // Validates a 10-15 digit mobile number
            'notes'         => 'nullable|string|max:1000',
           
          // Shipping Address
            'address_1'  => 'required|string|max:255',
            'address_2'  => 'nullable|string|max:255',
            'countryid'   => 'required|integer', // Ensure the country ID exists in the countries table
            'regionid'     => 'required|integer',   // Ensure the region ID exists in the regions table
            'city'      => 'required|string|max:255',
            'zipcode'   => 'required|string|max:20',
            'buildingno'   => 'required|string|max:20',
        ]); 


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // Step 2: Create new Customer
            $addressdata = array();
            $addressdata['companyid'] = $externalUser['companyid'] ?? 0;
            $addressdata['shipping_id'] = $request->addressid;
            $addressdata['clientid'] = $request->client_id ?? 0;
            $addressdata['userid'] = $externalUser['id'] ?? 0;
            $addressdata['ship_name'] = $request->ship_name ?? '';
            $addressdata['contact_name'] = $request->contact_name ?? '';
            $addressdata['buildingno'] = $request->buildingno ?? '';
            $addressdata['address1'] = $request->address_1 ?? '';
            $addressdata['address2'] = $request->address_2 ?? '';
            $addressdata['zip'] = $request->zipcode ?? 0;
            $addressdata['city'] = $request->city ?? '';
            $addressdata['countryid'] = $request->countryid ?? 0;
            $addressdata['regionid'] = $request->regionid ?? 0;
            $addressdata['email'] = $request->email;
            $addressdata['mobile'] = $request->mobile;
            $addressdata['note'] = $request->notes ?? '';
            
            $Response = $this->apiAuthService->Addaddress($addressdata);
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!',
                'redirect_url' => route('customers.address_list', ['customer' => $id]) // or wherever
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the address.',
                'error'   => $e->getMessage()
            ], 500);
        }

     
         

    }
}
