jQuery(document).ready(function($) {
    
    $(document).on("keyup blur focus change", "form.newsletter-form.full input.email", function() {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var inputVal = $(this).val();
        
        if (inputVal.length > 4 && inputVal != '' && emailReg.test(inputVal)) {
            $(this).css('border-bottom-color', '');
            $(this).closest("form").find("div.show_publications").slideDown(300);    
        } else {
            $(this).css('border-bottom-color', '#ef0a50');
        }
    });
    
    $(document).on("click", "form.newsletter-form.full a.newsletter_cancel", function(e) {
        e.preventDefault();
        $(this).closest("form").find("div.show_publications").slideUp(300);   
    });
    
    $(document).on('click', ".newsletter_submit", function (e) {
		
		var form = $(this).closest("form");
		//$("#classified-form-overlay").css('display', 'block');
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var hasError = 0;	
			$('input.required', form).each(function(){
            	var inputVal = $(this).val();
            	var $parentTag = $(this).parent();
				$(this).css('border-bottom-color', '');
				
            	if(inputVal == ''){
					$(this).css('border-bottom-color', '#ef0a50'); 
					hasError++;
           		}
				
            	if($(this).hasClass('email') == true){
                	if(!emailReg.test(inputVal)){
						$(this).css('border-bottom-color', '#ef0a50'); 
						hasError++;
                	}
           	 	}
        	});
			

		$(form).submit(function(e) {
			e.preventDefault(); //STOP default action
			$(".newsletter-loading").remove();
			$(this).find(".cq-container").slideUp("slow");
			if (hasError == 0) {
			//$("#classified-form-overlay").css('display', 'block');
				var existingHTML = $(this).find(".newsletter_submit").html();
                $(this).find(".newsletter_submit").html(" <i class=\"fa fa-refresh fa-spin fa-fw newsletter-loading\"></i>");
                $(this).find(".newsletter_submit").prop('disabled', true);
                var responseHTML = $(this).find(".cq-container");
                var postData = $(this).serializeArray();
                var email = $(form).find('input[name="newsletter_email"]').val();
                var is_full = $(this).hasClass('full') ? true : false;
                var formURL = $(this).attr("action");
                var data = {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    action : 'submit_cq_newsletter_signup_form'
                };
                
                var thisRequest = jQuery.post(formURL, data, function(response){
                    
                    if (is_popup) {
                        gtag('event', 'Submitted_PopUp', {
                                'event_label': 'Submitted Popup',
                                'event_category': 'newsletter_popup',
                                'non_interaction': true
                        });
                    } else {
                        gtag('event', 'Submitted_Home_Newsletter', {
                                'event_label': 'Submitted Home Newsletter',
                                'event_category': 'newsletter_subscribe',
                                'non_interaction': true
                        });
                    }
                    //f24("send", "form", "form.newsletter-form");
                    
                    if (typeof _paq != 'undefined') {
                        _paq.push(['setUserId', email]);
                        _paq.push(['trackEvent', 'Newsletter', 'Newsletter Inline Subscribe', email]);
                    }
                    

                    $(".newsletter-loading").remove();
                    $(".newsletter_submit").prop('disabled', false);
                    $(".newsletter_submit").html(existingHTML);
                    console.log(responseHTML);
                    $(".vc-newsletter-submit-result").html(response).slideDown("slow", "swing");
                    $(".newsletter_form").unbind();
                });

                /*var thisRequest = jQuery.post(formURL, data, function(response){
                    
                    if (is_full === true) {
                        
                        f24("send", "form", "form.newsletter-form");
                        
                        $(form).find('input.publication').each(function() {
                            if ($(this).is(':checked')) {
                                var this_id = $(this).attr('name');
                                var list_id = $('#list_'+this_id).val();
                                
                                if (typeof list_id != 'undefined') {
                                    f24("formMap", [{
                                          selector: "form.newsletter-form",
                                          meta: { f24name:"newsletter-form"},
                                          fields: {
                                              "FirstName": "first_name",
                                              "LastName": "first_name",
                                              "EmailAddress": "newsletter_email"
                                          },
                                          marketingList: list_id
                                      }]);
                                    f24("send", "form", "form.newsletter-form");
                                }
                            }
                        });
                        
                        setTimeout(function() {
                            $(form).find("div.show_publications").slideUp(300, function() {
                                $(form).next(".vc-newsletter-submit-result").slideUp("slow");
                            });
                        }, 5000)
                        
                    } else {
                    
                        f24("send", "form", "form.newsletter-form");
                        
                    }
                    
                    if (typeof _paq != 'undefined') {
                        _paq.push(['setUserId', email]);
                        _paq.push(['trackEvent', 'Newsletter', 'Newsletter Inline Subscribe', email]);
                    }
                    
                    $(".newsletter-loading").remove();
                    $(".newsletter_submit").prop('disabled', false);
                    $(".newsletter_submit").html(existingHTML);
                    console.log(responseHTML);
                    $(form).next(".vc-newsletter-submit-result").html(response).slideDown("slow", "swing");
                    $(".newsletter-form").unbind();
                    
                    if (response.search("error") == -1) {
                        $(".newsletter-form")[0].reset();
                    }
                });*/
			}
			console.log('Errors: '+hasError);
    		e.preventDefault(); //STOP default action
			
		});
		 //unbind. to stop multiple form submit.
	});
});