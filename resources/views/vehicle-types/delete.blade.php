<script>
    $(function() {
        $('.delete-vehicle-type').click(function() {
            var id = $(this).data('id');
            var href="{{ route('vehicle-types.destroy', '') }}/" +id;
            var name = $(this).data('name');
            swal({
                title: "Are you sure?",
                text: "You really want to remove this " + name +"?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: href,
                        type:'DELETE',
                        datatype:'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }, success:function(data)
                        {
                            if(data.success){
                                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                        }
                    })
                }
            });
        })
    })
</script>
