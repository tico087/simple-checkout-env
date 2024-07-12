<?php

use App\Http\Controllers\{CheckoutController, OrderController};
use Illuminate\Support\Facades\Route;


Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/obrigado/{order_id}', [CheckoutController::class, 'thanksPage'])->name('checkout.thankspage');

Route::get('/compras',[OrderController::class, 'index'])->name('order.index');
Route::get('/compras/{id}',[OrderController::class, 'show'])->name('order.show');

