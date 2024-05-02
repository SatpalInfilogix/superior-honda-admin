<div class="modal fade" id="edit-car-brand" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('car-types.store') }}" name="edit-car-brand" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="edit-brand-name">Car Type</label>
                            <select id="edit-brand-car-type" name="edit_brand_car_type" class="form-control">
                                <option value="">-- Select Car Type --</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="edit-brand-name">Brand Name</label>
                            <input type="text" id="edit-brand-name" name="edit_brand_name" class="form-control">
                        </div>
                        <div class="col-12 form-group">
                            <label for="edit-brand-logo">Brand Logo</label>
                            <div class="custom-file">
                                <input type="file" name="edit_brand_logo" class="custom-file-input" id="edit-brand-logo">
                                <label class="custom-file-label" for="edit-brand-logo">Choose Brand Logo</label>
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
        $('[name="edit-car-brand"]').validate({
            rules: {
                edit_brand_car_type: "required",
                edit_brand_name: "required",
                edit_brand_logo: "required"
            },
            messages: {
                edit_brand_car_type: "Please select car type",
                edit_brand_name: "Please enter brand name",
                edit_brand_logo: "Please choose brand logo"
            },
            errorClass: "text-danger f-12",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).editClass("form-control-danger");
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
