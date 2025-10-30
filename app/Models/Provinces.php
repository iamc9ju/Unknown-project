<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{

    // use HasFactory;

    protected $table = 'provinces';
    protected $primaryKey = 'province_id';
    protected $fillable = [
        'province_code',
        'name_in_thai' ,
        'name_in_english',
        
    ];
    public $timestamps = false;
    //
}
