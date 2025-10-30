<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistrictController extends Controller
{
    public function getDistricts($provinceId)
    {
        try {
            // ตรวจสอบว่ามีค่าส่งมาไหม
            if (empty($provinceId)) {
                return response()->json(['error' => 'Province ID is required'], 400);
            }

            // ลอง log ดูก่อน
            Log::info("Fetching districts for province: " . $provinceId);

            // ดึงข้อมูลจาก database
            $districts = Districts::where('province_id', $provinceId)
                ->select('district_id', 'name_in_thai', 'province_id')
                ->get();

            // ลอง log ผลลัพธ์
            Log::info("Found districts: " . $districts->count());

            // ถ้าไม่มีข้อมูล
            if ($districts->isEmpty()) {
                return response()->json([]);
            }

            return response()->json($districts);

        } catch (\Exception $e) {
            // บันทึก error
            Log::error("Error in getDistricts: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json(['test' => 'OK', 'province_id' => $provinceId]);
    }
}