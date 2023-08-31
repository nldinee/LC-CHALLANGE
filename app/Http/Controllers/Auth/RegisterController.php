<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\AuthRegisterRequest;

class RegisterController extends Controller
{
    
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(AuthRegisterRequest $request): RedirectResponse
    {
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agreed_to_terms' => $request->agreed_to_terms,
        ]);


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


}
