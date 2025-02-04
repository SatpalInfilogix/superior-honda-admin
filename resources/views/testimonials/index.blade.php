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
                                    <h5>Testimonial</h5>
                                        <div class="float-right">
                                            <a href="{{ route('testimonials.create') }}"
                                                class="btn btn-primary btn-md primary-btn">Add
                                                Testimonial</a>
                                        </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="testimonial-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Designation</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($testimonials as $index => $testimonial)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $testimonial->name }}</td>
                                                        <td><img src="{{ asset($testimonial->image) }}" width="50" height="50"></td>
                                                        <td>{{ $testimonial->designation }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('testimonials.edit', $testimonial->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2 edit-vehicle-type">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>

                                                                <button data-source="testimonial"
                                                                    data-endpoint="{{ route('testimonials.destroy', $testimonial->id) }}"
                                                                    class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
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
            $('#testimonial-list').DataTable();
        })
    </script>
@endsection