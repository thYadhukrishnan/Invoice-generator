<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[InvoiceController::class,'viewInvoice'])->name('viewInvoice');
Route::get('add-invoice',[InvoiceController::class,'addInvoice'])->name('addInvoice');
Route::get('edit-invoice',[InvoiceController::class,'editInvoice'])->name('editInvoice');