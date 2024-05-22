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
                                    @can('create roles & permissions')
                                        <div class="float-right">
                                            <a href="{{ route('roles.create') }}" class="btn btn-primary primary-btn btn-md">Add Role</a>
                                        </div>
                                    @endcan
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="roles-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Role</th>
                                                    @canany(['edit roles & permissions', 'delete roles & permissions'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $index => $role)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $role->name }}</td>
                                                        @canany(['edit roles & permissions', 'delete roles & permissions'])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit roles & permissions')
                                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                                        class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                        <i class="feather icon-edit m-0"></i>
                                                                    </a>
                                                                    @endcan

                                                                    @can('delete roles & permissions')
                                                                    <button data-source="role"
                                                                        data-endpoint="{{ route('roles.destroy', $role->id) }}"
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
            $('#roles-list').DataTable();
        })
    </script>
@endsection