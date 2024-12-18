<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .addInvoiceBtn{
        width: auto;
    }
    .addInvoiceBtnRow{
        justify-content: end;
        display: flex;
    }
</style>
<body>

    <div class="container px-0">
        @if(session('message'))
        <div class="alert alert-success" role="alert" id="successDiv">
          {{session('message')}}
        </div>
        @endif
          <div class="row pt-3 addInvoiceBtnRow">
              <a href="{{route('addInvoice')}}" class="btn btn-warning addInvoiceBtn me-2">Create Invoice</a>
          </div>
          <div class="row px-0 pt-5">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Invoice Code</th>
                      <th scope="col">Customer</th>
                      <th scope="col">Invoice Amount</th>
                      <th scope="col">Grand Total</th>
                      <th scope="col" style="text-align: end;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!$invoiceData->isEmpty())
                    @foreach($invoiceData as $invoice)
                    <tr>
                      <th scope="row">{{$invoiceData->firstItem() + $loop->index}}</th>
                      <td>{{$invoice->InvoiceCode}}</td>
                      <td>{{$invoice->CustomerName}}</td>
                      <td>{{$invoice->Amount}}</td>
                      <td>{{$invoice->TotalAmount}}</td>
                      <td>
                        <div class="row pe-2" style="justify-content: end">
                          <div class="col-sm-2">
                            <a class="btn btn-secondary " data-id = {{$invoice->id}} href="{{ route('editInvoiceView', ['id' => $invoice->id]) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                              </svg>
                            </a>
                          </div>
                          <div class="col-sm-2">
                            <a class="btn btn-danger" href="{{ route('deleteInvoice', ['id' => $invoice->id]) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                              </svg>                          
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="6" style="text-align: center;">No Data Found.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                <div class="d-flex justify-content-end">
                  {{ $invoiceData->links() }}
              </div>
          </div>
      </div>
</body>
</html>