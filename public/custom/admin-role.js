$('#new-record').click(function() {
  $("#NewRecordModal").modal()
});

$('#save').click(function() {
  storeRole();
})

$('#storeRole').submit(function (event) {
  storeRole();
  event.preventDefault();
})

function storeRole()
{
  $.ajax({
    url: window.location.origin + '/admin/setting/roles/',
    method: 'POST',
    data: {
      name: $('#name-role-new').val()
    },
    success: function (data) {
      alertify.success('Thêm thành công!')
      $('tbody').prepend(`
          <tr id="column-` + data.id + `">
            <td>#</td>
            <td id="role-name-` + data.id + `">` + data.name + `</td>
            <td><a href="#">#</href></td>
            <td>
              <div class="form-group">
                <div class="row">
                  <a class="text-primary fa fa-edit ml-2" id="edit-icon" onclick="showModalEdit(` + data.id + `)" ></a>
                  <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('Bạn có muốn xóa:','Xóa quyền?', ` + data.id + `)"></a>
                </div>
              </div>
            </td>
          </tr>
        `);
      $('#name-role-new').val('')
      $('#NewRecordModal').modal('hide')
    },
    error: function (errors) {
      alertify.error(errors.responseJSON.errors.name[0]);
    }
  })
}



function showModalEdit(id){
  var name = $('#role-name-' + id).text();
  $('#name-role-edit').val(name)
  $('#id-role-edit').val(id)
  $("#exampleModal").modal()
}

$('#save-change').click(function () {
  updateRole();
})

$('#updateRole').submit(function (event) {
  updateRole();
  event.preventDefault();
})

function updateRole()
{
  var name = $('#name-role-edit').val();
  var id = $('#id-role-edit').val();
  $.ajax({
    url: window.location.origin + '/admin/setting/roles/' + id,
    method: 'PUT',
    data: {
      name: name
    },
    success: function (data) {
      $('#role-name-' + id).text(data.name);
      alertify.success('Sửa thành công!')
      $('#exampleModal').modal('hide')
    },
    error: function(errors) {
      if(errors.status == 422) {
        alertify.error(errors.responseJSON.errors.name[0]);
      }
    }
  })
}

function deleteConfirm(title, text, id) {
  alertify.confirm(title, text,
    function(){
      $.ajax({
        url: window.location.origin + '/admin/setting/roles/' + id,
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
