function deleteCart(product_id, rowId, confirm, title) {
  alertify.confirm(confirm, title,
    function(){
      $.ajax({
        url: window.location.origin + '/carts/' + rowId + '/destroy',
        method: 'DELETE',
        success: function(data) {
          $('#subtotal').text(data.subtotal)
          $('#cart-' + rowId).hide();
          if (parseInt($('#qty').text()) > 0) {
            var q = parseInt($('#qty').text()) - 1;
            $('#qty').text(q)
          }
          $('#row-' + rowId).hide();
          $('#total').text(data.subtotal)
          alertify.success(data.status);
        },
        error: function(error) {
          console.log(error)
        }
      })
  },
    function(){
      
    }
  )
}

function updateCart(rowId) {
  var qty = $('#qty-' + rowId).val();
  if (qty > 8) {
    alertify.error('Bạn chỉ được mua nhiều nhất 8 sản phẩm!');
    $('#qty-' + rowId).val(8)
    return;
  } else if (qty <= 0) {
    $('#qty-' + rowId).val(1)
    alertify.error('Số sản phẩm phải lớn hơn 0');
    return;
  }
  $.ajax({
    url: window.location.origin + '/carts/update',
    method: 'PATCH',
    data: {
      qty: qty,
      rowId: rowId
    },
    success: function(data) {
      $('#total').text(data.subtotal);
      $('#price-row-' + rowId).text(data.cart_total);
      $('#subtotal').text(data.subtotal);
      $(`#item-${rowId}-qty`).text(qty);
      alertify.success(data.status);
    },
    error: function(errors) {
      console.log(errors)
    }
  })
}