<?php

namespace App\Traits;
use Illuminate\Validation\ValidationException;


trait ValidationTrait {


    public function sufficientBalance() {
        
        if ((float) $this->amount > (float) auth()->user()->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient balance',
            ]);
        }

    }


}

