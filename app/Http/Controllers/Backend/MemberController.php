<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Role;

class MemberController extends Controller
{
   public function index(Request $request)
    {
        return $this->getMembers($request, 'all');
    }
    // Active Members
    public function active(Request $request)
    {
        return $this->getMembers($request, 'active');
    }

    // Inactive Members
    public function inactive(Request $request)
    {
       
        return $this->getMembers($request, 'inactive');
    }

    // Pending Members (New Registrations)
    public function pending(Request $request)
    {
        return $this->getMembers($request, 'pending');
    }
   // Common method for all member types
    private function getMembers(Request $request, $type = 'all')
    {
       
        // NORMAL PAGE LOAD
        if (!$request->ajax()) {
            $countries = Country::where('status', 1)
                ->orderBy('name')
                ->get();
           
            return view('backend.members.index', compact('countries', 'type'));
        }
        $type = $request->input('type');
        // DATATABLE AJAX REQUEST
        $query = User::query()
            ->whereHas('role', function ($q) {
                $q->where('name', 'member');
            });
      
        // Apply status filter based on type
        switch ($type) {
            case 'active':
                $query->where('status', 'active');
                break;
            case 'inactive':
                $query->where('status', 'inactive');
                break;
            case 'pending':
                $query->where('status', 'pending')
                      ->whereNull('approved_at'); // New registrations
                break;
            // 'all' shows all members regardless of status
        }

       
        if ($request->search_text) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search_text}%")
                  ->orWhere('last_name', 'like', "%{$request->search_text}%")
                  ->orWhere('email', 'like', "%{$request->search_text}%")
                  ->orWhere('mobile', 'like', "%{$request->search_text}%");
            });
        }

      
        if ($request->countryid) {
            $query->where('countryid', $request->countryid);
        }

        
        if ($request->regionid) {
            $query->where('regionid', $request->regionid);
        }

        $totalRecords = $query->count();

        // PAGINATION
        $members = $query
            ->with(['country', 'state'])
            ->offset($request->start)
            ->limit($request->length)
            ->orderBy('id', 'desc')
            ->get();

        $data = [];
        foreach ($members as $member) {
            // Status badge based on member status
            $statusBadge = match($member->status) {
                'active' => '<span class="badge bg-success">Active</span>',
                'inactive' => '<span class="badge bg-danger">Inactive</span>',
                'pending' => '<span class="badge bg-warning">Pending</span>',
                default => '<span class="badge bg-secondary">Unknown</span>'
            };
          $referralUrl = url('/register?ref=' . $member->referral_code);

            $sponsorInfo = $member->sponsor 
        ? $member->sponsor->first_name . ' ' . $member->sponsor->last_name . '<br><small class="text-muted">' . ($member->sponsor->member_id ?? 'N/A') . '</small>'
        : '<span class="text-muted">No Sponsor</span>';
            // Approval badge for pending members
            $approvalBadge = '';
            if ($type == 'pending') {
                $approvalBadge = '
                    <div class="mt-1">
                        <button class="btn btn-xs btn-success btn-approve" data-id="'.$member->id.'">Approve</button>
                        <button class="btn btn-xs btn-danger btn-reject" data-id="'.$member->id.'">Reject</button>
                    </div>
                ';
            }

            

            $data[] = [
                'checkbox' => '<input type="checkbox" value="'.$member->id.'">',
                'member' => '
                    <div class="d-flex align-items-center">
                        <img src="'.$member->profile_image.'" class="avatar avatar-sm me-2">
                        <div>
                            <strong>'.$member->first_name.' '.$member->last_name.'
                             <a href="javascript:void(0)" 
                   class="ms-1 text-primary"
                   title="Copy referral link"
                   onclick="copyReferralLink(\''.$referralUrl.'\')">
                    <i class="isax isax-copy"></i>
                </a>
                <a href="javascript:void(0)" 
                   class="ms-1 text-success"
                   title="Share referral link"
                   onclick="shareReferralLink(\''.$referralUrl.'\')">
                    <i class="isax isax-send-2"></i>
                </a>
                            </strong>
                            '.$approvalBadge.'
                        </div>
                    </div>',
                     'member_id' => $member->member_id,
                    'sponsor' => $sponsorInfo,
                'mobile'   => $member->mobile ?? '-',
                'email'    => $member->email,
                'country'  => optional($member->country)->name ?? '-',
                'status'   => $statusBadge,
                'actions'  => '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'.route('members.edit', $member->id).'"><i class="isax isax-edit me-2"></i>Edit</a></li>
                            '.($member->status == 'active' ? 
                                '<li><a class="dropdown-item" href="#" onclick="toggleStatus('.$member->id.', \'inactive\')"><i class="isax isax-user-tag me-2"></i>Deactivate</a></li>' : 
                                '<li><a class="dropdown-item" href="#" onclick="toggleStatus('.$member->id.', \'active\')"><i class="isax isax-user-tick me-2"></i>Activate</a></li>'
                            ).'
                            <li><a class="dropdown-item" href="#" onclick="deleteMember('.$member->id.')"><i class="isax isax-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                ',
            ];
        }

        return response()->json([
            'draw'            => intval($request->draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $data,
        ]);
    }

    // Update member status
    public function updateStatus(Request $request, $id)
    {
        
        try {
            $member = User::findOrFail($id);
            
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,pending',
            ]);

            $member->update([
                'status' => $request->status,
                'approved_at' => $request->status == 'active' ? now() : null,
                'approved_by' => $request->status == 'active' ? auth()->id() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member status updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    // Approve pending member
    public function approve(Request $request, $id)
    {
        try {
            $member = User::findOrFail($id);
            
            $member->update([
                'status' => 'active',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member approved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve member'
            ], 500);
        }
    }

    public function create()
    {
        $countries = Country::where('status', 1)
            ->orderBy('name')
            ->get();
        
        $states = State::orderBy('name')->get();

        $sponsors = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })
        ->where('status', 'active')
        ->whereNotNull('approved_at')
        ->orderBy('first_name')
        ->get(['id', 'first_name', 'last_name', 'mobile', 'member_id']);

        return view('backend.members.create', compact('countries', 'states','sponsors'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|string|max:20',
                'dob' => 'nullable|date',
                'anniversary' => 'nullable|date',
                'address1' => 'nullable|string|max:500',
                'address2' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:100',
                'zip' => 'nullable|string|max:20',
                'countryid' => 'nullable|exists:countries,id',
                'regionid' => 'nullable|exists:states,id',
                'sponsor_id' => 'nullable|exists:users,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get member role
            $memberRole = Role::where('name', 'member')->first();
            if (!$memberRole) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member role not found'
                ], 500);
            }
            $memberId = User::generateMemberId();
            $data = $request->all();
            $data['role_id'] = $memberRole->id;
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['password'] = Hash::make($request->password);
            $data['email_verified_at'] = now();
            $data['approved_at'] = now();
            $data['member_id'] = $memberId;
            $data['registration_type'] = 'admin';
            $data['approved_by'] = Auth::id();
            $data['status'] = 'active';
            $data['created_by_admin'] = Auth::id();
            $data['referral_code'] = User::generateReferralCode();
             
            // Validate sponsor (if provided)
       // Check if this is the first member
$existingMembersCount = User::whereHas('role', function ($q) {
    $q->where('name', 'member');
})->count();

// If first member, don't require sponsor
if ($existingMembersCount === 0 && !$request->sponsor_id) {
    $data['sponsor_id'] = null; // No sponsor for first member
    $data['is_root'] = true; // Flag as root member
} else {
    // For subsequent members, sponsor is required
    if (!$request->sponsor_id) {
        return response()->json([
            'success' => false,
            'message' => 'Sponsor is required'
        ], 422);
    }
    
    // Validate sponsor
    $sponsor = User::where('id', $request->sponsor_id)
        ->whereHas('role', function ($q) {
            $q->where('name', 'member');
        })
        ->where('status', 'active')
        ->first();

    if (!$sponsor) {
        return response()->json([
            'success' => false,
            'message' => 'Selected sponsor is not valid or inactive'
        ], 422);
    }
    
    $data['sponsor_id'] = $sponsor->id;
}
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'users/' . $imageName;
                
                // Resize and save image
               $resizedImage = Image::read($image)->resize(300, 300);
                Storage::disk('public')->put($imagePath, (string) $resizedImage->encode());
                
                $data['image'] = $imagePath;
            }

            // Create member
            $member = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Member created successfully',
                'redirect_url' => route('members.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Member creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $member = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })->findOrFail($id);

        $countries = Country::where('status', 1)
        ->orderBy('name')
        ->get();

    // Get states based on user's country
    $states = [];
    if ($member->countryid) {
        $states = State::where('country_id', $member->countryid)
            ->orderBy('name')
            ->get();
    }  

    $sponsors = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })
        ->where('status', 'active')
        ->whereNotNull('approved_at')
        ->orderBy('first_name')
        ->get(['id', 'first_name', 'last_name', 'mobile', 'member_id']);

        return view('backend.members.edit', compact('member', 'countries', 'states', 'sponsors'));
    }

    public function update(Request $request, $id)
    {
        try {
            $member = User::whereHas('role', function ($q) {
                $q->where('name', 'member');
            })->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($member->id)
                ],
                'mobile' => 'required|string|max:20',
                'dob' => 'nullable|date',
                'anniversary' => 'nullable|date',
                'address1' => 'nullable|string|max:500',
                'address2' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:100',
                'zip' => 'nullable|string|max:20',
                'countryid' => 'nullable|exists:countries,id',
                'regionid' => 'nullable|exists:states,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->except('password');
            $data['name'] = $request->first_name . ' ' . $request->last_name;

            // Handle password update
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($member->image && Storage::disk('public')->exists($member->image)) {
                    Storage::disk('public')->delete($member->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'users/' . $imageName;
                
                // Resize and save image
                $resizedImage = Image::make($image)->fit(300, 300);
                Storage::disk('public')->put($imagePath, (string) $resizedImage->encode());
                
                $data['image'] = $imagePath;
            }

            // Update member
            $member->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully',
                'redirect_url' => route('members.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Member update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update member: ' . $e->getMessage()
            ], 500);
        }
    }
   // In MemberController
public function getSponsorDetails(Request $request)
{
    try {
        $sponsorId = $request->sponsor_id;
        
        $sponsor = User::where('id', $sponsorId)
            ->whereHas('role', function ($q) {
                $q->where('name', 'member');
            })
            ->where('status', 'active')
            ->first();

        if (!$sponsor) {
            return response()->json([
                'success' => false,
                'message' => 'Sponsor not found or inactive'
            ]);
        }

        // Get downline count
        $downlineCount = User::where('sponsor_id', $sponsorId)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $sponsor->id,
                'member_id' => $sponsor->member_id,
                'full_name' => $sponsor->first_name . ' ' . $sponsor->last_name,
                'email' => $sponsor->email,
                'mobile' => $sponsor->mobile,
                'total_downline' => $downlineCount,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch sponsor details'
        ]);
    }
}
    public function destroy($id)
    {
        try {
            $member = User::whereHas('role', function ($q) {
                $q->where('name', 'member');
            })->findOrFail($id);

            // Delete image if exists
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }

            $member->delete();

            return response()->json([
                'success' => true,
                'message' => 'Member deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Member deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete member'
            ], 500);
        }
    }
}