<div class="modal fade" id="edit-car-type" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Edit Car Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('car-types.store') }}" name="edit-car-type" method="post">
                @method('patch')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="edit-car-type">Car Type</label>
                            <input type="text" id="edit-car-type" name="edit_car_type" class="form-control">
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
        $('[name="edit-car-type"]').validate({
            rules: {
                edit_car_type: "required"
            },
            messages: {
                edit_car_type: "Please enter car type"
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
