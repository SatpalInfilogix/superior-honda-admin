@extends('layouts.app')

@section('content')
<style>
    #inquiries-report-table, #product-report-table {
        width: 100% !important; /* Ensure tables use full width */
    }
</style>

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
                                    <a href="{{ route('reports-chart') }}" target="_blank">
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
                                                <select name="report-filter" id="report-filter" class="form-control mr-2">
                                                    <option value="" selected disabled>Select Filter</option>
                                                    <option value="Inquiries" data-href="{{ route('export.inquiry')}}">Inquiries</option>
                                                    <option value="Inquiry_Customer" data-href="{{ route('customer.inquiry.export')}}">Customer Inquiry</option>
                                                    <option value="Vehicle">Inquiry By Vehicle</option>
                                                    <option value="Product_Sold_Report" data-href="{{ route('product.sold.export') }}">Product Sold Report</option>
                                                </select>
                                                <input type="hidden" name="dataFilter" value="" id="dataFilter">
                                                <input type="hidden" name="dailyFilter" value="" id="dailyFilter">
                                                <input type="hidden" name="date" value="" id="date">
                                                <input type="hidden" name="startDate" value="" id="startDate">
                                                <input type="hidden" name="endDate" value="" id="endDate">
                                                <input type="hidden" name="vehicleName" value="" id="vehicleName">
                                                <input type="hidden" name="vehicleMileage" value="" id="vehicleMileage">
                                                <input type="hidden" name="dateOfBirth" value="" id="dateOfBirth">
                                                <input type="hidden" name="vehicleLicenceNo" value="" id="vehicleLicenceNo">
                                                <input type="hidden" name="modelValue" value="" id="modelValue">
                                                <button type="button" id="filter-button" class="btn btn-primary primary-btn btn-group-sm">Apply</button>
                                            </div>
                                            <div class="error-message text-danger"></div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 form-group day-week-month-filter" hidden>
                                        <div>
                                            <a href="#" style="color:white;" id="export-url" class="btn btn-primary primary-btn float-right mr-2" data-filter="export-url">Export</a>
                                            <button type="button" id="day-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Day">Day</button>
                                            <button type="button" id="week-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Week">Week</button>
                                            <button type="button" id="month-filter" class="btn btn-primary primary-btn float-right mr-2" data-filter="Month">Month</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter"> Select Any Option</div>
                                <div class="dt-responsive table-responsive" id="table-container" hidden>
                                    <table id="inquiries-report-table" class="table table-striped table-bordered nowrap">
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
                                        <tbody>
                                            <!-- Data will be populated here by DataTables -->
                                        </tbody>
                                    </table>
                                </div>

                                <div class="dt-responsive table-responsive" id="product-table-container" hidden>
                                    <table id="product-report-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Product Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be populated here by DataTables -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="dt-responsive table-responsive" id="customer-table-container" hidden>
                                    <table id="customer-report-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Inquiry Category</th>
                                                <th>Inquiry Status</th>
                                                <th>Inquiry Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be populated here by DataTables -->
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

<!-- Modals -->
@include('reports.partials.modals') <!-- Include modals from a partial view -->
<x-include-plugins dataTable></x-include-plugins>

<script>
   $(document).ready(function() {
    // Initialize Inquiries DataTable
    var inquiriesTable = $('#inquiries-report-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("fetch-data") }}',
            type: 'GET',
            data: function(d) {
                d.filter = $('#report-filter').val();
                d.date = $('#date').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.vehicleName = $('#vehicleName').val();
                d.vehicleMileage = $('#vehicleMileage').val();
                d.dateOfBirth = $('#dateOfBirth').val();
                d.vehicleLicenceNo = $('#vehicleLicenceNo').val();
                d.filterValue = $('#modelValue').val();
            },
            dataSrc: function (json) {
                console.log('Inquiries Table Data:', json); // Debug: Check the data structure
                return json.data; // Ensure this matches the format returned from the server
            }
        },
        columns: [{
            data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        title: '#'
                    },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'email', name: 'email' },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'licence_no', name: 'licence_no' }
        ],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 20, 25, 50, 100],
        responsive: true
    });

    // Initialize Product DataTable
    var productTable = $('#product-report-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("fetch-data") }}',
            type: 'GET',
            data: function(d) {
                d.filter = $('#report-filter').val();
                d.date = $('#date').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.vehicleName = $('#vehicleName').val();
                d.vehicleMileage = $('#vehicleMileage').val();
                d.dateOfBirth = $('#dateOfBirth').val();
                d.vehicleLicenceNo = $('#vehicleLicenceNo').val();
                d.filterValue = $('#modelValue').val();
            },
            dataSrc: function (json) {
                console.log('Product Table Data:', json); // Debug: Check the data structure
                return json.data; // Ensure this matches the format returned from the server
            }
        },
        columns: [
            { data: null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                title: '#'
            },
            { data: 'product_name', name: 'product_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'cost_price', name: 'cost_price' }
        ],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 20, 25, 50, 100],
        responsive: true
    });

    //Apply filter on customer inquiries

    var inqueryCustomerTable = $('#customer-report-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("fetch-data") }}',
            type: 'GET',
            data: function(d) {
                d.filter = $('#report-filter').val();
                d.date = $('#date').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.vehicleName = $('#vehicleName').val();
                d.vehicleMileage = $('#vehicleMileage').val();
                d.dateOfBirth = $('#dateOfBirth').val();
                d.vehicleLicenceNo = $('#vehicleLicenceNo').val();
                d.filterValue = $('#modelValue').val();
            },
            dataSrc: function (json) {
                console.log('Customer Inquiries Table Data:', json); // Debug: Check the data structure
                return json.data; // Ensure this matches the format returned from the server
            }
        },
        columns: [
            {
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                title: '#'
            },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'customer_email', name: 'customer_email' },
            { data: 'customer_inquiry_category', name: 'customer_inquiry_category' },
            { data: 'inquiry_status', name: 'inquiry_status' },
            { data: 'inquiry_created_at', name: 'inquiry_created_at' }
        ],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 20, 25, 50, 100],
        responsive: true
    });

    // Apply filter button click event
    $('#filter-button').on('click', function(event) {
        event.preventDefault();
        var filterValue = $('#report-filter').val();

        if (!filterValue) {
            $('.error-message').html('Please select any option.');
            return false;
        } else {
            $('.error-message').html('');

            if (filterValue === 'Vehicle') {
                $('#vehicleModal').modal('show');
                $('#table-container').removeAttr('hidden');
                $('.day-week-month-filter').attr('hidden', true);
                return false; // Prevent default form submission
            } else if (filterValue === 'Product_Sold_Report') {
                $('#table-container').attr('hidden', true);
                $('#product-table-container').removeAttr('hidden');
                $('.day-week-month-filter').removeAttr('hidden');
                $('#product-report-table').show();
                productTable.ajax.reload();
            } else if (filterValue === 'Inquiry_Customer') { // Fix: Use filterValue instead of filterType
                $('#table-container').attr('hidden', true);
                $('#customer-table-container').removeAttr('hidden', true);
                $('.day-week-month-filter').removeAttr('hidden');
                $('#customer-report-table').show();
                $('#product-report-table').hide();
                inqueryCustomerTable.ajax.reload();
            } else {
                $('#product-table-container').attr('hidden', true);
                $('#table-container').removeAttr('hidden');
                $('#inquiries-report-table').show();
                $('#product-report-table').hide();
                $('.day-week-month-filter').removeAttr('hidden');
                $('.filter').hide();
                inquiriesTable.ajax.reload(); // Trigger DataTable to reload data
            }
        }
    });

    // Add click handlers for filtering by day, week, and month
    $('#month-filter').click(function() {
        $('#monthModal').modal('show');
    });

    $('#submit-month-modal').click(function() {
        var startDate = $('#start-month').val();
        var endDate = $('#end-month').val();
        if (!startDate) {
            $('.start-month-error-message').html('Please enter start month date.');
            return false;
        } else {
            $('.start-month-error-message').html('');
        }
        if (!endDate) {
            $('.end-month-error-message').html('Please enter end month date.');
            return false;
        } else {
            $('.end-month-error-message').html('');
        }

        $('#date').val('');
        $('#startDate').val(startDate);
        $('#endDate').val(endDate);
        $('#modelValue').val('Month');
        var filterType = $('#report-filter').val();
        if (filterType === 'Product_Sold_Report') {
            productTable.ajax.reload(); // Reload product table
        }else if(filterType === 'Inquiry_Customer'){
            inqueryCustomerTable.ajax.reload();
        }else {
            inquiriesTable.ajax.reload(); // Reload inquiries table
        }
        $('#monthModal').modal('hide');
    });

    $('#day-filter').click(function() {
        $('#dayModal').modal('show');
    });

    $('#submit-date-modal').click(function() {
        var date = $('#selected-date').val();
        if (!date) {
            $('.date-error-message').html('Please enter day date.');
            return false;
        } else {
            $('.date-error-message').html('');
        }
        $('#date').val(date);
        $('#startDate').val('');
        $('#endDate').val('');
        $('#modelValue').val('Day');
        var filterType = $('#report-filter').val();
        if (filterType === 'Product_Sold_Report') {
            productTable.ajax.reload(); // Reload product table
        }else if(filterType === 'Inquiry_Customer'){
            inqueryCustomerTable.ajax.reload();
        }else {
            inquiriesTable.ajax.reload(); // Reload inquiries table
        }
        $('#dayModal').modal('hide');
    });

    $('#week-filter').click(function() {
        $('#weekModal').modal('show');
    });

    $('#submit-week-modal').click(function() {
        var startDate = $('#start-week').val();
        var endDate = $('#end-week').val();
        if (!startDate) {
            $('.start-week-error-message').html('Please enter start week date.');
            return false;
        } else {
            $('.start-week-error-message').html('');
        }
        if (!endDate) {
            $('.end-week-error-message').html('Please enter end week date.');
            return false;
        } else {
            $('.end-week-error-message').html('');
        }

        $('#date').val('');
        $('#startDate').val(startDate);
        $('#endDate').val(endDate);
        $('#modelValue').val('Week');

        var filterType = $('#report-filter').val();
        if (filterType === 'Product_Sold_Report') {
            productTable.ajax.reload(); // Reload product table
        } else if(filterType === 'Inquiry_Customer'){
            inqueryCustomerTable.ajax.reload();
        }else {
            inquiriesTable.ajax.reload(); // Reload inquiries table
        }
        $('#weekModal').modal('hide');
    });

    // Handle table visibility based on filter
    $('#report-filter').on('change', function() {
        var filterValue = $(this).val();
        var exportUrl = $('#report-filter option:selected').attr('data-href');
        $('#export-url').attr('href',exportUrl);
        if (filterValue === 'Product_Sold_Report') {
            $('#product-table-container').show();
            $('#table-container').hide();
            $('#customer-report-table').hide(); // Hide customer table
        } else if (filterValue === 'Inquiry_Customer') { // Fix: Use filterValue instead of filterType
            $('#customer-report-table').show();
            $('#product-table-container').hide();
            $('#table-container').hide();
        } else {
            $('#product-table-container').hide();
            $('#customer-report-table').hide();
            $('#table-container').show();
        }
    });

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
        var vehicleName = $('#vehicle-name').val();
        var vehicleMileage = $('#vehicle_mileage').val();
        var dob = $('#dob').val();
        var vehicleLicense = $('#vehicle-license').val();
        var filterValue = $('#report-filter').val();

        if (!vehicleName) {
            $('.vechicle-name-error-message').html('Please select vehicle name.');
            return false;
        } else {
            $('.vechicle-name-error-message').html('');
        }

        $('#date').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#modelValue').val('Vehicle');
        $('#vehicleName').val(vehicleName);
        $('#vehicleMileage').val(vehicleMileage);
        $('#dateOfBirth').val(dob);
        $('#vehicleLicenceNo').val(vehicleLicense);

        if (filterValue === 'Inquiry_Customer') {
            inqueryCustomerTable.ajax.reload();
        } else {
            inquiriesTable.ajax.reload();
        }

        $('#vehicleModal').modal('hide');
    });

});
</script>
@endsection
