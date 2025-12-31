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

class EstimateController extends Controller
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
        $productData = $this->apiAuthService->Getestimatelist($apiRequestData);

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
            'message' => 'No list found',
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }
        return view('backend.estimate.index');
    }

     public function view($id)
    {
         $externalUser = session('external_user');
        $response = $this->apiAuthService->Getestimatdetails([
            'quoteid' => $id,
            'userid' => $externalUser['id'],
            'companyid' => $externalUser['companyid']
        ]);
        if ($response && $response['success']) {
            $order = $response['data'];
        } else {
            throw new \Exception($response['message']);
        }
        return view('backend.estimate.view', compact('order', 'id'));
    }

      public function ConvertOrder(Request $request)
    {
         $externalUser = session('external_user');
         
      
        $response = $this->apiAuthService->Convertorder([
            'userid' => $externalUser['id'],
            'quoteid' => $request->orderid,
            'shippingid' => $request->shippingid
        ]);
        

         if ($response && $response['success']) {
       return response()->json([
                        'success' => true,
                        'message' =>'Order Convert Successfully',
                        'data' => $response['data'],
                        'redirect_url' => route('estimate.view', ['order' => $request->orderid])
                    ]);
    } else {
        throw new \Exception($response['message']);

    }
       
    }
}
