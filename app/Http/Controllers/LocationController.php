<?php
namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;

class LocationController extends Controller
{
    public function getStatesByCountry($countryId)
    {
        if (!Country::where('id', $countryId)->exists()) {
            return response()->json(['states' => []], 404);
        }
       
        return response()->json([
            'states' => State::where('country_id', $countryId)
                ->orderBy('name')
                ->select('id', 'name')
                ->get()
        ]);
    }
}