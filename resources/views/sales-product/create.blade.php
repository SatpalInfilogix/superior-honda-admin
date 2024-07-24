@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
ul.chosen-choices {
    width: 477px !important;
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
                                    <h5>Add Sales Product</h5>
                                    <div class="float-right">
                                        <a href="{{ route('sales-products.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('sales-products.store') }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-group">
                                                <label for="product">Product</label>
                                                <input name="product" id="" type="text" class="form-control product-autocomplete"
                                                    value="{{ old('product') }}">
                                                <div class="autocomplete-items"></div>
                                            </div>

                                            <div class=" form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                            </div>

                                        <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('body').on('input', '.product-autocomplete', function () {
                var input = $(this).val().trim();
                var autocompleteContainer = $(this).siblings('.autocomplete-items');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('autocomplete') }}',
                    data: { input: input },
                    success: function (response) {
                        autocompleteContainer.empty();
                        if (response.length > 0) {
                            $.each(response, function (key, value) {
                                var autocompleteItem = '<div class="autocomplete-item" data-id="' + value.id + '">' + value.product_name + '</div>';
                                autocompleteContainer.append(autocompleteItem);
                            });
                            autocompleteContainer.show();
                        } else {
                            autocompleteContainer.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Autocomplete AJAX error:', status, error);
                    }
                });
            });

            $('body').on('click', '.autocomplete-item', function() {
                var productName = $(this).text();
                var productId = $(this).data('id');
                var inputField = $(this).closest('.form-group').find('.product-autocomplete');
                inputField.val(productName);
                $(this).closest('.autocomplete-items').empty().hide();
            });
        });

        $(function() {
            $('form').validate({
                rules: {
                    product: "required",
                    start_date: "required",
                    end_date: "required",
                },

                messages: {
                    product: "Please enter product",
                    start_date: "Please enter start date",
                    end_date: "Please enter end date",
                },

                errorClass: "text-danger f-12",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        })
    </script>
@endsection
