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
                                    <h5>Manage Roles</h5>
                                    <div class="float-right">
                                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-md">Add Role</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="roles-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $index => $role)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $role->name }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                <button data-source="role"
                                                                    data-endpoint="{{ route('roles.destroy', $role->id) }}"
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
            $('#roles-list').DataTable();
        })
    </script>
@endsection
