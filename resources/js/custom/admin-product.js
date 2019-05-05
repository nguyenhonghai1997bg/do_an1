function deleteConfirm(title, text, id) {
  alertify.confirm(title, text,
    function(){
      $.ajax({
        url: window.location.origin + '/admin/manager/products/' + id,
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

$('#sale-add').click(function () {
    $('#sale').slideDown();
    $(this).hide();
  });
  $('#sale-hide').click(function() {
    $('#sale').slideUp();
    $('#sale-add').show();
  });
  CKEDITOR.replace('detail')
  CKEDITOR.replace('sale_description')

$(function() {
  var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
      var filesAmount = input.files.length;
      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();

        reader.onload = function(event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
        }
        reader.readAsDataURL(input.files[i]);
      }
    }
  };
  $('#images-photo-add').on('change', function() {
    $('.images').html('');
    imagesPreview(this, 'div.images');
  });
});

function removeImage(id) {
  alertify.confirm('Delete Image', 'Delete images?',
    function(){
      $.ajax({
        url: window.location.origin + '/admin/manager/images/' + id + '/destroy',
        data: {
          model: 'product'
        },
        method: 'DELETE',
        success: function(data) {
          console.log(data)
          $('#img-' + id).hide();
          alertify.success(data.status);
        }
      })
    }, function(){

    })
}
