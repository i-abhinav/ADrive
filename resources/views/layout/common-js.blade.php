<script>
    @if(Session::has('swal_text'))
    swal({
        title: "{!! Session::get('swal_title') !!}",
        text: "{!! Session::get('swal_text') !!}",
        icon: "{!! Session::get('swal_type') !!}",
        button: "OK!",
    });
    @endif
 $('#create-folder-form').ajaxForm(function(resp) {
  if(resp.trim() == 'success') {
    $(this).find('.mySubmitBtn').prop('disabled', true);
    this.find('.ajax-error').show();
    this.find('.status').removeClass('text-danger').addClass('text-success').html('Folder Created successfully');
    // window.location.reload();
    setTimeout(function () { location.reload() }, 1500);
  } else {
    this.find('.ajax-error').show();
    this.find('.status').removeClass('text-success').addClass('text-danger');
  }
});

</script>