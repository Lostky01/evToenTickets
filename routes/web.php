<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Ticket;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
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

Route::get('/',[EventController::class, 'mainShow'])->name('dash');
Route::get('/ticket-status',[EventController::class, 'TicketStatusShow'])->name('status-tiket');
Route::get('/event-manage',[EventController::class, 'index'])->name('index');
Route::get('/siswa-table',[EventController::class, 'user_table'])->name('siswa-table');
Route::get('/siswa-create-menu',[EventController::class, 'CreateSiswaMenu'])->name('siswa-create-menu');
Route::post('/siswa/create', [EventController::class, 'createSiswa'])->name('create-siswa');
Route::get('/user-table',[EventController::class, 'user_external_table'])->name('user-external-table');
Route::get('/create-event',[EventController::class, 'create'])->name('create');
Route::post('/events/store', [EventController::class, 'store'])->name('store');
Route::get('/edit-event/{id}',[EventController::class, 'edit'])->name('edit');
Route::get('/transactions-history',[EventController::class, 'ShowTransactionsHistory'])->name('transaction-history');
Route::put('/edit/events/{id}', [EventController::class, 'update'])->name('edit-store');
Route::delete('/delete/events/{id}', [EventController::class, 'destroy'])->name('destroy');
Route::patch('/transaction/{id}/confirm', [EventController::class, 'confirmTicket'])->name('transaction.confirm');
Route::patch('/transaction/{id}/reject', [EventController::class, 'rejectTicket'])->name('transaction.reject');
Route::get('/scannershow',[EventController::class, 'ScannerShow'])->name('qr-scanner');
Route::post ('/scan-tiket',[EventController::class, 'scanTicket'])->name('scan-tiket');


Route::get('/login-menu',[LandingController::class, 'loginShow'])->name('login-menu');
Route::get('/login-admin-menu',[LandingController::class, 'loginAdminShow'])->name('login-admin-menu');
Route::get('/register-menu',[LandingController::class, 'registerShow'])->name('register-menu');
Route::post('/login', [LandingController::class, 'login'])->name('login');
Route::post('/login/admin', [LandingController::class, 'loginAdmin'])->name('login-admin');
Route::post('/register', [LandingController::class, 'register'])->name('register');
Route::get('/home',[LandingController::class, 'home'])->name('home');
Route::get('/history',[LandingController::class, 'showHistory'])->name('history');

Route::get('/otp', function () {
    return view('main.otp');
})->name('otp-form');

Route::post('/otp/verify', [LandingController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/detail/event/{id}', [LandingController::class, 'detailShow'])->name('detail-event');
Route::get('/menu/checkout/{id}', [LandingController::class, 'showCheckout'])->name('checkout-menu');
Route::post('/checkout/{id}', [LandingController::class, 'checkout'])->name('checkout');
Route::get('/ticket/success/{$id}', [LandingController::class, 'showTicket'])->name('ticket-success');
Route::post('/logout', [LandingController::class, 'logout'])->name('logout');
Route::get('/my-tickets', [LandingController::class, 'showTickets'])->name('tiket-saya');


Route::get('/experimental', function () {
    return view('main.experiment');
});