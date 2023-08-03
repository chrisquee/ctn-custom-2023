jQuery(function($) {

    /*let scrollTop = function() {
        let offset = $('#listing-filter').offset();
        let top = offset.top;
        $("html, body").animate({ scrollTop: top }, "slow");
    }*/

    /*$('.filter_top').on("click", function() {
        let test = $(this).closest('li').find('label');
        let checkbox = $(this).closest('li').find('input');

        let boolval = checkbox.is(":checked");

        if(boolval == false) {
            test.css({
                "background": "white",
                "color": "#D34E2E",
                "transition-duration": "0.5s"
            });
        } else {
            test.css({
                "background": "#D34E2E",
                "color": "white",
                "transition-duration": "0.5s"
            });
        }
        
        scrollTop();
    });*/

    $('#directory_keywords').on('keydown', function() {
        scrollTop();
    });
    
    $('.directory-content a').on('click', function(e) {
        if (!$('body').hasClass('logged-in') && $('body').hasClass('business-directory')) {
            e.preventDefault;
            $('.show_login').trigger('click');
            return false;
        }
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
    $("form#cqDirectoryFilter input, form#cqDirectoryFilter select").debounce('change keyup textInput input', function(event) {
        
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
        cq_loadmore_params.current_page = 1;

        $('form#cqDirectoryFilter input[type=checkbox]').each(function () {
            if (this.checked) {
                catArray[j] = $(this).val();
                j++;
            }
        });
        
        var country = $('form#cqDirectoryFilter select#filter_country').val();

        $.ajax(
        {
            type:    "POST",
            url:     ajax_login_object.ajaxurl,
            data:    ({ action: 'directory_filter', parent: parent, categories : catArray.toString(), keywords: keywords, country: country, per_page: per_page, page_number: 0 }),
            dataType: 'json',
            success: function(msg) {
                if (msg.result == 'success') {
                    $('#listing-wrapper').html(msg.content);
                    $('#listing-wrapper').fadeIn(300);
                    $('html,body').animate({
                        scrollTop: $("#directory-filter-listings").offset().top
                    });
                } else {
                    $('#listing-wrapper').html(msg.content);
                    $('#listing-wrapper').fadeIn(300);
                    resultEnd = true;
                    $('html,body').animate({
                        scrollTop: $("#directory-filter-listings").offset().top
                    });
                }
            }
        });

        return false;
     }, 500);
    
    var dirLoading = false;
	$(document).on('scroll', function(e) {
    
        var sTop = $(window).scrollTop();
		if ($('#directory-filter-listings').length) {
            
            var footerHeight = $('#main-footer').height();
            if(sTop > $('#directory-filter-listings').height()) {
                
                
                //$('#listing-wrapper').fadeOut(300);
                var catArray = new Array();
                var j = 0;
                var parent = $("form#cqDirectoryFilter #parent_category").val();
                var per_page = $('#listing-wrapper').attr('data-perpage');
                var keywords = $("form#cqDirectoryFilter #directory_keywords").val();
                var country = $('form#cqDirectoryFilter select#filter_country').val();
        
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
                    'keywords': keywords,
                    'country': country,
                    'per_page': 16,
                    'page_number' : cq_loadmore_params.current_page,
                    'loader': true
                };

                if(dirLoading == false && resultEnd == false) {
                    cq_loadmore_params.current_page++;
                    dirLoading = true;
                    $.ajax({
                        url : ajax_login_object.ajaxurl, // AJAX handler
                        data : data,
                        type : 'POST',
                        dataType: 'json',
                        beforeSend : function ( xhr ) {
                            //button.html('Loading... <i class="fa fa-refresh fa-spin fa-fw"></i>'); 
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
});
