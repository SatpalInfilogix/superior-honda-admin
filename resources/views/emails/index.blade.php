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
                                    <h5>Emails</h5>
                                    <div class="float-right">
                                        <a href="{{ route('emails.create') }}" class="btn btn-primary btn-md primary-btn">Add
                                                Email</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="email-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Template Name</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($emails as $key => $emailTemplate)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $emailTemplate->email_template }}</td>
                                                    <td>
                                                        <label @class([
                                                            'label',
                                                            'label-danger primary-btn' => $emailTemplate->status == 'Deactive',
                                                            'label-success' => $emailTemplate->status == 'Active',
                                                            ])>{{ $emailTemplate->status }}
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('emails.edit', $emailTemplate->id) }}"
                                                                class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                                                <i class="feather icon-edit m-0"></i>
                                                            </a>
                                                            <button data-source="Email Template"
                                                                data-endpoint="{{ route('emails.destroy', $emailTemplate->id) }}"
                                                                class="delete-btn btn btn-danger waves-effect waves-light primary-btn">
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

            $('#email-list').DataTable();
        })
    </script>
@endsection