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

                                        <a href="{{ route('inquiries.create') }}" class="btn btn-primary btn-md primary-btn">Add
                                            Inquiry</a>
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
                                                    <th>Status</th>
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
                                                        <td class="status-column" data-id="{{ $inquiry->id }}">{{ $inquiry->status }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('inquiries.edit', $inquiry->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                <a href="{{ route('inquiries.show', $inquiry->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </a>
                                                                <button data-source="Inquiry"
                                                                    data-endpoint="{{ route('inquiries.destroy', $inquiry->id) }}"
                                                                    class="delete-btn btn btn-danger waves-effect waves-light primary-btn">
                                                                    <i class="feather icon-trash m-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <form id="status-form" style="display:none;">
                                            @csrf
                                            <select name="status">
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                            <button type="submit">Save</button>
                                            <button type="button" id="cancel-btn">Cancel</button>
                                        </form>
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

            let appUrl = '{{ env("APP_URL") }}';

            function clickHandler() {
                var $this = $(this);
                var inquiryId = $this.data('id');
                var currentStatus = $this.text().trim();
                var $form = $('#status-form');
                var $originalContent = $this.html(); // Save the original content

                $this.off('click');

                $this.html($form.show());

                $form.find('select[name="status"]').val(currentStatus);

                $(document).on('click','#cancel-btn', function() {
                    $form.hide();
                    console.log($originalContent);
                    $this.html($originalContent); // Restore the original content
                    $this.on('click', clickHandler);
                });

                $form.on('submit', function(e) {
                    e.preventDefault();
                    var newStatus = $form.find('select[name="status"]').val();
                    console.log(newStatus);
                    $.ajax({
                        url: appUrl + '/inquiries/' + inquiryId + '/update-status',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus
                        },
                        success: function(response) {
                            if(response.success) {
                                alert('Status updated successfully');
                                location.reload();
                            } else {
                                alert('Error updating status');
                                $form.hide();
                                $this.html($originalContent); // Restore the original content
                                $this.on('click', clickHandler);
                            }
                        }
                    });
                });
            }

            $('.status-column').on('click', clickHandler);
        });
    </script>
@endsection
