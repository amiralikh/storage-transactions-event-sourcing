<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => 'auth:web'],function (){
    Volt::route('/goods','goods')->name('goods.index');
    Volt::route('/goods/{id}','update-goods')->name('goods.edit');

    Volt::route('warehouses','warehouses')->name('warehouses.index');
    Volt::route('warehouses/{id}','update-warehouse')->name('warehouses.edit');

    Volt::route('transactions','transactions')->name('transactions.index');
});

require __DIR__.'/auth.php';
