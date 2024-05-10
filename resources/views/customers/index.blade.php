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
                                @foreach (session('error') as $key => $error)
                                    @foreach ($error as $errorKey => $value)
                                        <x-alert type="error" message="{{ $value }}"></x-alert>
                                    @endforeach
                                @endforeach
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Customer Management</h5>
                                    <div class="float-right">

                                        {{-- <div class="file-button btn btn-primary">
                                            <form action="{{ route('customers.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                Import CSV
                                                <input type="file" name="file" accept=".csv" class="input-field" />
                                            </form>
                                        </div> --}}

                                        @can('create customer')
                                            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-md">Add
                                                customer</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="customers-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    @canany(['edit customer', 'delete customer'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $key => $customer)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $customer->first_name . $customer->last_names }}</td>
                                                        <td>{{ $customer->designation }}</td>
                                                        <td>{{ $customer->email }}</td>
                                                        @canany(['edit customer', 'delete customer'])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit customer')
                                                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                                                            class="btn btn-primary waves-effect waves-light mr-2">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan
                                                                    @can('delete customer')
                                                                        <button data-source="customer"
                                                                            data-endpoint="{{ route('customers.destroy', $customer->id) }}"
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
            $('[name="file"]').change(function() {
                $(this).parents('form').submit();
            });

            $('#customers-list').DataTable();
        })
    </script>
@endsection
