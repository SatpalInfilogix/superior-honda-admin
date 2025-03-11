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
                                        <button id="print-btn" class="btn btn-primary btn-md primary-btn">Print</button>

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
                                                        <td class="status-column" data-id="{{ $inquiry->id }}"><span>{{ $inquiry->status }} <i class="fas fa-chevron-down"></i></span></td>
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
                                                                <button data-endpoint="{{ route('inquiry.inquiry-print', $inquiry->id ) }}" id="print-inquiry"class="print-inquiry btn btn-primary waves-effect waves-light mr-2 primary-btn"><i class="feather icon-printer m-0"></i></button>

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
            $('#print-btn').click(function() {
                var printUrl = '{{ route('inquiry.print-inquiry') }}';
                var printWindow = window.open(printUrl, '_blank'); // Open the print page in a new tab/window

                printWindow.onload = function() {
                    printWindow.print();
                };
            });

            $('.print-inquiry').click(function() {
                var url = $(this).data('endpoint'); // Use $(this) to reference the clicked element
                var printWindow = window.open(url, '_blank'); // Open the print page in a new tab/window

                printWindow.onload = function() {
                    printWindow.print();
                };
            });

            $('[name="file"]').change(function() {
                $(this).parents('form').submit();
            });

            $('#inquiries-list').DataTable();

            let appUrl = '{{ env("APP_URL") }}';
            let $statusForm = $('#status-form');
            let $currentStatusColumn = null;
            let $originalContent = null;

            function clickHandler() {
                var $this = $(this);
                var inquiryId = $this.data('id');
                var currentStatus = $this.text().trim();

                if ($currentStatusColumn && $currentStatusColumn[0] !== $this[0]) {
                    $statusForm.hide();
                    $currentStatusColumn.html($originalContent);
                    $currentStatusColumn.on('click', clickHandler);
                }

                if ($this === $currentStatusColumn) {
                    $statusForm.hide();
                    $this.html($originalContent);
                    $this.on('click', clickHandler);
                    $currentStatusColumn = null;
                    $originalContent = null;
                    return;
                }

                $currentStatusColumn = $this;
                $originalContent = $this.html();

                $this.off('click');
                $this.html($statusForm.show());
                $statusForm.find('select[name="status"]').val(currentStatus);

                $(document).on('click', '#cancel-btn', function() {
                    $statusForm.hide();
                    $currentStatusColumn.html($originalContent);
                    $currentStatusColumn.on('click', clickHandler);
                    $currentStatusColumn = null;
                    $originalContent = null;
                });

                $statusForm.on('submit', function(e) {
                    e.preventDefault();
                    var newStatus = $statusForm.find('select[name="status"]').val();
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
                                $statusForm.hide();
                                $currentStatusColumn.html($originalContent);
                                $currentStatusColumn.on('click', clickHandler);
                                $currentStatusColumn = null;
                                $originalContent = null;
                            }
                        }
                    });
                });
            }

            $('.status-column').on('click', clickHandler);
        });
    </script>
@endsection
