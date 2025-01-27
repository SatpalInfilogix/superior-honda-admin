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
                                <input type="hidden" name="valueFilter" value="Day" id="valueFilter">
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
                            <input type="hidden" name="valueFilter" value="Week" id="valueFilter">
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
                            <input type="hidden" name="valueFilter" value="Month" id="valueFilter">
                            <input type="hidden" name="modelValue" value ="Month" id="modelValue">

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