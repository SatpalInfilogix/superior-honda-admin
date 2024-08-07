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
                                    <h5>Vehicle Models</h5>
                                    @can('create vehicle configuration')
                                        <div class="float-right">
                                            <a href="{{ route('vehicle-models.create') }}" class="btn btn-primary primary-btn btn-md">Add
                                                Vehicle Model</a>
                                        </div>
                                    @endcan
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="car-models-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Category</th>
                                                    <th>Brand Name</th>
                                                    <th>Model Name</th>
                                                    <th>Model Image</th>
                                                    @canany(['edit vehicle configuration', 'delete vehicle configuration'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicleModels as $key => $vehicleModel)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $vehicleModel->category->name }}</td>
                                                        <td>{{ optional($vehicleModel->brand)->brand_name ?? 'N/A' }}</td>
                                                        <td>{{ ucwords($vehicleModel->model_name) }}</td>
                                                        <td><img src="{{ asset($vehicleModel->model_image) }}"
                                                                width="50" height="50"></td>
                                                        @canany([
                                                            'edit vehicle configuration',
                                                            'delete vehicle
                                                            configuration',
                                                            ])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit vehicle configuration')
                                                                        <a href="{{ route('vehicle-models.edit', $vehicleModel->id) }}"
                                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete vehicle configuration')
                                                                        <button data-source="vehicle model"
                                                                            data-endpoint="{{ route('vehicle-models.destroy', $vehicleModel->id) }}"
                                                                            class="delete-btn btn btn-danger primary-btn waves-effect waves-light">
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
            $('#car-models-list').DataTable();
        })
    </script>
@endsection