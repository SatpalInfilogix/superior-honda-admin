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
                                    <h5>User Management</h5>
                                    <div class="float-right">

                                        <div class="file-button btn btn-primary">
                                            <form action="{{ route('users.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                Import CSV
                                                <input type="file" name="file" accept=".csv" class="input-field" />
                                            </form>
                                        </div>

                                        @can('create user')
                                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-md">Add
                                                User</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="user-management-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Designation </th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    @canany(['edit user', 'delete user'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $user->first_name . $user->last_names }}</td>
                                                        <td>{{ $user->designation }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->roles->pluck('name')[0] }}</td>
                                                        @canany(['edit user', 'delete user'])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @if (Auth::user()->can('edit user'))
                                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                                            class="btn btn-primary waves-effect waves-light mr-2">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if (Auth::user()->can('delete user'))
                                                                        <button data-source="User"
                                                                            data-endpoint="{{ route('users.destroy', $user->id) }}"
                                                                            class="delete-btn btn btn-danger waves-effect waves-light">
                                                                            <i class="feather icon-trash m-0"></i>
                                                                        </button>
                                                                    @endif
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

            $('#user-management-list').DataTable();
        })
    </script>
@endsection
