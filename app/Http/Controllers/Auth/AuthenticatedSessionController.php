<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
     
        // for account status
        $authWarning = Session::get('authWarning');
        $authLocked = Session::get('authLocked');
        
        if($authWarning) {
            return redirect()->back()->with('showAccountWarningModal', true);
        }
        
        if($authLocked) {
            return redirect()->back()->with('showAccountLockedModal', true);
        }

        $multiSession = Session::get('multiSession');
        if($multiSession) {
            return redirect()->back()->with('showMultiSessionModal', true);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Log::info('User Logged Out', ['user_id' => Auth::id()]);
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function killSession()
    {
        $user = User::find(Session::get('multiSession'));
        $currentSessionId = Session::getId();

        DB::table('sessions')->where('user_id', $user->id)->whereNot('id', $currentSessionId)->delete();

        $user = User::find(Session::get('multiSession'));

        if ($user) {
            Auth::login($user);
            DB::table('sessions')
                ->where('id', Session::getId())
                ->update(['user_id' => $user->id]);

            Session::forget('multiSession');

            return redirect()->route('dashboard');
        }
    }
}
