// изменение с фронта цветовой схемы
$(document).on('click', 'a.my-color', function() {
    var color = $(this).data('color');
    var csrf_name = $(this).data('csrf_name');
    var csrf = $(this).data('csrf');
    $.ajax({
        url: 'users/color/' + color,
        type: 'POST',
        data: {color: color,[csrf_name]: csrf },
    }).done(function(result) {
        location.reload(csrf_name);
    });
});

 