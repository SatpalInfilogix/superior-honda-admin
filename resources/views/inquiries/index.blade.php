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
                                    <h5>Inquiries</h5>
                                    <div class="float-right">

                                        {{-- <div class="file-button btn btn-primary">
                                            <form action="{{ route('customers.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                Import CSV
                                                <input type="file" name="file" accept=".csv" class="input-field" />
                                            </form>
                                        </div> --}}

                                        <a href="{{ route('inquiries.create') }}" class="btn btn-primary btn-md">Add
                                            Inquery</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="inquiries-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>sdasd</td>
                                                        <td>asd</td>
                                                        <td>fgd</td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href=""
                                                                        class="btn btn-primary waves-effect waves-light mr-2">
                                                                        <i class="feather icon-edit m-0"></i>
                                                                    </a>
                                                                    <button data-source="customer"
                                                                        data-endpoint=""
                                                                        class="delete-btn btn btn-danger waves-effect waves-light">
                                                                        <i class="feather icon-trash m-0"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                    </tr>
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

            $('#inquiries-list').DataTable();
        })
    </script>
@endsection