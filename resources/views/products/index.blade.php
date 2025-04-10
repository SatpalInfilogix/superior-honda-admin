@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        {{-- <h2>Code: 98245226222</h2>
        {!! $barcode !!} --}}
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <x-alert message="{{ session('success') }}"></x-alert>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('import_errors'))
                                <div class="alert alert-danger">
                                    <strong>Errors:</strong>
                                    <ul>
                                        @foreach (session('import_errors') as $index => $error)
                                            <li>
                                                Row {{ $index + 1 }}:
                                                @if (isset($error['errors']))
                                                    @foreach ($error['errors'] as $field => $messages)
                                                        Field: {{ $field }} - {{ is_array($messages) ? implode('; ', $messages) : $messages }}
                                                    @endforeach
                                                @else
                                                    {{ implode('; ', $error['errors']) }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5>Products</h5>

                                    <div class="float-right">
                                        <a href="{{ route('product-export.csv') }}" class="btn btn-primary primary-btn btn-md"><i class="fa fa-download"></i>Export Products</a>
                                        <a href="{{ url('download-product-sample') }}"
                                            class="btn btn-primary primary-btn btn-md"><i class="fa fa-download"></i>Product Sample File
                                        </a>
                                        <div class="file-button btn btn-primary primary-btn">
                                            <form action="{{ route('products.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                Import CSV
                                                <input type="file" name="file" accept=".csv" class="input-field" />
                                            </form>
                                        </div>

                                        @can('create product')
                                            <a href="{{ route('products.create') }}"
                                                class="btn btn-primary primary-btn btn-md">Add product
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <form id="productFilterForm" method="GET" action="{{ route('products.index') }}" class="mb-3">
                                            <div class="row mr-0">
                                                <div class="col-md-3">
                                                    <input name="product" id="productSearch" type="text" class="form-control product-autocomplete"
                                                    value="{{ request('product') }}" placeholder="Enter Product Name">
                                                    <div class="autocomplete-items"></div>                                                
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="product_code" class="form-control" placeholder="Enter Product Code" value="{{ request('product_code') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="item_number" class="form-control" placeholder="Enter Item Number" value="{{ request('item_number') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary primary-btn custom">Filter</button>
                                                    <a href="{{ route('products.index') }}" class="btn btn-secondary custom">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                        <table id="products-list"
                                            class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width:0px !important;">#</th>
                                                    <th style="width:487.585px !important;">Product Name</th>
                                                    <!-- <th>Barcode</th> -->
                                                    <!-- <th>Manufacture Name</th>
                                                    <th>Vehicle Category</th> -->
                                                    <!-- <th>Brand Name</th> -->
                                                    <th style="width:276.065px !important;">Model Name</th>
                                                    <!-- <th>Variant Name</th>
                                                    <th>Vehicle Type</th> -->
                                                    @canany(['edit product', 'delete product'])
                                                        <th style="width:200px !important;">Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $index => $product)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <!-- <td>{!! $product->barcode !!}
                                                            P- {{$product->product_code. ' '.$product->product_name}}
                                                        </td> -->
                                                        <!-- <td>{{ $product->manufacture_name }}</td>
                                                        <td>{{  optional($product->category)->name }}</td> -->
                                                        <!-- <td>{{ optional($product->brand)->brand_name }}</td> -->
                                                        <td>{{ optional($product->model)->model_name }}</td>
                                                        <!-- <td>{{ optional($product->variant)->variant_name }}</td>
                                                        <td>{{ optional($product->type)->vehicle_type }}</td> -->
                                                        @canany([
                                                            'edit product',
                                                            'delete product',
                                                            ])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit product')
                                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2 edit-vehicle-type">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @if($product->status == 1)
                                                                        <button
                                                                            class="disable-product btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                            data-id="{{ $product->id }}" data-value="enabled">
                                                                            <i class="feather icon-check-circle m-0"></i>
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            class="disable-product btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                            data-id="{{ $product->id }}" data-value="disabled">
                                                                            <i class="feather icon-slash m-0"></i>
                                                                        </button>
                                                                    @endif

                                                                    @can('delete product')
                                                                        <button data-source="product"
                                                                            data-endpoint="{{ route('products.destroy', $product->id) }}"
                                                                            class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
                                                                            <i class="feather icon-trash m-0"></i>
                                                                        </button>
                                                                    @endcan
                                                                </div>
                                                            </td>
                                                        @endcanany
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
    <script>
        document.getElementById('productFilterForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const form = event.target;
            const formData = new FormData(form);
            const queryParams = new URLSearchParams();
        
            formData.forEach((value, key) => {
                if (value.trim() !== '') {
                    queryParams.append(key, value);
                }
            });
        
            window.location.href = form.action + '?' + queryParams.toString();
        });
        $(document).ready(function () {
            $('body').on('input', '.product-autocomplete', function () {
                var input = $(this).val().trim();
                var autocompleteContainer = $(this).siblings('.autocomplete-items');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('product.autocomplete') }}',
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
                $('#productSearch').val(productName);
                $(this).closest('.autocomplete-items').empty().hide();
            });
        });

        $(function() {
            $('[name="file"]').change(function() {
                $(this).parents('form').submit();
            });

            $('#products-list').DataTable();

                $(document).on('click', '.disable-product', function() {
                    var id = $(this).data('id');
                    var value = $(this).data('value');
                    swal({
                        title: "Are you sure?",
                        text: `You really want to ${value == 'enabled' ? 'disabled' : 'enabled'} ?`,
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                    }, function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: '{{ route("disable-product") }}',
                                method: 'post',
                                data: {
                                    id: id,
                                    disable_product: value,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if(response.success){
                                        swal({
                                            title: "Success!",
                                            text: response.message,
                                            type: "success",
                                            showConfirmButton: false
                                        }) 

                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    }
                                }
                            })
                        }
                    });
                })
        })
        
    </script>
@endsection