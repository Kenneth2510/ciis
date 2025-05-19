<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmployeeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);

        $user = User::where('employee_id', $request->employee_id)->first();

        if ($user) {
            return redirect()->back()->with('showVerifyEidModal', $user);
        }

        return redirect()->back();
    }

    public function sendPasswordResetMail(Request $request)
    {
        $user = User::where('employee_id', $request->employee_id)->first();
        $new = [];

        if ($user)
        {
            $new['employee_id'] = $user->employee_id;
            $new['password'] = Str::password(12);
            $new['message'] = 'Recovery Password Request';
            $new['raw_password'] = $new['password'];
        }

            // Mail::to($this->email)->send(new EmployeeMail($new));
            Mail::to('philip.jhon.santillan@bankofmakati.com.ph')->send(new EmployeeMail($new));

            $new['password'] = Hash::make($new['password']);

            $user->update([
                'password' => $new['password'],
                'isReset' => 0,
                'status' => 'active'
            ]);

            // return back()->with('status', __('A reset link will be sent if the account exists.'));
            return redirect()->back()->with('toast', [
                'type' => 'success',
                'message' => 'Profile update successfully!',
            ]);
    }
}
