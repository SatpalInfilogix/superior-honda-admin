<div class="modal fade" id="add-car-model" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Add Model</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('car-models.store') }}" name="add-car-model" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="add-brand-id">Brand Name</label>
                            <select id="add-brand-id" name="add_brand_id" class="form-control">
                                <option value="" disabled selected>-- Select Brand --</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                                <option value="ss">ss</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="add-model-name">Model Name</label>
                            <input type="text" id="add-model-name" name="add_model_name" class="form-control">
                        </div>
                        <div class="col-12 form-group">
                            <label for="add-model-image">Image</label>
                            <div class="custom-file">
                                <input type="file" name="add_model_image" class="custom-file-input" id="add-model-image">
                                <label class="custom-file-label" for="add-model-image">Choose Image</label>
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
        $('[name="add-car-model"]').validate({
            rules: {
                add_brand_id: "required",
                add_model_name: "required",
                add_model_image: "required"
            },
            messages: {
                add_brand_id: "Please select brand of the model",
                add_model_name: "Please enter model name",
                add_model_image: "Please choose image"
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
