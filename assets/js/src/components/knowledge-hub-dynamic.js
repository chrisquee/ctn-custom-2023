jQuery(function($) {   
    var closeHeight = '200px'; /* Default "closed" height */
    var addedSpace = 60;
    var moreText 	= 'Read More <span class="fa fa-angle-down"></span>'; /* Default "Read More" text */
    var lessText	= 'Read Less <span class="fa fa-angle-up"></span>'; /* Default "Read Less" text */
    var duration	= '1000'; /* Animation duration */
    var easing = 'linear'; /* Animation easing option */

	// Limit height of .entry-content div
	$('.cruise-ship-meta-wrap').each(function() {
		
		// Set data attribute to record original height
		var current = $(this).children('.meta-content');
        if (current.height() > 200) {
            current.data('fullHeight', current.height()).css('height', closeHeight);

            // Insert "Read More" link
            current.after('<a href="javascript:void(0);" class="more-link closed">' + moreText + '</a>');
        }

	});
    
    $('.agenda-time-content .synopsis .synopsis-wrap').each(function() {
		
		closeHeight = '72px';
        addedSpace = 10;
		var current = $(this);
        if (current.height() > 72) {
            current.data('fullHeight', current.height()).css('height', closeHeight);

            // Insert "Read More" link
            current.after('<a href="javascript:void(0);" class="more-link closed">' + moreText + '</a>');
        }

	});
  
  // Link functinoality
	var openSlider = function() {
		link = $(this);
		var openHeight = link.prev('.meta-content').data('fullHeight') + addedSpace + 'px';
		link.prev('.meta-content').animate({'height': openHeight}, {duration: duration }, easing);
		link.html(lessText).addClass('open').removeClass('closed');
        //link.children('span').removeClass('fa-angle-down').addClass('fa-angle-up');
    	link.unbind('click', openSlider);
		link.bind('click', closeSlider);
	}

	var closeSlider = function() {
		link = $(this);
    	link.prev('.meta-content').animate({'height': closeHeight}, {duration: duration }, easing);
		link.html(moreText).addClass('closed').removeClass('open');
        //link.children('span').removeClass('fa-angle-up').addClass('fa-angle-down');
		link.unbind('click');
		link.bind('click', openSlider);
	}
  
	$('.more-link').bind('click', openSlider);
    
    var moreCruiseLines = function() {
        
        var moreText = 'See More <span class="fa fa-angle-down"></span>';
        var lessText = 'See Less <span class="fa fa-angle-up"></span>';
        
        link = $(this);
        link.prev('div.cruise-lines-see-more').slideToggle(1000);
        link.toggleClass('closed open');
        link.hasClass('closed') ? link.html(moreText) : link.html(lessText);
                        
    }
    
    $('.more-cruise-lines').bind('click', moreCruiseLines);
    
    $('#ship-menu .mobile-label').on('click', function() {
        $('#ship-menu .mobile-label span').toggleClass('fa-bars fa-close');
        $('#ship-menu').toggleClass('open');
    });
    
    $('#ship-menu ul li a').on('click', function() {
        $('#ship-menu .mobile-label span').toggleClass('fa-bars fa-close');
        $('#ship-menu').toggleClass('open');
    });
    
    if ($("#ship-about").length) {
      
        var aboutDiv = $("#ship-about").offset().top; //gets offset of header
        var height = $("#ship-about").outerHeight(); //gets height of header
        var aboutST = aboutDiv + height;

        $(document).on('scroll', function(){
            
            if($(window).scrollTop() > aboutST){
                $('#ship-menu .mobile-label').addClass('open');
                $('#ship-menu').addClass('stuck');
            } else {
                $('#ship-menu, #ship-menu .mobile-label').removeClass('open');
                $('#ship-menu').removeClass('stuck');
            }
        });
    }
});