jQuery(document).ready(function($){
    
    $(document).on('click', '.load-more', function(e) {
        
        e.preventDefault();
        
        var el = $(this);
        var isLoading = false;
        var category = $(this).attr('data-cat');
        var page = $(this).attr('data-page');
        var perPage = $(this).attr('data-perpage');
        var pageInt = parseInt(page);
        var listingWrapper = $(this).parent().siblings('.latest-wrapper');
        
        var data = {
                    'action': 'more_latest_news', 
                    'suppress' : page_data,
                    'cat': category,
                    'page': pageInt,
                    'per_page': perPage,
                };
        
        if (!isLoading) {
            $.ajax({
                  url : ajax_login_object.ajaxurl, // AJAX handler
                  data : data,
                  type : 'POST',
                  beforeSend : function ( xhr ) {
                      //button.html('Loading... <i class="fa fa-refresh fa-spin fa-fw"></i>');
                  },
                  success : function( html ) {
                      if( html ) {
                          $(listingWrapper).append(html);
                          
                          listingWrapper.find('.latest-item.new-item').each( function(i) {
                              console.log(i);
                              $(this).delay(150*i).fadeIn(600).removeClass('new-item');
                          })
                          //$('.latest-item').fadeIn('fast');
                          el.attr('data-page', pageInt+1);

                          isLoading = false;
                      } else {
                          el.hide();
                          isLoading = false;
                      }
                  }
              });
        }
    });
    
});