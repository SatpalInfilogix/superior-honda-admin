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
                                    <h5>Edit Faq</h5>
                                    <div class="float-right">
                                        <a href="{{ route('faqs.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('faqs.update', $faq->id) }}"  method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Question</label>
                                                <input type="text" name="question" value="{{ old('question', $faq->question) }}" class="form-control" placeholder="Enter Question">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="type">Answer</label>
                                                <input type="text" name="answer" value="{{ old('answer', $faq->answer) }}" class="form-control" placeholder="Enter Answer">
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
                    name: "required",
                    designation: "required",
                    heading: "required",
                    feedback: "required",
                },

                messages: {
                    name: "Please enter name",
                    designation: "Please enter designation",
                    heading: "Please enter heading",
                    feedback: "Please enter feedback",
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
