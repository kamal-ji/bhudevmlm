<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PriceHistory; // Add this line

class ServicePackageController extends Controller
{
    public function index()
    {
        $packages = ServicePackage::with('serviceCategory')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('backend.services.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('status', 'active')->get();
        return view('backend.services.packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:100|unique:service_packages',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'commission_type' => 'required|in:percentage,fixed,both',
            'commission_percentage' => 'nullable|required_if:commission_type,percentage,both|numeric|min:0|max:100',
            'commission_amount' => 'nullable|required_if:commission_type,fixed,both|numeric|min:0',
            'features' => 'nullable|array',
        ]);

        $features = [];
        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                if (!empty(trim($feature))) {
                    $features[] = trim($feature);
                }
            }
        }

        ServicePackage::create([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'commission_type' => $request->commission_type,
            'commission_percentage' => $request->commission_percentage,
            'commission_amount' => $request->commission_amount,
            'features' => $features,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('packages.index')
            ->with('success', 'Service package created successfully.');
    }

    public function edit($id)
    {
        $package = ServicePackage::findOrFail($id);
        $categories = ServiceCategory::where('status', 'active')->get();
        
        return view('backend.services.packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $package = ServicePackage::findOrFail($id);
        
        $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:100|unique:service_packages,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'commission_type' => 'required|in:percentage,fixed,both',
            'commission_percentage' => 'nullable|required_if:commission_type,percentage,both|numeric|min:0|max:100',
            'commission_amount' => 'nullable|required_if:commission_type,fixed,both|numeric|min:0',
            'features' => 'nullable|array',
        ]);

        $features = [];
        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                if (!empty(trim($feature))) {
                    $features[] = trim($feature);
                }
            }
        }

        $package->update([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'commission_type' => $request->commission_type,
            'commission_percentage' => $request->commission_percentage,
            'commission_amount' => $request->commission_amount,
            'features' => $features,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('packages.index')
            ->with('success', 'Service package updated successfully.');
    }

    public function destroy($id)
    {
        $package = ServicePackage::findOrFail($id);
        
        // Check if package has orders
        if ($package->orders()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete package with existing orders.');
        }
        
        $package->delete();
        
        return redirect()->route('.packages.index')
            ->with('success', 'Service package deleted successfully.');
    }

    public function byCategory($categoryId)
    {
        $category = ServiceCategory::findOrFail($categoryId);
        $packages = $category->packages()->paginate(20);
        
        return view('backend.services.packages.by-category', compact('category', 'packages'));
    }

    public function pricing()
{
    $categories = ServiceCategory::with(['packages'])->get();
    $packages = ServicePackage::with(['serviceCategory', 'orders'])
        ->orderBy('price')
        ->paginate(20);
   
    // Price ranges
    $lowPriceCount = ServicePackage::where('price', '<', 100)->count();
    $mediumPriceCount = ServicePackage::whereBetween('price', [100, 499])->count();
    $highPriceCount = ServicePackage::where('price', '>=', 500)->count();
    
    // Popular packages
    $popularPackages = ServicePackage::withCount('orders')
        ->orderBy('orders_count', 'desc')
        ->take(10)
        ->get();
    
    $totalRevenue = ServicePackage::with('orders')->get()->sum(function($package) {
        return $package->price * $package->orders->count();
    });
    
    return view('backend.services.packages.pricing', compact(
        'categories', 'packages', 'lowPriceCount', 'mediumPriceCount',
        'highPriceCount', 'popularPackages', 'totalRevenue'
    ));
}

public function updatePrice(Request $request, $id)
{
    $package = ServicePackage::findOrFail($id);
    
    $request->validate([
        'price' => 'required|numeric|min:0',
        'reason' => 'nullable|string'
    ]);
    
    // Log price change
    PriceHistory::create([
        'package_id' => $package->id,
        'old_price' => $package->price,
        'new_price' => $request->price,
        'reason' => $request->reason,
        'changed_by' => auth()->id()
    ]);
    
    $package->update(['price' => $request->price]);
    
    return redirect()->back()->with('success', 'Package price updated successfully.');
}

public function features()
{
   $packages = ServicePackage::with('serviceCategory')
        ->whereNotNull('features')  // Changed from whereHas
        ->whereJsonLength('features', '>', 0)  // Check if features array is not empty
        ->take(6)
        ->get();
    
    $allPackages = ServicePackage::all();
    
    // Get all features and count occurrences
    $allFeatures = [];
    $featureStats = [];
    
    foreach ($allPackages as $package) {
        if ($package->features) {
            foreach ($package->features as $feature) {
                $allFeatures[] = $feature;
                if (!isset($featureStats[$feature])) {
                    $featureStats[$feature] = 0;
                }
                $featureStats[$feature]++;
            }
        }
    }
    
    arsort($featureStats);
    $commonFeatures = array_slice(array_keys($featureStats), 0, 12);
    
    // Features by category
    $categoryFeatures = [];
    foreach ($allPackages as $package) {
        $category = $package->serviceCategory->name;
        if (!isset($categoryFeatures[$category])) {
            $categoryFeatures[$category] = 0;
        }
        $categoryFeatures[$category] += count($package->features ?? []);
    }
    
    $avgFeatures = $allPackages->count() > 0 ? 
        array_sum(array_map(function($p) { return count($p->features ?? []); }, $allPackages->toArray())) / $allPackages->count() : 0;
    
    $allUniqueFeatures = array_unique($allFeatures);
    
    return view('backend.services.packages.features', compact(
        'packages', 'allPackages', 'allUniqueFeatures', 'featureStats',
        'commonFeatures', 'categoryFeatures', 'avgFeatures'
    ));
}

public function getFeatures($id)
{
    $package = ServicePackage::findOrFail($id);
    
    return response()->json([
        'features' => $package->features ?? []
    ]);
}

public function updateFeatures(Request $request)
{
    $package = ServicePackage::findOrFail($request->package_id);
    
    $features = [];
    if ($request->has('features')) {
        foreach ($request->features as $feature) {
            if (!empty(trim($feature))) {
                $features[] = trim($feature);
            }
        }
    }
    
    $package->update(['features' => $features]);
    
    return redirect()->back()->with('success', 'Package features updated successfully.');
}
}