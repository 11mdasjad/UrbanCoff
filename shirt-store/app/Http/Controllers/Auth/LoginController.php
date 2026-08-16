<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Merge guest cart items to user cart after login
            $this->mergeGuestCart($request);

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Transfer session-based cart items to the authenticated user's cart.
     */
    private function mergeGuestCart(Request $request): void
    {
        $sessionId = $request->session()->getId();
        $user = Auth::user();

        \App\Models\CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->each(function ($cartItem) use ($user) {
                $existing = \App\Models\CartItem::where('user_id', $user->id)
                    ->where('variant_id', $cartItem->variant_id)
                    ->first();

                if ($existing) {
                    $existing->increment('quantity', $cartItem->quantity);
                    $cartItem->delete();
                } else {
                    $cartItem->update([
                        'user_id' => $user->id,
                        'session_id' => null,
                    ]);
                }
            });
    }
}
