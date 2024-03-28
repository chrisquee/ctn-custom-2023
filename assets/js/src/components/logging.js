$( document ).ready( function() {
    if ($('.single-post').length ) {
        setTimeout(function() {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_login_object.ajaxurl,
                data: { 
                    'action': 'logPageView',
                    'post_id': ajax_login_object.post_id,
                },
                success: function(data){
                    console.log('PAGEEVIEW');
                }
            });
        }, 2000);
    }

});