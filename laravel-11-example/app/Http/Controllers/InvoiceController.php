<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceDetailsRelation;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function viewInvoice(){
        $invoiceData = Invoice::paginate('5');
        return view('viewInvoice',compact('invoiceData'));
    }

    public function addInvoice(){
        $invData = Invoice::orderBy('created_at','desc')->first();
        if(!empty($invData)){
            $invCode = 'INV'.($invData->id + 1);
        }else{
            $invCode = 'INV1';
        }
        return view('addInvoice',compact('invCode'));
    }

    public function saveInvoice(Request $request){
        $invoiceCode = $request->input('invoiceCode');
        $customer = $request->input('customer');
        $invoiceNotes = $request->input('invoiceNotes');
        $invoiceDate = $request->input('invoiceDate');
        $address = $request->input('address');
        $price = $request->input('price');
        $hours = $request->input('hours');
        $total = $request->input('total');
        $service = $request->input('service');
        if(empty($service)){
            return redirect()->route('addInvoice')->with('message','Please select aleast one service');
        }
        $invoiceAmount = $request->input('invoiceAmount');
        $discount = $request->input('discount');
        $enablevat = $request->has('enablevat') ? 1 : 0 ;
        $grandTotal = $request->input('grandTotal');
        $totalVat = $request->has('totalVat') ? $request->input('totalVat') : '';
        
        $saveInvoice = new Invoice();
        $saveInvoice->invoiceCode = $invoiceCode;
        $saveInvoice->CustomerID = $customer;
        $saveInvoice->CustomerName = $customer;
        $saveInvoice->Notes = $invoiceNotes;
        $saveInvoice->Address = $address;
        $saveInvoice->Amount = $invoiceAmount;
        $saveInvoice->Discount = $discount;
        $saveInvoice->EnableVat = $enablevat;
        $saveInvoice->TotalAmount = $grandTotal;
        $saveInvoice->TotalVat = $totalVat == '' ? 0 : $totalVat;
        $saveInvoice->invoiceDate = $invoiceDate;
        $saveInvoice->save();

        $invoiceID = $saveInvoice->id;

        foreach($service as $key=>$value){
            $serviceDetails = new ServiceDetailsRelation();
            $serviceDetails->ServiceID = $value;
            $serviceDetails->InvoiceID = $invoiceID;
            $serviceDetails->ServiceName = $value;
            $serviceDetails->ServicePrice = $price[$key];
            $serviceDetails->ServiceHrs = $hours[$key];
            $serviceDetails->Total = $total[$key];
            $serviceDetails->save();
        }
        
        return redirect()->route('viewInvoice')->with('message','Invoice Added');
    }

    public function deleteInvoice(Request $request){
        $invoiceID = $request->input('id');
        $invoiceData = Invoice::find($invoiceID);
        $invoiceData->delete();
        ServiceDetailsRelation::where('InvoiceID',$invoiceID)->delete();
        return redirect()->route('viewInvoice')->with('message','Invoice Deleted');
    }

    public function editInvoiceView(Request $request){
        $invoiceID = $request->input('id');
        $invoiceData = Invoice::find($invoiceID);
        $serviceDetails = ServiceDetailsRelation::where('InvoiceID',$invoiceID)->get();
        return view('editInvoice',compact('invoiceData','serviceDetails'));
    }

    public function editInvoive(Request $request){

        $invoiceID = $request->input('invoiceID');
        $invoiceCode = $request->input('invoiceCode');
        $customer = $request->input('customer');
        $invoiceNotes = $request->input('invoiceNotes');
        $invoiceDate = $request->input('invoiceDate');
        $address = $request->input('address');
        $price = $request->input('price');
        $hours = $request->input('hours');
        $total = $request->input('total');
        $service = $request->input('service');
        if(empty($service)){
            return redirect()->route('editInvoiceView',['id'=>$invoiceID])->with('message','Please select aleast one service');
        }
        $invoiceAmount = $request->input('invoiceAmount');
        $discount = $request->input('discount');
        $enablevat = $request->has('enablevat') ? 1 : 0 ;
        $grandTotal = $request->input('grandTotal');
        $totalVat = $request->has('totalVat') ? $request->input('totalVat') : '';
        
        $saveInvoice =Invoice::find($invoiceID);
        $saveInvoice->invoiceCode = $invoiceCode;
        $saveInvoice->CustomerID = $customer;
        $saveInvoice->CustomerName = $customer;
        $saveInvoice->Notes = $invoiceNotes;
        $saveInvoice->Address = $address;
        $saveInvoice->Amount = $invoiceAmount;
        $saveInvoice->Discount = $discount;
        $saveInvoice->EnableVat = $enablevat;
        $saveInvoice->TotalAmount = $grandTotal;
        $saveInvoice->TotalVat = $totalVat == '' ? 0 : $totalVat;
        $saveInvoice->invoiceDate = $invoiceDate;
        $saveInvoice->save();

        ServiceDetailsRelation::where('InvoiceID',$invoiceID)->delete();

        foreach($service as $key=>$value){
            $serviceDetails = new ServiceDetailsRelation();
            $serviceDetails->ServiceID = $value;
            $serviceDetails->InvoiceID = $invoiceID;
            $serviceDetails->ServiceName = $value;
            $serviceDetails->ServicePrice = $price[$key];
            $serviceDetails->ServiceHrs = $hours[$key];
            $serviceDetails->Total = $total[$key];
            $serviceDetails->save();
        }

        return redirect()->route('viewInvoice')->with('message','Invoice Edited');

    }
}
