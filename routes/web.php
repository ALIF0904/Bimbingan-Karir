<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\TypetiketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LokasiController;

// Home / landing page menampilkan event
Route::get('/', [EventController::class, 'home'])->name('home');

// Detail event
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Register
Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Dashboard Admin
Route::get('/admin', [DashboardAdminController::class, 'index'])
    ->middleware(['auth', 'verified']) //auth memastikan hanya user yang sudah login dapat mengakses admin, verified memastikan email user sudah tervalidasi.
    ->name('dashboard'); 

// Resource categories (hanya user login)
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class); //Mengurangi duplikasi kode route.
    Route::resource('events', EventController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('types', TypetiketController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('lokasis', LokasiController::class);
});

// nested route: tiket milik event tertentu
Route::get('events/{event}/tickets', [TicketController::class, 'index'])
    ->name('events.tickets.index');

//Kelola tiket
Route::get('events/{event}/tikets', [TicketController::class, 'index'])->name('events.tikets.index');
Route::post('events/{event}/tikets', [TicketController::class, 'store'])->name('events.tikets.store');

Route::put('events/{event}/tikets/{tiket}', [TicketController::class, 'update'])->name('events.tikets.update');
Route::delete('events/{event}/tikets/{tiket}', [TicketController::class, 'destroy'])->name('events.tikets.destroy');

//kelola transaksi
Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('transactions/{order}', [TransactionController::class, 'show'])->name('transactions.show');

//kelola payment
Route::patch('payments/{payment}/toggle', [PaymentController::class, 'toggle'])
    ->name('payments.toggle');


//login user
Route::middleware(['auth'])->group(function () {
    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        Route::get('/event', [PembeliController::class, 'index'])->name('event.index');
        Route::get('/event/{event}', [PembeliController::class, 'show'])->name('event.show');

        Route::post('/order', [OrderController::class, 'store'])
            ->name('order.store');

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{order}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });
});
