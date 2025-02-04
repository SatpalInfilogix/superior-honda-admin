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
                                    <h5>Add Coupon</h5>
                                    <div class="float-right">
                                        <a href="{{ route('coupons.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('coupons.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="coupon_code" label="Coupon Code" value="{{ old('coupon_code') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="coupon_image" class>Coupon Image</label>
                                                <input type="file" name="coupon_image" id="coupon_image" class="form-control" accept="image/*" required>
                                                <img src="" id="previewCouponImage" height="100" width="100" name="icon" hidden>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="discount_type">Discount Type</label>
                                                <select name="discount_type" id="discount_type" class="form-control">
                                                    <option value="Percentage ">Percentage </option>
                                                    <option value="Fixed">Fixed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="discount_amount" label="Discount Amount" value="{{ old('discount_amount') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="discount_type">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="discount_type">End Date</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            function updateEndDateMin() {
                const startDate = new Date(startDateInput.value);
                if (!isNaN(startDate.getTime())) {
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(startDate.getDate() + 1);
                    endDateInput.setAttribute('min', minEndDate.toISOString().split('T')[0]);
                } else {
                    endDateInput.removeAttribute('min');
                }
            }

            startDateInput.addEventListener('change', updateEndDateMin);

            endDateInput.addEventListener('change', function() {
                const endDate = new Date(endDateInput.value);
                const minEndDate = new Date(startDateInput.value);
                minEndDate.setDate(minEndDate.getDate() + 1);
                if (endDate < minEndDate) {
                    alert('End date must be after start date.');
                    endDateInput.value = '';
                }
            });

            updateEndDateMin();
        });

        $(function() {
            $('form').validate({
                rules: {
                    coupon_code: "required",
                    discount_type: "required",
                    discount_amount: "required"
                },
                messages: {
                    coupon_code: "Please enter coupon code",
                    discount_type: "Please enter discount type",
                    discount_amount: "Please choose discount amount"
                },
                errorClass: "text-danger f-12",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        $(document).ready(function(){
            $('#coupon_image').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewCouponImage').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewCouponImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        })
    </script>
@endsection
