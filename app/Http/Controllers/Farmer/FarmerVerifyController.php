<?php

namespace App\Http\Controllers\Farmer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Verifications;
use App\Models\Districts;
use App\Models\Provinces;
use App\Models\Subdistricts;
use App\Models\BankAccount;

class FarmerVerifyController extends Controller
{
    public function index()
    {

        //Farmer คนปัจจุบัน
        $allFarmers = Farmer::query() // 👈 เพิ่ม query() เพื่อเริ่มต้น Query Builder
        ->join('bank_account', 'farmers.bank_account_id', '=', 'bank_account.bank_account_id')
        ->join('bank_name', 'bank_account.bank_name_id', '=', 'bank_name.bank_name_id')
        ->join('village', 'village.village_id', '=', 'farmers.village_id')
        ->join('subdistricts', 'subdistricts.subdistrict_id', '=', 'farmers.subdistrict_id')
        ->join('districts', 'districts.district_id', '=', 'farmers.district_id')
        ->join('provinces', 'provinces.province_id', '=', 'farmers.province_id')
        ->select(
            'farmers.*',
            'bank_name.bank_name as bank_name',
            'village.village_name',
            'subdistricts.name_in_thai as subdistrict_name',
            'subdistricts.zip_code as subdistrict_zip_code',
            'districts.name_in_thai as district_name',
            'provinces.name_in_thai as province_name'
        )
        ->get();

        // $pendingFarmers = Farmer::where('village_id',$currentFarmer->village_id)
        // ->where('subdistrict',$currentFarmer->subdistrict_id)
        // ->where('district',$currentFarmer->district_id)
        // ->where('province',$currentFarmer->province_id)
        // ->where('farmer_id',$currentFarmer->farmer_id)
        // ->get();

        return view('farmer.verify.index', compact('allFarmers'));
    }

    // แสดงเกษตรกรที่รอการรับรอง (ตามหมู่บ้านของผุ้รับรอง)
    public function getPendingFarmers(Request $request, Farmer $verifier)
    {
        //ตรวจสอบว่าผู้รับรองผ่านการยืนยันเเล้ว
        // if ($approver->verification_status !== 'verified') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'เกษตรกรท่านนี้ยังไม่ได้รับการยืนยัน ไม่สามารถรับรองผู้อื่นได้'
        //     ], 403);
        // }

        // ดึงเกษตรกรที่รอการรับรองที่อยู่ในหมู่บ้านเดียวกัน
        $pendingFarmers = Farmer::where('village_id', $verifier->village_id)
            ->where('subdistrict_id', $verifier->subdistrict_id)
            ->where('district_id', $verifier->district_id)
            ->where('province_id', $verifier->province_id)
            ->where('farmer_id', "!=", $verifier->farmer_id)
            ->get()
            ->map(function ($farmer) use ($verifier) {
                //เช็คว่าผู้รับรองคนนี้ได้รับการรับรองไปเเล้วหรือยัง
                $farmer->already_verified_by_this_verifier = Verifications::where('farmer_id', $farmer->farmer_id)
                    ->where('verify_by_farmer_id', $verifier->farmer_id)
                    ->exists();

                //นับจำนวนการรรับรอง
                $farmer->verifier_count = $farmer->verifiers->count();

                //รายชื่อผู้รับรอง
                $farmer->verifier_list = $farmer->verifiers->map(function ($a) {
                    return [
                        'id' => $a->id,
                        'name' => $a->first_name . ' ' . $a->last_name,
                        'village_id' => $a->village_id
                    ];
                });

                return $farmer;
            });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'verifier' => [
                    'farmer_id' => $verifier->farmer_id,
                    'name' => $verifier->first_name . ' ' . $verifier->last_name,
                    'village_id' => $verifier->village_id,
                    'full_address' => 'test',
                ],
                'pending_farmers' => $pendingFarmers
            ]);
        }

        return view('farmer.verify.pending-list',compact('verifier','pendingFarmers'));
    }

    //search farmer ยังไม่ทำ

    //รับรองเกษตรกร
    public function verify(Request $request,Farmer $farmer){
        $request->validate([
            'verifier_id' => 'required|exists:farmers,farmer_id' //คือะไรนิ่ approver_id
        ]);
        
        $farmer = Farmer::findOrFail($farmer->farmer_id);
        
        $verifier = Farmer::findOrFail($request->verifier_id);

        //ตรวจสอบสิทธิ์
        if(!$verifier->canVerify($farmer)){
            return response()->json([
                'successs'=> false,
                'message' => 'ไม่สามารถรับรองได้(ไม่อยู่หมู่บ้านเดียวกันหรือรับรองไปเเล้ว)'
            ],403);
        }

        // $currentVerifiedCount = $farmer->verifiers()->count();
        // if ($currentVerifiedCount >= 5) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'เกษตรกรท่านนี้ได้รับการรับรองครบ 5 คนแล้ว'
        //     ], 400);
        // }

        try{
            //บันทึกการรับรอง
            Verifications::create([
                'farmer_id' => $farmer->farmer_id, //ผู้ถูกรับรอง
                'verify_by_farmer_id' => $verifier->farmer_id, //ผู้รับรอง
                'verify_at' => now(),
            ]);

            $verifiedCount = $farmer->getVerifiedCount();


             //ถ้าครบ 5 คนจะเปลี่ยนสถานะเป็น verified
            $isVerified = false;
            if($verifiedCount >= 5){
                $farmer->update(['verification_status'=> 1]);
                $isVerified = true;
            }

            return response()->json([
                'success' => true,
                'message' => $isVerified 
                    ? 'รับรองเกษตรกรเรียบร้อย และเกษตรกรได้รับการยืนยันครบ 5 คนแล้ว' 
                    : 'รับรองเกษตรกรเรียบร้อย',
                'verified_count' => $verifiedCount,
                'is_verified' => $isVerified,
                'remaining' => max(0, 5 - $verifiedCount)
            ]);
           
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }
}
