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
                                    <h5>Vehicles</h5>

                                    <div class="float-right">
                                        @can('create product')
                                            <a href="{{ route('vehicles.create') }}"
                                                class="btn btn-primary btn-md">Add Vehicle
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicles-list"
                                            class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Variant</th>
                                                    <th>Type</th>
                                                    @canany(['edit vehicle', 'delete vehicle'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicles as $index => $vehicle)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $vehicle->customer->first_name.' '.$vehicle->customer->last_name }}</td>
                                                        <td>{{ $vehicle->category->name }}</td>
                                                        <td>{{ optional($vehicle->brand)->brand_name }}</td>
                                                        <td>{{ optional($vehicle->model)->model_name }}</td>
                                                        <td>{{ optional($vehicle->variant)->variant_name }}</td>
                                                        <td>{{ optional($vehicle->type)->vehicle_type }}</td>
                                                        @canany([
                                                            'edit vehicle',
                                                            'delete vehicle',
                                                            ])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit vehicle')
                                                                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                                            class="btn btn-primary waves-effect waves-light mr-2 edit-vehicle-type">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete vehicle')
                                                                        <button data-source="product"
                                                                            data-endpoint="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                                            class="delete-btn btn btn-danger waves-effect waves-light">
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
            $('#vehicles-list').DataTable();
        })
    </script>
@endsection