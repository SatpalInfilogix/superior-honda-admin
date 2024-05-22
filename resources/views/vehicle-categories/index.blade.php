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
                                    <h5>Vehicle Categories</h5>
                                    @can('create vehicle configuration')
                                        <div class="float-right">
                                            <a href="{{ route('vehicle-categories.create') }}"
                                                class="btn btn-primary btn-md primary-btn">Add
                                                Vehicle Category</a>
                                        </div>
                                    @endcan
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-categories-list"
                                            class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Category Name</th>
                                                    @canany(['edit vehicle configuration', 'delete vehicle configuration'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $index => $category)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        @canany([
                                                            'edit vehicle configuration',
                                                            'delete vehicle
                                                            configuration',
                                                            ])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @can('edit vehicle configuration')
                                                                        <a href="{{ route('vehicle-categories.edit', $category->id) }}"
                                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2 edit-vehicle-type">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete vehicle configuration')
                                                                        <button data-source="category"
                                                                            data-endpoint="{{ route('vehicle-categories.destroy', $category->id) }}"
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
            $('#vehicle-categories-list').DataTable();
        })
    </script>
@endsection