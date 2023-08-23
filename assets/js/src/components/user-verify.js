jQuery(function($) {
    
    jQuery('#user-code-submit').on('click', 
        function (event) {
            event.preventDefault();
            var acceptButtonWidth = jQuery( this ).width()
            if ( jQuery( this ).hasClass( "update-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "updated" )  ) {

                company_id = jQuery(this).attr("data-companyid");
                nonce = jQuery(this).attr("data-nonce");
                var adminURL = ajax_login_object.ajaxurl;
                var updateButton = jQuery( this );

                updateButton.html('<i class="fa fa-refresh fa-spin"></i>').width(acceptButtonWidth);


                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "business_verify", company_id : company_id, security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            updateButton.text('Sent').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                        } else {
                             alert("An error occurred")
                            updateButton.text('Send verification code').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                        }
                    }
                }) 
            } else {
                jQuery(this).text('Confirm').addClass('update-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );
    
    jQuery('#user-code-submit').on('click', 
        function (event) {
            event.preventDefault();
            var acceptButtonWidth = jQuery( this ).width()
            if ( jQuery( this ).hasClass( "update-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "updated" )  ) {

                nonce = jQuery(this).attr("data-nonce");
                var adminURL = ajax_login_object.ajaxurl;
                var updateButton = jQuery( this );

                updateButton.html('<i class="fa fa-refresh fa-spin"></i>').width(acceptButtonWidth);


                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "account_verify", security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            updateButton.text('Sent').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                        } else {
                             alert("An error occurred")
                            updateButton.text('Send verification code').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                        }
                    }
                }) 
            } else {
                jQuery(this).text('Confirm').addClass('update-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );
    
    jQuery('#verify-submit').on('click', 
        function (event) {
            event.preventDefault();
            var acceptButtonWidth = jQuery( this ).width()
            if ( jQuery( this ).hasClass( "update-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "updated" )  ) {

                company_id = $('#company_id').val();
                nonce = jQuery(this).attr("data-nonce");
                verification_code = $('#business_code').val();
                var adminURL = ajax_login_object.ajaxurl;
                var updateButton = jQuery( this );

                updateButton.html('<i class="fa fa-refresh fa-spin"></i>').width(acceptButtonWidth);


                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "business_confirm", company_id : company_id, verification_code: verification_code, security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            updateButton.text('Verify').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                            $('#claim-message').addClass(response.status).text(response.message);
                        } else {
                            updateButton.text('Verify').width('auto').addClass('updated').removeClass('clicked').removeClass('update-confirm');
                            $('#claim-message').addClass(response.status).text(response.message);
                        }
                    }
                }) 
            } else {
                jQuery(this).text('Confirm').addClass('update-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );
    
    jQuery('#user-verify-submit').on('click', 
        function (event) {
            event.preventDefault();
            var acceptButtonWidth = jQuery( this ).width()
            if ( jQuery( this ).hasClass( "update-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "updated" )  ) {

                nonce = jQuery(this).attr("data-nonce");
                var verification_code = $('#user_code').val();
                var adminURL = ajax_login_object.ajaxurl;
                var updateButton = jQuery( this );

                updateButton.html('<i class="fa fa-refresh fa-spin"></i>').width(acceptButtonWidth);


                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "account_confirm", verification_code: verification_code, security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            updateButton.text('Verify').width('auto').removeClass('clicked').removeClass('update-confirm');
                            $('#claim-message').addClass(response.status).text(response.message);
                            
                            if (response.redirect !== '') {
                                setTimeout(function(){ window.location = response.redirect; }, 3000);
                            }
                            
                        } else {
                            updateButton.text('Verify').width('auto').removeClass('clicked').removeClass('update-confirm');
                            $('#claim-message').addClass(response.status).text(response.message);
                        }
                    }
                }) 
            } else {
                jQuery(this).text('Confirm').addClass('update-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );
});