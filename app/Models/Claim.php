<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Claim extends Model
{
    protected $fillable = [
        'employee_id',
        'claim_type',
        'amount',
        'claim_date',
        'description',
        'receipt_path',
        'status',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}