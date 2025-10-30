<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $table = 'farmers';
    protected $primaryKey = 'farmer_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'village_id',
        'subdistrict_id',
        'district_id',
        'province_id',
        'zip_code',
        'phone_number',
        'total_rai',
        'pledge_right_kg', //สิทธื์การจำนำสูงสุด
        'pledged_amount_kg', // ปริมาณข้าวที่จำนำไปเเล้ว
        'bank_account_id',
        'verification_status',
    ];
    public $timestamps = true;

    public function subdistricts()
    {
        return $this->belongsTo(Subdistricts::class, 'subdistrict_id');
    }

    public function districts()
    {
        return $this->belongsTo(Districts::class, 'district_id');
    }

    public function provinces()
    {
        return $this->belongsTo(Provinces::class, 'province_id');
    }

    public function bank_account()
    {
        return $this->hasOne(BankAccount::class, 'bank_account_id');
    }

    //เกษตรกรที่รับรองคนนี้

    public function verifiers()
    {
        return $this->belongsToMany(
            Farmer::class,
            'verifications',
            'farmer_id',
            'verify_by_farmer_id'
        )->withPivot('verify_at');
    }

    // เกษตรกรที่คนนี้ไปรับรองให้
    public function verifyFors()
    {
        return $this->belongsToMany(
            Farmer::class,
            'verifications',
            'verify_by_farmer_id',
            'farmer_id',
        )->withPivot('verify_at')->withTimestamps();
    }

    public function verifiedRecord()
    {
        return $this->hasMany(Verifications::class, 'farmer_id');
    }

    public function verifyForsRecord()
    {
        return $this->hasMany(Verifications::class, 'verify_by_farmer_id');
    }

    public function canVerify(Farmer $farmer)
    {
        //ต้องอยู่หมูบ้านเดียวกัน
        if (
            $this->village_id !== $farmer->village_id ||
            $this->subdistrict_id !== $farmer->subdistrict_id ||
            $this->district_id !== $farmer->district_id ||
            $this->province_id !== $farmer->province_id
        ) {
            return false;
        }

        //ไม่สามรถรับรองตัวเองได้
        if (
            $this->farmer_id === $farmer->farmer_id
        ) {
            return false;
        }

        //คนท่ีจะรับรอง ต้องได้รับการรับรองเเล้ว
        // if($this->verification_status !== '1'){
        //     return false;
        // }

        $alreadyApproved = Verifications::where('farmer_id', $farmer->farmer_id)
            ->where('verify_by_farmer_id', $this->farmer_id)
            ->exists();

        return !$alreadyApproved;
    }

    //ตรวจสอบว่าได้รับการรับรองครบ 5 คนหรือยัง

    public function isFullyVerified(){
        return $this->verifiers()->count() >= 5;
    }

    // นับจำนวนคนที่รับรองเเล้ว
    public function getVerifiedCount(){
        return $this->verifiers()->count();
    }

    // หาเกษตรกรในหมู่บ้านเดียวกันที่สามารถรับรองได้
    public function getEligibleVerfify(){
        return self::where('village_id',$this->village_id)
                    ->where('subdistrict_id',$this->subdistrict_id)
                    ->where('district_id',$this->district_id)
                    ->where('province_id',$this->province_id)
                    ->where('farmer_id',"!=",$this->farmer_id)
                    ->whereNotIn('farmer_id', function($query) { //เลือกรายการทั้งหมดจากตารางหลัก โดยที่ไอดีของรายการนั้น ต้องไม่อยู่ในรายชื่อไอดีที่มาจากคิวรีย่อย
                        $query->select('verify_by_farmer_id')
                            ->from('verifications')
                            ->where('farmer_id', $this->farmer_id);
                    }) ->get();
    }
}
