<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #0056b3;
        }
        .invoice-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .invoice-header h2 {
            margin: 0;
        }
        .product-list {
            margin-top: 20px;
        }
        .product {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
            align-items: center;
        }
        .product:last-child {
            border-bottom: none; /* Remove last border */
        }
        .product-info {
            flex: 1; /* Allow product name to take available space */
        }
        .product-pricing {
            display: flex;
            justify-content: center;
            flex: 1; /* Center pricing and discount details */
        }
        .price, .discount, .discounted-price {
            margin: 0 60px; /* Add space between the pricing elements */
        }
        .product-pricing strong {
            margin: 0 40px; /* Increased space between heading elements */
        }
        .total-amount {
            margin-top: 20px;
            font-size: 1.5em;
            font-weight: bold;
            text-align: right; /* Align total amount text to the right */
        }

        /* Print styles */
        @media print {
            body {
                margin: 0; /* Remove margin for print */
                padding: 0;
            }
            h1 {
                margin-top: 0; /* Remove margin for print */
            }
            .btn {
                display: none; /* Hide buttons during print */
            }
        }
    </style>
</head>
<body>
    <h1>Invoice Report</h1>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Invoice Number: {{ $invoices->invoice_no }}</h2>
        </div>
        <div class="product-list">
            <div class="product">
                <div class="product-info"><strong>Product Name</strong></div>
                <div class="product-pricing">
                    <strong>Price</strong>
                    <strong>Discount</strong>
                    <strong>Discounted Price</strong>
                </div>
            </div>
            <?php
                $productDetails = json_decode($invoices->product_details);
            ?>
            @foreach($productDetails->products as $invoice)
                <div class="product">
                    <div class="product-info">{{ $invoice->product }}</div>
                    <div class="product-pricing">
                        <div class="price">${{ number_format($invoice->price, 2) }}</div>
                        <div class="discount">${{ number_format($invoice->discount, 2) }}</div>
                        <div class="discounted-price">${{ number_format($invoice->discounted_price, 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="total-amount">
            Total Amount: ${{ number_format(optional($productDetails)->totalAmount, 2) }}
        </div>
    </div>
</body>
</html>
