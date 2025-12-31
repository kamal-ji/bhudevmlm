<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiAuthService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
     public $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService; // Dependency injection
    }

  public function index(Request $request)
{ 
    // Retrieve the external user session data
    $externalUser = session('external_user');
    
    // Fetch the filter items from the API
    $response = $this->apiAuthService->Getfilteritems([
        'userid' => $externalUser['id'],
        'companyid' => $externalUser['companyid']
    ]);

    // Check if the API response is successful
    if ($response['success']) {
        $filterData = $response['data'];
    } else {
        $filterData = [];
    }
    
    if($request->ajax()){
        $filters = $request->all();
        
        // Prepare the API request data according to the required structure
        $apiRequestData = [
            'companyid' => $externalUser['companyid'],
            'userid' => $externalUser['id'],
            'page' => $filters['page'] ?? 0,
            'count' => $filters['count'] ?? 50,
            'product' => $filters['product'] ?? '',
            'category' => $filters['category'] ?? [],
            'collection' => $filters['collection'] ?? [],
            'metal' => $filters['metal'] ?? [],
            'stone' => $filters['stone'] ?? [],
            'shape' => $filters['shape'] ?? [],
            'gender' => $filters['gender'] ?? [],
            'noofstone' => $filters['noofstone'] ?? [],
            'searchtext' => $filters['searchtext'] ?? '',
            'sortby' => $filters['sortby'] ?? 0,
            'price' => [
                'min' => $filters['price']['min'] ?? 0,
                'max' => $filters['price']['max'] ?? 0
            ],
            'weight' => [
                'min' => $filters['weight']['min'] ?? 0,
                'max' => $filters['weight']['max'] ?? 0
            ],
            'stone_weight' => [
                'min' => $filters['stone_weight']['min'] ?? 0,
                'max' => $filters['stone_weight']['max'] ?? 0
            ]
        ];

        // Call the API service
        $productData = $this->apiAuthService->Getproductlist($apiRequestData);

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
    // Pass the URL parameters to the view for initial state
    $urlParams = $request->query();
    // Pass the data to the view
    return view('backend.product.index', compact('filterData', 'urlParams'));
}

 public function view($id)
{
    $externalUser = session('external_user');
    
    if (!$externalUser || !isset($externalUser['id'])) {
      
        return redirect()->route('login')->with('error', 'User is not logged in.');
    }

    $params = [
        'userid' => $externalUser['id'],
        'companyid' => $externalUser['companyid'],
        'clientid' => $externalUser['id'], 
        'productid' => $id,
        'device' => 'web'
    ];

    $response2 = $this->apiAuthService->Getproduct($params);

    if ($response2 && $response2['success']) {
        $product = $response2['data'];
    } else {
        throw new \Exception($response2['message']);
    }

    return view('backend.product.product-detail', compact('id', 'product'));
}

  public function create()
  {
      return view('backend.product.create');
  }

  public function store(Request $request)
  {
      // Validate the form data
      $validator = Validator::make($request->all(), [
          'name' => 'required',
          'description' => 'required',
          'price' => 'required|numeric',
          'weight' => 'required|numeric',
          'stone_weight' => 'required|numeric',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
      } 

      // Get the external user session data
      $externalUser = session('external_user');

      // Prepare the API request data
      $apiRequestData = [
          'companyid' => $externalUser['companyid'],
          'userid' => $externalUser['id'],
          'name' => $request->name,
          'description' => $request->description,
          'price' => $request->price,
          'weight' => $request->weight,
          'stone_weight' => $request->stone_weight,
          'image' => $request->image,
      ];

      // Call the API service
      $productData = $this->apiAuthService->Createproduct($apiRequestData);

      if ($productData['success']) {
          return redirect()->route('product.index')->with('success', 'Product created successfully');
      } else {
          return redirect()->back()->with('error', 'Failed to create product');
      }
  }

  public function edit($id)
  {
      return view('backend.product.edit', compact('id'));
  }

  public function update(Request $request, $id)
  {
      // Validate the form data
      
      return redirect()->route('product.index');
  }

 public function addtocart(Request $request)
{
    $externalUser = session('external_user');
    
    // Check if the external user exists in the session
    if (!$externalUser) {
        return response()->json(['success' => false, 'message' => 'User not logged in']);
    }

    $requestdata = $request->all();

    // Validate product_id, quantity, and barcodeid
    if ($requestdata['product_id'] == null) {
        return response()->json(['success' => false, 'message' => 'Please select a product']);
    }
    if ($requestdata['quantity'] == null) {
        return response()->json(['success' => false, 'message' => 'Please enter quantity']);
    }
    if ($requestdata['barcodeid'] == null) {
        return response()->json(['success' => false, 'message' => 'Please enter barcode ID']);
    }

    
   

    // Add user ID to the request data
    

    $data=[
        'productid' => $requestdata['product_id'],
        'qty' => $requestdata['quantity'],
        'barcodeid' => $requestdata['barcodeid'],
        'userid' => $externalUser['id']
    ];

    // Call the API service to add the product to the cart
    $response = $this->apiAuthService->Addtocart($data);

    // Check if the response is valid and contains data
    if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
         
        if ($requestdata['iscart'] === 'true') {
           
            return response()->json([
                'success' => true, 
                'message' => $response['message'], 
                'data' => $responseData,
                'cart' => false
            ]);
    }else{
        
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            'cart' => true
        ]);
    }

        $responseData = $response['data'];
        
        // Return successful response with data
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}



 public function addtowishlist(Request $request)
{
    $externalUser = session('external_user');
    
    // Check if the external user exists in the session
    if (!$externalUser) {
        return response()->json(['success' => false, 'message' => 'User not logged in']);
    }

    $requestdata = $request->all();

    // Validate product_id, quantity, and barcodeid
    if ($requestdata['product_id'] == null) {
        return response()->json(['success' => false, 'message' => 'Please select a product']);
    }
    if ($requestdata['barcodeid'] == null) {
        return response()->json(['success' => false, 'message' => 'Please enter barcode ID']);
    }

    
   

    // Add user ID to the request data
    

    $data=[
        'productid' => $requestdata['product_id'],
        'barcodeid' => $requestdata['barcodeid'],
        'userid' => $externalUser['id']
    ];

    // Call the API service to add the product to the wishlist
    $response = $this->apiAuthService->Addtowishlist($data);

    // Check if the response is valid and contains data
    if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
         
        if ($requestdata['iswishlist'] === 'true') {
           
            return response()->json([
                'success' => true, 
                'message' => $response['message'], 
                'data' => $responseData,
                'wishlist' => false
            ]);
    }else{
        
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            'wishlist' => true
        ]);
    }

        $responseData = $response['data'];
        
        // Return successful response with data
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}

public function cartlist(){
   
    $requestdata = array(
        'userid' => session('external_user')['id']
    );
    $response = $this->apiAuthService->Getcartlist($requestdata);
    
     if ($response && $response['success']) {
        $lists = $response['data'];
    } else {
        throw new \Exception($response['message']);
    }
    return view('backend.product.cart', compact('lists'));    
}

public function wishlist(Request $request){
    $page = $request->input('start', 0) / $request->input('length', 50) + 1;
    $count = $request->input('length', 50);
    
    $requestdata = array(
        'userid' => session('external_user')['id'],
        'page' => $page,
        'count' => $count
    );
   
    
    $response = $this->apiAuthService->Getwishlist($requestdata);
     
    if ($response && $response['success']) {
        $lists = $response['data'];
        $totalCount = count($lists); // Adjust based on your API response structure
        
        if ($request->ajax()) {
            $formattedData = [];
            $i = 1;
            
            foreach ($lists as $item) {
                $serialNumber = (($page - 1) * $count) + $i;
                
                $formattedData[] = [
                    'serial' => $serialNumber,
                    'product' => '
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="'.($item['image'] ? get('image_url') . $item['image'] : asset('assets/backend/img/users/user-08.jpg')).'" 
                                     alt="'.$item['name'].'" class="rounded" width="60">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">'.$item['name'].'</h6></p>
                            </div>
                        </div>
                    ',
                    'price' => '
                        <div>
                            <span class="fs-14 fw-semibold text-primary">'.$item['currency'].number_format($item['price'], 2).'</span>
                            '.($item['tagprice'] > $item['price'] ? 
                                '<div class="text-muted text-decoration-line-through fs-12">'.$item['currency'].number_format($item['tagprice'], 2).'</div>' 
                                : '').'
                        </div>
                    ',
                    'actions' => '
                        <div class="align-items-center">
                            <a href="javascript:void(0);" 
                               class="btn btn-sm btn-soft-primary border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular  movecart"
                               data-productid="'.$item['productid'].'"
                               data-id="'.$item['id'].'"
                               data-barcodeid="'.$item['barcodeid'].'">
                                Move to Cart
                            </a>
                            <a href="javascript:void(0);" 
                               class="btn btn-sm btn-outline-danger applywishlist"
                               data-productid="'.$item['productid'].'"
                                                data-wishlist="true"
                                                data-barcodeid="'.$item['barcodeid'].'">
                                <i class="fa fa-heart"></i>
                            </a>
                        </div>
                    '
                ];
                $i++;
            }

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalCount,
                'recordsFiltered' => $totalCount,
                'data' => $formattedData,
            ]);
        }
        
    } else {
        if ($request->ajax()) {
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $response['message'] ?? 'Failed to load wishlist'
            ]);
        }
        throw new \Exception($response['message'] ?? 'Failed to load wishlist');
    }
    
    return view('backend.product.wishlist');
}

public function updatecart(Request $request){
   

    $requestdata = array(
        'userid' => session('external_user')['id'],
        'id' => $request->item_id,
        'pcs' => $request->quantity
    );
    $response = $this->apiAuthService->Updatecart($requestdata);
     if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}

public function movewishlist(Request $request){
   

    $requestdata = array(
        'userid' => session('external_user')['id'],
        'id' => $request->item_id,
        
    );
    $response = $this->apiAuthService->Movewishlist($requestdata);
     if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}

public function movecart(Request $request){
   

    $requestdata = array(
        'userid' => session('external_user')['id'],
        'id' => $request->item_id,
        
    );
    $response = $this->apiAuthService->Movecart($requestdata);
     if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}
 
public function removecart(Request $request){
   

    $requestdata = array(
        'userid' => session('external_user')['id'],
        'id' => $request->item_id,
        
    );
    $response = $this->apiAuthService->Removecart($requestdata);
     if (isset($response['success']) && $response['success']) {
         $responseData = $response['data'];
        return response()->json([
            'success' => true, 
            'message' => $response['message'], 
            'data' => $responseData,
            
        ]);
    } else {
        // Handle failure: Check if the response contains a message
        $errorMessage = $response['message'] ?? 'Something went wrong';
        
        // Return error response
        return response()->json([
            'success' => false, 
            'message' => $errorMessage, 
            'data' => []
        ]);
    }
}

/*Checkout code start*/
public function checkout(){
   
    $requestdata = array(
        'userid' => session('external_user')['id']
    );
    $response = $this->apiAuthService->Getcartlist($requestdata);
    
     if ($response && $response['success']) {
        $lists = $response['data'];
    } else {
        throw new \Exception($response['message']);
    }
    return view('backend.product.checkout', compact('lists'));    
}
/* end checkout code */
}
