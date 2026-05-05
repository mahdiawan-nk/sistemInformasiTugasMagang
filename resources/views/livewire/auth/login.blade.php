<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
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

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
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
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>


<div class="w-full max-w-md bg-white">

    <!-- LOGO -->
    <div class="flex justify-center mb-3">
        <img src="/images/logo-pku.png" alt="Logo" class="h-14">
    </div>

    <!-- GREETING -->
    <div class="text-center mb-1">
        <p class="text-sm text-gray-500">
            Selamat datang di
        </p>
        <h2 class="text-base font-medium text-gray-700">
            Sistem Informasi Tugas Magang
        </h2>
    </div>

    <!-- TITLE -->
    <h1 class="text-xl font-semibold text-center text-gray-800 mt-4 mb-6">
        Login Akun
    </h1>

    <!-- SESSION STATUS -->
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif

    <!-- FORM -->
    <form wire:submit="login" class="space-y-4">

        <!-- EMAIL -->
        <div>
            <label class="text-sm font-medium text-gray-700">
                Email
            </label>
            <input type="email" wire:model="email" placeholder="email@example.com"
                class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 text-sm">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="text-sm font-medium text-gray-700">
                Password
            </label>
            <input type="password" wire:model="password" placeholder="Password"
                class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 text-sm">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- REMEMBER + FORGOT -->
        <div class="flex items-center justify-between text-sm">

            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" wire:model="remember">
                Remember me
            </label>

            {{-- @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                    Lupa password?
                </a>
            @endif --}}

        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
            Login
        </button>

    </form>

    <!-- REGISTER -->
    {{-- <div class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
            Daftar
        </a>
    </div> --}}

</div>
