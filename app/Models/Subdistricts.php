<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdistricts extends Model
{

    // use HasFactory;

    protected $table = 'subdistricts';
    protected $primaryKey = 'subdistrict_id';
    protected $fillable = [
        'subdistrict_code',
        'name_in_thai' ,
        'name_in_english',
        'latitude',
        'longitude',
        'district_id',
        'zip_code',
    ];
    public $timestamps = false;
    //
}
