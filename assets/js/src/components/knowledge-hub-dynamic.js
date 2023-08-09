jQuery(function($) {   
    
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