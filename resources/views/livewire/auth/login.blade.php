<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Username')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>

        <div class="space-y-3">
            <a href="{{ route('login.google') }}" class="inline-flex items-center justify-center w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-zinc-50">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-white shadow-sm">
                    <svg viewBox="0 0 18 18" class="h-4 w-4" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.64 9.204c0-.63-.056-1.24-.16-1.82H9v3.44h4.84c-.21 1.13-.83 2.09-1.77 2.74v2.28h2.86c1.68-1.55 2.64-3.84 2.64-6.64Z" fill="#4285F4"/>
                        <path d="M9 18c2.43 0 4.47-.8 5.96-2.17l-2.86-2.28c-.8.54-1.82.86-3.1.86-2.39 0-4.42-1.62-5.14-3.8H.96v2.39C2.44 15.95 5.46 18 9 18Z" fill="#34A853"/>
                        <path d="M3.86 10.61a5.41 5.41 0 0 1 0-3.23V4.99H.96a8.99 8.99 0 0 0 0 8.98l2.9-3.36Z" fill="#FBBC05"/>
                        <path d="M9 3.56c1.32 0 2.5.45 3.43 1.33l2.57-2.57C13.46.94 11.42 0 9 0 5.46 0 2.44 2.05.96 4.99l2.9 2.39A5.44 5.44 0 0 1 9 3.56Z" fill="#EA4335"/>
                    </svg>
                </span>
                <span class="ms-3">{{ __('Log in with Google') }}</span>
            </a>

            <a href="{{ route('login.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900 shadow-sm transition hover:bg-emerald-100">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path fill="#ffffff" d="M12.004 2a10 10 0 0 0-8.93 14.74l-1.01 3.68 3.8-1.01A10 10 0 1 0 12.005 2Zm4.5 15.34c-.2.56-1.15 1.08-1.58 1.16-.41.09-.92.12-2.15-.41-1.23-.54-2.01-1.23-2.26-1.47-.24-.24-.9-.98-1.24-1.5-.34-.52-.7-.45-1.29-.2-.57.24-2.18.8-2.95.98-.78.18-1.42.08-1.95-.48-.52-.56-2.01-1.85-2.01-4.5 0-2.65 1.74-4.99 1.98-5.34.24-.34.53-.43.87-.43.34 0 .67 0 .98 0 .31 0 .73-.12 1.13.89.41 1 1.4 3.43 1.53 3.68.14.24.22.55.06.88-.16.34-.23.55-.47.85-.24.3-.5.66-.72.89-.24.24-.49.52-.22 1.05.27.52 1.2 1.97 2.57 3.18 1.77 1.52 3.22 1.73 3.66 1.93.45.2.74.17 1.02.1.28-.07.9-.36 1.03-.71.12-.35.12-.65.08-.71-.04-.07-.16-.12-.34-.2Z"/>
                    </svg>
                </span>
                <span class="ms-3">{{ __('Log in with WhatsApp') }}</span>
            </a>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
