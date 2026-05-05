<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\Tasks\Index as TasksIndex;
use App\Livewire\Tasks\Create as TasksCreate;
use App\Livewire\Tasks\Edit as TasksEdit;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
Volt::route('/', 'auth.login')
        ->name('login');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('users/create', UsersCreate::class)->name('users.create');
    Route::get('users/{id}/edit', UsersEdit::class)->name('users.edit');

    Route::get('tasks', TasksIndex::class)->name('tasks.index');
    Route::get('tasks/create', TasksCreate::class)->name('tasks.create');
    Route::get('tasks/{task}/edit', TasksEdit::class)->name('tasks.edit');

});

require __DIR__ . '/auth.php';
