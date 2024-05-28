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

@isset($multipleImage)
    <script>
        var fileArr = [];
        $("#images").change(function() {
            if (fileArr.length > 0) fileArr = [];
            $('#image_preview_new').html("");
            var total_file = document.getElementById("images").files;
            if (!total_file.length) return;
            for (var i = 0; i < total_file.length; i++) {
                if (total_file[i].size > 1048576) {
                    return false;
                } else {
                    fileArr.push(total_file[i]);
                    $('#image_preview_new').append("<div class='img-div' id='img-div" + i + "'><img src='" + URL
                        .createObjectURL(event.target.files[i]) +
                        "' class='img-responsive image' style='height:141px; width:150px' title='" + total_file[
                            i].name + "'><div class='middle'><button id='action-icon' value='img-div" + i +
                        "' class='btn btn-danger' role='" + total_file[i].name +
                        "'><i class='fa fa-trash'></i></button></div></div>");
                }
            }
        });

        $('body').on('click', '#action-icon', function(evt) {
            var divName = this.value;
            var fileName = $(this).attr('role');
            $(`#${divName}`).remove();
            for (var i = 0; i < fileArr.length; i++) {
                if (fileArr[i].name === fileName) {
                    fileArr.splice(i, 1);
                }
            }
            document.getElementById('images').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file) {
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        $('#vehicle_category_id').on('change', function() {
            var category_id = this.value;
            $("#brand_name").html('');
            $("#vehicle_type").html('');
            $("#model_name").html('<option value="">Select Model</option>');
            $("#model_variant_name").html('<option value="">Select Model Variant</option>');
            $.ajax({
                url: "{{ url('get-vehicle-brand') }}",
                type: "POST",
                data: {
                    category_id: category_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#brand_name').html(result.options);
                    $("#vehicle_type").html(result.vehicleTypeOption);
                }
            });
        });

        $('#brand_name').on('change', function() {
            var brand_id = this.value;
            $("#model_name").html('');
            $.ajax({
                url: "{{ url('get-vehicle-model') }}",
                type: "POST",
                data: {
                    brand_id: brand_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#model_name').html(result.options);
                }
            });
        });

        $('#model_name').on('change', function() {
            var model_id = this.value;
            $("#model_variant_name").html('');
            $.ajax({
                url: "{{ url('get-vehicle-model-variant') }}",
                type: "POST",
                data: {
                    model_id: model_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#model_variant_name').html(result.options);
                }
            });
        });
    </script>
@endisset

@isset($imagePreview)
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('image_preview');
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    preview.innerHTML = '';
                    preview.appendChild(img);
                };
            };
            reader.readAsDataURL(file);
        });
    </script>
@endisset
