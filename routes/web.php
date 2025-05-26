<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvoiceController::class, 'index'])->name('home');

Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::put('/clients', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'delete'])->name('clients.delete');

Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoice.store');

Route::get('/download/{invoice}', [InvoiceController::class, 'downloadInvoice'])->name('download');
Route::put('/update/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');

require __DIR__ . '/auth.php';
