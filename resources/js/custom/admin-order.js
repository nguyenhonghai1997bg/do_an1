function done(id) {
    $.ajax({
        url: window.location.origin + '/admin/manager/orders/do/done',
        method: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            $('#column-' + id).hide();
            alertify.success(data.status);
        },
        error: function(error) {
            console.log(error)
        }
    })
}

function waiting(id) {
    $.ajax({
        url: window.location.origin + '/admin/manager/orders/do/waiting',
        method: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            $('#column-' + id).hide();
            alertify.success(data.status);
        },
        error: function(error) {
            console.log(error)
        }
    })
}

function process(id) {
    $.ajax({
        url: window.location.origin + '/admin/manager/orders/do/process',
        method: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            $('#column-' + id).hide();
            alertify.success(data.status);
        },
        error: function(error) {
            console.log(error)
        }
    })
}
