<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{

    // use HasFactory;

    protected $table = 'districts';
    protected $primaryKey = 'district_id';
    protected $fillable = [
        'district_code',
        'province_id',
        'name_in_thai',
        'name_in_english'
    ];
    public $timestamps = false;
    //s
}
