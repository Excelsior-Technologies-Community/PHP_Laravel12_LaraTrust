<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $histories = LoginHistory::where('user_id', $user->id)
            ->orderBy('logged_in_at', 'desc')
            ->paginate(20);

        $activeSessions = LoginHistory::where('user_id', $user->id)
            ->whereNull('logged_out_at')
            ->orderBy('logged_in_at', 'desc')
            ->get();

        return view('profile.login-history', compact('histories', 'activeSessions'));
    }

    public function destroy(Request $request, LoginHistory $loginHistory)
    {
        if ($loginHistory->user_id !== Auth::id()) {
            abort(403);
        }

        $loginHistory->update([
            'logged_out_at' => now(),
        ]);

        return back()->with('success', 'Session logged out successfully');
    }

    public function destroyAll(Request $request)
    {
        $user = Auth::user();
        
        LoginHistory::where('user_id', $user->id)
            ->whereNull('logged_out_at')
            ->update(['logged_out_at' => now()]);

        return back()->with('success', 'All sessions logged out successfully');
    }
}
