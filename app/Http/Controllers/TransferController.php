<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\TransferRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction;
use App\Models\User;

class TransferController extends Controller
{
    
    public function create(): View
    {
        return view('transfer');
    }


    public function store(TransferRequest $request)
    {
        // Validate user balance before substraction
        $request->sufficientBalance();

        // Prevent self transfer

        $request->preventSelfTransfer();

        $user = Auth()->user();
        $beneficiary = User::where('email', $request->email)->first();

        // Decrease user balance
        $updatedBalance = $user->update(['balance' => $user->balance - $request->amount]);
        
        // Increase beneficiary balance
        $updatedBeneficiaryBalance = $beneficiary->update(['balance' => $beneficiary->balance + $request->amount]);

        if (!$updatedBalance || !$updatedBeneficiaryBalance) {
            return back()->with(['error' => 'Transfer was not successful please try again.']);
        }


        // Creating transaction record for sender
        Transaction::create([
            'amount' => $request->amount,
            'type' => 'debit',
            'balance' => $user->balance,
            'user_id' => $user->id,
            'beneficiary' => $beneficiary->id
        ]);

        // Creating transaction record for beneficiary
        Transaction::create([
            'amount' => $request->amount,
            'type' => 'credit',
            'balance' => $beneficiary->balance,
            'user_id' => $beneficiary->id,
            'beneficiary' => $user->id
        ]);

        return back()->with(['success' => 'Transfer successful.']);

    }


}
