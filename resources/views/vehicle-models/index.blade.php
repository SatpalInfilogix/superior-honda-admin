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
                                    <h5>Car Models</h5>
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-md" data-toggle="modal"
                                            data-target="#add-car-model">Add Car Model</button>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="car-models-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Brand Name</th>
                                                    <th>Model Name</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>SUV</td>
                                                    <td>SUV</td>
                                                    <td>SUV</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-primary waves-effect waves-light mr-2"
                                                                data-toggle="modal" data-target="#edit-car-model">
                                                                <i class="feather icon-edit m-0"></i>
                                                            </button>
                                                            <button class="delete-car-model btn btn-danger waves-effect waves-light">
                                                                <i class="feather icon-trash m-0"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Sedan</td>
                                                    <td>Sedan</td>
                                                    <td>Sedan</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-primary waves-effect waves-light mr-2">
                                                                <i class="feather icon-edit m-0"></i>
                                                            </button>
                                                            <button class="delete-car-model btn btn-danger waves-effect waves-light">
                                                                <i class="feather icon-trash m-0"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
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

    @include('car-models.create')
    @include('car-models.edit')
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
            $('#car-models-list').DataTable();
        })
    </script>
@endsection
