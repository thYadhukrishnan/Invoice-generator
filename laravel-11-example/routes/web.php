<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::get('/',[InvoiceController::class,'viewInvoice'])->name('viewInvoice');
Route::get('add-invoice',[InvoiceController::class,'addInvoice'])->name('addInvoice');
Route::get('edit-invoice-view',[InvoiceController::class,'editInvoiceView'])->name('editInvoiceView');
Route::get('delete-invoice',[InvoiceController::class,'deleteInvoice'])->name('deleteInvoice');
Route::post('save-invoice',[InvoiceController::class,'saveInvoice'])->name('saveInvoice');
Route::post('edit-invoice',[InvoiceController::class,'editInvoive'])->name('editInvoive');

