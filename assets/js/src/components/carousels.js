export {owl_init, fancybox_init};

jQuery(document).ready(function() {
    owl_init();
    var $cqowl = jQuery(".cq-owl-carousel");
    $cqowl.each(function (index) {

        var items_no = jQuery(this).attr('data-items') != undefined ? jQuery(this).attr('data-items') : 3;
        var mobile_items = jQuery(this).attr('data-mobile-items') != undefined ? jQuery(this).attr('data-mobile-items') : 2;
        var data_autoscroll = jQuery(this).attr('data-autoscroll') != undefined ? jQuery(this).attr('data-autoscroll') : 'false';
        var autoscroll = (data_autoscroll === "true");
        var data_autoscroll_timing = jQuery(this).attr('data-scrolltiming') != undefined ? jQuery(this).attr('data-scrolltiming') : 2;
        var autoScrollTimeout = Number(data_autoscroll_timing) * 1000;

        jQuery(this).tns({
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
    });
});

function owl_init() {
    var $owl = jQuery(".owl-carousel");
	$owl.each(function (index) {
        
        var items_no = jQuery(this).attr('data-items') != undefined ? jQuery(this).attr('data-items') : 1;
        var mobile_items = jQuery(this).attr('data-mobile-items') != undefined ? jQuery(this).attr('data-mobile-items') : 1;
        
        jQuery(this).owlCarousel({
          items : items_no, //10 items above 1000px browser width
          margin: 16,	  
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
                items:3,
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

function fancybox_init() {
    
    var $fancybox = jQuery("a.lightbox");
    
    $fancybox.each(function (index) {
        $(this).fancybox({
            thumbs : { autoStart:true },
            toolbar: "auto",
            arrows: true,
            infobar: true,
            smallBtn: "auto",
            preventCaptionOverlap: true,
            protect: true,
            animationEffect: "zoom-in-out",
            zoomOpacity: "auto",
            transitionEffect: "rotate",
            spinnerTpl: '<div class="fancybox-loading"></div>',
            fullScreen: false,
        });
    });
}