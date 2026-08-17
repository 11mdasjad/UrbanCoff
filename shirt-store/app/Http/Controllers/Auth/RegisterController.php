<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Merge guest cart
        $sessionId = $request->session()->getId();
        \App\Models\CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->update(['user_id' => $user->id, 'session_id' => null]);

        return redirect()->intended(route('home'))->with('success', 'Welcome to URBANCOFF! Your account has been created.');
    }
}
