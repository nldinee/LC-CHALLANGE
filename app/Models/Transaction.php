<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'amount',
        'balance',
        'type',
        'user_id',
        'beneficiary'
    ];


    public function beneficiaryUser() {
        return $this->belongsTo(User::class, 'beneficiary');
    }


    public function getDetailsAttribute()
    {
        
        if ($this->beneficiary != null && $this->beneficiary != auth()->user()->id  && $this->type == 'debit') {
            return 'Transfer to ' . $this->beneficiaryUser->email;
        }
        else if ($this->beneficiary != null && $this->beneficiary != auth()->user()->id && $this->type == 'credit') {
            return 'Transfer from ' . $this->beneficiaryUser->email;
        }
        else {
            return $this->type == 'credit' ? 'Deposit' : 'Debit';
        }

    }

}
