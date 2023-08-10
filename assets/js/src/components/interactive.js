import {createCookie, readCookie} from './cookies';
import {owl_init, fancybox_init} from './carousels';

jQuery(document).ready(function($) {    

    if ($('body.single-cq_interactive_item').length > 0) {
        swipeInfo();
    }
    
    $('.single-cq_interactive_item ol#hotspots li.hotspot').click(function(event) {
	   
	   event.preventDefault();
        
        var hotspot = $(this);
		var content_id = $(this).data('content_id');
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
        $('.single-cq_interactive_item ol#hotspots li.hotspot').removeClass('active');
        $(hotspot).addClass('active');
		$("#interactive_content_box").addClass('active').fadeIn(300, function() {
			$("#interactive_content_container").html("<div class='animation-image-container'><div class='animation-image'></div></div>");
			$('html,body').css("overflow","hidden");
			//window.history.pushState('#viewinginfo', title, url);
			var thisRequest = $.post(ajax_url, data, function(response){
            	$("#interactive_content_container").fadeIn(300).html(response);
            
                fancybox_init();    
                owl_init();
        	});
		});
        
		$("body").css("overflow", "hidden");
		
		window.onpopstate = function() {
    		$("#interactive_content_box").fadeIn(300);
    		$('html,body').css("overflow","auto");
			$("#interactive_content_container").html('');
		}
		
        $(".close-icon .popup-close").click(function () {
			$("#interactive_content_box").fadeIn(300);
			//$(".team-popup-container").fadeOut(300);
			$("html,body").css("overflow", "auto");
			$("#interactive_content_container").html('');
        })
	})
    
    $("#interactive_content_box .close-icon").on('click', function() {
        $("#interactive_content_box").removeClass('active');
        $('.single-cq_interactive_item ol#hotspots li.hotspot').removeClass('active');
    });
    
    $('.cf7-check-all').click(function(event) {
        
        event.preventDefault();
        
        var checkboxes = $(this).data('checkbox');
        $('input[name="'+checkboxes+'[]"]').prop('checked', 'checked');
        
    });
    
});

function swipeInfo() {
    var cookieStatus = readCookie("swipeInfo");
    if (cookieStatus != 1 && $(window).width() < 769) {
        $("#mobile-scroll").fadeIn(600);
        $("#mobile-scroll").fadeOut(4000);
        createCookie("swipeInfo", 1, 10)
       
    }
}