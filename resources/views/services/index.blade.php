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
                            <div class="card">
                                <div class="card-header">
                                    <h5>Services</h5>
                                    <div class="float-right">
                                        <a href="{{ route('services.create') }}" class="btn btn-primary primary-btn btn-md">Create
                                            Services </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="servies-product-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Service Name</th>
                                                    <th>Price</th>
                                                    <!-- <th>Model</th> -->
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($services as $key => $service)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $service->name}}</td>
                                                        <td>{{ $service->price}}</td>
                                                        <!-- <td>{{ $service->model_name}}</td> -->
                                                        <td>{{ $service->start_date}}</td>
                                                        <td>{{ $service->end_date}}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('services.edit', $service->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>

                                                                <button data-source="Service"
                                                                    data-endpoint="{{ route('services.destroy', $service->id) }}"
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
            $('#servies-product-list').DataTable();
        })
    </script>
@endsection