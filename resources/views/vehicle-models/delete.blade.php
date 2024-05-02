<script>
    $(function() {
        $('.delete-car-model').click(function() {
            swal({
                title: "Are you sure?",
                text: "You really want to remove this model?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                }
            });
        })
    })
</script>
