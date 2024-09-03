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
                                        <a href="{{ url('download-user-sample') }}"
                                            class="btn btn-primary primary-btn btn-md"><i class="fa fa-download"></i>User Sample File
                                        </a>
                                        <div class="file-button btn btn-primary primary-btn">
                                            <form action="{{ route('users.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                Import CSV
                                                <input type="file" name="file" accept=".csv" class="input-field" />
                                            </form>
                                        </div>

                                        @can('create user')
                                            <a href="{{ route('users.create') }}" class="btn btn-primary primary-btn btn-md">Add
                                                User</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="users-list" class="table table-striped table-bordered nowrap">
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
                                                        <td> 
                                                            @if ($user->roles->isNotEmpty())
                                                            {{ $user->roles->pluck('name')[0] }}
                                                            @endif
                                                        </td>
                                                        @canany(['edit user', 'delete user'])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit user')
                                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan
                                                                    @can('delete user')
                                                                        <button data-source="User"
                                                                            data-endpoint="{{ route('users.destroy', $user->id) }}"
                                                                            class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
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
            $('[name="file"]').change(function() {
                $(this).parents('form').submit();
            });

            $('#users-list').DataTable();
        })
    </script>

@endsection

