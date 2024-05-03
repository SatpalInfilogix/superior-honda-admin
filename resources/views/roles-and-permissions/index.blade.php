@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5>Roles & Permissions</h5>
                                </div>
                                <div class="card-block">
                                    <div class="roles-and-permissions">
                                        @foreach ($roles as $key => $role)
                                            <a class="accordion-msg b-none waves-effect waves-light">{{ $role->name }}</a>
                                            <div class="accordion-desc p-0 b-default">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Module Name</th>
                                                            <th>View</th>
                                                            <th>Add</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($modules as $module)
                                                            <tr>
                                                                <th scope="row">{{ $module }}</th>
                                                                <td>
                                                                    <x-input-checkbox
                                                                        name="{{ $role->name }}-{{ Str::lower($module) }}.view"
                                                                        checked="{{ $role->permissions->contains('name', Str::lower($module) . '.view') }}"
                                                                        data-role-id="{{ $role->id }}"
                                                                        data-permission="{{ Str::lower($module) . '.view' }}" />
                                                                </td>
                                                                <td>
                                                                    <x-input-checkbox
                                                                        name="{{ $role->name }}-{{ Str::lower($module) }}.create"
                                                                        checked="{{ $role->permissions->contains('name', Str::lower($module) . '.create') }}"
                                                                        data-role-id="{{ $role->id }}"
                                                                        data-permission="{{ Str::lower($module) . '.create' }}" />
                                                                </td>
                                                                <td>
                                                                    <x-input-checkbox
                                                                        name="{{ $role->name }}-{{ Str::lower($module) }}.update"
                                                                        checked="{{ $role->permissions->contains('name', Str::lower($module) . '.update') }}"
                                                                        data-role-id="{{ $role->id }}"
                                                                        data-permission="{{ Str::lower($module) . '.update' }}" />
                                                                </td>
                                                                <td>
                                                                    <x-input-checkbox
                                                                        name="{{ $role->name }}-{{ Str::lower($module) }}.delete"
                                                                        checked="{{ $role->permissions->contains('name', Str::lower($module) . '.delete') }}"
                                                                        data-role-id="{{ $role->id }}"
                                                                        data-permission="{{ Str::lower($module) . '.delete' }}" />
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
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
    <link rel="stylesheet" href="{{ asset('assets/css/notification.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>

    <script>
        $(function() {
            var icons = {
                header: "fas fa-up-arrow",
                activeHeader: "fas fa-down-arrow"
            };

            $(".roles-and-permissions").accordion({
                heightStyle: "content",
                icons: icons
            });


            $('[data-permission]').click(function() {
                let role_id = $(this).data('role-id');
                let permission_name = $(this).data('permission');

                $.ajax({
                    url: `{{ route('roles-and-permissions.index') }}/${ role_id }`,
                    method: 'PATCH',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        role_id: role_id,
                        permission_name: permission_name
                    },
                    success: function(response) {
                        $.growl({
                            message: response.message
                        }, {
                            type: 'inverse',
                            allow_dismiss: false,
                            label: 'Cancel',
                            className: 'btn-xs btn-inverse',
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            }
                        });
                    }
                })
            })
        })
    </script>
@endsection
