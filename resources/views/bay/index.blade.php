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
                                    <h5>Bays</h5>
                                    <div class="float-right">
                                        @if(Auth::user()->can('create bay'))
                                        <a href="{{ route('bay.create') }}" class="btn btn-primary primary-btn btn-md">Add Bay</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-types-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Branch</th>
                                                    @canany(['edit bay', 'delete bay'])
                                                    <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bays as $key => $bay)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ ucwords($bay->name) }}</td>
                                                        <td>{{ optional($bay->branch)->name }}-{{ optional($bay->branch)->address }}</td>
                                                        @canany(['edit bay', 'delete bay'])
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                @if(Auth::user()->can('edit bay'))
                                                                <a href="{{ route('bay.edit', $bay->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                @endif
                                                                @if($bay->status == 0)
                                                                    <button
                                                                        class="disable-bay btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                        data-id="{{ $bay->id }}" data-value="enabled">
                                                                        <i class="feather icon-slash m-0"></i>
                                                                    </button>
                                                                @else
                                                                    <button
                                                                        class="disable-bay btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                        data-id="{{ $bay->id }}" data-value="disabled">
                                                                        <i class="feather icon-check-circle m-0"></i>
                                                                    </button>
                                                                @endif
                                                                @if(Auth::user()->can('delete bay'))
                                                                <button data-source="Bay" data-endpoint="{{ route('bay.destroy', $bay->id) }}"
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
            $('#vehicle-types-list').DataTable();

            $(document).on('click', '.disable-bay', function() {
                var id = $(this).data('id');
                var value = $(this).data('value');
                swal({
                    title: "Are you sure?",
                    text: `You really want to ${value} ?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ route("disable-bay") }}',
                            method: 'post',
                            data: {
                                id: id,
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
        });
    </script>
@endsection