<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifications extends Model
{
    use HasFactory;

    protected $table = 'verifications';
    protected $primaryKey = 'varification_id';

    protected $fillable = [
        'verification_id',
        'farmer_id',           // เกษตรกรที่ถูกรับรอง
        'verify_by_farmer_id', // เกษตรกรที่ทำการรับรอง             // pending, approved, rejected
        'verification_date',         // วันเวลาที่รับรอง
    ];
    public $timestamps = false;

    protected $casts = [
        'verification_date' => 'datetime',
    ];

    //กำหนดความสัมพันธ์ ทำให้ดึงข้อมูลที่เกี่ยข้องได้ง่ายขึ้น
    public function verified() {
        return $this->belongsTo(Farmer::class,'farmer_id'); //farmer_id = foreign_key belognsTo เพื่อดึงข้อมูลเกษตรกรที่ถูกรับรอง
    }

    public function verifier(){
        return $this->belongsTo(Farmer::class,'verify_by_farmer_id'); //verify_by_farmer_id = foreign_key belognTo เพื่อดึงข้อมูลเกษตรกรที่เป็นผู้รับรอง
    }


}
