function deleteConfirm(title, text, id) {
  alertify.confirm(title, text,
    function(){
      $.ajax({
        url: window.location.origin + '/admin/setting/users/' + id,
        method: 'DELETE',
        success: function (data) {
          $('#column-' + id).hide();
          alertify.success('Xóa thành công!')
        },
        error: function(errors) {
          if (errors.status == 417) {
            alertify.error(errors.responseJSON.errors)
          }
        }
      })
    }
    ,function(){
      alertify.error('Cancel')
    }
  );
}
$('#roles').change(function() {
  var role_id = $(this).val();
  var search = $('#search').val();
  if (search) {
    window.location.href = window.location.origin + '/admin/setting/users?role=' + role_id + '&search=' + search;
  } else {
    window.location.href = window.location.origin + '/admin/setting/users?role=' + role_id;
  }
})

