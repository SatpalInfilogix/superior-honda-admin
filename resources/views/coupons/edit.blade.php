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
                                    <h5>Edit Coupon</h5>
                                    <div class="float-right">
                                        <a href="{{ route('coupons.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                            <x-input-text name="coupon_code" label="Coupon Code" value="{{ old('coupon_code', $coupon->coupon_code) }}"></x-input-text>
                                        </div>
                                        <div class="form-group">
                                            <label for="discount_type">Discount Type</label>
                                            <select name="discount_type" id="discount_type" class="form-control">
                                                <option value="Percentage" @selected($coupon->discount_type == 'Percentage')>Percentage </option>
                                                <option value="Fixed"  @selected($coupon->discount_type == 'Fixed')>Fixed</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <x-input-text name="discount_amount" label="Discount Amount" value="{{ old('discount_amount', $coupon->discount_amount) }}"></x-input-text>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="discount_type">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="discount_type">End Date</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date) }}">
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
        })
    </script>
@endsection
