<div class="modal fade" id="add-vehicle-type" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Add Vehicle Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('vehicle-types.store') }}" name="add-vehicle-type" method="post">
                @csrf
                <div class="modal-body">
                    
                    <div class="error"></div>

                    <div class="row">
                        <div class="col-12">
                            <label for="add-vehicle-type">Vehicle Type</label>
                            <input type="text" id="add-vehicle-type" name="add_vehicle_type" class="form-control">
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
        $('[name="add-vehicle-type"]').validate({
            rules: {
                add_vehicle_type: "required"
            },
            messages: {
                add_vehicle_type: "Please enter vehicle type"
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
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.success == true){
                            $('div#add-vehicle-type').addClass('d-none');
                            swal({
                                title: "Success!",
                                text: "Vehicle type created successfully!",
                                icon: "success",
                                buttons: false,
                                timer: 2000
                            });
                            
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            $('.error').text(response.message);
                            $('.error').addClass('text-danger');
                        }
                    }
                });
            }
        });
    })
</script>
