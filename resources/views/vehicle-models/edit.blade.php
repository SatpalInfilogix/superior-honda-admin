<div class="modal fade" id="edit-car-model" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('car-models.store') }}" name="edit-car-model" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="edit-brand-id">Brand Name</label>
                            <select id="edit-brand-id" name="edit_brand_id" class="form-control">
                                <option value="" disabled>-- Select Brand --</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="edit-model-name">Model Name</label>
                            <input type="text" id="edit-model-name" name="edit_model_name" class="form-control">
                        </div>
                        <div class="col-12 form-group">
                            <label for="edit-model-image">Image</label>
                            <div class="custom-file">
                                <input type="file" name="edit_model_image" class="custom-file-input" id="edit-model-image">
                                <label class="custom-file-label" for="edit-brand-logo">Choose Image</label>
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
        $('[name="edit-car-model"]').validate({
            rules: {
                edit_brand_car_type: "required",
                edit_model_name: "required",
                edit_model_image: "required"
            },
            messages: {
                edit_brand_car_type: "Please select car type",
                edit_model_name: "Please enter brand name",
                edit_model_image: "Please choose image"
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
