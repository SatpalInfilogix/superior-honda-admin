@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Car Types</h5>
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-md" data-toggle="modal"
                                            data-target="#add-car-type">Add Car Type</button>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="car-types-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Car Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($carTypes as $key => $carType)
                                                <tr>
                                                    <td>{{ ++$key}}</td>
                                                    <td>{{ $carType->car_type }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="" class="btn btn-primary waves-effect waves-light mr-2"
                                                                data-toggle="modal" data-target="#edit-car-type" data-id="{{ $carType->id }}" data-name="{{ $carType->car_type }}">
                                                                <i class="feather icon-edit m-0"></i>
                                                            </a>
                                                            <button
                                                                class="delete-car-type btn btn-danger waves-effect waves-light">
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

    @include('car-types.create')
    @include('car-types.edit')
    @include('car-types.delete')
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
            $('#car-types-list').DataTable();
        })
    </script>
@endsection
