<?php

use App\Http\Controllers\Invoice;
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

// Route::get('/', function () {
//     return view('Home/home');
// });
Route::get('/', function () {
    return view('Laundry/home');
})
->name('home');
Route::get('/transaksi/{id}/status', [Invoice::class, 'getStatus']);
Route::get('/invoice', function () {
    return view('Laundry/trackinvoice');
})
->name('trackinvoice');
Route::get('/bearry', function () {
    return view('companyprofile/view');
})
->name('home');

Route::get('/invoices/{transaksi}/download', [Invoice::class, 'download'])
->name('invoices.download');

Route::post('/invoices/validate', [Invoice::class, 'validateTransaction'])
    ->name('invoices.validate');

