@isset($dataTable)
    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables.bootstrap4.min.css') }}">
    @endsection

    @section('script')
        <script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
    @endsection
@endisset
