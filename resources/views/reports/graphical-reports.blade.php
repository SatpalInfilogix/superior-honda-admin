@extends('layouts.app')

@section('content')
<script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>


<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Report Charts</h5>
                                <div class="float-right">
                                    <!-- Add any additional header content if needed -->
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="container">
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <div class="container">
                                                <h6>Pending Inquiries</h6>
                                                <canvas id="pendingChart"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="container">
                                                <h6>Completed Inquiries</h6>
                                                <canvas id="completedChart"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="container">
                                                <h6>In Progress Inquiries</h6>
                                                <canvas id="inProgressChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
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
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: '{{ route('chart-data') }}',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);

                // Extract month names for labels
                var labels = data.map(function (item) {
                    return item.month_name;
                });

                // Extract total counts for data values
                var values = data.map(function (item) {
                    return item.total_count;
                });

                // Initialize Chart.js
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar', // Changed to 'bar' since 'horizontalBar' is deprecated
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Inquiries',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true // Updated for Chart.js v3+ syntax
                            },
                            y: {
                                beginAtZero: true // Ensure y-axis starts at zero
                            }
                        }
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching chart data:", status, error);
            }
        });
        $.ajax({
                url: '{{ route('inquiries.by-status') }}',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    function createChart(ctx, labels, values, chartLabel) {
                        return new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: chartLabel,
                                    data: values,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        beginAtZero: true
                                    },
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    function processData(inquiries) {
                        var labels = inquiries.map(function (item) {
                            return new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                        });

                        var counts = inquiries.reduce(function (acc, item) {
                            var key = new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                            acc[key] = (acc[key] || 0) + 1;
                            return acc;
                        }, {});

                        var values = Object.keys(counts).map(function (key) {
                            return counts[key];
                        });

                        return { labels: Object.keys(counts), values: values };
                    }

                    // Process data for each status
                    var pendingData = processData(data.pending);
                    var completedData = processData(data.completed);
                    var inProgressData = processData(data.inProgress);

                    // Create charts for each status
                    createChart(document.getElementById('pendingChart').getContext('2d'), pendingData.labels, pendingData.values, 'Pending Inquiries');
                    createChart(document.getElementById('completedChart').getContext('2d'), completedData.labels, completedData.values, 'Completed Inquiries');
                    createChart(document.getElementById('inProgressChart').getContext('2d'), inProgressData.labels, inProgressData.values, 'In Progress Inquiries');
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching inquiries:", status, error);
                }
            });
    });
</script>
@endsection
