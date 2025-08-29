<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('web')->group(function () {
    Route::any('login', fn () => abort(404));
    Route::any('register', fn () => abort(404));
    Route::any('forgot-password', fn () => abort(404));
    Route::any('reset-password/{token}', fn () => abort(404));

    Route::any('verify-email', fn () => abort(404));
    Route::any('verify-email/{id}/{hash}', fn () => abort(404));
    Route::any('confirm-password', fn () => abort(404));
});


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
