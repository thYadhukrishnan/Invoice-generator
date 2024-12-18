<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function viewInvoice(){
        return view('viewInvoice');
    }

    public function addInvoice(){
        return view('addInvoice');
    }
}
