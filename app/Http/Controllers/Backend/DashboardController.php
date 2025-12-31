<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user data from session (external API)
        $externalUser = session('external_user');
       
        // You can fetch additional data from external API if needed
        $stats = $this->getDashboardStats($externalUser['id']);
        
        return view('backend.dashboard', [
            'user' => $externalUser,
            'stats' => $stats
        ]);
    }
    
    /**
     * Fetch dashboard stats from external API
     */
    private function getDashboardStats($token)
    {
      
        // Return default stats if API call fails
        return [
            'total_customers' => 0,
            'total_orders' => 0,
            'revenue' => 0,
            'pending_orders' => 0
        ];
    }
}
