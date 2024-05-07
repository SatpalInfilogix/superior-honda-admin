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
                                    <h5>Roles & Permissions</h5>
                                </div>
                                <div class="card-block">
                                    <div class="roles-and-permissions">
                                        @foreach ($roles as $key => $role)
                                            <a class="accordion-msg b-none waves-effect waves-light">{{ $role->name }}</a>
                                            <form action="{{ route('roles-and-permissions.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
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
                                                                    <th scope="row">{{ $module->name }}</th>
                                                                    <td>
                                                                        <x-input-checkbox name="permissions[]"
                                                                            id="{{ $role->id . 'view_' . $module->slug }}"
                                                                            value="{{ 'view ' . $module->slug }}"
                                                                            checked="{{ $role->permissions->contains('name', 'view ' . $module->slug) }}" />
                                                                    </td>
                                                                    <td>
                                                                        <x-input-checkbox name="permissions[]"
                                                                            id="{{ $role->id . 'create_' . $module->slug }}"
                                                                            value="{{ 'create ' . $module->slug }}"
                                                                            checked="{{ $role->permissions->contains('name', 'create ' . $module->slug) }}" />
                                                                    </td>
                                                                    <td>
                                                                        <x-input-checkbox name="permissions[]"
                                                                            id="{{ $role->id . 'edit_' . $module->slug }}"
                                                                            value="{{ 'edit ' . $module->slug }}"
                                                                            checked="{{ $role->permissions->contains('name', 'edit ' . $module->slug) }}" />
                                                                    </td>
                                                                    <td>
                                                                        <x-input-checkbox name="permissions[]"
                                                                            id="{{ $role->id . 'delete_' . $module->slug }}"
                                                                            value="{{ 'delete ' . $module->slug }}"
                                                                            checked="{{ $role->permissions->contains('name', 'delete ' . $module->slug) }}" />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-2">Save</button>
                                            </form>
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
        })
    </script>
@endsection
