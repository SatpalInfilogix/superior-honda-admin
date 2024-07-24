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
                                        @if(Auth::user()->can('create branch'))
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
                                                    @canany(['edit branch', 'delete branch'])
                                                    <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($branches as $key => $branch)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $branch->name }}</td>
                                                        <td>{{ $branch->branch->name }}-{{ $branch->branch->address }}</td>
                                                        @canany(['edit branch', 'delete branch'])
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                @if(Auth::user()->can('edit branch'))
                                                                <a href="{{ route('bay.edit', $branch->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                @endif
                                                                @if(Auth::user()->can('edit branch'))
                                                                <button
                                                                    class="disable-branch btn btn-primary primary-btn waves-effect waves-light mr-2" data-value="{{$branch->id}}">
                                                                    <i class="feather icon-octagon m-0"></i>
                                                                </button>
                                                                @endif
                                                                @if(Auth::user()->can('delete branch'))
                                                                <button data-source="Branch" data-endpoint="{{ route('bay.destroy', $branch->id) }}"
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
             $('.disable-branch').on('click', function() {
        var id = $(this).data('value');
        
        if (confirm('Are you sure to make the branch disabled!')) {
            $.ajax({
                        url: '{{ route("disable-branch") }}',
                        method: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);
                        },
                        error: function(response) {
                            alert('Issue while updating the branch status');
                            console.error(response); // Log the error to the console
                        }
                    });
                }
            });
        });
    </script>
@endsection