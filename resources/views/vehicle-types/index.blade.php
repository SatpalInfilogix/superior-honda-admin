@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Vehicle Types</h5>
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-md" data-toggle="modal"
                                            data-target="#add-vehicle-type">Add Vehicle Type</button>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-types-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vehicle_types as $key => $vehicle_type)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $vehicle_type->vehicle_type }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-primary waves-effect waves-light mr-2 edit-vehicle-type"
                                                                data-toggle="modal" data-target="#edit-vehicle-type" data-vehicle-type="{{ json_encode($vehicle_type) }}">
                                                                <i class="feather icon-edit m-0"></i>
                                                        </button>
                                                            <button
                                                                class="delete-vehicle-type btn btn-danger waves-effect waves-light">
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

    @include('vehicle-types.create')
    @include('vehicle-types.edit')
    @include('vehicle-types.delete')
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
            $('#vehicle-types-list').DataTable();
        })
    </script>
@endsection
