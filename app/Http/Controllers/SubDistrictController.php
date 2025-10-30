<?php

namespace App\Http\Controllers;

use App\Models\Subdistricts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubDistrictController extends Controller
{
    public function getSubdistricts($district_id)
{
    $subdistricts = Subdistricts::where('district_id', $district_id)
        ->select('subdistrict_id', 'name_in_thai', 'zip_code')
        ->get();
    
    return response()->json($subdistricts);
}
}