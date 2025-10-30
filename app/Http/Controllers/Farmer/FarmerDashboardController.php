<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Farmer;


class FarmerDashboardController extends Controller
{
    public function index(){
        $farmers = Farmer::all();
        return view('farmer.index',[FarmerDashboardController::class,'farmers'=>$farmers]);
    }
}
