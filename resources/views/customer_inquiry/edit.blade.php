@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
    div#week_status_chosen {
        width: 423px !important;
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
                                    <h5>Edit Customer Inquiry</h5>
                                    <div class="float-right">
                                        <a href="{{ route('customer-inquiry.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('customer-inquiry.update', $customer_inquiry->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="Customer Name" style="font-weight: bold">Customer Name</label>
                                                <p>{{$customer_inquiry->customer_name}}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Customer Phone" style="font-weight: bold">Customer Phone</label>
                                                <p>{{ $customer_inquiry->customer_phone }}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Customer Email" style="font-weight: bold">Customer Email</label>
                                                <p>{{ $customer_inquiry->customer_email }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="Inquiry Category" style="font-weight: bold">Inquiry Category</label>
                                                <p>{{ ucfirst($customer_inquiry->inquiry_category) }}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Product Name" style="font-weight: bold">Product Name</label>
                                                <p>{{ $customer_inquiry->product->product_name }}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Location" style="font-weight: bold">Location</label>
                                                <p>{{ $customer_inquiry->location->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="Inquiry Created At" style="font-weight: bold">Inquiry Created At</label>
                                                <p>{{ $customer_inquiry->inquiry_created_at ? date('d-m-Y h:i a', strtotime($customer_inquiry->inquiry_created_at)) : 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <label for="Inquiry Description" style="font-weight: bold">Inquiry Description</label>
                                                <p>{{ $customer_inquiry->inquiry_description }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="CSR Name" style="font-weight: bold">CSR Name</label>
                                                <p>{{ !empty($customer_inquiry->inquiry_attended_by_csr_id) ? $customer_inquiry->csr->first_name . ' ' . $customer_inquiry->csr->last_name : 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Inquiry Status" style="font-weight: bold">Inquiry Status</label>
                                                <select name="inquiry_status" id="inquiry_status" class="form-control">
                                                    <option value="" disabled>Select Status</option>
                                                    <option value="pending" {{$customer_inquiry->inquiry_status == 'pending' ? 'selected' : ''}}>Pending</option>
                                                    <option value="in_process" {{$customer_inquiry->inquiry_status == 'in_process' ? 'selected' : ''}}>In Process</option>
                                                    <option value="closed" {{$customer_inquiry->inquiry_status == 'closed' ? 'selected' : ''}}>Closed</option>
                                                    <option value="failed" {{$customer_inquiry->inquiry_status == 'failed' ? 'selected' : ''}}>Failed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="CSR Comment" style="font-weight: bold">CSR Comment</label>
                                                <textarea name="inquiry_attended_by_csr_comment" id="inquiry_attended_by_csr_comment" class="form-control" row="1">
                                                    {{!empty($customer_inquiry->inquiry_attended_by_csr_comment) ? $customer_inquiry->inquiry_attended_by_csr_comment : '' }}
                                                </textarea>
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
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })
        $(function() {
            $('form').validate({
                rules: {
                    inquiry_status: "required",
                    inquiry_attended_by_csr_comment: "required",
                },
                messages: {
                    inquiry_status: "Please select a status.",
                    inquiry_attended_by_csr_comment: "Please enter a comment.",
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
