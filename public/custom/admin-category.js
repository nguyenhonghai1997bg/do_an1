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
    url: window.location.origin + '/admin/manager/categories/',
    method: 'POST',
    data: {
      name: $('#name-new').val(),
      catalog_id: $('#catalog_id').val()
    },
    success: function (data) {
      console.log(data)
      alertify.success('Thêm thành công!')
      $('tbody').prepend(`
          <tr id="column-` + data.id + `">
            <td>#</td>
            <td id="name-` + data.id + `">` + data.name + `</td>
            <td id="catalog-` + data.id + `">` + data.catalog.name + `</td>
            <td><a href="#">#</a></td>
            <input type="hidden" id="current-catalog-` + data.id + `" value="` + data.catalog.id + `">
            <td>
              <div class="form-group">
                <div class="row">
                  <a class="text-primary fa fa-edit ml-2" id="edit-icon" onclick="showModalEdit(` + data.id + `)" ></a>
                  <a href="#" class="fa fa-trash ml-2" onclick="deleteConfirm('Bạn có muốn xóa:','Xóa loại sản phẩm?', ` + data.id + `)"></a>
                </div>
              </div>
            </td>
          </tr>
        `);
      $('#name-new').val('')
      $('#catalog_id').prop('selectedIndex', 0)
      $('#NewRecordModal').modal('hide')
    },
    error: function (errors) {
      if(typeof(errors.responseJSON.errors.name) != 'undefined') {
        alertify.error(errors.responseJSON.errors.name[0]);
      } else if (typeof(errors.responseJSON.errors.catalog_id[0]) != 'undefined') {
        alertify.error(errors.responseJSON.errors.catalog_id[0]);
      }
    }
  })
}



function showModalEdit(id){
  var name = $('#name-' + id).text();
  $('#name-edit').val(name);
  $('#id-edit').val(id);
  $('#catalog_id_update').val($('#current-catalog-' + id).val());
  $("#exampleModal").modal();
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
  var catalog_id_update = $('#catalog_id_update').val()
  $.ajax({
    url: window.location.origin + '/admin/manager/categories/' + id,
    method: 'PUT',
    data: {
      name: name,
      catalog_id: catalog_id_update
    },
    success: function (data) {
      $('#name-' + id).text(data.name);
      $('#catalog-' + data.id).text(data.catalog.name);
      $('#current-catalog-' + data.id).val(data.catalog.id)
      alertify.success('Sửa thành công!');
      $('#exampleModal').modal('hide');
    },
    error: function(errors) {
      if(errors.status == 422) {
        if(typeof(errors.responseJSON.errors.name) != 'undefined') {
        alertify.error(errors.responseJSON.errors.name[0]);
      } else if (typeof(errors.responseJSON.errors.catalog_id[0]) != 'undefined') {
        alertify.error(errors.responseJSON.errors.catalog_id[0]);
      }
      }
    }
  })
}

function deleteConfirm(title, text, id) {
  alertify.confirm(title, text,
    function(){
      $.ajax({
        url: window.location.origin + '/admin/manager/categories/' + id,
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

$('#catalogs').change(function() {
  var catalog_id = $(this).val();
  var search = $('#search').val();
  if (search) {
    window.location.href = window.location.origin + '/admin/manager/categories?catalog=' + catalog_id + '&search=' + search;
  } else {
    window.location.href = window.location.origin + '/admin/manager/categories?catalog=' + catalog_id;
  }
})
