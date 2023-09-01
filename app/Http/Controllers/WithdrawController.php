<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\WithdrawRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Type\Decimal;

class WithdrawController extends Controller
{
    
    public function create(): View
    {
        return view('withdraw');
    }


    public function store(WithdrawRequest $request)
    {
        // Validate user balance before substraction
        $request->sufficientBalance();
        
        $user = Auth()->user();

        // Decrease user balance
        $updatedBalance = $user->update(['balance' => $user->balance - $request->amount]);
        
        if (!$updatedBalance) {
            return back()->with(['error' => 'Withdraw was not successful please try again.']);
        }

        Transaction::create([
            'amount' => $request->amount,
            'type' => 'debit',
            'balance' => $user->balance,
            'user_id' => $user->id,
        ]);
        
        return back()->with(['success' => 'Withdraw successful.']);

    }


}
