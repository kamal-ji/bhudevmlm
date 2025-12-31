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

class InvoiceController extends Controller
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
            'clientid' => 0,
            'start_date' => $filters['start_date'] ?? '',
            'end_date' => $filters['end_date'] ?? '',
            'page' => $filters['page'] ?? 0,
            'count' =>  $filters['count'] ?? 50,
            
        ];
        //print_r($apiRequestData);die;
        // Call the API service
        $invoiceData = $this->apiAuthService->Getinvoicelist($apiRequestData);

        // Check if the data is returned successfully
        if ($invoiceData['success']) {
            return response()->json([
                'success' => true,
                'data' => $invoiceData['data'],
                'recordsTotal' => $invoiceData['count'] ?? count($invoiceData['data']),
                'recordsFiltered' => $invoiceData['count'] ?? count($invoiceData['data'])
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No Invoices found',
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }
    
    return view('backend.invoice.index');
}
}