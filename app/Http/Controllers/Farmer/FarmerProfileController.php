<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Districts;
use App\Models\Farmer;
use App\Models\Provinces;
use App\Models\Subdistricts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FarmerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farmers = Farmer::all();
        $provinces = Provinces::all();
        return view('farmer.profile.index', [FarmerDashboardController::class, 'farmers' => $farmers,'provinces' => $provinces]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subdistricts = Subdistricts::all();
        $provinces = Provinces::all();
        $districts = Districts::all();
        return view('farmer.profile.create', ['subdistricts' => $subdistricts, 'provinces' => $provinces, 'districts' => $districts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //บันทึกข้อมูล

        $validated = $request->validate([
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'phone_number' => 'required|string|size:10',
            // 'address' => 'required|string',
            // 'province_id' => 'required|integer',
            // 'district_id' => 'required|integer',
            // 'subdistrict_id' => 'required|integer',
            // 'zip_code' => 'required|string|max:5',
            // 'pledge_right_kg' => 'required|numeric|min:0',
            'bank_account_id' => 'required|string|unique:farmers,bank_account_id', // เช็คใน table farmers, // เช็คว่ามีในตาราง bank_account แล้วหรือยัง

        ]);

        $existingFarmer = Farmer::where('bank_account_id', $request->bank_account_id)->first();

        if ($existingFarmer) {
            // ถ้าเป็น Ajax request ส่ง JSON กลับไป
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'เลขบัญชีนี้ถูกใช้งานโดยเกษตรกรท่านอื่นแล้ว',
                    'farmer' => [
                        'name' => $existingFarmer->first_name . ' ' . $existingFarmer->last_name,
                        'phone' => $existingFarmer->phone_number
                    ]
                ], 422);
            }

            // ถ้าไม่ใช่ Ajax ให้ redirect กลับพร้อม error
            return redirect()->back()
                ->withInput()
                ->withErrors(['bank_account_id' => 'เลขบัญชีนี้ถูกใช้งานโดยเกษตรกรท่านอื่นแล้ว']);
        }

        BankAccount::firstOrCreate([
            'bank_account_id' => $request->bank_account_id,
            'bank_name_id' => $request->bank_name_id,
        ]);

        Farmer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'village_id'=> $request->village_id,
            'subdistrict_id' => $request->subdistrict_id,
            'district_id' => $request->district_id,
            'province_id' => $request->province_id,
            'zip_code' => $request->zip_code,
            'phone_number' => $request->phone_number,
            'total_rai' => 25,
            'pledge_right_kg' => $request->pledge_right_kg, //สิทธื์การจำนำสูงสุด
            'pledged_amount_kg' => 0.00, // ปริมาณข้าวที่จำนำไปเเล้ว
            'bank_account_id' => $request->bank_account_id,
            'is_certified' => 1,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'เพิ่มข้อมูลสำเร็จ',
                'redirect' => route('farmer.profile.index')
            ]);
        }


        return redirect()->route('farmer.profile.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $farmer = Farmer::with([
        'subdistricts',
        'districts', 
        'provinces',
    ])
    ->join('bank_account', 'farmers.bank_account_id', '=', 'bank_account.bank_account_id')
    ->join('bank_name', 'bank_account.bank_name_id', '=', 'bank_name.bank_name_id')
    ->join('village','village.village_id','=','farmers.village_id')
    ->select('farmers.*', 'bank_name.bank_name as bank_name','village_name')
    ->findOrFail($id);
    
    return view('farmer.profile.show', ['farmer' => $farmer]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //แสดงฟอร์มแก้ไข
        $farmer = Farmer::findOrFail($id);
        $provinces = Provinces::all();
        $districts = Districts::where('province_id', $farmer->province_id)->get();
        $subdistricts = Subdistricts::where('district_id', $farmer->district_id)->get();
        // $banks = $this->getBankList();
        return view('farmer.profile.edit', compact('farmer', 'provinces', 'districts', 'subdistricts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)

    {
        //อีพเดทข้อมูล
        $farmer = Farmer::findOrFail($id);
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|size:10',
            'address' => 'required|string',
            'province_id' => 'required|integer',
            'district_id' => 'required|integer',
            'subdistrict_id' => 'required|integer',
            'zip_code' => 'required|string|max:5',
            'total_rai' => 'required|numeric|min:0',
            'pledge_right_kg' => 'required|numeric|min:0',
            'bank_account_id' => 'required|integer',
            'bank_name_id',
        ]);
        //Todo: เพ่ิม validating / update ข้อมูล
        $farmer->update($validated);


        return redirect()->route('farmer.profile.index')->with('success', 'อัพเดทข้อมูลสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //todo : ลบขู้อมุล
        $farmer = Farmer::findOrFail($id);
        $farmer->delete();
        return redirect()->route('farmer.profile.index')->with('success', 'ลบข้อมูลเกษตรกรสำเร็จ');
    }
}
