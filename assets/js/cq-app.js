(function(a){function b(a,b){var c=this,d,e;return function(){return e=Array.prototype.slice.call(arguments,0),d=clearTimeout(d,e),d=setTimeout(function(){a.apply(c,e),d=0},b),this}}a.extend(a.fn,{debounce:function(a,c,d){this.bind(a,b.apply(this,[c,d]))}})})(jQuery)

jQuery(function($) {

    // Show the login dialog box on click
    $('a#show_login, a.show_login').on('click', function(e){
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
    
    $(".newsletter_submit").click(function (e) {
		
		var form = $(this).closest("form");
		//$("#classified-form-overlay").css('display', 'block');
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var hasError = 0;	
			$('.required', form).each(function(){
            	var inputVal = $(this).val();
            	var $parentTag = $(this).parent();
				$(this).css('border', '1px solid #efefef');
				
            	if(inputVal == ''){
					$(this).css('border', '1px solid #ef0a50'); 
					hasError++;
           		}
				
            	if($(this).hasClass('email') == true){
                	if(!emailReg.test(inputVal)){
						$(this).css('border', '1px solid #ef0a50'); 
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
                var is_popup = $(this).find(".newsletter_submit").hasClass("popup_submit");
                $(this).find(".newsletter_submit").html(" <i class=\"fa fa-refresh fa-spin fa-fw newsletter-loading\"></i>");
                $(this).find(".newsletter_submit").prop('disabled', true);
                var responseHTML = $(this).find(".cq-container");
                var postData = $(this).serializeArray();
                var email = $(form).find('input[name="newsletter_email"]').val();
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
                    f24("send", "form", "form.newsletter-form");
                    
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
			}
			console.log('Errors: '+hasError);
    		e.preventDefault(); //STOP default action
			
		});
		 //unbind. to stop multiple form submit.
	});
    
    $('.search-button').click(function(event) {
	   
	   event.preventDefault();
		
       var searchBoxStyle = {
          	position: "fixed",
			left: "50%",
			top: "30%",
           	height: "auto",
           	width: "700px",
			//"margin-left": "-25%",
		    transform: "translateX(-50%)",
		    "margin-top": "0px",
		   	"max-width": "93%",
           	padding: "0",
           "background-color": "rgba(255, 255, 255, 0)",
           	display: "none"
        };
		
        $(".search-box-fs").css(searchBoxStyle);
		$(".search-popup-overlay").css("display: block");
        $(".search-box-fs").add(".search-popup-overlay").fadeIn(300);
		$(".search-popup-container").fadeIn(300);
        $(".close-icon").click(function () {
			$(".search-popup-container").fadeOut(300);
            $(".search-box-fs").add(".search-popup-overlay").fadeOut(300);
        })
	})
    
    var resultEnd = false;
    $("form#cqDirectoryFilter input").debounce('change keyup textInput input', function(event) {
        
        if (event.type === 'keyup') {
            var search = $("form#cqDirectoryFilter #directory_keywords").val();
            if (search.length < 4) {
                return;
            } 
        }
        
        $('#listing-wrapper').fadeOut(300);
        resultEnd = false;
        var catArray = new Array();
        var j = 0;
        var parent = $("form#cqDirectoryFilter #parent_category").val();
        var per_page = $('#listing-wrapper').attr('data-perpage');
        var keywords = $("form#cqDirectoryFilter #directory_keywords").val();

        $('form#cqDirectoryFilter input[type=checkbox]').each(function () {
            if (this.checked) {
                catArray[j] = $(this).val();
                j++;
            }
        });

        // Just put this here so you can see the output
         //alert('array:'+catArray.toString());

        $.ajax(
        {
            type:    "POST",
            url:     ajax_login_object.ajaxurl,
            data:    ({ action: 'directory_filter', parent: parent, categories : catArray.toString(), keywords: keywords, per_page: per_page, page_number: 0 }),
            dataType: 'json',
            success: function(msg) {
                if (msg.result == 'success') {
                    $('#listing-wrapper').html(msg.content);
                    $('#listing-wrapper').fadeIn(300);
                } else {
                    $('#listing-wrapper').html(msg.content);
                    $('#listing-wrapper').fadeIn(300);
                    resultEnd = true;
                }
            }
        });

        return false;
     }, 500);
    
    var dirLoading = false;
	$(window).scroll(function () {
		if ($('#listing-wrapper').length) {
            if ($(window).scrollTop() >= $('#listing-wrapper').offset().top + $('#listing-wrapper').outerHeight() - window.innerHeight) {
                
                //$('#listing-wrapper').fadeOut(300);
                var catArray = new Array();
                var j = 0;
                var parent = $("form#cqDirectoryFilter #parent_category").val();
                var per_page = $('#listing-wrapper').attr('data-perpage');
        
            $('form#cqDirectoryFilter input[type=checkbox]').each(function () {
                if (this.checked) {
                    catArray[j] = $(this).val();
                    j++;
                }
            });

                var data = {
                    'action': 'directory_filter',
                    'parent': parent, 
                    'categories' : catArray.toString(),
                    'per_page': per_page,
                    'page_number' : cq_loadmore_params.current_page,
                    'loader': true
                };

                if(dirLoading==false && resultEnd == false) {
                    cq_loadmore_params.current_page++;
                    dirLoading = true;
                    $.ajax({
                        url : ajax_login_object.ajaxurl, // AJAX handler
                        data : data,
                        type : 'POST',
                        dataType: 'json',
                        beforeSend : function ( xhr ) {
                            //button.html('Loading... <i class="fa fa-refresh fa-spin fa-fw"></i>');  change the button text, you can also add a preloader image
                        },
                        success : function( data ){
                            if( data ) {
                                if (data.result == 'empty') {
                                    resultEnd = true;
                                }
                                // insert new posts
                                $('#listing-wrapper').append(data.content);
                                //$('#listing-wrapper .item_wrap').fadeIn('fast');

                                dirLoading = false;
                            } else {
                                resultEnd = true;
                                dirLoading = false;
                            }
                        }
                    });
                }
            }
        }
    });
    
    $('.category_filter .open_sub').click(function(event) {
        event.preventDefault();
        $(this).siblings('.sub_menu').slideToggle(300);
    });
    
    $('#cq_tabs li a:not(:first)').addClass('inactive');
    $('.tab-container').hide();
    $('.tab-container:first').show();
    
    $('#cq_tabs li a').click(function(){
        var t = $(this).attr('id');
        if($(this).hasClass('inactive')){ //this is the start of our condition 
          $('#cq_tabs li a').addClass('inactive');           
          $(this).removeClass('inactive');

          $('.tab-container').hide();
          $('#'+ t + 'C').fadeIn('slow');
       }
    });
    
    jQuery('.dashboard-content #code-submit').on('click', 
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
    
    
    var closeHeight = '200px'; /* Default "closed" height */
    var addedSpace = 60;
    var moreText 	= 'Read More <span class="fa fa-angle-down"></span>'; /* Default "Read More" text */
    var lessText	= 'Read Less <span class="fa fa-angle-up"></span>'; /* Default "Read Less" text */
    var duration	= '1000'; /* Animation duration */
    var easing = 'linear'; /* Animation easing option */

	// Limit height of .entry-content div
	jQuery('.cruise-ship-meta-wrap').each(function() {
		
		// Set data attribute to record original height
		var current = jQuery(this).children('.meta-content');
        if (current.height() > 200) {
            current.data('fullHeight', current.height()).css('height', closeHeight);

            // Insert "Read More" link
            current.after('<a href="javascript:void(0);" class="more-link closed">' + moreText + '</a>');
        }

	});
    
    jQuery('.agenda-time-content .synopsis .synopsis-wrap').each(function() {
		
		closeHeight = '72px';
        addedSpace = 10;
		var current = jQuery(this);
        if (current.height() > 72) {
            current.data('fullHeight', current.height()).css('height', closeHeight);

            // Insert "Read More" link
            current.after('<a href="javascript:void(0);" class="more-link closed">' + moreText + '</a>');
        }

	});
  
  // Link functinoality
	var openSlider = function() {
		link = jQuery(this);
		var openHeight = link.prev('.meta-content').data('fullHeight') + addedSpace + 'px';
		link.prev('.meta-content').animate({'height': openHeight}, {duration: duration }, easing);
		link.html(lessText).addClass('open').removeClass('closed');
        //link.children('span').removeClass('fa-angle-down').addClass('fa-angle-up');
    	link.unbind('click', openSlider);
		link.bind('click', closeSlider);
	}

	var closeSlider = function() {
		link = jQuery(this);
    	link.prev('.meta-content').animate({'height': closeHeight}, {duration: duration }, easing);
		link.html(moreText).addClass('closed').removeClass('open');
        //link.children('span').removeClass('fa-angle-up').addClass('fa-angle-down');
		link.unbind('click');
		link.bind('click', openSlider);
	}
  
	jQuery('.more-link').bind('click', openSlider);
    
    var moreCruiseLines = function() {
        
        var moreText = 'See More <span class="fa fa-angle-down"></span>';
        var lessText = 'See Less <span class="fa fa-angle-up"></span>';
        
        link = jQuery(this);
        link.prev('div.cruise-lines-see-more').slideToggle(1000);
        link.toggleClass('closed open');
        link.hasClass('closed') ? link.html(moreText) : link.html(lessText);
                        
    }
    
    jQuery('.more-cruise-lines').bind('click', moreCruiseLines);
    
    jQuery('#ship-menu .mobile-label').on('click', function() {
        jQuery('#ship-menu .mobile-label span').toggleClass('fa-bars fa-close');
        jQuery('#ship-menu').toggleClass('open');
    });
    
    jQuery('#ship-menu ul li a').on('click', function() {
        jQuery('#ship-menu .mobile-label span').toggleClass('fa-bars fa-close');
        jQuery('#ship-menu').toggleClass('open');
    });
    
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
    
    if (jQuery('body.single-cq_interactive_item').length > 0) {
        swipeInfo();
    }
    
    jQuery('.single-cq_interactive_item ol#hotspots li.hotspot').click(function(event) {
	   
	   event.preventDefault();
        
        var hotspot = jQuery(this);
		var content_id = jQuery(this).data('content_id');
		var ajax_url = ajax_login_object.ajaxurl;
		var title = document.title;
		var url = document.URL;
		console.log('content id: '+content_id);
		var data = {
        		url : ajax_url,
        		type: "POST",
        		data : {
					content_id: content_id,
				},
				action : 'get_interactive_content'
    		};
        jQuery('.single-cq_interactive_item ol#hotspots li.hotspot').removeClass('active');
        jQuery(hotspot).addClass('active');
		jQuery("#interactive_content_box").addClass('active').fadeIn(300, function() {
			jQuery("#interactive_content_container").html("<div class='animation-image-container'><div class='animation-image'></div></div>");
			jQuery('html,body').css("overflow","hidden");
			//window.history.pushState('#viewinginfo', title, url);
			var thisRequest = jQuery.post(ajax_url, data, function(response){
            	jQuery("#interactive_content_container").fadeIn(300).html(response);
                fancybox_init();
                owl_init();
        	});
		});
        
		jQuery("body").css("overflow", "hidden");
		
		window.onpopstate = function() {
    		jQuery("#interactive_content_box").fadein(300);
    		jQuery('html,body').css("overflow","auto");
			jQuery("#interactive_content_container").html('');
		}
		
        jQuery(".close-icon .popup-close").click(function () {
			jQuery("#interactive_content_box").fadein(300);
			//jQuery(".team-popup-container").fadeOut(300);
			jQuery("html,body").css("overflow", "auto");
			jQuery("#interactive_content_container").html('');
        })
	})
    
    jQuery("#interactive_content_box .close-icon").on('click', function() {
        jQuery("#interactive_content_box").removeClass('active');
        jQuery('.single-cq_interactive_item ol#hotspots li.hotspot').removeClass('active');
    });
    
    jQuery('.cf7-check-all').click(function(event) {
        
        event.preventDefault();
        
        var checkboxes = jQuery(this).data('checkbox');
        jQuery('input[name="'+checkboxes+'[]"]').prop('checked', 'checked');
        
    });
    
});

function createCookie(a, b, c) {
    if (c) {
        var d = new Date;
        d.setTime(d.getTime() + c * 24 * 60 * 60 * 1e3);
        var e = "; expires=" + d.toGMTString()
    } else var e = "";
    document.cookie = a + "=" + b + e + "; path=/"
}

function readCookie(a) {
    var b = a + "=";
    var c = document.cookie.split(";");
    for (var d = 0; d < c.length; d++) {
        var e = c[d];
        while (e.charAt(0) == " ") e = e.substring(1, e.length);
        if (e.indexOf(b) == 0) return e.substring(b.length, e.length)
    }
    return null
}

function swipeInfo() {
    var cookieStatus = readCookie("swipeInfo");
    if (cookieStatus != 1 && jQuery(window).width() < 769) {
        jQuery("#mobile-scroll").fadeIn(600);
        jQuery("#mobile-scroll").fadeOut(4000);
        createCookie("swipeInfo", 1, 10)
       
    }
}

function fancybox_init() {
    jQuery("a.lightbox, img.lightbox").fancybox({
		'transitionIn'	:	'fade',
		'transitionOut'	:	'fade',
		'overlayShow' : true,
		'overlayColor' : '2E3439',
		'height'	: '800',
		'width'		: '800',
		'autoScale'		: true,
		'autoDimensions' : true,
		'overlayOpacity' : 0.8,
		'speedIn'		:	600, 
		'speedOut'		:	200
	});
}

function owl_init() {
    var $owl = jQuery(".owl-carousel");
	$owl.each(function (index) {
        
        var items_no = jQuery(this).attr('data-items') != undefined ? jQuery(this).attr('data-items') : 1;
        var mobile_items = jQuery(this).attr('data-mobile-items') != undefined ? jQuery(this).attr('data-mobile-items') : 1;
        
        jQuery(this).owlCarousel({
          items : items_no, //10 items above 1000px browser width
          margin: 15,	  
          responsiveClass:true,
          autoHeight:true,
          navText: ['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],	  
            responsive:{
            0:{
                items: mobile_items,
                nav:true,
                stagePadding: 0
            },
            600:{
                items:1,
                nav:true,
                stagePadding: 0
            },
            1000:{
                items:items_no,
                nav:true,
                loop:false,
            }
        }
      });
    });
}

/* Chosen v1.8.7 | (c) 2011-2018 by Harvest | MIT License, https://github.com/harvesthq/chosen/blob/master/LICENSE.md */

(function(){var t,e,s,i,n=function(t,e){return function(){return t.apply(e,arguments)}},r=function(t,e){function s(){this.constructor=t}for(var i in e)o.call(e,i)&&(t[i]=e[i]);return s.prototype=e.prototype,t.prototype=new s,t.__super__=e.prototype,t},o={}.hasOwnProperty;(i=function(){function t(){this.options_index=0,this.parsed=[]}return t.prototype.add_node=function(t){return"OPTGROUP"===t.nodeName.toUpperCase()?this.add_group(t):this.add_option(t)},t.prototype.add_group=function(t){var e,s,i,n,r,o;for(e=this.parsed.length,this.parsed.push({array_index:e,group:!0,label:t.label,title:t.title?t.title:void 0,children:0,disabled:t.disabled,classes:t.className}),o=[],s=0,i=(r=t.childNodes).length;s<i;s++)n=r[s],o.push(this.add_option(n,e,t.disabled));return o},t.prototype.add_option=function(t,e,s){if("OPTION"===t.nodeName.toUpperCase())return""!==t.text?(null!=e&&(this.parsed[e].children+=1),this.parsed.push({array_index:this.parsed.length,options_index:this.options_index,value:t.value,text:t.text,html:t.innerHTML,title:t.title?t.title:void 0,selected:t.selected,disabled:!0===s?s:t.disabled,group_array_index:e,group_label:null!=e?this.parsed[e].label:null,classes:t.className,style:t.style.cssText})):this.parsed.push({array_index:this.parsed.length,options_index:this.options_index,empty:!0}),this.options_index+=1},t}()).select_to_array=function(t){var e,s,n,r,o;for(r=new i,s=0,n=(o=t.childNodes).length;s<n;s++)e=o[s],r.add_node(e);return r.parsed},e=function(){function t(e,s){this.form_field=e,this.options=null!=s?s:{},this.label_click_handler=n(this.label_click_handler,this),t.browser_is_supported()&&(this.is_multiple=this.form_field.multiple,this.set_default_text(),this.set_default_values(),this.setup(),this.set_up_html(),this.register_observers(),this.on_ready())}return t.prototype.set_default_values=function(){return this.click_test_action=function(t){return function(e){return t.test_active_click(e)}}(this),this.activate_action=function(t){return function(e){return t.activate_field(e)}}(this),this.active_field=!1,this.mouse_on_container=!1,this.results_showing=!1,this.result_highlighted=null,this.is_rtl=this.options.rtl||/\bchosen-rtl\b/.test(this.form_field.className),this.allow_single_deselect=null!=this.options.allow_single_deselect&&null!=this.form_field.options[0]&&""===this.form_field.options[0].text&&this.options.allow_single_deselect,this.disable_search_threshold=this.options.disable_search_threshold||0,this.disable_search=this.options.disable_search||!1,this.enable_split_word_search=null==this.options.enable_split_word_search||this.options.enable_split_word_search,this.group_search=null==this.options.group_search||this.options.group_search,this.search_contains=this.options.search_contains||!1,this.single_backstroke_delete=null==this.options.single_backstroke_delete||this.options.single_backstroke_delete,this.max_selected_options=this.options.max_selected_options||Infinity,this.inherit_select_classes=this.options.inherit_select_classes||!1,this.display_selected_options=null==this.options.display_selected_options||this.options.display_selected_options,this.display_disabled_options=null==this.options.display_disabled_options||this.options.display_disabled_options,this.include_group_label_in_selected=this.options.include_group_label_in_selected||!1,this.max_shown_results=this.options.max_shown_results||Number.POSITIVE_INFINITY,this.case_sensitive_search=this.options.case_sensitive_search||!1,this.hide_results_on_select=null==this.options.hide_results_on_select||this.options.hide_results_on_select},t.prototype.set_default_text=function(){return this.form_field.getAttribute("data-placeholder")?this.default_text=this.form_field.getAttribute("data-placeholder"):this.is_multiple?this.default_text=this.options.placeholder_text_multiple||this.options.placeholder_text||t.default_multiple_text:this.default_text=this.options.placeholder_text_single||this.options.placeholder_text||t.default_single_text,this.default_text=this.escape_html(this.default_text),this.results_none_found=this.form_field.getAttribute("data-no_results_text")||this.options.no_results_text||t.default_no_result_text},t.prototype.choice_label=function(t){return this.include_group_label_in_selected&&null!=t.group_label?"<b class='group-name'>"+this.escape_html(t.group_label)+"</b>"+t.html:t.html},t.prototype.mouse_enter=function(){return this.mouse_on_container=!0},t.prototype.mouse_leave=function(){return this.mouse_on_container=!1},t.prototype.input_focus=function(t){if(this.is_multiple){if(!this.active_field)return setTimeout(function(t){return function(){return t.container_mousedown()}}(this),50)}else if(!this.active_field)return this.activate_field()},t.prototype.input_blur=function(t){if(!this.mouse_on_container)return this.active_field=!1,setTimeout(function(t){return function(){return t.blur_test()}}(this),100)},t.prototype.label_click_handler=function(t){return this.is_multiple?this.container_mousedown(t):this.activate_field()},t.prototype.results_option_build=function(t){var e,s,i,n,r,o,h;for(e="",h=0,n=0,r=(o=this.results_data).length;n<r&&(s=o[n],i="",""!==(i=s.group?this.result_add_group(s):this.result_add_option(s))&&(h++,e+=i),(null!=t?t.first:void 0)&&(s.selected&&this.is_multiple?this.choice_build(s):s.selected&&!this.is_multiple&&this.single_set_selected_text(this.choice_label(s))),!(h>=this.max_shown_results));n++);return e},t.prototype.result_add_option=function(t){var e,s;return t.search_match&&this.include_option_in_results(t)?(e=[],t.disabled||t.selected&&this.is_multiple||e.push("active-result"),!t.disabled||t.selected&&this.is_multiple||e.push("disabled-result"),t.selected&&e.push("result-selected"),null!=t.group_array_index&&e.push("group-option"),""!==t.classes&&e.push(t.classes),s=document.createElement("li"),s.className=e.join(" "),t.style&&(s.style.cssText=t.style),s.setAttribute("data-option-array-index",t.array_index),s.innerHTML=t.highlighted_html||t.html,t.title&&(s.title=t.title),this.outerHTML(s)):""},t.prototype.result_add_group=function(t){var e,s;return(t.search_match||t.group_match)&&t.active_options>0?((e=[]).push("group-result"),t.classes&&e.push(t.classes),s=document.createElement("li"),s.className=e.join(" "),s.innerHTML=t.highlighted_html||this.escape_html(t.label),t.title&&(s.title=t.title),this.outerHTML(s)):""},t.prototype.results_update_field=function(){if(this.set_default_text(),this.is_multiple||this.results_reset_cleanup(),this.result_clear_highlight(),this.results_build(),this.results_showing)return this.winnow_results()},t.prototype.reset_single_select_options=function(){var t,e,s,i,n;for(n=[],t=0,e=(s=this.results_data).length;t<e;t++)(i=s[t]).selected?n.push(i.selected=!1):n.push(void 0);return n},t.prototype.results_toggle=function(){return this.results_showing?this.results_hide():this.results_show()},t.prototype.results_search=function(t){return this.results_showing?this.winnow_results():this.results_show()},t.prototype.winnow_results=function(t){var e,s,i,n,r,o,h,l,c,_,a,u,d,p,f;for(this.no_results_clear(),_=0,e=(h=this.get_search_text()).replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),c=this.get_search_regex(e),i=0,n=(l=this.results_data).length;i<n;i++)(r=l[i]).search_match=!1,a=null,u=null,r.highlighted_html="",this.include_option_in_results(r)&&(r.group&&(r.group_match=!1,r.active_options=0),null!=r.group_array_index&&this.results_data[r.group_array_index]&&(0===(a=this.results_data[r.group_array_index]).active_options&&a.search_match&&(_+=1),a.active_options+=1),f=r.group?r.label:r.text,r.group&&!this.group_search||(u=this.search_string_match(f,c),r.search_match=null!=u,r.search_match&&!r.group&&(_+=1),r.search_match?(h.length&&(d=u.index,o=f.slice(0,d),s=f.slice(d,d+h.length),p=f.slice(d+h.length),r.highlighted_html=this.escape_html(o)+"<em>"+this.escape_html(s)+"</em>"+this.escape_html(p)),null!=a&&(a.group_match=!0)):null!=r.group_array_index&&this.results_data[r.group_array_index].search_match&&(r.search_match=!0)));return this.result_clear_highlight(),_<1&&h.length?(this.update_results_content(""),this.no_results(h)):(this.update_results_content(this.results_option_build()),(null!=t?t.skip_highlight:void 0)?void 0:this.winnow_results_set_highlight())},t.prototype.get_search_regex=function(t){var e,s;return s=this.search_contains?t:"(^|\\s|\\b)"+t+"[^\\s]*",this.enable_split_word_search||this.search_contains||(s="^"+s),e=this.case_sensitive_search?"":"i",new RegExp(s,e)},t.prototype.search_string_match=function(t,e){var s;return s=e.exec(t),!this.search_contains&&(null!=s?s[1]:void 0)&&(s.index+=1),s},t.prototype.choices_count=function(){var t,e,s;if(null!=this.selected_option_count)return this.selected_option_count;for(this.selected_option_count=0,t=0,e=(s=this.form_field.options).length;t<e;t++)s[t].selected&&(this.selected_option_count+=1);return this.selected_option_count},t.prototype.choices_click=function(t){if(t.preventDefault(),this.activate_field(),!this.results_showing&&!this.is_disabled)return this.results_show()},t.prototype.keydown_checker=function(t){var e,s;switch(s=null!=(e=t.which)?e:t.keyCode,this.search_field_scale(),8!==s&&this.pending_backstroke&&this.clear_backstroke(),s){case 8:this.backstroke_length=this.get_search_field_value().length;break;case 9:this.results_showing&&!this.is_multiple&&this.result_select(t),this.mouse_on_container=!1;break;case 13:case 27:this.results_showing&&t.preventDefault();break;case 32:this.disable_search&&t.preventDefault();break;case 38:t.preventDefault(),this.keyup_arrow();break;case 40:t.preventDefault(),this.keydown_arrow()}},t.prototype.keyup_checker=function(t){var e,s;switch(s=null!=(e=t.which)?e:t.keyCode,this.search_field_scale(),s){case 8:this.is_multiple&&this.backstroke_length<1&&this.choices_count()>0?this.keydown_backstroke():this.pending_backstroke||(this.result_clear_highlight(),this.results_search());break;case 13:t.preventDefault(),this.results_showing&&this.result_select(t);break;case 27:this.results_showing&&this.results_hide();break;case 9:case 16:case 17:case 18:case 38:case 40:case 91:break;default:this.results_search()}},t.prototype.clipboard_event_checker=function(t){if(!this.is_disabled)return setTimeout(function(t){return function(){return t.results_search()}}(this),50)},t.prototype.container_width=function(){return null!=this.options.width?this.options.width:this.form_field.offsetWidth+"px"},t.prototype.include_option_in_results=function(t){return!(this.is_multiple&&!this.display_selected_options&&t.selected)&&(!(!this.display_disabled_options&&t.disabled)&&!t.empty)},t.prototype.search_results_touchstart=function(t){return this.touch_started=!0,this.search_results_mouseover(t)},t.prototype.search_results_touchmove=function(t){return this.touch_started=!1,this.search_results_mouseout(t)},t.prototype.search_results_touchend=function(t){if(this.touch_started)return this.search_results_mouseup(t)},t.prototype.outerHTML=function(t){var e;return t.outerHTML?t.outerHTML:((e=document.createElement("div")).appendChild(t),e.innerHTML)},t.prototype.get_single_html=function(){return'<a class="chosen-single chosen-default">\n  <span>'+this.default_text+'</span>\n  <div><b></b></div>\n</a>\n<div class="chosen-drop">\n  <div class="chosen-search">\n    <input class="chosen-search-input" type="text" autocomplete="off" />\n  </div>\n  <ul class="chosen-results"></ul>\n</div>'},t.prototype.get_multi_html=function(){return'<ul class="chosen-choices">\n  <li class="search-field">\n    <input class="chosen-search-input" type="text" autocomplete="off" value="'+this.default_text+'" />\n  </li>\n</ul>\n<div class="chosen-drop">\n  <ul class="chosen-results"></ul>\n</div>'},t.prototype.get_no_results_html=function(t){return'<li class="no-results">\n  '+this.results_none_found+" <span>"+this.escape_html(t)+"</span>\n</li>"},t.browser_is_supported=function(){return"Microsoft Internet Explorer"===window.navigator.appName?document.documentMode>=8:!(/iP(od|hone)/i.test(window.navigator.userAgent)||/IEMobile/i.test(window.navigator.userAgent)||/Windows Phone/i.test(window.navigator.userAgent)||/BlackBerry/i.test(window.navigator.userAgent)||/BB10/i.test(window.navigator.userAgent)||/Android.*Mobile/i.test(window.navigator.userAgent))},t.default_multiple_text="Select Some Options",t.default_single_text="Select an Option",t.default_no_result_text="No results match",t}(),(t=jQuery).fn.extend({chosen:function(i){return e.browser_is_supported()?this.each(function(e){var n,r;r=(n=t(this)).data("chosen"),"destroy"!==i?r instanceof s||n.data("chosen",new s(this,i)):r instanceof s&&r.destroy()}):this}}),s=function(s){function n(){return n.__super__.constructor.apply(this,arguments)}return r(n,e),n.prototype.setup=function(){return this.form_field_jq=t(this.form_field),this.current_selectedIndex=this.form_field.selectedIndex},n.prototype.set_up_html=function(){var e,s;return(e=["chosen-container"]).push("chosen-container-"+(this.is_multiple?"multi":"single")),this.inherit_select_classes&&this.form_field.className&&e.push(this.form_field.className),this.is_rtl&&e.push("chosen-rtl"),s={"class":e.join(" "),title:this.form_field.title},this.form_field.id.length&&(s.id=this.form_field.id.replace(/[^\w]/g,"_")+"_chosen"),this.container=t("<div />",s),this.container.width(this.container_width()),this.is_multiple?this.container.html(this.get_multi_html()):this.container.html(this.get_single_html()),this.form_field_jq.hide().after(this.container),this.dropdown=this.container.find("div.chosen-drop").first(),this.search_field=this.container.find("input").first(),this.search_results=this.container.find("ul.chosen-results").first(),this.search_field_scale(),this.search_no_results=this.container.find("li.no-results").first(),this.is_multiple?(this.search_choices=this.container.find("ul.chosen-choices").first(),this.search_container=this.container.find("li.search-field").first()):(this.search_container=this.container.find("div.chosen-search").first(),this.selected_item=this.container.find(".chosen-single").first()),this.results_build(),this.set_tab_index(),this.set_label_behavior()},n.prototype.on_ready=function(){return this.form_field_jq.trigger("chosen:ready",{chosen:this})},n.prototype.register_observers=function(){return this.container.on("touchstart.chosen",function(t){return function(e){t.container_mousedown(e)}}(this)),this.container.on("touchend.chosen",function(t){return function(e){t.container_mouseup(e)}}(this)),this.container.on("mousedown.chosen",function(t){return function(e){t.container_mousedown(e)}}(this)),this.container.on("mouseup.chosen",function(t){return function(e){t.container_mouseup(e)}}(this)),this.container.on("mouseenter.chosen",function(t){return function(e){t.mouse_enter(e)}}(this)),this.container.on("mouseleave.chosen",function(t){return function(e){t.mouse_leave(e)}}(this)),this.search_results.on("mouseup.chosen",function(t){return function(e){t.search_results_mouseup(e)}}(this)),this.search_results.on("mouseover.chosen",function(t){return function(e){t.search_results_mouseover(e)}}(this)),this.search_results.on("mouseout.chosen",function(t){return function(e){t.search_results_mouseout(e)}}(this)),this.search_results.on("mousewheel.chosen DOMMouseScroll.chosen",function(t){return function(e){t.search_results_mousewheel(e)}}(this)),this.search_results.on("touchstart.chosen",function(t){return function(e){t.search_results_touchstart(e)}}(this)),this.search_results.on("touchmove.chosen",function(t){return function(e){t.search_results_touchmove(e)}}(this)),this.search_results.on("touchend.chosen",function(t){return function(e){t.search_results_touchend(e)}}(this)),this.form_field_jq.on("chosen:updated.chosen",function(t){return function(e){t.results_update_field(e)}}(this)),this.form_field_jq.on("chosen:activate.chosen",function(t){return function(e){t.activate_field(e)}}(this)),this.form_field_jq.on("chosen:open.chosen",function(t){return function(e){t.container_mousedown(e)}}(this)),this.form_field_jq.on("chosen:close.chosen",function(t){return function(e){t.close_field(e)}}(this)),this.search_field.on("blur.chosen",function(t){return function(e){t.input_blur(e)}}(this)),this.search_field.on("keyup.chosen",function(t){return function(e){t.keyup_checker(e)}}(this)),this.search_field.on("keydown.chosen",function(t){return function(e){t.keydown_checker(e)}}(this)),this.search_field.on("focus.chosen",function(t){return function(e){t.input_focus(e)}}(this)),this.search_field.on("cut.chosen",function(t){return function(e){t.clipboard_event_checker(e)}}(this)),this.search_field.on("paste.chosen",function(t){return function(e){t.clipboard_event_checker(e)}}(this)),this.is_multiple?this.search_choices.on("click.chosen",function(t){return function(e){t.choices_click(e)}}(this)):this.container.on("click.chosen",function(t){t.preventDefault()})},n.prototype.destroy=function(){return t(this.container[0].ownerDocument).off("click.chosen",this.click_test_action),this.form_field_label.length>0&&this.form_field_label.off("click.chosen"),this.search_field[0].tabIndex&&(this.form_field_jq[0].tabIndex=this.search_field[0].tabIndex),this.container.remove(),this.form_field_jq.removeData("chosen"),this.form_field_jq.show()},n.prototype.search_field_disabled=function(){return this.is_disabled=this.form_field.disabled||this.form_field_jq.parents("fieldset").is(":disabled"),this.container.toggleClass("chosen-disabled",this.is_disabled),this.search_field[0].disabled=this.is_disabled,this.is_multiple||this.selected_item.off("focus.chosen",this.activate_field),this.is_disabled?this.close_field():this.is_multiple?void 0:this.selected_item.on("focus.chosen",this.activate_field)},n.prototype.container_mousedown=function(e){var s;if(!this.is_disabled)return!e||"mousedown"!==(s=e.type)&&"touchstart"!==s||this.results_showing||e.preventDefault(),null!=e&&t(e.target).hasClass("search-choice-close")?void 0:(this.active_field?this.is_multiple||!e||t(e.target)[0]!==this.selected_item[0]&&!t(e.target).parents("a.chosen-single").length||(e.preventDefault(),this.results_toggle()):(this.is_multiple&&this.search_field.val(""),t(this.container[0].ownerDocument).on("click.chosen",this.click_test_action),this.results_show()),this.activate_field())},n.prototype.container_mouseup=function(t){if("ABBR"===t.target.nodeName&&!this.is_disabled)return this.results_reset(t)},n.prototype.search_results_mousewheel=function(t){var e;if(t.originalEvent&&(e=t.originalEvent.deltaY||-t.originalEvent.wheelDelta||t.originalEvent.detail),null!=e)return t.preventDefault(),"DOMMouseScroll"===t.type&&(e*=40),this.search_results.scrollTop(e+this.search_results.scrollTop())},n.prototype.blur_test=function(t){if(!this.active_field&&this.container.hasClass("chosen-container-active"))return this.close_field()},n.prototype.close_field=function(){return t(this.container[0].ownerDocument).off("click.chosen",this.click_test_action),this.active_field=!1,this.results_hide(),this.container.removeClass("chosen-container-active"),this.clear_backstroke(),this.show_search_field_default(),this.search_field_scale(),this.search_field.blur()},n.prototype.activate_field=function(){if(!this.is_disabled)return this.container.addClass("chosen-container-active"),this.active_field=!0,this.search_field.val(this.search_field.val()),this.search_field.focus()},n.prototype.test_active_click=function(e){var s;return(s=t(e.target).closest(".chosen-container")).length&&this.container[0]===s[0]?this.active_field=!0:this.close_field()},n.prototype.results_build=function(){return this.parsing=!0,this.selected_option_count=null,this.results_data=i.select_to_array(this.form_field),this.is_multiple?this.search_choices.find("li.search-choice").remove():(this.single_set_selected_text(),this.disable_search||this.form_field.options.length<=this.disable_search_threshold?(this.search_field[0].readOnly=!0,this.container.addClass("chosen-container-single-nosearch")):(this.search_field[0].readOnly=!1,this.container.removeClass("chosen-container-single-nosearch"))),this.update_results_content(this.results_option_build({first:!0})),this.search_field_disabled(),this.show_search_field_default(),this.search_field_scale(),this.parsing=!1},n.prototype.result_do_highlight=function(t){var e,s,i,n,r;if(t.length){if(this.result_clear_highlight(),this.result_highlight=t,this.result_highlight.addClass("highlighted"),i=parseInt(this.search_results.css("maxHeight"),10),r=this.search_results.scrollTop(),n=i+r,s=this.result_highlight.position().top+this.search_results.scrollTop(),(e=s+this.result_highlight.outerHeight())>=n)return this.search_results.scrollTop(e-i>0?e-i:0);if(s<r)return this.search_results.scrollTop(s)}},n.prototype.result_clear_highlight=function(){return this.result_highlight&&this.result_highlight.removeClass("highlighted"),this.result_highlight=null},n.prototype.results_show=function(){return this.is_multiple&&this.max_selected_options<=this.choices_count()?(this.form_field_jq.trigger("chosen:maxselected",{chosen:this}),!1):(this.container.addClass("chosen-with-drop"),this.results_showing=!0,this.search_field.focus(),this.search_field.val(this.get_search_field_value()),this.winnow_results(),this.form_field_jq.trigger("chosen:showing_dropdown",{chosen:this}))},n.prototype.update_results_content=function(t){return this.search_results.html(t)},n.prototype.results_hide=function(){return this.results_showing&&(this.result_clear_highlight(),this.container.removeClass("chosen-with-drop"),this.form_field_jq.trigger("chosen:hiding_dropdown",{chosen:this})),this.results_showing=!1},n.prototype.set_tab_index=function(t){var e;if(this.form_field.tabIndex)return e=this.form_field.tabIndex,this.form_field.tabIndex=-1,this.search_field[0].tabIndex=e},n.prototype.set_label_behavior=function(){if(this.form_field_label=this.form_field_jq.parents("label"),!this.form_field_label.length&&this.form_field.id.length&&(this.form_field_label=t("label[for='"+this.form_field.id+"']")),this.form_field_label.length>0)return this.form_field_label.on("click.chosen",this.label_click_handler)},n.prototype.show_search_field_default=function(){return this.is_multiple&&this.choices_count()<1&&!this.active_field?(this.search_field.val(this.default_text),this.search_field.addClass("default")):(this.search_field.val(""),this.search_field.removeClass("default"))},n.prototype.search_results_mouseup=function(e){var s;if((s=t(e.target).hasClass("active-result")?t(e.target):t(e.target).parents(".active-result").first()).length)return this.result_highlight=s,this.result_select(e),this.search_field.focus()},n.prototype.search_results_mouseover=function(e){var s;if(s=t(e.target).hasClass("active-result")?t(e.target):t(e.target).parents(".active-result").first())return this.result_do_highlight(s)},n.prototype.search_results_mouseout=function(e){if(t(e.target).hasClass("active-result")||t(e.target).parents(".active-result").first())return this.result_clear_highlight()},n.prototype.choice_build=function(e){var s,i;return s=t("<li />",{"class":"search-choice"}).html("<span>"+this.choice_label(e)+"</span>"),e.disabled?s.addClass("search-choice-disabled"):((i=t("<a />",{"class":"search-choice-close","data-option-array-index":e.array_index})).on("click.chosen",function(t){return function(e){return t.choice_destroy_link_click(e)}}(this)),s.append(i)),this.search_container.before(s)},n.prototype.choice_destroy_link_click=function(e){if(e.preventDefault(),e.stopPropagation(),!this.is_disabled)return this.choice_destroy(t(e.target))},n.prototype.choice_destroy=function(t){if(this.result_deselect(t[0].getAttribute("data-option-array-index")))return this.active_field?this.search_field.focus():this.show_search_field_default(),this.is_multiple&&this.choices_count()>0&&this.get_search_field_value().length<1&&this.results_hide(),t.parents("li").first().remove(),this.search_field_scale()},n.prototype.results_reset=function(){if(this.reset_single_select_options(),this.form_field.options[0].selected=!0,this.single_set_selected_text(),this.show_search_field_default(),this.results_reset_cleanup(),this.trigger_form_field_change(),this.active_field)return this.results_hide()},n.prototype.results_reset_cleanup=function(){return this.current_selectedIndex=this.form_field.selectedIndex,this.selected_item.find("abbr").remove()},n.prototype.result_select=function(t){var e,s;if(this.result_highlight)return e=this.result_highlight,this.result_clear_highlight(),this.is_multiple&&this.max_selected_options<=this.choices_count()?(this.form_field_jq.trigger("chosen:maxselected",{chosen:this}),!1):(this.is_multiple?e.removeClass("active-result"):this.reset_single_select_options(),e.addClass("result-selected"),s=this.results_data[e[0].getAttribute("data-option-array-index")],s.selected=!0,this.form_field.options[s.options_index].selected=!0,this.selected_option_count=null,this.is_multiple?this.choice_build(s):this.single_set_selected_text(this.choice_label(s)),this.is_multiple&&(!this.hide_results_on_select||t.metaKey||t.ctrlKey)?t.metaKey||t.ctrlKey?this.winnow_results({skip_highlight:!0}):(this.search_field.val(""),this.winnow_results()):(this.results_hide(),this.show_search_field_default()),(this.is_multiple||this.form_field.selectedIndex!==this.current_selectedIndex)&&this.trigger_form_field_change({selected:this.form_field.options[s.options_index].value}),this.current_selectedIndex=this.form_field.selectedIndex,t.preventDefault(),this.search_field_scale())},n.prototype.single_set_selected_text=function(t){return null==t&&(t=this.default_text),t===this.default_text?this.selected_item.addClass("chosen-default"):(this.single_deselect_control_build(),this.selected_item.removeClass("chosen-default")),this.selected_item.find("span").html(t)},n.prototype.result_deselect=function(t){var e;return e=this.results_data[t],!this.form_field.options[e.options_index].disabled&&(e.selected=!1,this.form_field.options[e.options_index].selected=!1,this.selected_option_count=null,this.result_clear_highlight(),this.results_showing&&this.winnow_results(),this.trigger_form_field_change({deselected:this.form_field.options[e.options_index].value}),this.search_field_scale(),!0)},n.prototype.single_deselect_control_build=function(){if(this.allow_single_deselect)return this.selected_item.find("abbr").length||this.selected_item.find("span").first().after('<abbr class="search-choice-close"></abbr>'),this.selected_item.addClass("chosen-single-with-deselect")},n.prototype.get_search_field_value=function(){return this.search_field.val()},n.prototype.get_search_text=function(){return t.trim(this.get_search_field_value())},n.prototype.escape_html=function(e){return t("<div/>").text(e).html()},n.prototype.winnow_results_set_highlight=function(){var t,e;if(e=this.is_multiple?[]:this.search_results.find(".result-selected.active-result"),null!=(t=e.length?e.first():this.search_results.find(".active-result").first()))return this.result_do_highlight(t)},n.prototype.no_results=function(t){var e;return e=this.get_no_results_html(t),this.search_results.append(e),this.form_field_jq.trigger("chosen:no_results",{chosen:this})},n.prototype.no_results_clear=function(){return this.search_results.find(".no-results").remove()},n.prototype.keydown_arrow=function(){var t;return this.results_showing&&this.result_highlight?(t=this.result_highlight.nextAll("li.active-result").first())?this.result_do_highlight(t):void 0:this.results_show()},n.prototype.keyup_arrow=function(){var t;return this.results_showing||this.is_multiple?this.result_highlight?(t=this.result_highlight.prevAll("li.active-result")).length?this.result_do_highlight(t.first()):(this.choices_count()>0&&this.results_hide(),this.result_clear_highlight()):void 0:this.results_show()},n.prototype.keydown_backstroke=function(){var t;return this.pending_backstroke?(this.choice_destroy(this.pending_backstroke.find("a").first()),this.clear_backstroke()):(t=this.search_container.siblings("li.search-choice").last()).length&&!t.hasClass("search-choice-disabled")?(this.pending_backstroke=t,this.single_backstroke_delete?this.keydown_backstroke():this.pending_backstroke.addClass("search-choice-focus")):void 0},n.prototype.clear_backstroke=function(){return this.pending_backstroke&&this.pending_backstroke.removeClass("search-choice-focus"),this.pending_backstroke=null},n.prototype.search_field_scale=function(){var e,s,i,n,r,o,h;if(this.is_multiple){for(r={position:"absolute",left:"-1000px",top:"-1000px",display:"none",whiteSpace:"pre"},s=0,i=(o=["fontSize","fontStyle","fontWeight","fontFamily","lineHeight","textTransform","letterSpacing"]).length;s<i;s++)r[n=o[s]]=this.search_field.css(n);return(e=t("<div />").css(r)).text(this.get_search_field_value()),t("body").append(e),h=e.width()+25,e.remove(),this.container.is(":visible")&&(h=Math.min(this.container.outerWidth()-10,h)),this.search_field.width(h)}},n.prototype.trigger_form_field_change=function(t){return this.form_field_jq.trigger("input",t),this.form_field_jq.trigger("change",t)},n}()}).call(this);



/*! jQuery Validation Plugin - v1.19.3 - 1/9/2021
 * https://jqueryvalidation.org/
 * Copyright (c) 2021 Jörn Zaefferer; Licensed MIT */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){a.extend(a.fn,{validate:function(b){if(!this.length)return void(b&&b.debug&&window.console&&console.warn("Nothing selected, can't validate, returning nothing."));var c=a.data(this[0],"validator");return c?c:(this.attr("novalidate","novalidate"),c=new a.validator(b,this[0]),a.data(this[0],"validator",c),c.settings.onsubmit&&(this.on("click.validate",":submit",function(b){c.submitButton=b.currentTarget,a(this).hasClass("cancel")&&(c.cancelSubmit=!0),void 0!==a(this).attr("formnovalidate")&&(c.cancelSubmit=!0)}),this.on("submit.validate",function(b){function d(){var d,e;return c.submitButton&&(c.settings.submitHandler||c.formSubmitted)&&(d=a("<input type='hidden'/>").attr("name",c.submitButton.name).val(a(c.submitButton).val()).appendTo(c.currentForm)),!(c.settings.submitHandler&&!c.settings.debug)||(e=c.settings.submitHandler.call(c,c.currentForm,b),d&&d.remove(),void 0!==e&&e)}return c.settings.debug&&b.preventDefault(),c.cancelSubmit?(c.cancelSubmit=!1,d()):c.form()?c.pendingRequest?(c.formSubmitted=!0,!1):d():(c.focusInvalid(),!1)})),c)},valid:function(){var b,c,d;return a(this[0]).is("form")?b=this.validate().form():(d=[],b=!0,c=a(this[0].form).validate(),this.each(function(){b=c.element(this)&&b,b||(d=d.concat(c.errorList))}),c.errorList=d),b},rules:function(b,c){var d,e,f,g,h,i,j=this[0],k="undefined"!=typeof this.attr("contenteditable")&&"false"!==this.attr("contenteditable");if(null!=j&&(!j.form&&k&&(j.form=this.closest("form")[0],j.name=this.attr("name")),null!=j.form)){if(b)switch(d=a.data(j.form,"validator").settings,e=d.rules,f=a.validator.staticRules(j),b){case"add":a.extend(f,a.validator.normalizeRule(c)),delete f.messages,e[j.name]=f,c.messages&&(d.messages[j.name]=a.extend(d.messages[j.name],c.messages));break;case"remove":return c?(i={},a.each(c.split(/\s/),function(a,b){i[b]=f[b],delete f[b]}),i):(delete e[j.name],f)}return g=a.validator.normalizeRules(a.extend({},a.validator.classRules(j),a.validator.attributeRules(j),a.validator.dataRules(j),a.validator.staticRules(j)),j),g.required&&(h=g.required,delete g.required,g=a.extend({required:h},g)),g.remote&&(h=g.remote,delete g.remote,g=a.extend(g,{remote:h})),g}}});var b=function(a){return a.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"")};a.extend(a.expr.pseudos||a.expr[":"],{blank:function(c){return!b(""+a(c).val())},filled:function(c){var d=a(c).val();return null!==d&&!!b(""+d)},unchecked:function(b){return!a(b).prop("checked")}}),a.validator=function(b,c){this.settings=a.extend(!0,{},a.validator.defaults,b),this.currentForm=c,this.init()},a.validator.format=function(b,c){return 1===arguments.length?function(){var c=a.makeArray(arguments);return c.unshift(b),a.validator.format.apply(this,c)}:void 0===c?b:(arguments.length>2&&c.constructor!==Array&&(c=a.makeArray(arguments).slice(1)),c.constructor!==Array&&(c=[c]),a.each(c,function(a,c){b=b.replace(new RegExp("\\{"+a+"\\}","g"),function(){return c})}),b)},a.extend(a.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",pendingClass:"pending",validClass:"valid",errorElement:"label",focusCleanup:!1,focusInvalid:!0,errorContainer:a([]),errorLabelContainer:a([]),onsubmit:!0,ignore:":hidden",ignoreTitle:!1,onfocusin:function(a){this.lastActive=a,this.settings.focusCleanup&&(this.settings.unhighlight&&this.settings.unhighlight.call(this,a,this.settings.errorClass,this.settings.validClass),this.hideThese(this.errorsFor(a)))},onfocusout:function(a){this.checkable(a)||!(a.name in this.submitted)&&this.optional(a)||this.element(a)},onkeyup:function(b,c){var d=[16,17,18,20,35,36,37,38,39,40,45,144,225];9===c.which&&""===this.elementValue(b)||a.inArray(c.keyCode,d)!==-1||(b.name in this.submitted||b.name in this.invalid)&&this.element(b)},onclick:function(a){a.name in this.submitted?this.element(a):a.parentNode.name in this.submitted&&this.element(a.parentNode)},highlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).addClass(c).removeClass(d):a(b).addClass(c).removeClass(d)},unhighlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).removeClass(c).addClass(d):a(b).removeClass(c).addClass(d)}},setDefaults:function(b){a.extend(a.validator.defaults,b)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",equalTo:"Please enter the same value again.",maxlength:a.validator.format("Please enter no more than {0} characters."),minlength:a.validator.format("Please enter at least {0} characters."),rangelength:a.validator.format("Please enter a value between {0} and {1} characters long."),range:a.validator.format("Please enter a value between {0} and {1}."),max:a.validator.format("Please enter a value less than or equal to {0}."),min:a.validator.format("Please enter a value greater than or equal to {0}."),step:a.validator.format("Please enter a multiple of {0}.")},autoCreateRanges:!1,prototype:{init:function(){function b(b){var c="undefined"!=typeof a(this).attr("contenteditable")&&"false"!==a(this).attr("contenteditable");if(!this.form&&c&&(this.form=a(this).closest("form")[0],this.name=a(this).attr("name")),d===this.form){var e=a.data(this.form,"validator"),f="on"+b.type.replace(/^validate/,""),g=e.settings;g[f]&&!a(this).is(g.ignore)&&g[f].call(e,this,b)}}this.labelContainer=a(this.settings.errorLabelContainer),this.errorContext=this.labelContainer.length&&this.labelContainer||a(this.currentForm),this.containers=a(this.settings.errorContainer).add(this.settings.errorLabelContainer),this.submitted={},this.valueCache={},this.pendingRequest=0,this.pending={},this.invalid={},this.reset();var c,d=this.currentForm,e=this.groups={};a.each(this.settings.groups,function(b,c){"string"==typeof c&&(c=c.split(/\s/)),a.each(c,function(a,c){e[c]=b})}),c=this.settings.rules,a.each(c,function(b,d){c[b]=a.validator.normalizeRule(d)}),a(this.currentForm).on("focusin.validate focusout.validate keyup.validate",":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], [type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox'], [contenteditable], [type='button']",b).on("click.validate","select, option, [type='radio'], [type='checkbox']",b),this.settings.invalidHandler&&a(this.currentForm).on("invalid-form.validate",this.settings.invalidHandler)},form:function(){return this.checkForm(),a.extend(this.submitted,this.errorMap),this.invalid=a.extend({},this.errorMap),this.valid()||a(this.currentForm).triggerHandler("invalid-form",[this]),this.showErrors(),this.valid()},checkForm:function(){this.prepareForm();for(var a=0,b=this.currentElements=this.elements();b[a];a++)this.check(b[a]);return this.valid()},element:function(b){var c,d,e=this.clean(b),f=this.validationTargetFor(e),g=this,h=!0;return void 0===f?delete this.invalid[e.name]:(this.prepareElement(f),this.currentElements=a(f),d=this.groups[f.name],d&&a.each(this.groups,function(a,b){b===d&&a!==f.name&&(e=g.validationTargetFor(g.clean(g.findByName(a))),e&&e.name in g.invalid&&(g.currentElements.push(e),h=g.check(e)&&h))}),c=this.check(f)!==!1,h=h&&c,c?this.invalid[f.name]=!1:this.invalid[f.name]=!0,this.numberOfInvalids()||(this.toHide=this.toHide.add(this.containers)),this.showErrors(),a(b).attr("aria-invalid",!c)),h},showErrors:function(b){if(b){var c=this;a.extend(this.errorMap,b),this.errorList=a.map(this.errorMap,function(a,b){return{message:a,element:c.findByName(b)[0]}}),this.successList=a.grep(this.successList,function(a){return!(a.name in b)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){a.fn.resetForm&&a(this.currentForm).resetForm(),this.invalid={},this.submitted={},this.prepareForm(),this.hideErrors();var b=this.elements().removeData("previousValue").removeAttr("aria-invalid");this.resetElements(b)},resetElements:function(a){var b;if(this.settings.unhighlight)for(b=0;a[b];b++)this.settings.unhighlight.call(this,a[b],this.settings.errorClass,""),this.findByName(a[b].name).removeClass(this.settings.validClass);else a.removeClass(this.settings.errorClass).removeClass(this.settings.validClass)},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(a){var b,c=0;for(b in a)void 0!==a[b]&&null!==a[b]&&a[b]!==!1&&c++;return c},hideErrors:function(){this.hideThese(this.toHide)},hideThese:function(a){a.not(this.containers).text(""),this.addWrapper(a).hide()},valid:function(){return 0===this.size()},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{a(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").trigger("focus").trigger("focusin")}catch(b){}},findLastActive:function(){var b=this.lastActive;return b&&1===a.grep(this.errorList,function(a){return a.element.name===b.name}).length&&b},elements:function(){var b=this,c={};return a(this.currentForm).find("input, select, textarea, [contenteditable]").not(":submit, :reset, :image, :disabled").not(this.settings.ignore).filter(function(){var d=this.name||a(this).attr("name"),e="undefined"!=typeof a(this).attr("contenteditable")&&"false"!==a(this).attr("contenteditable");return!d&&b.settings.debug&&window.console&&console.error("%o has no name assigned",this),e&&(this.form=a(this).closest("form")[0],this.name=d),this.form===b.currentForm&&(!(d in c||!b.objectLength(a(this).rules()))&&(c[d]=!0,!0))})},clean:function(b){return a(b)[0]},errors:function(){var b=this.settings.errorClass.split(" ").join(".");return a(this.settings.errorElement+"."+b,this.errorContext)},resetInternals:function(){this.successList=[],this.errorList=[],this.errorMap={},this.toShow=a([]),this.toHide=a([])},reset:function(){this.resetInternals(),this.currentElements=a([])},prepareForm:function(){this.reset(),this.toHide=this.errors().add(this.containers)},prepareElement:function(a){this.reset(),this.toHide=this.errorsFor(a)},elementValue:function(b){var c,d,e=a(b),f=b.type,g="undefined"!=typeof e.attr("contenteditable")&&"false"!==e.attr("contenteditable");return"radio"===f||"checkbox"===f?this.findByName(b.name).filter(":checked").val():"number"===f&&"undefined"!=typeof b.validity?b.validity.badInput?"NaN":e.val():(c=g?e.text():e.val(),"file"===f?"C:\\fakepath\\"===c.substr(0,12)?c.substr(12):(d=c.lastIndexOf("/"),d>=0?c.substr(d+1):(d=c.lastIndexOf("\\"),d>=0?c.substr(d+1):c)):"string"==typeof c?c.replace(/\r/g,""):c)},check:function(b){b=this.validationTargetFor(this.clean(b));var c,d,e,f,g=a(b).rules(),h=a.map(g,function(a,b){return b}).length,i=!1,j=this.elementValue(b);"function"==typeof g.normalizer?f=g.normalizer:"function"==typeof this.settings.normalizer&&(f=this.settings.normalizer),f&&(j=f.call(b,j),delete g.normalizer);for(d in g){e={method:d,parameters:g[d]};try{if(c=a.validator.methods[d].call(this,j,b,e.parameters),"dependency-mismatch"===c&&1===h){i=!0;continue}if(i=!1,"pending"===c)return void(this.toHide=this.toHide.not(this.errorsFor(b)));if(!c)return this.formatAndAdd(b,e),!1}catch(k){throw this.settings.debug&&window.console&&console.log("Exception occurred when checking element "+b.id+", check the '"+e.method+"' method.",k),k instanceof TypeError&&(k.message+=".  Exception occurred when checking element "+b.id+", check the '"+e.method+"' method."),k}}if(!i)return this.objectLength(g)&&this.successList.push(b),!0},customDataMessage:function(b,c){return a(b).data("msg"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase())||a(b).data("msg")},customMessage:function(a,b){var c=this.settings.messages[a];return c&&(c.constructor===String?c:c[b])},findDefined:function(){for(var a=0;a<arguments.length;a++)if(void 0!==arguments[a])return arguments[a]},defaultMessage:function(b,c){"string"==typeof c&&(c={method:c});var d=this.findDefined(this.customMessage(b.name,c.method),this.customDataMessage(b,c.method),!this.settings.ignoreTitle&&b.title||void 0,a.validator.messages[c.method],"<strong>Warning: No message defined for "+b.name+"</strong>"),e=/\$?\{(\d+)\}/g;return"function"==typeof d?d=d.call(this,c.parameters,b):e.test(d)&&(d=a.validator.format(d.replace(e,"{$1}"),c.parameters)),d},formatAndAdd:function(a,b){var c=this.defaultMessage(a,b);this.errorList.push({message:c,element:a,method:b.method}),this.errorMap[a.name]=c,this.submitted[a.name]=c},addWrapper:function(a){return this.settings.wrapper&&(a=a.add(a.parent(this.settings.wrapper))),a},defaultShowErrors:function(){var a,b,c;for(a=0;this.errorList[a];a++)c=this.errorList[a],this.settings.highlight&&this.settings.highlight.call(this,c.element,this.settings.errorClass,this.settings.validClass),this.showLabel(c.element,c.message);if(this.errorList.length&&(this.toShow=this.toShow.add(this.containers)),this.settings.success)for(a=0;this.successList[a];a++)this.showLabel(this.successList[a]);if(this.settings.unhighlight)for(a=0,b=this.validElements();b[a];a++)this.settings.unhighlight.call(this,b[a],this.settings.errorClass,this.settings.validClass);this.toHide=this.toHide.not(this.toShow),this.hideErrors(),this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return a(this.errorList).map(function(){return this.element})},showLabel:function(b,c){var d,e,f,g,h=this.errorsFor(b),i=this.idOrName(b),j=a(b).attr("aria-describedby");h.length?(h.removeClass(this.settings.validClass).addClass(this.settings.errorClass),h.html(c)):(h=a("<"+this.settings.errorElement+">").attr("id",i+"-error").addClass(this.settings.errorClass).html(c||""),d=h,this.settings.wrapper&&(d=h.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()),this.labelContainer.length?this.labelContainer.append(d):this.settings.errorPlacement?this.settings.errorPlacement.call(this,d,a(b)):d.insertAfter(b),h.is("label")?h.attr("for",i):0===h.parents("label[for='"+this.escapeCssMeta(i)+"']").length&&(f=h.attr("id"),j?j.match(new RegExp("\\b"+this.escapeCssMeta(f)+"\\b"))||(j+=" "+f):j=f,a(b).attr("aria-describedby",j),e=this.groups[b.name],e&&(g=this,a.each(g.groups,function(b,c){c===e&&a("[name='"+g.escapeCssMeta(b)+"']",g.currentForm).attr("aria-describedby",h.attr("id"))})))),!c&&this.settings.success&&(h.text(""),"string"==typeof this.settings.success?h.addClass(this.settings.success):this.settings.success(h,b)),this.toShow=this.toShow.add(h)},errorsFor:function(b){var c=this.escapeCssMeta(this.idOrName(b)),d=a(b).attr("aria-describedby"),e="label[for='"+c+"'], label[for='"+c+"'] *";return d&&(e=e+", #"+this.escapeCssMeta(d).replace(/\s+/g,", #")),this.errors().filter(e)},escapeCssMeta:function(a){return a.replace(/([\\!"#$%&'()*+,.\/:;<=>?@\[\]^`{|}~])/g,"\\$1")},idOrName:function(a){return this.groups[a.name]||(this.checkable(a)?a.name:a.id||a.name)},validationTargetFor:function(b){return this.checkable(b)&&(b=this.findByName(b.name)),a(b).not(this.settings.ignore)[0]},checkable:function(a){return/radio|checkbox/i.test(a.type)},findByName:function(b){return a(this.currentForm).find("[name='"+this.escapeCssMeta(b)+"']")},getLength:function(b,c){switch(c.nodeName.toLowerCase()){case"select":return a("option:selected",c).length;case"input":if(this.checkable(c))return this.findByName(c.name).filter(":checked").length}return b.length},depend:function(a,b){return!this.dependTypes[typeof a]||this.dependTypes[typeof a](a,b)},dependTypes:{"boolean":function(a){return a},string:function(b,c){return!!a(b,c.form).length},"function":function(a,b){return a(b)}},optional:function(b){var c=this.elementValue(b);return!a.validator.methods.required.call(this,c,b)&&"dependency-mismatch"},startRequest:function(b){this.pending[b.name]||(this.pendingRequest++,a(b).addClass(this.settings.pendingClass),this.pending[b.name]=!0)},stopRequest:function(b,c){this.pendingRequest--,this.pendingRequest<0&&(this.pendingRequest=0),delete this.pending[b.name],a(b).removeClass(this.settings.pendingClass),c&&0===this.pendingRequest&&this.formSubmitted&&this.form()?(a(this.currentForm).submit(),this.submitButton&&a("input:hidden[name='"+this.submitButton.name+"']",this.currentForm).remove(),this.formSubmitted=!1):!c&&0===this.pendingRequest&&this.formSubmitted&&(a(this.currentForm).triggerHandler("invalid-form",[this]),this.formSubmitted=!1)},previousValue:function(b,c){return c="string"==typeof c&&c||"remote",a.data(b,"previousValue")||a.data(b,"previousValue",{old:null,valid:!0,message:this.defaultMessage(b,{method:c})})},destroy:function(){this.resetForm(),a(this.currentForm).off(".validate").removeData("validator").find(".validate-equalTo-blur").off(".validate-equalTo").removeClass("validate-equalTo-blur").find(".validate-lessThan-blur").off(".validate-lessThan").removeClass("validate-lessThan-blur").find(".validate-lessThanEqual-blur").off(".validate-lessThanEqual").removeClass("validate-lessThanEqual-blur").find(".validate-greaterThanEqual-blur").off(".validate-greaterThanEqual").removeClass("validate-greaterThanEqual-blur").find(".validate-greaterThan-blur").off(".validate-greaterThan").removeClass("validate-greaterThan-blur")}},classRuleSettings:{required:{required:!0},email:{email:!0},url:{url:!0},date:{date:!0},dateISO:{dateISO:!0},number:{number:!0},digits:{digits:!0},creditcard:{creditcard:!0}},addClassRules:function(b,c){b.constructor===String?this.classRuleSettings[b]=c:a.extend(this.classRuleSettings,b)},classRules:function(b){var c={},d=a(b).attr("class");return d&&a.each(d.split(" "),function(){this in a.validator.classRuleSettings&&a.extend(c,a.validator.classRuleSettings[this])}),c},normalizeAttributeRule:function(a,b,c,d){/min|max|step/.test(c)&&(null===b||/number|range|text/.test(b))&&(d=Number(d),isNaN(d)&&(d=void 0)),d||0===d?a[c]=d:b===c&&"range"!==b&&(a[c]=!0)},attributeRules:function(b){var c,d,e={},f=a(b),g=b.getAttribute("type");for(c in a.validator.methods)"required"===c?(d=b.getAttribute(c),""===d&&(d=!0),d=!!d):d=f.attr(c),this.normalizeAttributeRule(e,g,c,d);return e.maxlength&&/-1|2147483647|524288/.test(e.maxlength)&&delete e.maxlength,e},dataRules:function(b){var c,d,e={},f=a(b),g=b.getAttribute("type");for(c in a.validator.methods)d=f.data("rule"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase()),""===d&&(d=!0),this.normalizeAttributeRule(e,g,c,d);return e},staticRules:function(b){var c={},d=a.data(b.form,"validator");return d.settings.rules&&(c=a.validator.normalizeRule(d.settings.rules[b.name])||{}),c},normalizeRules:function(b,c){return a.each(b,function(d,e){if(e===!1)return void delete b[d];if(e.param||e.depends){var f=!0;switch(typeof e.depends){case"string":f=!!a(e.depends,c.form).length;break;case"function":f=e.depends.call(c,c)}f?b[d]=void 0===e.param||e.param:(a.data(c.form,"validator").resetElements(a(c)),delete b[d])}}),a.each(b,function(a,d){b[a]="function"==typeof d&&"normalizer"!==a?d(c):d}),a.each(["minlength","maxlength"],function(){b[this]&&(b[this]=Number(b[this]))}),a.each(["rangelength","range"],function(){var a;b[this]&&(Array.isArray(b[this])?b[this]=[Number(b[this][0]),Number(b[this][1])]:"string"==typeof b[this]&&(a=b[this].replace(/[\[\]]/g,"").split(/[\s,]+/),b[this]=[Number(a[0]),Number(a[1])]))}),a.validator.autoCreateRanges&&(null!=b.min&&null!=b.max&&(b.range=[b.min,b.max],delete b.min,delete b.max),null!=b.minlength&&null!=b.maxlength&&(b.rangelength=[b.minlength,b.maxlength],delete b.minlength,delete b.maxlength)),b},normalizeRule:function(b){if("string"==typeof b){var c={};a.each(b.split(/\s/),function(){c[this]=!0}),b=c}return b},addMethod:function(b,c,d){a.validator.methods[b]=c,a.validator.messages[b]=void 0!==d?d:a.validator.messages[b],c.length<3&&a.validator.addClassRules(b,a.validator.normalizeRule(b))},methods:{required:function(b,c,d){if(!this.depend(d,c))return"dependency-mismatch";if("select"===c.nodeName.toLowerCase()){var e=a(c).val();return e&&e.length>0}return this.checkable(c)?this.getLength(b,c)>0:void 0!==b&&null!==b&&b.length>0},email:function(a,b){return this.optional(b)||/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(a)},url:function(a,b){return this.optional(b)||/^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z0-9\u00a1-\uffff][a-z0-9\u00a1-\uffff_-]{0,62})?[a-z0-9\u00a1-\uffff]\.)+(?:[a-z\u00a1-\uffff]{2,}\.?))(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test(a)},date:function(){var a=!1;return function(b,c){return a||(a=!0,this.settings.debug&&window.console&&console.warn("The `date` method is deprecated and will be removed in version '2.0.0'.\nPlease don't use it, since it relies on the Date constructor, which\nbehaves very differently across browsers and locales. Use `dateISO`\ninstead or one of the locale specific methods in `localizations/`\nand `additional-methods.js`.")),this.optional(c)||!/Invalid|NaN/.test(new Date(b).toString())}}(),dateISO:function(a,b){return this.optional(b)||/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(a)},number:function(a,b){return this.optional(b)||/^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(a)},digits:function(a,b){return this.optional(b)||/^\d+$/.test(a)},minlength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d>=c},maxlength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d<=c},rangelength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d>=c[0]&&d<=c[1]},min:function(a,b,c){return this.optional(b)||a>=c},max:function(a,b,c){return this.optional(b)||a<=c},range:function(a,b,c){return this.optional(b)||a>=c[0]&&a<=c[1]},step:function(b,c,d){var e,f=a(c).attr("type"),g="Step attribute on input type "+f+" is not supported.",h=["text","number","range"],i=new RegExp("\\b"+f+"\\b"),j=f&&!i.test(h.join()),k=function(a){var b=(""+a).match(/(?:\.(\d+))?$/);return b&&b[1]?b[1].length:0},l=function(a){return Math.round(a*Math.pow(10,e))},m=!0;if(j)throw new Error(g);return e=k(d),(k(b)>e||l(b)%l(d)!==0)&&(m=!1),this.optional(c)||m},equalTo:function(b,c,d){var e=a(d);return this.settings.onfocusout&&e.not(".validate-equalTo-blur").length&&e.addClass("validate-equalTo-blur").on("blur.validate-equalTo",function(){a(c).valid()}),b===e.val()},remote:function(b,c,d,e){if(this.optional(c))return"dependency-mismatch";e="string"==typeof e&&e||"remote";var f,g,h,i=this.previousValue(c,e);return this.settings.messages[c.name]||(this.settings.messages[c.name]={}),i.originalMessage=i.originalMessage||this.settings.messages[c.name][e],this.settings.messages[c.name][e]=i.message,d="string"==typeof d&&{url:d}||d,h=a.param(a.extend({data:b},d.data)),i.old===h?i.valid:(i.old=h,f=this,this.startRequest(c),g={},g[c.name]=b,a.ajax(a.extend(!0,{mode:"abort",port:"validate"+c.name,dataType:"json",data:g,context:f.currentForm,success:function(a){var d,g,h,j=a===!0||"true"===a;f.settings.messages[c.name][e]=i.originalMessage,j?(h=f.formSubmitted,f.resetInternals(),f.toHide=f.errorsFor(c),f.formSubmitted=h,f.successList.push(c),f.invalid[c.name]=!1,f.showErrors()):(d={},g=a||f.defaultMessage(c,{method:e,parameters:b}),d[c.name]=i.message=g,f.invalid[c.name]=!0,f.showErrors(d)),i.valid=j,f.stopRequest(c,j)}},d)),"pending")}}});var c,d={};return a.ajaxPrefilter?a.ajaxPrefilter(function(a,b,c){var e=a.port;"abort"===a.mode&&(d[e]&&d[e].abort(),d[e]=c)}):(c=a.ajax,a.ajax=function(b){var e=("mode"in b?b:a.ajaxSettings).mode,f=("port"in b?b:a.ajaxSettings).port;return"abort"===e?(d[f]&&d[f].abort(),d[f]=c.apply(this,arguments),d[f]):c.apply(this,arguments)}),a});

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
    
    jQuery('.set-draft').on('click', function (event) {
		event.preventDefault();
			job_id = jQuery(this).attr("data-id");
			job_name = jQuery(this).attr("data-itemName");
            job_action = jQuery(this).attr("data-itemAction");
			
            jQuery(".set-delete").attr('data-id', job_id);
            jQuery("#item_name").text(job_name);
	   }
    );

    jQuery('.set-delete').on('click', 
        function (event) {
            event.preventDefault();
            var deleteButtonWidth = jQuery( this ).width()
            if ( jQuery( this ).hasClass( "delete-confirm" ) && !jQuery( this ).hasClass( "clicked" ) && !jQuery( this ).hasClass( "sent" )  ) {

                var job_id = jQuery(this).attr("data-id");
                nonce = ajax_login_object.ctn_nonce;
                var adminURL = ajax_login_object.ajaxurl;
                var deleteButton = jQuery( this );
                var here = this;

                deleteButton.html('<i class="fa fa-refresh fa-spin"></i>').width(deleteButtonWidth);


                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : adminURL,
                    data : {action: "remove_job", job_id : job_id, security: nonce},
                    success: function(response) {
                        if(response.status == "success") {
                            var id = response.job_id;
                            jQuery('#row-'+id).find('td, th').fadeOut('fast', 
                                function(id){ 
                                    jQuery('#row-'+id).remove();                    
                                });  
                            deleteButton.html('Deleted <i class="fa fa-check"></i>').width('auto').removeClass('clicked').attr("disabled", true);;
                        } else {
                             alert("This item could not be deleted")
                        }
                    }
                }) 
            } else {
                jQuery(this).html('Confirm').addClass('delete-confirm').addClass('clicked').delay(1000)
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

    jQuery(document).on("hidden.bs.modal", "#deleteModal", function () {
        jQuery(".set-delete").attr('data-id', '');
        jQuery("#item_name").text('');
        jQuery(".set-delete").removeClass('clicked').removeClass('delete-confirm').html('Delete').attr("disabled", false);
      });

});

if (jQuery("#ship-about").length) {
  var aboutDiv = jQuery("#ship-about").offset().top; //gets offset of header
  var height = jQuery("#ship-about").outerHeight(); //gets height of header

  jQuery(window).scroll(function(){
      if(jQuery(window).scrollTop() > (aboutDiv + height)){
        jQuery('#ship-menu .mobile-label').addClass('open');
        jQuery('#ship-menu').addClass('stuck');
      }
      else{
        jQuery('#ship-menu, #ship-menu .mobile-label').removeClass('open');
        jQuery('#ship-menu').removeClass('stuck');
      }
  });
}

jQuery(document).ready(function() {
    var $cqowl = jQuery(".cq-owl-carousel");
    $cqowl.each(function (index) {

        var items_no = jQuery(this).attr('data-items') != undefined ? jQuery(this).attr('data-items') : 3;
        var mobile_items = jQuery(this).attr('data-mobile-items') != undefined ? jQuery(this).attr('data-mobile-items') : 2;
        var data_autoscroll = jQuery(this).attr('data-autoscroll') != undefined ? jQuery(this).attr('data-autoscroll') : 'false';
        var autoscroll = (data_autoscroll === "true");
        var data_autoscroll_timing = jQuery(this).attr('data-scrolltiming') != undefined ? jQuery(this).attr('data-scrolltiming') : 2;
        var autoScrollTimeout = Number(data_autoscroll_timing) * 1000;

        jQuery(this).owlCarousel({
          items : items_no, //10 items above 1000px browser width
          margin: 80,
          responsiveClass:true,
          autoplay: autoscroll,
          autoplayTimeout: autoScrollTimeout,
          autoplayHoverPause:true,
          //navText: ['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],
          navText: [''],	  
            responsive:{
            0:{
                items: mobile_items,
                nav:false,
            },
            600:{
                items:3,
                nav:false,
            },
            1000:{
                items:items_no,
                nav:true,
                loop:true,
            }
        }
      });
    });
    
    $cqowl.on('mouseleave',function(){
    $cqowl.trigger('stop.owl.autoplay'); //this is main line to fix it
    $cqowl.trigger('play.owl.autoplay', 500);
})
});