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

                            <div class="card">
                                <div class="card-header">
                                    <h5>Products</h5>

                                    <div class="float-right">
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
                                        <table id="products-list"
                                            class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Barcode</th>
                                                    <th>Manufacture Name</th>
                                                    <th>Vehicle Category</th>
                                                    <th>Brand Name</th>
                                                    <th>Model Name</th>
                                                    <th>Variant Name</th>
                                                    <th>Vehicle Type</th>
                                                    @canany(['edit product', 'delete product'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $index => $product)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{!! $product->barcode !!}
                                                            P- {{$product->product_code}}
                                                        </td>
                                                        <td>{{ $product->manufacture_name }}</td>
                                                        <td>{{ $product->category->name }}</td>
                                                        <td>{{ optional($product->brand)->brand_name }}</td>
                                                        <td>{{ optional($product->model)->model_name }}</td>
                                                        <td>{{ optional($product->variant)->variant_name }}</td>
                                                        <td>{{ optional($product->type)->vehicle_type }}</td>
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
        $(function() {
            $('#products-list').DataTable();
        })
    </script>
@endsection