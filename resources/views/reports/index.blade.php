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
                                    <h5>Reports</h5>
                                    <div class="float-right">
                                    <a href="{{route('reports-chart')}}"  target="_blank">
                                        <button type="button" class="btn btn-primary primary-btn btn-group-sm">Reports Chart</button>
                                    </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <form id="filter-form" action="#" method="GET">
                                                <label for="report-filter">Report Filter:</label>
                                                <div class="d-flex">
                                                    <select name="report-filter" id="report-filter"
                                                        class="form-control mr-2">
                                                        <option value="" selected disabled>Select Filter</option>
                                                        <option value="Inqueries">Inquiries</option>
                                                        <option value="Vehicle">Inquiry By Vehicle</option>
                                                        <option value="Product_Sold_Report">Product Sold Report</option>
                                                    </select>
                                                    <input type="hidden" name="dataFilter" value="" id="dataFilter">
                                                    <input type="hidden" name="dataFilter" value="" id="dailyFilter">
                                                    <input type="hidden" name="date" value="" id="date">
                                                    <input type="hidden" name="startDate" value="" id="startDate">
                                                    <input type="hidden" name="endDate" value="" id="endDate">
                                                    <input type="hidden" name="vehicleName" value="" id="vehicleName">
                                                    <input type="hidden" name="vehicleMileage" value="" id="vehicleMileage">
                                                    <input type="hidden" name="dateOfBirth" value="" id="dateOfBirth">
                                                    <input type="hidden" name="vehicleLicenceNo" value="" id="vehicleLicenceNo">

                                                    <button type="button" id="filter-button" class="btn btn-primary primary-btn btn-group-sm">Apply</button>
                                                </div>
                                                <div class="error-message text-danger"></div>
                                            </form>
                                        </div>
                                        <div class="col-md-6 form-group day-week-month-filter" hidden>
                                            <div>
                                                <button type="button" id="day-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Day">Day</button>
                                                <button type="button" id="week-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Week">Week</button>
                                                <button type="button" id="month-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Month">Month</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dt-responsive table-responsive">
                                        <div class="filter"> Select Any Option</div>
                                        <table id="inquiries-report-table" class="table table-striped table-bordered nowrap"
                                            hidden>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Vehicle</th>
                                                    <th>License Number</th>
                                                </tr>
                                            </thead>
                                            <tbody id="inquiries-report-table-body">
                                                <!-- Table body will be filled dynamically -->
                                            </tbody>
                                        </table>

                                        <table id="product-report-table" class="table table-striped table-bordered nowrap" hidden>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Manufacture Name</th>
                                                    <th>Cost Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-report-table-body">
                                                <!-- Table body will be filled dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="pagination-container" class="pagination d-flex justify-content-center mt-3">
                                        <!-- Pagination links will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!--- Pop Up Model Day ----- -->
    <div class="modal fade" id="dayModal" tabindex="-1" role="dialog" aria-labelledby="dayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dayModalLabel">Select Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="date-form">
                        <div class="form-group">
                            <label for="selected-date">Date:</label>
                            <input type="date" class="form-control" id="selected-date" name="selected-date">
                            <input type="hidden" name="filter" value="Day" id="dayFilter">
                            <div class="date-error-message text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-date-modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
        <!--- Pop Up Model Week ----- -->
    <div class="modal fade" id="weekModal" tabindex="-1" role="dialog" aria-labelledby="weekModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weekModalLabel">Select Start and End Dates for Week</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="week-form">
                        <div class="form-group">
                            <label for="start-week">Start Date:</label>
                            <input type="date" class="form-control" id="start-week" name="start-week">
                            <div class="start-week-error-message text-danger"></div>
                        </div>
                        <div class="form-group">
                            <label for="end-week">End Date:</label>
                            <input type="date" class="form-control" id="end-week" name="end-week">
                            <div class="end-week-error-message text-danger"></div>
                        </div>
                        <input type="hidden" name="filter" value="Week" id="weekFilter">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-week-modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
        <!--- Pop Up Model Month ----- -->
    <div class="modal fade" id="monthModal" tabindex="-1" role="dialog" aria-labelledby="monthModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monthModalLabel">Select Start and End Dates for Month</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="month-form">
                        <div class="form-group">
                            <label for="start-month">Start Date:</label>
                            <input type="date" class="form-control" id="start-month" name="start-month">
                            <div class="start-month-error-message text-danger"></div>
                        </div>
                        <div class="form-group">
                            <label for="end-month">End Date:</label>
                            <input type="date" class="form-control" id="end-month" name="end-month">
                            <div class="end-month-error-message text-danger"></div>
                        </div>
                        <input type="hidden" name="filter" value="Month" id="monthFilter">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-month-modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop Up Model Vehicle Inquiry -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleModalLabel">Select Vehicle License Plate Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehicle-form">
                        <div class="form-group">
                            <label for="vehicle-name">Vehicle:</label>
                            <select class="form-control" id="vehicle-name" name="vehicle-name">
                                <option value="" selected disabled>Vehicle Name</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->vehicle }}">{{ $vehicle->vehicle }}</option>
                                @endforeach
                            </select>
                            <div class="vechicle-name-error-message text-danger"></div>
                        </div>

                        <div class="form-group">
                            <label for="vehicle-mielage">Mielage:</label>
                            <select class="form-control" id="vehicle_mileage" name="mielage" disabled>
                                <option value="" selected disabled>Select Mielage</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dob">DOB:</label>
                            <select class="form-control" id="dob" name="dob" disabled>
                                <option value="" selected disabled>Select DOB</option>
                            </select>
                            {{-- <input type="hidden" name="filter" value="Vehicle" id="vehicleFilter"> --}}
                        </div>

                        <div class="form-group">
                            <label for="vehicle-license">License Plate Number:</label>
                            <select class="form-control" id="vehicle-license" name="vehicle-license" disabled>
                                <option value="" selected disabled>Select License Plate Number</option>
                            </select>
                            {{-- <input type="hidden" name="filter" value="Vehicle" id="vehicleFilter"> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-vehicle-modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader element -->
    <div id="loader" class="d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script>
        function loadReports(page = 1) {
            var filterValue = $('#dataFilter').val();
            var filter = $('#dailyFilter').val();
            var date = $('#date').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var vehicleName = $('#vehicleName').val();
            var vehicleMileage = $('#vehicleMileage').val();
            var dob = $('#dateOfBirth').val();
            var license = $('#vehicleLicenceNo').val();

            var url = '{{ route("fetch-data") }}?page=' + page + '&filter=' + filter + '&date=' + date + '&startDate=' + startDate +
                    '&endDate=' + endDate + '&filterValue=' + filterValue +  '&vehicleName=' + vehicleName + '&vehicleMileage=' + vehicleMileage + '&dob=' + dob + '&vehicleLicense=' + license;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if(filterValue == 'Inqueries') {
                        $('#inquiries-report-table tbody').html(response.data);
                    } else if(filterValue == 'Product_Sold_Report'){
                        $('#product-report-table tbody').html(response.data);
                    } else {
                        $('#inquiries-report-table tbody').html(response.data);
                    }
                    $('#pagination-container').html(response.links);
                },
            });
        }
        $(document).on('click', '#pagination-container a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadReports(page);
        });

        loadReports();
        $(document).ready(function() {
            $('#filter-button').on('click', function(event) {
                event.preventDefault();
                var filterValue = $('#report-filter').val();
                if (!filterValue) {
                    $('.error-message').html('Please select any option.');
                    return false;
                } else {
                    $('.error-message').html('');
                    // $('#filter-button').attr('hidden', 'hidden');
                    if (filterValue == 'Vehicle') {
                        $('#vehicleModal').modal('show');
                    } else {
                        // Hide vehicle modal if another option is selected
                        $('#vehicleModal').modal('hide');
                        showLoader();
                        $.ajax({
                            url: '{{ route("fetch-data") }}',
                            method: 'GET',
                            data: {
                                filter: filterValue,
                                filterValue: filterValue
                            },
                            success: function(response) {
                                hideLoader();
                                if (response.success) {
                                    if (filterValue == 'Inqueries') {
                                        $('#inquiries-report-table').removeAttr('hidden');
                                        $('#inquiries-report-table tbody').html(response.data);
                                        $('#product-report-table').attr('hidden', 'hidden');
                                    }
                                    if (filterValue == 'Product_Sold_Report') {
                                        $('#inquiries-report-table').attr('hidden', 'hidden');
                                        $('#product-report-table tbody').html(response.data);
                                        $('#product-report-table').removeAttr('hidden');
                                    }
                                    $('.day-week-month-filter').removeAttr('hidden');
                                    $('.filter').attr('hidden', 'hidden');
                                    $('#dailyFilter').val($('#report-filter').val());
                                    $('#dataFilter').val($('#report-filter').val());
                                    $('#pagination-container').html(response.links);
                                }
                            },
                        });
                    }
                }
            });

            $('#day-filter').click(function() {
                $('#dayModal').modal('show');
            });

            $('#submit-date-modal').click(function() {
                var selectedDate = $('#selected-date').val();
                var dataFilter = $('#dayFilter').val();
                var filterValue = $('#report-filter').val();
                if (!selectedDate) {
                    $('.date-error-message').html('Please enter date.');
                    return false;
                } else {
                    $('.date-error-message').html('');
                    $('#dayModal').modal('hide');
                    if (selectedDate) {
                        showLoader();
                        $.ajax({
                            url: '{{ route("fetch-data") }}',
                            method: 'GET',
                            data: {
                                filter: 'Day',
                                date: selectedDate,
                                filterValue: filterValue
                            },
                            success: function(response) {
                                hideLoader();
                                if (response.success) {
                                    if (filterValue == 'Inqueries') {
                                        $('#inquiries-report-table tbody').html(response.data);
                                        $('#inquiries-report-table').removeAttr('hidden');
                                    } else {
                                        $('#product-report-table tbody').html(response.data);
                                        $('#product-report-table').removeAttr('hidden');
                                    }
                                    $('.filter').attr('hidden', 'hidden');
                                    $('#pagination-container').html(response.links);
                                    $('#dataFilter').val(filterValue);
                                    $('#dailyFilter').val(dataFilter);
                                    $('#date').val(selectedDate);
                                }
                            },
                            error: function(xhr, status, error) {
                                hideLoader();
                                console.error(error);
                            }
                        });
                    }
                }
            });

            $('#week-filter').click(function() {
                $('#weekModal').modal('show');
            });

            $('#submit-week-modal').click(function() {
                var dataFilter = $('#weekFilter').val();
                var startDate = $('#start-week').val();
                var filterValue = $('#report-filter').val();

                if (!startDate) {
                    $('.start-week-error-message').html('Please enter start week date.');
                    return false;
                } else {
                    $('.start-week-error-message').html('');
                }
                var endDate = $('#end-week').val();
                if (!endDate) {
                    $('.end-week-error-message').html('Please enter end  week date.');
                    return false;
                } else {
                    $('.end-week-error-message').html('');
                }
                $('#weekModal').modal('hide');
                if (startDate && endDate) {
                    showLoader();
                    $.ajax({
                        url: '{{ route("fetch-data") }}',
                        method: 'GET',
                        data: {
                            filter: 'Week',
                            startDate: startDate,
                            endDate: endDate,
                            filterValue: filterValue
                        },
                        success: function(response) {
                            hideLoader();
                            if (response.success) {
                                if (filterValue == 'Inqueries') {
                                    $('#inquiries-report-table tbody').html(response.data);
                                    $('#inquiries-report-table').removeAttr('hidden');
                                } else {
                                    $('#product-report-table tbody').html(response.data);
                                    $('#product-report-table').removeAttr('hidden');
                                }
                                $('.filter').attr('hidden', 'hidden');
                                $('#pagination-container').html(response.links);
                                $('#dataFilter').val(filterValue);
                                $('#dailyFilter').val(dataFilter);
                                $('#startDate').val(startDate);
                                $('#endDate').val(endDate);
                            }
                        },
                    });
                }
            });

            $('#month-filter').click(function() {
                $('#monthModal').modal('show');
            });

            $('#submit-month-modal').click(function() {
                var dataFilter = $('#monthFilter').val();
                var startDate = $('#start-month').val();
                var filterValue = $('#report-filter').val();
                if (!startDate) {
                    $('.start-month-error-message').html('Please enter start month date.');
                    return false;
                } else {
                    $('.start-month-error-message').html('');
                }
                var endDate = $('#end-month').val();
                if (!endDate) {
                    $('.end-month-error-message').html('Please enter end month date.');
                    return false;
                } else {
                    $('.end-month-error-message').html('');
                }
                $('#monthModal').modal('hide');
                if (startDate && endDate) {
                    showLoader();
                    $.ajax({
                        url: '{{ route("fetch-data") }}',
                        method: 'GET',
                        data: {
                            filter: 'Month',
                            startDate: startDate,
                            endDate: endDate,
                            filterValue: filterValue
                        },
                        success: function(response) {
                            hideLoader();
                            if (response.success) {
                                if (filterValue == 'Inqueries') {
                                    $('#inquiries-report-table tbody').html(response.data);
                                    $('#inquiries-report-table').removeAttr('hidden');
                                } else {
                                    $('#product-report-table tbody').html(response.data);
                                    $('#product-report-table').removeAttr('hidden');
                                }
                                $('.filter').attr('hidden', 'hidden');
                                $('#pagination-container').html(response.links);
                                $('#dataFilter').val(filterValue);
                                $('#dailyFilter').val(dataFilter);
                                $('#startDate').val(startDate);
                                $('#endDate').val(endDate);
                            }
                        },
                    });
                }
            });

            function showLoader() {
                $('#loader').removeClass('d-none'); // Show loader
            }

            function hideLoader() {
                $('#loader').addClass('d-none'); // Hide loader
            }

            $('#vehicle-name').on('change', function() {
                var vehicleName = this.value;
                $.ajax({
                    url: "{{ url('get-vehicle-name') }}",
                    type: "POST",
                    data: {
                        vehicleName: vehicleName,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#vehicle_mileage').html(result.options);
                        $('#vehicle_mileage').prop('disabled', false);
                    }
                });
            });

            $('#vehicle_mileage').on('change', function() {
                var vehicleMileage = this.value;
                $.ajax({
                    url: "{{ url('get-vehicle_mileage') }}",
                    type: "POST",
                    data: {
                        vehicleMileage: vehicleMileage,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#dob').html(result.options);
                        $('#dob').prop('disabled', false);
                    }
                });
            });

            $('#dob').on('change', function() {
                var dob = this.value;
                $.ajax({
                    url: "{{ url('get-dob') }}",
                    type: "POST",
                    data: {
                        dob: dob,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#vehicle-license').html(result.options);
                        $('#vehicle-license').prop('disabled', false);
                    }
                });
            });

            $('#submit-vehicle-modal').click(function() {
                var filterValue = $('#report-filter').val();
                var vehicleMileage = $('#vehicle_mileage').val();
                var dob = $('#dob').val();
                var vehicleLicense = $('#vehicle-license').val();
                var vehicleName = $('#vehicle-name').val();

                if (!vehicleName) {
                    $('.vechicle-name-error-message').html('Please select vehicle name.');
                    return false;
                } else {
                    $('.vechicle-name-error-message').html('');
                }
                $('#vehicleModal').modal('hide');
                showLoader();
                $.ajax({
                    url: '{{ route("fetch-data") }}',
                    method: 'GET',
                    data: {
                        filter: 'Vehicle',
                        vehicleName: vehicleName,
                        vehicleMileage: vehicleMileage,
                        dob: dob,
                        vehicleLicense: vehicleLicense,
                        filterValue: filterValue
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.success) {
                            $('#inquiries-report-table tbody').html(response.data);
                            $('#inquiries-report-table').removeAttr('hidden');
                            $('.filter').attr('hidden', 'hidden');
                            $('#pagination-container').html(response.links);
                            $('#dataFilter').val(filterValue);
                            $('#vehicleName').val(vehicleName);
                            $('#vehicleMileage').val(vehicleMileage);
                            $('#dateOfBirth').val(dob);
                            $('#vehicleLicenceNo').val(vehicleLicense);
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoader();
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
