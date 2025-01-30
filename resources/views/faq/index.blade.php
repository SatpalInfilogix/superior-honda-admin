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
                                    <h5>Faq</h5>
                                        <div class="float-right">
                                            <a href="{{ route('faqs.create') }}"
                                                class="btn btn-primary btn-md primary-btn">Add
                                                Faq</a>
                                        </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="faq-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($faqs as $key => $faq)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $faq->question }}</td>
                                                    <td>{!! Str::words($faq->answer, 5) !!}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('faqs.edit', $faq->id) }}"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2 edit-vehicle-type">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>

                                                                <button data-source="faq"
                                                                    data-endpoint="{{ route('faqs.destroy', $faq->id) }}"
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
            $('#faq-list').DataTable();
        })
    </script>
@endsection