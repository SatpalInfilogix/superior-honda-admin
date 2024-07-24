@extends('layouts.app')

@section('content')
<style>
.autocomplete-items {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ddd;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;
    width: 96%;
}

.autocomplete-item {
    padding: 10px;
    cursor: pointer;
}

.autocomplete-item:hover {
    background-color: #f0f0f0;
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
                                <h5>Add Invoice</h5>
                                <div class="float-right">
                                    <a href="{{ route('invoices.index') }}" class="btn btn-primary btn-md primary-btn">
                                        <i class="feather icon-arrow-left"></i>
                                        Go Back
                                    </a>
                                </div>
                            </div>

                            <div class="card-block">
                                <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="job">Jobs</label>
                                            <select name="job_id" id="job_id" class="form-control">
                                                <option value="" selected disabled>Select Job</option>
                                                @foreach($jobs as $job)
                                                <option value="{{ $job->id }}">{{ $job->name .' '. $job->vehicle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 products-list" hidden>
                                            <label for="products">Products</label>
                                            <div id="product-fields">
                                                <!-- Initial product row -->
                                                <div class="form-row product-row">
                                                    <div class="col-md-3">
                                                        <input name="product[]" type="text" class="form-control product-autocomplete" placeholder="Product">
                                                        <div class="autocomplete-items"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input name="price[]" type="text" class="form-control cost-price" placeholder="Cost Price">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input name="discount[]" type="text" class="form-control discount" placeholder="Discount">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-danger removeButton remove-button d-none" type="button">
                                                            <i class="bi bi-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="newinput"></div><br>
                                            <button id="rowAdder" type="button" class="btn btn-add btn-sm">
                                                <i class="fa fa-plus"></i> Add More
                                            </button>
                                            <br><br>
                                            <div id="totalAmountDisplay" class="mt-3">
                                                Total Amount: <span id="totalAmount">$0.00</span>
                                            </div>
                                            <button type="submit" class="btn btn-primary primary-btn">Save</button> 
                                            <button type="button" class="btn btn-primary primary-btn waves-effect waves-light mr-2 btn-view" data-toggle="modal" data-target="#invoiceModalJob">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="invoiceModalJob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Discount Price</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceModalBody">
                        <!-- Data will be dynamically appended here -->
                    </tbody>
                </table>
                <div class="float-right total-amount"> Total Amount: <span id="modalTotalAmount">$0.00</span></div>
            </div>
            <div class="modal-footer d-flex">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function generateProductRow() {
            var html = '<div class="form-row product-row">' +
                '<div class="col-md-3">' +
                '<input name="product[]" type="text" class="form-control product-autocomplete" placeholder="Product">' +
                '<div class="autocomplete-items"></div>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input name="price[]" type="text" class="form-control cost-price" placeholder="Cost Price">' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input name="discount[]" type="text" class="form-control discount" placeholder="Discount">' +
                '</div>' +
                '<div class="col-md-3">' +
                '<button class="btn btn-danger removeButton remove-button" type="button">' +
                '<i class="bi bi-trash"></i> Remove' +
                '</button>' +
                '</div>' +
                '</div>';
            return html;
        }

        $('#job_id').on('change', function() {
            $(".products-list").removeAttr('hidden');
        });

        $('#rowAdder').click(function() {
            $('#product-fields').append(generateProductRow());
            $('.remove-button').removeClass('d-none');
        });

        $('body').on('click', '.remove-button', function() {
            var productRows = $('.product-row');
            if (productRows.length > 1) {
                $(this).closest('.product-row').remove();
            } else {
                $(this).closest('.product-row').find('input').val('');
            }
            if ($('#product-fields .product-row').length === 1) {
                $('.remove-button').addClass('d-none');
            }
            calculateTotalAmount();
        });

        $('body').on('input', '.product-autocomplete', function() {
            var input = $(this).val().trim();
            var autocompleteContainer = $(this).siblings('.autocomplete-items');

            $.ajax({
                type: 'GET',
                url: '{{ route('autocomplete') }}',
                data: { input: input },
                success: function(response) {
                    autocompleteContainer.empty();
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            var autocompleteItem = '<div class="autocomplete-item" data-id="' + value.id + '">' + value.product_name + '</div>';
                            autocompleteContainer.append(autocompleteItem);
                        });
                        autocompleteContainer.show();
                    } else {
                        autocompleteContainer.hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Autocomplete AJAX error:', status, error);
                }
            });
        });

        $('body').on('click', '.autocomplete-item', function() {
            var productName = $(this).text();
            var productId = $(this).data('id');
            var productRow = $(this).closest('.product-row');
            var inputField = productRow.find('.product-autocomplete');
            inputField.val(productName);
            $.ajax({
                type: 'GET',
                url: '{{ route('getProductDetails') }}',
                data: { id: productId },
                success: function(response) {
                    if (response.success) {
                        productRow.find('.cost-price').val(response.product.price);
                        productRow.find('.discount').val(response.product.discount);
                        calculateTotalAmount();
                    } else {
                        console.error('Failed to fetch product details.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Get Product Details AJAX error:', status, error);
                }
            });

            $(this).parent('.autocomplete-items').empty().hide();
        });

        function calculateTotalAmount() {
            var totalAmount = 0;

            $('.product-row').each(function() {
                var price = $(this).find('.cost-price').val();
                var discount = $(this).find('.discount').val();

                price = parseFloat(price) || 0;
                discount = parseFloat(discount) || 0;

                var totalPrice = price - (price * discount / 100);
                totalAmount += totalPrice;
            });

            $('#totalAmount').text('$' + totalAmount.toFixed(2));
        }

        $('#invoiceForm').submit(function(e) {
            if (!validateInputs()) {
                e.preventDefault();
            }
        });

        function validateInputs() {
            var isValid = true;

            $('.product-row').each(function() {
                var productInput = $(this).find('.product-autocomplete');
                var priceInput = $(this).find('.cost-price');
                var discountInput = $(this).find('.discount');

                if (productInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a product name.');
                    return false;
                }

                if (priceInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a cost price.');
                    return false;
                }

                if (discountInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a discount.');
                    return false;
                }
            });

            return isValid;
        }

        $('body').on('input', '.cost-price, .discount', function() {
            calculateTotalAmount();
        });
    });

    $(document).ready(function() {
        $('.btn-view').click(function() {
            $('#invoiceModalBody').empty();

            $('.product-row').each(function(index) {
                var productName = $(this).find('.product-autocomplete').val();
                var price = $(this).find('.cost-price').val();
                var discount = $(this).find('.discount').val();

                var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + productName + '</td>' +
                            '<td>' + price + '</td>' +
                            '<td>' + discount + '</td>' +
                            '<td>' + calculateDiscountPrice(price, discount) + '</td>' +
                        '</tr>';
                $('#invoiceModalBody').append(row);
            });

            var totalAmount = calculateTotalAmount();
            console.log(totalAmount);
            $('#modalTotalAmount').text('$' + totalAmount.toFixed(2));
        });

        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.product-row').each(function() {
                var price = $(this).find('.cost-price').val();
                var discount = $(this).find('.discount').val();
                price = parseFloat(price) || 0;
                discount = parseFloat(discount) || 0;

                var totalPrice = price - (price * discount / 100);
                totalAmount += totalPrice;
            });

            return totalAmount;
        }

        function calculateDiscountPrice(price, discount) {
            price = parseFloat(price) || 0;
            discount = parseFloat(discount) || 0;
            return (price - (price * discount / 100)).toFixed(2);
        }
    });
</script>

@endsection
