jQuery(function($) {

    // Show the login dialog box on click
    $('#show_login, a.show_login').on('click', function(e){
        $('body').prepend('<div class="login_overlay"></div>');
        $('form#login').fadeIn(500);
		$('body,html').toggleClass('noScroll');
        $('div.login_overlay, form#login span.close').on('click', function(){
			$('body,html').toggleClass('noScroll');
            $('div.login_overlay').remove();
            $('form#login').hide();
        });
        e.preventDefault();
    });

    // Perform AJAX login on form submit
    $('.login_form').on('submit', function(e){
        $('form.login_form p.status').show().text(ajax_login_object.loadingmessage).css('color', '');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('.login_form #username').val(), 
                'password': $('.login_form #password').val(), 
                'security': $('.login_form #security').val(),
				'_wp_http_referer': $(".login_form input[name=_wp_http_referer]").val() },
            success: function(data){
                $('.login_form p.status').html(data.message);
                if (data.loggedin == true){
					var redirect = '';
					
					if (data.redirect) {
						redirect = data.redirect;
					} else {
						redirect = ajax_login_object.redirecturl;
					}
					
                    document.location.href = redirect;
                } else {
					$('.login_form p.status').css('color', 'red');
                    $('.login_form p.status a').css({"color": "red",
                                                    "text-decoration": "underline"});
				}
            }
        });
        e.preventDefault();
    });
});