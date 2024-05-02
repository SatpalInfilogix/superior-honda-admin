<script>
    $(function() {
        $('.delete-car-brand').click(function() {
            swal({
                title: "Are you sure?",
                text: "You really want to remove this brand?",
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
