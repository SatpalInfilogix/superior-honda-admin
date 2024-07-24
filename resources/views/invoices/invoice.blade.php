<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style type="text/css">
        .main-header{
                display: flex;
        }
        .header-left-section{
                float: left;
                margin: 0;
                padding: 0;
        }
        .header-right-section{
            float: right; 
            width: 249px;
            margin-top: 22px;
            margin-left: 20%;
        }

        .invoice-number-div{
            border: 1px solid;
            border-radius: 10px;
            width: 220px;
            height: 66px;
            display: flex;
            justify-content: space-between;
            /*align-content: center;*/
        }
        .estrick-ul-list{
            list-style-type: none; /* Remove default bullets */
        }
        .estrick-li-element::before
        {
            content: "* "; /* Add asterisk before each item */
            
        }
        .estrick-li-element{
            width: 166px;
        }
        .address-header{
            display: flex;

        }
        .content-section{
            display: flex
        }
        .bill-to-section{
            float:left;
        }
        .ship-to-section{
            float:right;
        }
        .department-table{
            border: 1px solid;
            border-radius: 11px;
            width: 100%;
        }
        .item-table-heading{
            border: 1px solid;
            width: 100%;
        }
    </style>
</head>
<body style="margin: 10px;">
    @php
        $order = $invoice;
    @endphp
    <!-- Invoice Header Section Startes Here -->
    <div class="header-right-section">
                    <h3>Charge Invoice</h3>
                    <div class="invoice-number-div" style="display: flex;">
                        <p align="left" style="margin-top:20px; margin-left:5px; float:left;">Invoice# </p>
                        <p align="right" style="margin-top:20px; float:right;margin-right:5px;">{{ $order->invoice_no }}</p>
                    </div>
                </div>
    <section>
        <div>
            <div class="main-header">
                <div class="header-left-section">
                <h1>SUPERIOR PARTS LTD.</h1>
                <p stalign="left">Website:- https://hondasuperiorpart.com</p><br><p stalign="left"> Email:- contact@hondasuperiorpart.com</p>
                </div>
            </div>
            <!-- Header Invoice  Address Section Starts Here -->
            <div class="address-header">
                <div class="adrress adress-1">
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
            <!-- Header Invoice  Address Section Ends Here -->
        </div>
    </section>
    <!-- Invoice Header Section Ends Here -->
    <div class="bill-to-section">
        <h5>
            Bill To
        </h5>
        <p> {{$order->billingAddress['first_name'].' '.$order->billingAddress['last_name']}}, <br> {{$order->billingAddress['address']}}, <br>{{$order->billingAddress['city'] }}, <br>{{optional($order->billingAddress)['state_name'] }}, <br>{{ optional($order->billingAddress)['country_name'] }}</p>
    </div>
    <div class="ship-to-section">
        <h5>
            Ship To
        </h5>
        <p> {{$order->shippingAddress['first_name'].' '.$order->shippingAddress['last_name']}}, <br>{{$order->shippingAddress['address']}}, <br>{{$order->shippingAddress['city'] }}, <br>{{optional($order['shippingAddress'])['state_name'] }}, <br>{{optional($order['shippingAddress'])['country_name'] }}</p>
    </div><br><br><br><br><br><br><br><br><br>
    <!-- Invoice Body Section Starts Here-->
    
         <table class="department-table">
            <tr>
                <td>User ID: </td>
                <td>RAD </td>
                <td>S/Clerk: </td>
                <td>HQ </td>
                <td>Invoice Date: </td>
                <td>May 29,2024</td>
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
            @foreach($order->cart_items['products'] as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td></td>
                <td>{{$product['quantity'] }} ea</td>
                <td>${{ number_format($product['price'], 2) }}</td>
                <td>${{ number_format($product['price'], 2) }}</td>
            </tr>
            @endforeach
        </table>
        
    <!-- Invoice Body Section Ends Here-->
    <br>
    <br><br><br><br>
    <br>
    <hr>
    <br>
    <!-- Inoice Footer Section Starts Here-->
    <div style="float:left; width:40%">
        <p>
            No Returns after 24 Hours & On Correct Items. Incorrect parts purchased must be in original condition. A 10% restocking fee will apply. Electrical parts are not refundable. No refund without Invoice.
        </p>
    </div>
    
    <div style="float:right; width: 40%;">
        <div style="float:left; width: 50%;">
            <p>Non-Taxable Total</p>
        </div>
        <div style="float:right; width: 50%; text-align: right;">
            <p>{{ $order->cart_items['formatted_sub_total'] }}</p>
        </div>
    
        <div style="float:left; width: 50%;  margin-top: 30px;">
            <p>Discount (%)</p>
        </div>
        <div style="float:right; width: 50%; text-align: right; margin-top: 30px;">
            <p>{{ optional($order->cart_items['applied_coupons'])['discount_amount'] }}</p>
        </div><br><br><br>
        <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 2px;"></div>

        <div style="float:left; width: 50%; ">
            <p>Sub-Total</p>
        </div>
        <div style="float:right; width: 50%; text-align: right; ">
            <p>{{ $order->cart_items['formatted_grand_total'] }}</p>
        </div><br><br>
        <div style="float:left; width: 50%; ">
            <p>Tax (18%)</p>
        </div>
        <div style="float:right; width: 50%; text-align: right;">
            <p>{{ number_format($order->cart_items['grand_total'] * 0.18, 2) }}</p>
        </div><br>
        <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;"></div>
    
        <div style="float:left; width: 50%; ">
            <p>Total Invoice</p>
        </div>
        <div style="float:right; width: 50%; text-align: right;">
            <p><b>{{ number_format($order->cart_items['grand_total'] + ($order->cart_items['grand_total'] * 0.18), 2) }}</b></p>
        </div>
    </div>
    <!-- Inoice Footer Section Ends Here-->
</body>
</html>