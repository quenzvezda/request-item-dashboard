<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/item-requests');
});

Route::get('/item-requests', [\App\Http\Controllers\ItemRequestController::class, 'index']);

Route::get('/item-requests/{id}', [\App\Http\Controllers\ItemRequestController::class, 'show'])->name('item-requests.show');
