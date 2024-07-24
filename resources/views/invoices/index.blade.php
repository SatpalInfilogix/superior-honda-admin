@extends('layouts.app')

@section('content')
<style>
    .modal-content {
        width: 173%;
        margin-left: -104px;
    }
    .main-header {
        display: flex;
    }
    .header-left-section {
        float: left;
        margin: 0;
        padding: 0;
    }
    .header-right-section {
        float: right; 
        width: 249px;
        margin-top: 22px;
        margin-left: 20%;
    }
    .invoice-number-div {
        border: 1px solid;
        border-radius: 10px;
        width: 220px;
        height: 66px;
        display: flex;
        justify-content: space-between;
    }
    .estrick-ul-list {
        list-style-type: none; /* Remove default bullets */
    }
    .estrick-li-element::before {
        content: "* "; /* Add asterisk before each item */
    }
    .estrick-li-element {
        width: 166px;
    }
    .address-header {
        display: flex;
    }
    .content-section {
        display: flex;
    }
    .bill-to-section {
        float: left;
        margin-top: 44px;
    }
    .ship-to-section {
        float: right;
        margin-top: 44px;
    }
    .department-table {
        border: 1px solid;
        border-radius: 11px;
        width: 100%;
    }
    .item-table-heading {
        border: 1px solid;
        width: 100%;
    }
    .total-amount {
        font-size: 20px;
        font-weight: 800;
    }
</style>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Invoices</h5>
                                <div class="float-right">
                                    <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-md primary-btn">Add Invoice</a>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="invoice-list" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice Number</th>
                                                <th>Email</th>
                                                <th>Invoice View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $key => $invoice)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $invoice->invoice_no }}</td>
                                                    <td>{{ optional($invoice->order)->email }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($invoice->order_id == Null)
                                                                <button type="button" class="btn btn-primary primary-btn waves-effect waves-light mr-2" data-toggle="modal" data-target="#invoiceModalJob{{ $key }}">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </button>
                                                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2 edit-vehicle-type">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                            @else
                                                                <button type="button" class="btn btn-primary primary-btn waves-effect waves-light mr-2" data-toggle="modal" data-target="#invoiceModalOrder{{ $key }}">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-include-plugins dataTable></x-include-plugins>

<!-- Invoice Modals -->
@foreach ($invoices as $key => $invoice)
    @if($invoice->order_id == Null)
    @php $productDeatils = json_decode($invoice->product_details); @endphp
    <div class="modal fade" id="invoiceModalJob{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invoice : {{ $invoice->invoice_no }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered nowrap">
                        <tr>
                            <td>Sr.</td>
                            <td>Item</td>
                            <td>Price</td>
                            <td>Discount</td>
                            <td>Discount Price</td>
                        </tr>
                        <tbody>
                        @if($productDeatils)
                            @foreach ($productDeatils->products as $proKey => $productDetail)
                                <tr>
                                    <td>{{ $proKey + 1}}</td>
                                    <td>{{ $productDetail->product }}</td>
                                    <td>${{ number_format($productDetail->price, 2) }}</td>
                                    <td>{{ optional($productDetail)->discount }} %</td>
                                    <td>${{ number_format(optional($productDetail)->discounted_price,2) }} </td>
                                </tr>
                            @endforeach
                        @endif
                        <tbody>
                    </table>
                    <div class="float-right total-amount">Total Amount: ${{ number_format($productDeatils->totalAmount,2)}}</div>
                </div>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="modal fade" id="invoiceModalOrder{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="header-right-section float-right">
                        <h5>Charge Invoice</h5>
                        <div class="invoice-number-div" style="display: flex;">
                            <p style="margin-top:20px; margin-left:5px;">Invoice# </p>
                            <p style="margin-top:20px; margin-right:5px;">{{ $invoice->invoice_no }}</p>
                        </div>
                    </div>
                    <section>
                        <div class="main-header">
                            <div class="header-left-section">
                                <h3>SUPERIOR PARTS LTD.</h3>
                                <p stalign="left" style="width:150%">Website:- https://hondasuperiorpart.com Email:- contact@hondasuperiorpart.com</p>
                            </div>
                        </div>
                        <div class="address-header">
                            <div class="address address-1">
                                <ul class="estrick-ul-list">
                                    <li class="estrick-li-element">
                                        88 Haglet Park Road
                                        Kingston 10, Jamaica
                                    </li>
                                    <li class="estrick-li-element">
                                        11 Caledonia Road
                                        Mandeville, Jamaica
                                        Tel:- 987446301
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>
                    <div class="bill-to-section">
                        <h5> Bill To </h5>
                        <p> {{ optional($invoice->billingAddress)['first_name'].' '. optional($invoice->billingAddress)['last_name'] }}, {{ optional($invoice->billingAddress)['address'] }}, {{ optional($invoice->billingAddress)['city'] }}</p>
                    </div>
                    <div class="ship-to-section">
                        <h5>Ship To </h5>
                        <p> {{ optional($invoice->shippingAddress)['first_name'].' '.optional($invoice->shippingAddress)['last_name'] }}, {{ optional($invoice->shippingAddress)['address'] }}, {{ optional($invoice->shippingAddress)['city'] }}</p>
                    </div>
                    <br><br><br><br><br><br><br>
                    <table class="department-table">
                        <tr>
                            <td>User ID: </td>
                            <td>RAD </td>
                            <td>S/Clerk: </td>
                            <td>HQ </td>
                            <td>Invoice Date: </td>
                            <td>May 29, 2024</td>
                            <td>Page# : 1 of 1</td>
                        </tr>
                        <tr>
                            <td>Bill By: </td>
                            <td>RL</td>
                            <td>Time</td>
                            <td>16:07:05</td>
                            <td>Transit#:  </td>
                            <td> </td>
                            <td>GCT# 541788</td>
                        </tr>
                    </table>
                    <table class="item-table-heading">
                        <tr>
                            <td>Cust ID: </td>
                            <td>Reference </td>
                            <td>P/O#: </td>
                            <td>Terms</td>
                        </tr>
                        <tr>
                            <td>Item</td>
                            <td>Description</td>
                            <td>Quantity</td>
                            <td>Price</td>
                            <td>Total</td>
                        </tr>
                        @if(isset($invoice->cart_items['products']) && is_array($invoice->cart_items['products']))
                            @foreach ($invoice->cart_items['products'] as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td></td>
                                    <td>{{ $product['quantity'] }} ea</td>
                                    <td>${{ number_format($product['price'], 2) }}</td>
                                    <td>${{ number_format($product['price'], 2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <br><br><br><hr>
                    <div style="float:left; width:70%">
                        <p>No Return after 24Hrs & On correct Items. Incorrect parts purchased must be in orignal Condition. A 10% restocking fee will apply. Electrical parts are not refundable. No refund without Invoice.</p>
                    </div>
                    <div class="float-right">
                        <p class="float-left"> NonTaxable Total &nbsp;&nbsp;</p><p class="float-right">{{ optional($invoice->cart_items)['formatted_sub_total'] }}</p><br>
                        <p class="float-left"> Disc% &nbsp;&nbsp;</p><p class="float-right">{{ optional(optional($invoice->cart_items)['applied_coupons'])['discount_amount']}}</p><br>
                        <br>
                        <hr>
                        <p class="float-left">Sub-Total &nbsp;&nbsp;</p><p class="float-right">{{ optional($invoice->cart_items)['formatted_grand_total'] }}</p><br>
                        <p class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tax &nbsp;&nbsp;</p><p style="float:right">{{ ( optional($invoice->cart_items)['grand_total']) * 0.18 }}</p><br>
                        <br><hr>
                        <p class="float-left">Total Amount &nbsp;&nbsp;</p><p style="float:right;font-weight: 5"><b>{{ number_format( optional($invoice->cart_items)['grand_total'] + (optional($invoice->cart_items)['grand_total']* 0.18) , 2)}}</b></p><br><br>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary pdf-import" data-id="{{$invoice->id}}" data-dismiss="modal">Download Invoice-PDF</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
       
    @endif
@endforeach

<script>
    $(function() {
        $('#invoice-list').DataTable();
        $('.pdf-import').on('click', function(){
             var invoiceId = $(this).data('id'); // Assuming the button has a data attribute with the invoice ID

            $.ajax({
                url: '{{env("APP_URL")}}download-invoice-pdf/' + invoiceId,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Important to handle the binary data
                },
                success: function(data, status, xhr) {
                    var filename = "";
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    }
                    var blob = new Blob([data], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr, status, error) {
                    console.error('Error downloading invoice:', error);
                    alert('Failed to download invoice. Please try again.');
                }
            });
        });
    });
</script>
@endsection
