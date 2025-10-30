<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankName extends Model
{
    protected $table = 'bank_name';
    protected $primaryKey = 'bank_name_id';
    protected $fillable = [
        'bank_name_id',
        'bank_name',
    ];
}
