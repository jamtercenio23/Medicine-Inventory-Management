<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Cache\RateLimiter;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 5; // Max login attempts
    protected $decayMinutes = 1; // Cooldown time in minutes

    protected $limiter;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->limiter = app(RateLimiter::class);
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts, $this->decayMinutes
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter->hit($this->throttleKey($request), $this->decayMinutes * 60);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())) . '|' . $request->ip();
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_active) {
            auth()->logout();
            return abort(404, 'Account is inactive');
        }

        $this->limiter->clear($this->throttleKey($request));

        return redirect()->intended($this->redirectPath());
    }
}
