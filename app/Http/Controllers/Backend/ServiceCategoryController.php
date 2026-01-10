<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('sort_order')->get();
        return view('backend.services.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.services.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:service_categories',
            'description' => 'nullable|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'icon' => 'required|string',
            'color' => 'required|string',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'commission_rate' => $request->commission_rate,
            'icon' => $request->icon,
            'color' => $request->color,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Service category created successfully.');
    }

    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('backend.services.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100|unique:service_categories,name,' . $id,
            'description' => 'nullable|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'icon' => 'required|string',
            'color' => 'required|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'commission_rate' => $request->commission_rate,
            'icon' => $request->icon,
            'color' => $request->color,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Service category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);
        
        // Check if category has members or packages
        if ($category->members()->count() > 0 || $category->packages()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with members or packages.');
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Service category deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->status = $request->status;
        $category->save();
        
        return response()->json(['success' => true]);
    }

    public function commissionRates()
{
    $categories = ServiceCategory::withCount(['activeMembers'])
        ->orderBy('commission_rate', 'desc')
        ->get();
    
    return view('backend.services.categories.commission-rates', compact('categories'));
}

public function updateCommissionRates(Request $request)
{
   
    $request->validate([
        'rates' => 'required|array',
        'rates.*' => 'numeric|min:0|max:100'
    ]);
    
    foreach ($request->rates as $categoryId => $rate) {
        ServiceCategory::where('id', $categoryId)->update([
            'commission_rate' => $rate
        ]);
    }
    
    return redirect()->back()->with('success', 'Commission rates updated successfully.');
}

public function performance()
{
    // Use the memberServices relationship (hasMany) instead of members (belongsToMany)
    $categories = ServiceCategory::withCount([
        'activeMembers'
    ])->withSum('memberServices', 'total_sales')
      ->withSum('memberServices', 'total_commission')
      ->get();
    
    $totalSales = $categories->sum('member_services_sum_total_sales');
    $totalCommission = $categories->sum('member_services_sum_total_commission');
    $totalMembers = $categories->sum('active_members_count');
    $totalOrders = ServiceOrder::count();
    
    $topCategories = $categories->sortByDesc('member_services_sum_total_sales')->take(5);
    
    return view('backend.services.categories.performance', compact(
        'categories', 'totalSales', 'totalCommission', 
        'totalMembers', 'totalOrders', 'topCategories'
    ));
}

public function detailPerformance($id)
{
    $category = ServiceCategory::with([
        'members' => function($query) {
            $query->orderBy('member_service_categories.total_sales', 'desc')
                  ->withPivot('referral_code', 'commission_rate', 'total_sales', 'total_commission', 'status');
        },
        'packages' => function($query) {
            $query->withCount('orders');
        },
        'orders' => function($query) {
            $query->with(['member', 'servicePackage'])
                  ->latest()
                  ->take(10);
        }
    ])->findOrFail($id);
    
    // Calculate totals
    $memberCount = $category->members()->count();
    $totalSales = $category->members()->sum('member_service_categories.total_sales');
    $totalCommission = $category->members()->sum('member_service_categories.total_commission');
    $totalOrders = $category->orders()->count();
    
    return view('backend.services.categories.detail-performance', compact(
        'category',
        'memberCount',
        'totalSales',
        'totalCommission',
        'totalOrders'
    ));
}
}