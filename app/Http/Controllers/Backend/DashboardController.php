<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get logged-in user
        $user = Auth::user();

        // Fetch dashboard stats (replace with real queries later)
        $stats = $this->getDashboardStats($user->id);

        return view('backend.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
    
    /**
     * Fetch dashboard stats
     */
    private function getDashboardStats($userId)
    {
        // You can fetch stats from your database
        return [
            'total_customers' => 0, // Example: Customer::count()
            'total_orders' => 0,    // Example: Order::count()
            'revenue' => 0,         // Example: Order::sum('total')
            'pending_orders' => 0   // Example: Order::where('status', 'pending')->count()
        ];
    }
}
