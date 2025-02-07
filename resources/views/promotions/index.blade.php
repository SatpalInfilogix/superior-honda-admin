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
                                <x-alert message="{{ session('error') }}"></x-alert>
                            @endif

                            @if (session('import_errors'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach (session('import_errors') as $error)
                                            <li>
                                                @foreach ($error['errors'] as $field => $messages)
                                                    <strong>Row {{ $loop->parent->index + 1 }}:</strong>
                                                    @foreach ($messages as $message)
                                                        {{ $message }}<br>
                                                    @endforeach
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Promotions</h5>
                                    <div class="float-right">
                                        @if(Auth::user()->can('create promotions'))
                                            <a href="{{ route('promotions.create') }}" class="btn btn-primary primary-btn btn-md">Add Promotions</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="promotions" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    @canany(['edit promotions', 'delete promotions'])
                                                    <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($promotions as $key => $promotion)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $promotion->heading }}</td>
                                                        <td><img src="{{ asset($promotion->main_image) }}" width="50"
                                                                height="50"></td>
                                                        @canany(['edit promotions', 'delete promotions'])
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                @if(Auth::user()->can('edit promotions'))
                                                                    <a href="{{ route('promotions.edit', $promotion->id) }}"
                                                                        class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                        <i class="feather icon-edit m-0"></i>
                                                                    </a>
                                                                @endif

                                                                @if($promotion->status == 'active')
                                                                    <button
                                                                        class="disable-promotion btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                        data-id="{{ $promotion->id }}" data-value="enabled">
                                                                        <i class="feather icon-check-circle m-0"></i>
                                                                    </button>
                                                                @else
                                                                    <button
                                                                        class="disable-promotion btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                        data-id="{{ $promotion->id }}" data-value="disabled">
                                                                        <i class="feather icon-slash m-0"></i>
                                                                    </button>
                                                                @endif
                                                                @if(Auth::user()->can('delete promotions'))
                                                                    <button data-source="promotion" data-endpoint="{{ route('promotions.destroy', $promotion->id) }}"
                                                                        class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
                                                                        <i class="feather icon-trash m-0"></i>
                                                                    </button>
                                                                @endif 
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
            $('#promotions').DataTable();

            $(document).on('click', '.disable-promotion', function() {
                var id = $(this).data('id');
                var value = $(this).data('value');
                swal({
                    title: "Are you sure?",
                    text: `You really want to ${value == 'enabled' ? 'disabled' : 'enabled'} ?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ route("disable-promotion") }}',
                            method: 'post',
                            data: {
                                id: id,
                                disable_promotion: value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.success){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        type: "success",
                                        showConfirmButton: false
                                    }) 

                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            }
                        })
                    }
                });
            })

            $(document).ready(function () {
                $('#importButton').on('click', function () {
                    $('#fileInput').click();
                });

                $('#fileInput').on('change', function (event) {
                    var file = $(this).prop('files')[0];
                    if (file) {
                        var validTypes = ['text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                        if (validTypes.includes(file.type)) {
                            $('#importForm').submit();
                        } else {
                            alert('Please select a valid CSV or XLSX file.');
                            $(this).val('');
                        }
                    } else {
                        alert('No file selected.');
                    }
                });
            });

        //      $('.disable-promotion').on('click', function() {
        // var id = $(this).data('value');
        
        // if (confirm('Are you sure to make the promotion disabled!')) {
        //     $.ajax({
        //                 url: '{{ route("disable-promotion") }}',
        //                 method: 'post',
        //                 data: {
        //                     id: id,
        //                     _token: '{{ csrf_token() }}'
        //                 },
        //                 success: function(response) {
        //                     alert(response.message);
        //                 },
        //                 error: function(response) {
        //                     alert('Issue while updating the promotion status');
        //                     console.error(response); // Log the error to the console
        //                 }
        //             });
        //         }
        //     });
        });
    </script>
@endsection