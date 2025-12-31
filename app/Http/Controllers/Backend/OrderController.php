<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\Setting;
use App\Services\ApiAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
     public $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService; // Dependency injection
    }
    public function index(Request $request)
    {
        
        // Get the external user session data
        $externalUser = session('external_user');
        
        // Fetch the filter items from the API
         if($request->ajax()){
        $filters = $request->all();
        
        // Prepare the API request data according to the required structure
        $apiRequestData = [
           'userid' => $externalUser['id'],
            'page' => $filters['page'] ?? 0,
            'count' => $filters['count'] ?? 50,
            
        ];

        // Call the API service
        $productData = $this->apiAuthService->Getorderlist($apiRequestData);

        // Check if the data is returned successfully
        if ($productData['success']) {
            return response()->json([
                'success' => true,
                'data' => $productData['data'],
                'recordsTotal' => $productData['count'] ?? count($productData['data']),
                'recordsFiltered' => $productData['count'] ?? count($productData['data'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No products found',
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }
        return view('backend.order.index');
    }

    public function view($id)
    {
         $externalUser = session('external_user');
        $response = $this->apiAuthService->Getorderdetails([
            'orderid' => $id,
            'userid' => $externalUser['id'],
            'companyid' => $externalUser['companyid']
        ]);
        if ($response && $response['success']) {
            $order = $response['data'];
        } else {
            throw new \Exception($response['message']);
        }
        return view('backend.order.view', compact('order', 'id'));
    }

 public function create()
    {
        // Get the external user session data
        $externalUser = session('external_user');
        
    $response = $this->apiAuthService->Getcartlist([
            'userid' => $externalUser['id']
        ]);
    
     if ($response && $response['success']) {
        $cartlists = $response['data'];
    } else {
        throw new \Exception($response['message']);
    }

        return view('backend.order.create', compact('cartlists'));
    }

    public function CancelOrder(Request $request)
    {
         $externalUser = session('external_user');
         
      
        $response = $this->apiAuthService->Cancelorder([
            'userid' => $externalUser['id'],
            'orderid' => $request->orderid
        ]);
        

         if ($response && $response['success']) {
       return response()->json([
                        'success' => true,
                        'message' =>'Order Cancelled Successfully',
                        'data' => $response['data'],
                        'redirect_url' => route('orders.view', ['order' => $request->orderid])
                    ]);
    } else {
        throw new \Exception($response['message']);

    }
       
    }
   
    public function getCustomerList(Request $request)
    {
        // Prepare request data for API
         $externalUser = session('external_user');
       
        // Fetch the filter items from the API
        $response = $this->apiAuthService->Getcustomerlist([
            'userid' => $externalUser['id'],
            'companyid' => $externalUser['companyid'],
             'search_text' => $request->q ?? '',
            'page' => $request->page ?? 0,
            'count' => $request->count ?? 500
        ]);

        if (!isset($response['success']) || !$response['success']) {
            return response()->json(['success' => false, 'message' => 'Unable to fetch  list.']);
        }

        // Assume API returns data like: ['data' => [ {id, name, address, phone, email, gst}, ... ]]
        $customers = collect($response['data'])->map(function ($item) {
            return [
                'id' => $item['customerid'],
                'text' => $item['name'], // required by Select2
                'full' => $item, // include full record for JS
            ];
        });

        return response()->json(['success' => true, 'results' => $customers]);
    }
    public function getShippingList(Request $request)
    {
        // Prepare request data for API
         $externalUser = session('external_user');
          $customerId = $request->get('customerid');
        // Fetch the filter items from the API

        if (!$customerId) {
        return response()->json([
            'success' => false,
            'message' => 'Customer ID is required'
        ]);
    }

        $shippinglists = $this->apiAuthService->Getshippinglist([
            'clientid' => $customerId
        ]);

        if (!isset($shippinglists['success']) || !$shippinglists['success']) {
            return response()->json(['success' => false, 'message' => 'Unable to fetch shipping list.']);
        }

        // Assume API returns data like: ['data' => [ {id, name, address, phone, email, gst}, ... ]]
        $addresses = collect($shippinglists['data'])->map(function ($item) {
            return [
                'id' => $item['shipping_id'],
                'text' => $item['ship_name'], // required by Select2
                'full' => $item, // include full record for JS
            ];
        });

        return response()->json(['success' => true, 'results' => $addresses]);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'ordertype' => 'required|in:order,estimate',
            'clientid' => 'required|integer|min:1',
            'shippingid' => $request->ordertype === 'order' ? 'required|integer|min:1' : 'nullable|integer',
            
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the external user session data
        $externalUser = session('external_user');
     
        // Prepare the API request data
        $apiRequestData = [
            'userid' => $externalUser['id'],
            'companyid' => $externalUser['companyid'],
            'clientid' => $request->clientid,
            'shippingid' => $request->shippingid ?? 0,
           
        ];

        try {
            // Call the appropriate API service based on order type
            if ($request->ordertype === 'order') {
                $orderData =  $this->apiAuthService->createOrder($apiRequestData);
            } else {
                $orderData =  $this->apiAuthService->createEstimate($apiRequestData);
            }

            if ($orderData['success'] ?? false) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => $request->ordertype === 'order' ? 'Order created successfully' : 'Estimate created successfully',
                        'data' => $orderData,
                        'redirect_url' => route('orders')
                    ]);
                }
                return redirect()->route('orders')->with('success', 
                    $request->ordertype === 'order' ? 'Order created successfully' : 'Estimate created successfully');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $orderData['message'] ?? 'Failed to create order'
                    ], 400);
                }
                return redirect()->back()->with('error', $orderData['message'] ?? 'Failed to create order')->withInput();
            }

        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create order: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
        }
    }
}