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
$(document).ready(function() {
  var destinations = $('#ddress-order').val();
  address(destinations);
});
$('#address-order').change(function(){
  var destinations = $(this).val();
  address(destinations);
})

function address(destinations) {
  var request = 'https://maps.googleapis.com/maps/api/distancematrix/json?&origins=dai-hoc-tai-nguyen-va-moi-truong-ha-noi&destinations=' + destinations + '&key=AIzaSyC08YIQaMRFrkprEUy7rkd4dM6-4HJTzZ0';
  $.ajax({
    url: 'https://cors-anywhere.herokuapp.com/' + request,
    cache: false,
    method: 'GET',
    success: function (data) {
      var tien = 0;
      if (data.rows[0].elements[0].status != "OK") {
        $('#err-address').text('Địa điểm không xác định');
        $('#ship').val(-1)
        $('#km').text('')
        $('#money-ship').text('0')
        return;
      }
      $('#err-address').text('');
      var m = data.rows[0].elements[0].distance.value;
      if (m < 1000) {
          tien = 0;
      } else if( m >= 1000 && m <= 5000) {
          tien = (m/1000) * 5000;
      } else if(m > 5000 && m <= 10000) {
          tien = 25000 + (((m - 5000)/1000) * 10000);
      } else if (m > 10000) {
          tien = 25000 + 50000 + (((m - 10000)/1000) * 15000);
      }
      console.log('tien= ' + tien)
      $('#ship').val(tien)
      $('#km').text(data.rows[0].elements[0].distance.text)
      $('#money-ship').text(tien)
    },
    error: function(error) {
      console.log(error)
    }
  })
}

$('#paymethod_id').change(function() {
  if ($(this).val() == 2) {
    $('#bank_code').show();
  } else {
    $('#bank_code').hide();
  }
})

  