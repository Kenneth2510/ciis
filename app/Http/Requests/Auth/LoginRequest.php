<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'string', 'max:7'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        Session::forget('authWarning');
        Session::forget('authLocked');
        Session::forget('multiSession');

        $user = User::where('employee_id', $this->employee_id)->first();

        if (!$user || !Hash::check($this->password, $user->password))
        {
            if ($user && !Hash::check($this->password, $user->password))
            {
                $user->increment('failed_attempts');

                if ($user->failed_attempts === 3) {
                    Session::put('authWarning', true);
                    return;
                }

                if ($user->failed_attempts >= 5) {
                    Session::put('authLocked', true);
                    $user->update([
                        'status' => 'locked',
                    ]);
                    return;
                }
            }
            
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'employee_id' => __('auth.failed'),
            ]);
        }

        if ($user->status != 'active') {
            throw ValidationException::withMessages([
                'employee_id' => 'Your account is ' . $user->status . ' | Please Contact SAPU for Inquiry.',
            ]);
        }

        $existingSession = DB::table('sessions')
            ->where('user_id', $user->id)
            ->whereNot('id', Session::getId())
            ->where('last_activity', '>', now()->subMinutes(config('session.lifetime'))->timestamp)
            ->first();

        if ($existingSession) {
            Session::put('multiSession', $user->id);
            return;
        }

        RateLimiter::clear($this->throttleKey());

        $user->failed_attempts = 0;
        $user->save();

        Log::info('User Logged In', ['user_id' => $user->id]);

        Auth::attempt($this->only('employee_id', 'password'), $this->boolean('remember'));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'employee_id' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('employee_id')).'|'.$this->ip());
    }
}
