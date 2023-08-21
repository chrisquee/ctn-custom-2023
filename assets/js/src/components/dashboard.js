jQuery(function($){

	// on upload button click
	$('body').on( 'click', '.cq-upload', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
            console.log(attachment);
			button.html('<img src="' + attachment.sizes.thumbnail.url + '">').next('.cq-remove').show().next().val(attachment.id);
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.cq-remove', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});
    
    jQuery('#logo-upload').on('click', 
        function (event) {
            event.preventDefault();
            //var uploadButtonWidth = jQuery( this ).width();
            if (jQuery('#logo_image').val() == '') {
                return;
            }
            if ( jQuery( this ).hasClass( "upload-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "sent" )  ) {

                var nonce = jQuery(this).attr("data-nonce");
                var adminURL = ajax_login_object.ajaxurl;
                var uploadButton = jQuery( this );
                //var here = this;
                var file_data = jQuery('#logo_image').prop('files')[0];
                var form_data = new FormData();

                form_data.append('file', file_data);
                form_data.append('action', 'business_logo_upload');
                form_data.append('security', nonce);

                uploadButton.html('<i class="fa fa-refresh fa-spin"></i>');

                jQuery.ajax({
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: form_data,
                    url : ajax_login_object.ajaxurl,
                    success: function(response) {
                        var json = JSON.parse(response);
                        if(json.message == "success") { 
                            jQuery('#logo-img').attr("src", json.thumbnail_src);
                            jQuery('#logo_image_id').val(json.image_id);
                            uploadButton.html('Updated <i class="fa fa-check"></i>').addClass('sent').removeClass('clicked').removeClass('upload-confirm');
                            setTimeout(function() {
                                uploadButton.html('Add Logo');
                            }, 5000)
                        } else {
                            uploadButton.removeClass('clicked');
                            uploadButton.html('Add Logo');
                            alert(json.message);
                        }
                    },
                    error: function(response) {
                        jQuery(this).html('<i class="fa fa-check"></i>').addClass('delete-confirm').addClass('clicked').delay(1000).queue(function(next){
                            jQuery(this).removeClass('clicked');
                           next();
                        })

                    }
                }) 
            } else {
                jQuery(this).html('Confirm <i class="fa fa-check"></i>').addClass('upload-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );

    jQuery('#featured-upload').on('click', 
        function (event) {
            event.preventDefault();
            //var uploadButtonWidth = jQuery( this ).width();
            if (jQuery('#featured_image').val() == '') {
                return;
            }
            if ( jQuery( this ).hasClass( "upload-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "sent" )  ) {

                var nonce = jQuery(this).attr("data-nonce");
                var adminURL = ajax_login_object.ajaxurl;
                var uploadButton = jQuery( this );
                var here = this;
                var file_data = jQuery('#featured_image').prop('files')[0];
                var form_data = new FormData();

                form_data.append('file', file_data);
                form_data.append('action', 'featured_image_upload');
                form_data.append('security', nonce);

                uploadButton.html('<i class="fa fa-refresh fa-spin"></i>');


                jQuery.ajax({
                    type: 'post',
                    contentType: false,
                    processData: false,
                    data: form_data,
                    url : adminURL,
                    success: function(response) {
                        var json = JSON.parse(response);
                        if(json.message == "success") { 
                            jQuery('#featured-img').attr("src", json.thumbnail_src);
                            jQuery('#featured_image_id').val(json.image_id);
                            uploadButton.html('Updated <i class="fa fa-check"></i>').addClass('sent').removeClass('clicked').removeClass('upload-confirm');
                            setTimeout(function() {
                                uploadButton.html('Add Logo');
                            }, 5000)
                        } else {
                            uploadButton.removeClass('clicked');
                            uploadButton.html('Add Logo');
                            alert(json.message);
                        }
                    },
                    error: function(response) {
                        jQuery(this).html('<i class="fa fa-check"></i>').addClass('delete-confirm').addClass('clicked').delay(1000).queue(function(next){
                            jQuery(this).removeClass('clicked');
                           next();
                        })

                    }
                }) 
            } else {
                jQuery(this).html('<i class="fa fa-check"></i>').addClass('upload-confirm').addClass('clicked').delay(1000)
                    .queue(function(next){
                        jQuery(this).removeClass('clicked');
                        next();
                    })

            }
        }
    );
    
    jQuery('#sidebar .menu-open').on('click', function() {
        jQuery('#sidebar').toggleClass('mobile-active');
        jQuery('.menu-open i.fa').toggleClass("fa-bars fa-close");
    });

});