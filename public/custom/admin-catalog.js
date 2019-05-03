$('#new-record').click(function() {
  $("#NewRecordModal").modal()
});

$('#save').click(function() {
  store();
})

$('#store').submit(function (event) {
  store();
  event.preventDefault();
})

function store()
{
  $.ajax({
    url: window.location.origin + '/admin/manager/catalogs/',
    method: 'POST',
    data: {
      name: $('#name-new').val()
    },
    success: function (data) {
      console.log(data)
      alertify.success('Thêm thành công!')
      $('tbody').prepend(`
          <tr id="column-` + data.id + `">
            <td>#</td>
            <td id="name-` + data.id + `">` + data.name + `</td>
            <td><a href="#">#</a></td>
            <td>
              <div class="form-group">
                <div class="row">
                  <a class="text-primary fa fa-edit ml-2" id="edit-icon" onclick="showModalEdit(` + data.id + `)" ></a>
                  <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('Bạn có muốn xóa:','Xóa Danh mục?', ` + data.id + `)"></a>
                </div>
              </div>
            </td>
          </tr>
        `);
      $('#name-new').val('')
      $('#NewRecordModal').modal('hide')
    },
    error: function (errors) {
      alertify.error(errors.responseJSON.errors.name[0]);
    }
  })
}



function showModalEdit(id){
  var name = $('#name-' + id).text();
  $('#name-edit').val(name)
  $('#id-edit').val(id)
  $("#exampleModal").modal()
}

$('#save-change').click(function () {
  update();
})

$('#update-form').submit(function (event) {
  update();
  event.preventDefault();
})

function update()
{
  var name = $('#name-edit').val();
  var id = $('#id-edit').val();
  $.ajax({
    url: window.location.origin + '/admin/manager/catalogs/' + id,
    method: 'PUT',
    data: {
      name: name
    },
    success: function (data) {
      $('#name-' + id).text(data.name);
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
        url: window.location.origin + '/admin/manager/catalogs/' + id,
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
