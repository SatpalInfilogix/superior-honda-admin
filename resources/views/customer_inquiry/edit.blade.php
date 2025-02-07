@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
    div#week_status_chosen {
        width: 423px !important;
    }
    .comment-log {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        background: #f9f9f9;
    }
    .comment-item {
        border-bottom: 1px solid #ddd;
        padding: 8px 0;
    }
    .comment-item:last-child {
        border-bottom: none;
    }
</style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-8">
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
                                                <p>{{ !empty($customer_inquiry->customer_email) ? $customer_inquiry->customer_email : '-'; }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="Customer Inquiry Category" style="font-weight: bold">Customer Inquiry Category</label>                                                
                                                <p>{{ ucfirst($customer_inquiry->customer_inquiry_category) }}</p>
                                            </div>
                                            @if($customer_inquiry->customer_inquiry_category == 'promotion')
                                                <div class="col-md-4 form-group">
                                                    <label for="Promotion Heading" style="font-weight: bold">Promotion Heading</label>
                                                    <p>{{ $customer_inquiry->promotion->heading }}</p>  
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="Total Price" style="font-weight: bold">Promotion Total Price</label>
                                                    <p>{{ $customer_inquiry->promotion->total_price }}/-</p>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="Discount" style="font-weight: bold">Promotion Discount</label>
                                                    <p>{{ $customer_inquiry->promotion->discount }}/-</p>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="Final Bucket Cost" style="font-weight: bold">Promotion Bucket Cost</label>
                                                    <p style="color: red;">{{ $customer_inquiry->promotion->final_bucket_cost }}/-</p>
                                                </div>
                                            @endif
                                            <div class="col-md-4 form-group">
                                                <label for="Location" style="font-weight: bold">Location</label>
                                                <p>{{ $customer_inquiry->location->name }}</p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="Product Name" style="font-weight: bold">Product Name</label>
                                                @if($customer_inquiry->customer_inquiry_category == 'product')
                                                    <p>{{ $customer_inquiry->product->product_name }}</p>
                                                @else
                                                    @php
                                                        $products_names = $customer_inquiry->promotion->promotion_products->pluck('product_details')->pluck('product_name');
                                                    @endphp
                                                    @foreach ($products_names as $product_name)
                                                        <li style="font-size:14px; line-height:1.4;">{{ $product_name }}</li>
                                                    @endforeach
                                                @endif
                                            </div>
                                            @if($customer_inquiry->customer_inquiry_category == 'promotion')
                                                <div class="col-md-4 form-group">
                                                    <label for="Service Name" style="font-weight: bold">Service Name</label>
                                                    @php
                                                        $service_names = $customer_inquiry->promotion->promotion_services->pluck('service_details')->pluck('product_name');
                                                    @endphp
                                                    @foreach ($service_names as $service_name)
                                                        <li style="font-size:14px; line-height:1.4;">{{ $service_name }}</li>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="col-md-4 form-group">
                                                <label for="Inquiry Created At" style="font-weight: bold">Inquiry Created At</label>
                                                <p>{{ $customer_inquiry->inquiry_created_at ? date('d-m-Y h:i a', strtotime($customer_inquiry->inquiry_created_at)) : 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 form-group">
                                                <label for="Inquiry Description" style="font-weight: bold">Inquiry Description</label>
                                                <p>{{ $customer_inquiry->inquiry_description }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
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
                                            <div class="col-md-8 form-group">
                                                <label for="CSR Comment" style="font-weight: bold">CSR Comment <span style="color: red;">*</span></label>
                                                <textarea name="inquiry_attended_by_csr_comment" id="inquiry_attended_by_csr_comment" class="form-control" row="3"></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment Log Section -->
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Comment Log</h5>
                                </div>
                                <div class="card-block">
                                    @if(!empty($customer_inquiry->csr_comments) && count($customer_inquiry->csr_comments))
                                        <div class="comment-log">
                                            @foreach($customer_inquiry->csr_comments as $comment)
                                                <div class="comment-item">
                                                    <strong style="font-weight:bold;">{{$comment->csr_details->first_name . ' ' . $comment->csr_details->last_name}}</strong> 
                                                    <br>
                                                    <small style="font-weight:400;">{{ date('d-m-Y h:i a', strtotime($comment->created_at)) }}</small>
                                                    <br>
                                                    <strong style="font-weight:bold;">Status:</strong> @if($comment->inquiry_status == 'pending') <span style="color : blue;">Pending</span> @elseif($comment->inquiry_status == 'in_process') <span style="color : #ff6a00;">In Process</span> @elseif($comment->inquiry_status == 'closed') <span style="color : green;">Closed</span> @else <span style="color : red;">Failed</span> @endif
                                                    <br>
                                                    <strong style="font-weight:bold;">Comment:</strong> {{ $comment->inquiry_attended_by_csr_comment }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No comments found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End of Comment Log Section -->
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
