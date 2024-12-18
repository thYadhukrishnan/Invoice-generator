<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .form-control:focus {
            border-color: #e1c699;
            box-shadow: 0 0 5px #e1c699;
        }
        .btnSubmit{
            width: 115px;
            border-radius: 25px;
        }
        
    </style>
</head>
<body>
    <form action="{{route('editInvoive')}}" method="post">
        @csrf
        <div class="container">
            @if(session('message'))
            <div class="alert alert-success" role="alert" id="successDiv">
              {{session('message')}}
            </div>
            @endif
            <div class="row py-3">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Invoice Code</label>
                        <div class="col-sm-8">
                          <input type="text" name="invoiceCode" value="{{$invoiceData->InvoiceCode}}" class="form-control" id="invoiceCode" readonly>
                        </div>
                      </div>
    
                      <div class="form-group row mt-2">
                        <label class="col-sm-4 col-form-label">Customer:</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="customer" id="customer" aria-label="Default select example" required>
                                <option >-Select Customer-</option>
                                <option value="1" {{$invoiceData->CustomerID == 1 ? 'selected' : ''}}>Customer 1</option>
                                <option value="2" {{$invoiceData->CustomerID == 2 ? 'selected' : ''}}>Customer 2</option>
                                <option value="3" {{$invoiceData->CustomerID == 3 ? 'selected' : ''}}>Customer 3</option>
                              </select>
                        </div>
                      </div>
    
                      <div class="form-group row mt-5">
                        <label class="col-sm-4 col-form-label">Notes:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="invoiceNotes" id="invoiceNotes" rows="3" required>{{$invoiceData->Notes}}</textarea>
                        </div>
                      </div>
    
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 px-4">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Invoice Date</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="basic-addon1">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <input type="date" id="invoiceDate" name="invoiceDate" value="{{ \Carbon\Carbon::parse($invoiceData->invoiceDate)->format('Y-m-d')}}" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                      </div>
    
                      <div class="form-group row mt-2">
                        <label class="col-sm-3 col-form-label">Customer Address:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address" id="address" rows="3">{{$invoiceData->Address}}</textarea>
                        </div>
                      </div>
                </div>
            </div>
    
            <div class="row m3" style="border: 1px solid green;">
                <h3>Service Details</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Service</th>
                            <th scope="col">Price</th>
                            <th scope="col">Hrs</th>
                            <th scope="col">Total</th>
                            <th scope="col">
                                <a href="javascript:void(0)" class="addNewRow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                      </svg>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="serviceDetailsTableBody">
                        @foreach($serviceDetails as $sd)
                        <tr>
                            <td>
                                <select class="form-select" name=service[] id="" aria-label="Default select example" required>
                                    <option >-Select Service-</option>
                                    <option value="1" {{$sd->ServiceID == 1 ? 'selected' : ''}}>Badminton Court</option>
                                    <option value="2" {{$sd->ServiceID == 2 ? 'selected' : ''}}>Carrom Table</option>
                                    <option value="3" {{$sd->ServiceID == 3 ? 'selected' : ''}}>Football</option>
                                </select>
                            </td>
                            <td>
                                    <input type="text" name="price[]" value="{{$sd->ServicePrice}}" class="form-control numberOnly price" id="" required>
                            </td>
                            <td>
                                <input type="text" name="hours[]" value="{{$sd->ServiceHrs}}" class="form-control numberOnly hours" id="" required>   
                            </td>
                            <td>
                                <input type="text" name="total[]" value="{{$sd->Total}}" class="form-control numberOnly total" id="" required readonly>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="deleteRow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <div class="row py-3">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Invoice Amount</label>
                        <div class="col-sm-8">
                          <input type="text" name="invoiceAmount" value="{{$invoiceData->Amount}}" class="form-control numberOnly" id="invoiceAmount" required readonly>
                        </div>
                      </div>
    
                      <div class="form-group row mt-2">
                        <label class="col-sm-4 col-form-label">Discount Amount</label>
                        <div class="col-sm-8">
                          <input type="text" name="discount" value="{{$invoiceData->Discount}}" class="form-control" id="discount" required>
                        </div>
                      </div>
    
                      <div class="form-group row mt-2">
                        <label class="col-sm-4 col-form-label">Enable vat</label>
                        <div class="col-sm-8">
                          <input type="checkbox" name="enablevat" class="form-check-input" id="enablevat" {{$invoiceData->EnableVat == 1 ? 'checked' : ''}}>
                          <label class="form-check-label" for="flexCheckChecked">
                           5%
                          </label>
                        </div>
                      </div>
    
                      <div class="form-group row mt-2">
                        <label class="col-sm-4 col-form-label">Grand Total</label>
                        <div class="col-sm-8">
                          <input type="text" name="grandTotal" value="{{$invoiceData->TotalAmount}}" class="form-control" id="grandTotal" readonly>
                        </div>
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row mt-2">
                        <label class="col-sm-4 col-form-label">Total Vat</label>
                        <div class="col-sm-8">
                          <input type="text" name="totalVat" value="{{$invoiceData->TotalVat}}" class="form-control" id="totalVat" readonly>
                        </div>
                      </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <input type="hidden" name="invoiceID" value="{{$invoiceData->id}}">
                <button type="submit" class="btn btn-warning btnSubmit me-2">Save</button>
                <a type="button" href="{{route('viewInvoice')}}" class="btn btn-secondary btnSubmit">Cancel</a>

            </div>
        </div>
    </form>
</body>

<script>
    $(document).ready(function(){
        $(document).on('click','.addNewRow',function(){
            var newRow = `<tr>
                            <td>
                                <select class="form-select" name=service[] id="" aria-label="Default select example" required>
                                    <option selected>-Select Service-</option>
                                    <option value="1">Badminton Court</option>
                                    <option value="2">Carrom Table</option>
                                    <option value="3">Football</option>
                                </select>
                            </td>
                            <td>
                                    <input type="text" name="price[]" value="" class="form-control numberOnly price" id="" required>
                            </td>
                            <td>
                                <input type="text" name="hours[]" value="" class="form-control numberOnly hours" id="" required>   
                            </td>
                            <td>
                                <input type="text" name="total[]" value="" class="form-control numberOnly total" id="" required readonly>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="deleteRow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </td>
                            </tr>`;
            $('#serviceDetailsTableBody').append(newRow);
        });

        $(document).on('click','.deleteRow',function(){
            $(this).closest('tr').remove();
        });

        $(document).on('keypress','.numberOnly',function(event){
            var charCode = event.which; 
            var charStr = String.fromCharCode(charCode);

            if (!charStr.match(/^[0-9.]$/)) {
                event.preventDefault();
            }

            if (charStr === '.' && $(this).val().includes('.')) {
                event.preventDefault();
            }
        });

        $(document).on('keyup','.price',function(){
            var price = $(this).val();
            var hrs = $(this).closest('tr').find('.hours').val();
            var total = 0;
            var invAmount = 0;
            if(price == ''){
                price = 0;
            }else{
                price = parseFloat(price);
            }
            if(hrs == ''){
                hrs = 0;
            }else{
                hrs = parseFloat(hrs);
            }
            total = price * hrs;
            console.log(price,total,hrs);
            $(this).closest('tr').find('.total').val(total);

            $('.total').each(function(){
                var total = $(this).val();
                if(total == ''){
                    total = 0;
                }else{
                    total = parseFloat(total);
                }
                invAmount += total;
            });
            $('#invoiceAmount').val(invAmount);
        });


        $(document).on('keyup','.hours',function(){
            var hrs = $(this).val() == '' ? 0 : parseFloat($(this).val());
            var price = $(this).closest('tr').find('.price').val();
            price = price == '' ? 0 : parseFloat(price);
            var total = 0;
            var invAmount = 0;

            total = price * hrs;
            console.log(price,total,hrs);
            $(this).closest('tr').find('.total').val(total);

            $('.total').each(function(){
                var total = $(this).val() == '' ? 0 : parseFloat($(this).val());
                invAmount += total;
            });
            $('#invoiceAmount').val(invAmount);

        });

        $(document).on('keyup','#discount',function(){
            var discount = $(this).val() == '' ? 0 : parseFloat($(this).val());
            var total = $('#invoiceAmount').val() == '' ? 0 : parseFloat($('#invoiceAmount').val());
            var grandTotal = total - discount;
            $('#grandTotal').val(grandTotal);
        });

        $('#enablevat').click(function(){
            var total = $('#invoiceAmount').val() == '' ? 0 : parseFloat($('#invoiceAmount').val());
            var discount = $('#discount').val() == '' ? 0 : parseFloat($('#discount').val());
            var vatAmount = total * 0.05;
            var grandTotal = 0;
            if($(this).is(':checked')){
                grandTotal = (total+vatAmount) - discount;
                $('#totalVat').val(vatAmount);

            }else{
                grandTotal = total - discount;
            }
            console.log(total,discount,vatAmount,grandTotal);
            $('#grandTotal').val(grandTotal);
        });

    });
</script>
</html>