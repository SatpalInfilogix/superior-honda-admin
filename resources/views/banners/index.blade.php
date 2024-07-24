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
                                    <h5>Banners</h5>
                                    <div class="float-right">
                                        <a href="{{ route('banners.create') }}" class="btn btn-primary primary-btn btn-md">Create
                                            Banner</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="banner-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User</th>
                                                    <th>Banner Image</th>
                                                    <th>Product Name</th>
                                                    <th>Menu</th>
                                                    <th>Submenu</th>
                                                    <th>Size</th>
                                                    <th>Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($banners as $key => $banner)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $banner->user->first_name. ' '.$banner->user->last_name }}</td>
                                                        <td><img src="{{ asset($banner->banner_image) }}"  width="50" height="50"></td>
                                                        <td>{{ $banner->product_name}}</td>
                                                        <td>{{ $banner->menu}}</td>
                                                        <td>{{ $banner->submenu}}</td>
                                                        <td>{{ $banner->size}}</td>
                                                        <td>{{ $banner->type}}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('banners.edit', $banner->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>

                                                                <button data-source="Banner"
                                                                    data-endpoint="{{ route('banners.destroy', $banner->id) }}"
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
            $('#banner-list').DataTable();
        })
    </script>
@endsection