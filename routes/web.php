<?php

use App\Livewire\UserList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/user-list', UserList::class)->name('users');

Route::redirect('users', '/user-list');
