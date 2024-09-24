@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <x-alert message="{{ session('success') }}"></x-alert>
                            @endif
                            @if (session('error'))
                                <x-alert message="{{ session('error') }}"></x-alert>
                            @endif
                            @if (session('import_errors'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach (session('import_errors') as $error)
                                            <li>
                                                @foreach ($error['errors'] as $field => $messages)
                                                    <strong>Row {{ $loop->parent->index + 1 }}:</strong>
                                                    @foreach ($messages as $message)
                                                        {{ $message }}<br>
                                                    @endforeach
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Sales Product</h5>
                                    <div class="float-right">
                                        <a href="{{ url('download-sales-sample') }}"
                                        class="btn btn-primary primary-btn btn-md"><i class="fa fa-download"></i>Sales Sample File
                                    </a>
                                    <div class="d-inline-block">
                                        <form id="importForm" action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label for="fileInput" class="btn btn-primary primary-btn btn-md mb-0">
                                                Import CSV
                                                <input type="file" id="fileInput" name="file" accept=".csv" style="display:none;">
                                            </label>
                                        </form>
                                    </div>
                                        <a href="{{ route('sales-products.create') }}" class="btn btn-primary primary-btn btn-md">Create
                                            Sales Product</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="sales-product-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($salesProducts as $key => $salesProduct)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ optional($salesProduct->product)->product_name}}</td>
                                                        <td>{{ $salesProduct->start_date}}</td>
                                                        <td>{{ $salesProduct->end_date}}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button data-source="Sales Product"
                                                                    data-endpoint="{{ route('sales-products.destroy', $salesProduct->id) }}"
                                                                    class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
                                                                    <i class="feather icon-trash m-0"></i>
                                                                </button>
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

    <script>
        $(function() {
            $('#sales-product-list').DataTable();
        })

        $(document).ready(function() {
            $('#importButton').on('click', function() {
                $('#fileInput').click();
            });

            $('#fileInput').on('change', function(event) {
                var file = $(this).prop('files')[0];
                if (file && file.type === 'text/csv') {
                    $('#importForm').submit();
                } else {
                    alert('Please select a valid CSV file.');
                }
            });
        });
    </script>
@endsection