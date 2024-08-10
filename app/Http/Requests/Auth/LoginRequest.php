<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 *
 */
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
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
            ],
            'password' => [
                'required',
                'string',
                'max:100'
            ]
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     * @return string The token
     */
    public function authenticate(): string
    {
        $this->ensureIsNotRateLimited();
        if (! $token =  Auth::attempt($this->validated()) ) {
            RateLimiter::hit($this->throttleKey());

            throw new HttpResponseException(response([
                'errors' => [
                    'login failed' => trans('auth.failed')
                ]
            ], 401));
        }

        RateLimiter::clear($this->throttleKey());

        return $token;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw new HttpResponseException(response([
            'errors' => [
                'To many login request' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]
        ], 429));
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
