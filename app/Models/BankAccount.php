<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_account';
    protected $primaryKey = 'bank_account_id';
    protected $fillable = [
        'bank_account_id',
        'bank_name_id',
    ];
    public $timestamps = false;
    public $incrementing = false;

    public function bank_name()
    {
        return $this->belongsTo(BankName::class, 'bank_name_id');
    }
}
