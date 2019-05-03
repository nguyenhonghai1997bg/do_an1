$('#review-form').submit(function(event) {
  var product_id = $('#product_id').val();
  var content = $('textarea').val();
  var rating = $( "input[name*='rating']:checked" ).val();
  $.ajax({
    url: window.location.origin + '/reviews/',
    method: 'POST',
    data: {
      product_id: product_id,
      content: content,
      rating: rating,
    },
    success: function (data) {
      if (data.error) {
        alertify.error(data.error);
        return;
      }
      var old_count = parseInt($('#count-review').text());
      var new_count = old_count + 1;
      $('#count-review').text(new_count)
      var r = '';
      for (var i = 1; i <= data.rating; i++) {
        r += `<i class="fa fa-star"></i>`;
      }
      var html = `
        <div class="single-review" id="review-${data.id}">
          <div class="review-heading">
          <div><a href="#"><i class="fa fa-user-o"></i> ` + data.user.name + `</a></div>
          <div><a href="#"><i class="fa fa-clock-o"></i>` + data.created_at + `</a></div>

          <a href="#" class="mt-2 ml-5" onclick="showModalEditReview(` + data.id + `, `+ data.product_id +`, '`+ data.content +`', `+ data.rating +`)">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </a>
          <a href="#" class="mt-2 ml-5" onclick="deleteReview('Xóa đánh giá','Xác nhận?', `+ data.id +`)">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </a>




          <div class="review-rating pull-right" id="rating-${data.id}">
          ` + r + `
          </div>
        </div>
        <div class="review-body">
          <p id="content-${data.id}">` + data.content +`</p>
        </div>
        </div>
      `;
      $('#content-review').prepend(html)
      $('textarea').val('');
      $( "input[name*='rating']:checked" ).prop('checked', false);
    },

    error: function(errors) {
      if(errors.status == 422) {
        if (errors.responseJSON.errors.content) {
          alertify.error(errors.responseJSON.errors.content[0]);
        }
        if (errors.responseJSON.errors.rating) {
          alertify.error(errors.responseJSON.errors.rating[0]);
        }
        if (errors.responseJSON.errors.product_id) {
          alertify.error(errors.responseJSON.errors.product_id[0]);
        }
      }
    }
  })
  event.preventDefault();
})

function showModalEditReview(id, product_id, content, rating) {
  $('#review-edit-content').val(content);
  $('#review_id').val(id)
  $("input[name*='rating_update']" ).val([rating])
  $("#edit-review").modal()
}


$('#save-update').click(function() {
  var review_id = $('#review_id').val();
  var product_id = $('#product_id').val();
  var content = $('#review-edit-content').val();
  var rating = $( "input[name*='rating_update']:checked" ).val();
  $.ajax({
    url: window.location.origin + '/reviews/' + review_id,
    method: 'PUT',
    data: {
      rating: rating,
      content: content,
      product_id: product_id,
      id: review_id
    },
    success: function(data) {
      var currentRating = '';
      for (var i = 1; i <= rating; i++) {
        currentRating += `<i class="fa fa-star"></i>`;
      }
      $(`#review-${review_id} #rating-${review_id}`).html(currentRating)
      $(`#review-${review_id} #content-${review_id}`).html(content)
      $('#edit-review').modal('hide')
      alertify.success(data.status);
    },

    error: function(errors) {
      if(errors.status == 422) {
        if (errors.responseJSON.errors.content) {
          alertify.error(errors.responseJSON.errors.content[0]);
        }
        if (errors.responseJSON.errors.rating) {
          alertify.error(errors.responseJSON.errors.rating[0]);
        }
        if (errors.responseJSON.errors.product_id) {
          alertify.error(errors.responseJSON.errors.product_id[0]);
        }
      }

      if (errors.status == 403) {
        alertify.error(errors.responseJSON.message);
      }

      if (errors.status == 404) {
        console.log(errors)
        alertify.error(errors.responseJSON.message);
      }
    }
  })
});

function deleteReview(title, text, id) {

  alertify.confirm(title, text,
    function(){
      $.ajax({
        url: window.location.origin + '/reviews/' + id,
        method: 'DELETE',
        success: function (data) {
          var old_count = parseInt($('#count-review').text());
          var new_count = old_count - 1;
          $('#count-review').text(new_count)
          $('#review-' + id).hide();
          alertify.success(data.status);
        },
        error: function(errors) {
          if (errors.status == 403) {
            alertify.error(errors.responseJSON.message);
          }
        }
      })
    },
    function(){
      alertify.error('Cancel')
    })

}
