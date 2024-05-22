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
                                                    <th>Vehicle</th>
                                                    <th>Year</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inquiries as $key => $inquiry)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ ucwords($inquiry->name) }}</td>
                                                        <td>{{ $inquiry->vehicle }}</td>
                                                        <td>{{ $inquiry->year }}</td>
                                                        <td>{{ $inquiry->date }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('inquiries.edit', $inquiry->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                <a href="{{ route('inquiries.show', $inquiry->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </a>
                                                                <button data-source="Inquiry"
                                                                    data-endpoint="{{ route('inquiries.destroy', $inquiry->id) }}"
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