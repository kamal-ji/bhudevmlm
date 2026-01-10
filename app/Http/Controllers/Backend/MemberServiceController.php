<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ServiceCategory;
use App\Models\MemberServiceCategory;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class MemberServiceController extends Controller
{
    public function index()
    {
        $assignments = MemberServiceCategory::with(['member', 'serviceCategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('backend.services.member-services.index', compact('assignments'));
    }

    public function create()
    {
        $members = User::where('status', 'active')->get();
        $categories = ServiceCategory::where('status', 'active')->get();
        
        return view('backend.services.member-services.create', compact('members', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'service_category_id' => 'required|exists:service_categories,id',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        // Check if already assigned
        $existing = MemberServiceCategory::where([
            'member_id' => $request->member_id,
            'service_category_id' => $request->service_category_id
        ])->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Member is already assigned to this service category.');
        }

        $member = User::find($request->member_id);
        $category = ServiceCategory::find($request->service_category_id);

        // Generate referral code
        $referralCode = MemberServiceCategory::generateReferralCode($member, $category);

        MemberServiceCategory::create([
            'member_id' => $request->member_id,
            'service_category_id' => $request->service_category_id,
            'referral_code' => $referralCode,
            'commission_rate' => $request->commission_rate ?? $category->commission_rate,
            'status' => 'active',
        ]);

        return redirect()->route('member-services.index')
            ->with('success', 'Service category assigned to member successfully.');
    }

    public function edit($id)
    {
        $assignment = MemberServiceCategory::with(['member', 'serviceCategory'])
            ->findOrFail($id);
        
        return view('backend.services.member-services.edit', compact('assignment'));
    }

    public function update(Request $request, $id)
    {
        $assignment = MemberServiceCategory::findOrFail($id);
        
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $assignment->update([
            'commission_rate' => $request->commission_rate,
            'status' => $request->status,
        ]);

        return redirect()->route('member-services.index')
            ->with('success', 'Member service assignment updated successfully.');
    }

    public function generateCodes()
    {
        $members = User::where('status', 'active')->get();
        $categories = ServiceCategory::where('status', 'active')->get();
        
        return view('backend.services.member-services.generate-codes', compact('members', 'categories'));
    }

    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id',
            'service_category_ids' => 'required|array',
            'service_category_ids.*' => 'exists:service_categories,id',
        ]);

        $generated = 0;
        $skipped = 0;

        foreach ($request->member_ids as $memberId) {
            foreach ($request->service_category_ids as $categoryId) {
                // Check if already assigned
                $existing = MemberServiceCategory::where([
                    'member_id' => $memberId,
                    'service_category_id' => $categoryId
                ])->first();

                if (!$existing) {
                    $member = User::find($memberId);
                    $category = ServiceCategory::find($categoryId);

                    $referralCode = MemberServiceCategory::generateReferralCode($member, $category);

                    MemberServiceCategory::create([
                        'member_id' => $memberId,
                        'service_category_id' => $categoryId,
                        'referral_code' => $referralCode,
                        'commission_rate' => $category->commission_rate,
                        'status' => 'active',
                    ]);
                    
                    $generated++;
                } else {
                    $skipped++;
                }
            }
        }

        return redirect()->route('member-services.index')
            ->with('success', "Generated $generated new referral codes. Skipped $skipped existing assignments.");
    }

  public function commissionOverride()
{
    $assignments = MemberServiceCategory::with(['member', 'serviceCategory'])
        ->join('service_categories', 'member_service_categories.service_category_id', '=', 'service_categories.id')
        ->whereColumn('member_service_categories.commission_rate', '!=', 'service_categories.commission_rate')
        ->orWhereNull('member_service_categories.commission_rate')
        ->select('member_service_categories.*') // Ensure we get the main model columns
        ->paginate(20);
    
    $categories = ServiceCategory::all();
    
    // Statistics for chart - need to join for these queries too
    $belowDefault = MemberServiceCategory::join('service_categories', 'member_service_categories.service_category_id', '=', 'service_categories.id')
        ->whereColumn('member_service_categories.commission_rate', '<', 'service_categories.commission_rate')
        ->count();
    
    $atDefault = MemberServiceCategory::join('service_categories', 'member_service_categories.service_category_id', '=', 'service_categories.id')
        ->whereColumn('member_service_categories.commission_rate', '=', 'service_categories.commission_rate')
        ->count();
    
    $aboveDefault = MemberServiceCategory::join('service_categories', 'member_service_categories.service_category_id', '=', 'service_categories.id')
        ->whereColumn('member_service_categories.commission_rate', '>', 'service_categories.commission_rate')
        ->count();
    
    return view('backend.services.member-services.commission-override', compact(
        'assignments', 'categories', 'belowDefault', 'atDefault', 'aboveDefault'
    ));
}

public function updateCommission(Request $request, $id)
{
    $assignment = MemberServiceCategory::findOrFail($id);
    
    $request->validate([
        'commission_rate' => 'required|numeric|min:0|max:100'
    ]);
    
    $assignment->update([
        'commission_rate' => $request->commission_rate
    ]);
    
    return redirect()->back()->with('success', 'Commission rate updated successfully.');
}

public function resetCommission(Request $request, $id)
{
    $assignment = MemberServiceCategory::with('serviceCategory')->findOrFail($id);
    
    $assignment->update([
        'commission_rate' => $assignment->serviceCategory->commission_rate
    ]);
    
    return response()->json(['success' => true]);
}

public function bulkUpdateCommission(Request $request)
{
    $request->validate([
        'service_category_id' => 'nullable|exists:service_categories,id',
        'commission_rate' => 'required|numeric|min:0|max:100',
        'apply_to' => 'required|array'
    ]);
    
    $query = MemberServiceCategory::query();
    
    if ($request->service_category_id) {
        $query->where('service_category_id', $request->service_category_id);
    }
    
    if (in_array('active', $request->apply_to)) {
        $query->where('status', 'active');
    }
    
    if (in_array('below_default', $request->apply_to)) {
        $query->whereColumn('commission_rate', '<', 'service_categories.commission_rate');
    }
    
    $updated = $query->update(['commission_rate' => $request->commission_rate]);
    
    return redirect()->back()->with('success', "Updated commission rates for {$updated} members.");
}

public function performance()
{
    $assignments = MemberServiceCategory::with(['member', 'serviceCategory'])
        ->orderBy('total_sales', 'desc')
        ->paginate(20);
    
    $categories = ServiceCategory::all();
    
    // Statistics
    $totalSales = MemberServiceCategory::sum('total_sales');
    $totalCommission = MemberServiceCategory::sum('total_commission');
    $totalOrders = ServiceOrder::count();
    $activeMembers = MemberServiceCategory::where('status', 'active')->count();
    
    // Top services by sales - use the memberServices relationship you already have
    $topServices = ServiceCategory::withCount(['members as member_count'])
        ->withSum('memberServices', 'total_sales')
        ->orderBy('member_services_sum_total_sales', 'desc')
        ->take(5)
        ->get();
    
    return view('backend.services.member-services.performance', compact(
        'assignments', 'categories', 'totalSales', 'totalCommission',
        'totalOrders', 'activeMembers', 'topServices'
    ));
}
}