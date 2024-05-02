<div class="modal fade" id="add-vehicle-brand" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Add Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('vehicle-brands.store') }}" name="add-vehicle-brand" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="add-brand-name">Brand Name</label>
                            <input type="text" id="add-brand-name" name="add_brand_name" class="form-control">
                        </div>
                        <div class="col-12 form-group">
                            <label for="add-brand-logo">Brand Logo</label>
                            <div class="custom-file">
                                <input type="file" name="add_brand_logo" class="custom-file-input" id="add-brand-logo">
                                <label class="custom-file-label" for="add-brand-logo">Choose Brand Logo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('[name="add-vehicle-brand"]').validate({
            rules: {
                add_brand_name: "required",
                add_brand_logo: "required"
            },
            messages: {
                add_brand_name: "Please enter brand name",
                add_brand_logo: "Please choose brand logo"
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
                console.log(form)
            }
        });
    })
</script>
