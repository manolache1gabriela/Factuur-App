<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Models\Client;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $clientId = $request->get('client_id', null);
    if (empty($clientId)) {
        $invoices = Invoice::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->with(['client'])
            ->orderBy('id', 'DESC')
            ->paginate(1);
    } else {
        $invoices = Invoice::where('client_id', $clientId)->orderBy('id', 'DESC')->paginate(5);
    }
    $clients = Client::all();
    $clients->prepend((new Client())->setId(0)->setName('All clients'));

    return Inertia::render('Welcome', [
        'clients' => $clients,
        'invoices' => $invoices,
        'client_id' => $clientId
    ]);
})->name('home');
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoice.store');

Route::get('/download/{invoice}', [InvoiceController::class, 'downloadInvoice'])->name('download');
Route::put('/update/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';