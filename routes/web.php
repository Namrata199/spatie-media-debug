<?php

use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user-profile', UserProfile::class)
    ->name('user.profile');
