<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\v1\SsoAuthContoller;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
 
Route::get('auth/{provider}', [SsoAuthContoller::class, 'redirectToProvider'])
    ->name('auth.provider');

Route::get('auth/{provider}/callback', [SsoAuthContoller::class, 'handleProviderCallback']);
