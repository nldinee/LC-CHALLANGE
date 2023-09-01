<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction;

class DepositController extends Controller
{
    
    public function create(): View
    {
        return view('deposit');
    }


    public function store(DepositRequest $request)
    {
        $user = Auth()->user();

        // Increase user balance
        $updatedBalance = $user->update(['balance' => $user->balance + $request->amount]);
        
        if (!$updatedBalance) {
            return back()->with(['error' => 'Deposit was not successful please try again.']);
        }

        Transaction::create([
            'amount' => $request->amount,
            'type' => 'credit',
            'balance' => $user->balance,
            'user_id' => $user->id,
        ]);

        return back()->with(['success' => 'Deposit successful.']);

    }


}
