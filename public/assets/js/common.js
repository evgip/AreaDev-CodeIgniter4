// изменение с фронта цветовой схемы
$(document).on('click', 'a.my-color', function() {
    var color = $(this).data('color');
    var csrf_name = $(this).data('csrf_name');
    var csrf = $(this).data('csrf');
    $.ajax({
        url: '/users/color/' + color,
        type: 'POST',
        data: {color: color,[csrf_name]: csrf },
    }).done(function(result) {
        location.reload(csrf_name);
    });
});


// https://makitweb.com/how-to-send-ajax-request-with-csrf-token-in-codeigniter-4/
//  https://forum.codeigniter.com/thread-78411.html?highlight=Update+CSRF
$(function(){
    $(document).on("click", ".addcomm", function(){
        var csrf_name = $(this).data('csrf_name');
        var csrf = $(this).data('csrf');
        var comm_id = $(this).data('id'); 
        var post_id = $(this).data('post_id');        
       
            $('.cm_addentry').remove();
            $('.cm_add_link').show();
            $link_span  = $('#cm_add_link'+comm_id);
            old_html    = $link_span.html();
           
            $.post('/comments/addform/'+comm_id, {comm_id: comm_id, post_id: post_id, [csrf_name]: csrf}, function(data) {
                
                if(data){
                    //$('.addcomm').val(data.token);
                    
                    $("#cm_addentry"+comm_id).html(data).fadeIn();
                    $('#content').focus();
                    $link_span.html(old_html).hide();
                    $('#submit_cmm').click(function() {
                        $('#submit_cmm').prop('disabled', true);
                        $('#cancel_cmm').hide();
                        $('.submit_cmm').append('...');
                      /*  var options = {
                            success: showResponseAdd,
                            dataType: 'json'
                        };
                        
                      
                         $('#msgform').ajaxSubmit(options); */
                    });
                }
            });
    });
    $(document).on("click", "#cancel_cmm", function(){
        $('.cm_addentry').remove();
        $('.cm_add_link').show();
    });
});
/*
$(document).on("click", ".reply", function(e){
    var csrf_name = $(this).data('csrf_name');
    var csrf = $(this).data('csrf');
    var comm_id = $(this).data('id');
    var post_id = $(this).data('pid');    

    $('.cm_addentry').remove();
    $('.cm_add_link').show();
    $link_span  = $('#cm_add_link'+post_id);
    old_html    = $link_span.html();

     $.post({
        url: '/comments/addform/' + comm_id,
        type: 'POST',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {comm_id: comm_id,[csrf_name]: csrf},
    }).done(function (data) { 
        
            $("#cm_addentry"+comm_id).html(data).fadeIn();
            $('#content').focus();
            $link_span.html(old_html).hide();        
             
             
        $("#commentform"+comm_id).html(data);
        $("#commentform"+comm_id).removeAttr('disabled');
        
        // var welcome = document.getElementById('commentform');
        // ....
    });  
    
}); */