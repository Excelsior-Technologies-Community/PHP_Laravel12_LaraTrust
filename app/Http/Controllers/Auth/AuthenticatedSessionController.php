<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
      * Display the login view.
      */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
      * Handle an incoming authentication request.
      */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        LoginHistory::create([
            'user_id' => auth()->id(),
            'email' => auth()->user()->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
      * Destroy an authenticated session.
      */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        if ($user) {
            LoginHistory::where('user_id', $user->id)
                ->whereNull('logged_out_at')
                ->update(['logged_out_at' => now()]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
