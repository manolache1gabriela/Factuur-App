<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // $invoice = Invoice::with(['client'])->find(2025031);
    // dd($invoice->data);
    return view('pdfs.invoice', [
        'invoice' => Invoice::with(['client'])->find(2025031)
    ]);
    // $clients = Client::where('id', '!=', 1)->get();
    // return Inertia::render('Welcome', ['clients' => $clients]);
})->name('home');
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoice.store');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
