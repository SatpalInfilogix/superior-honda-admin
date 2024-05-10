@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Branches</h5>
                                    <div class="float-right">
                                        @if(Auth::user()->can('create branch'))
                                        <a href="{{ route('branches.create') }}" class="btn btn-primary btn-md">Add Branch</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-types-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unique Code</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Pincode</th>
                                                    @canany(['edit branch', 'delete branch'])
                                                    <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($branches as $key => $branch)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $branch->unique_code }}</td>
                                                        <td>{{ $branch->name }}</td>
                                                        <td>{{ $branch->address }}</td>
                                                        <td>{{ $branch->pincode }}</td>
                                                        @canany(['edit branch', 'delete branch'])
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                @if(Auth::user()->can('edit branch'))
                                                                <a href="{{ route('branches.edit', $branch->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                @endif
                                                                @if(Auth::user()->can('delete branch'))
                                                                <button data-source="Branch" data-endpoint="{{ route('branches.destroy', $branch->id) }}"
                                                                    class="delete-btn btn btn-danger waves-effect waves-light">
                                                                    <i class="feather icon-trash m-0"></i>
                                                                </button>
                                                            </div>
                                                            @endif
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
            $('#vehicle-types-list').DataTable();
        })
    </script>
@endsection