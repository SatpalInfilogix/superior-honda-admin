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
                            <div class="card">
                                <div class="card-header">
                                    <h5>Vehicle Model variants</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-model-variants.create') }}" class="btn btn-primary btn-md">Add Vehicle Model</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-model-variants-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Category</th>
                                                    <th>Brand Name</th>
                                                    <th>Model Name</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Variant Name</th>
                                                    <th>Fuel Type</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vehicleModelVariants as $key => $vehicleModelVariant)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $vehicleModelVariant->category->name }}</td>
                                                    <td>{{ optional($vehicleModelVariant->brand)->brand_name ?? 'N/A' }}</td>
                                                    <td>{{ optional($vehicleModelVariant->model)->model_name }}</td>
                                                    <td>{{ optional($vehicleModelVariant->type)->vehicle_type }}</td>
                                                    <td>{{ $vehicleModelVariant->variant_name }}</td>
                                                    <td>{{ $vehicleModelVariant->fuel_type }}</td>
                                                    <td><img src="{{ asset($vehicleModelVariant->model_variant_image) }}" width="50" height="50"></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('vehicle-model-variants.edit', $vehicleModelVariant->id) }}"
                                                                class="btn btn-primary waves-effect waves-light mr-2">
                                                                <i class="feather icon-edit m-0"></i>
                                                            </a>
                                                            <button data-source="vehicle model" data-endpoint="{{ route('vehicle-model-variants.destroy', $vehicleModelVariant->id) }}"
                                                                class="delete-btn btn btn-danger waves-effect waves-light">
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

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.bootstrap4.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>

    <script>
        $(function() {
            $('#vehicle-model-variants-list').DataTable();
        })
    </script>
@endsection
