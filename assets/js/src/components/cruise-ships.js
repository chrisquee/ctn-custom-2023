jQuery(function($){
    
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
    
});
