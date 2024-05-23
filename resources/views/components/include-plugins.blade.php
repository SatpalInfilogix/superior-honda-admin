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

@isset($datePicker)
    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datedropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">

        <script src="{{ asset('assets/js/moment.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min-2.js') }}"></script>
        <script src="{{ asset('assets/js/moment-with-locales.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datedropper.min.js') }}"></script>
    @endsection
@endisset


@isset($fullCalendar)
    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.print.css') }}" media='print'>
    @endsection

    @section('script')
        <script src="{{ asset('assets/js/moment.min-2.js') }}"></script>
        <script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/js/calendar.js') }}"></script>
    @endsection
@endisset

@isset($textEditor)
        <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@endisset