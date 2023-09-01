<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction;

class StatementController extends Controller
{
    
    public function view(): View
    {
        // Fetch transactions from db
        $transactions = Transaction::where('user_id', Auth()->user()->id)->orderBy('id','DESC')->paginate(5);
        // dd($transactions);   

        // Return view with transactions
        return view('statement', compact('transactions'));
    }


}
