jQuery(document).ready(function($){
    
    $(document).on("click", ".load-more-header", function() {
        
        $(this).siblings(".mobile-view").slideDown();

        $(this).html(
            '<a href="digital-issues/">' +
            '<span class="material-symbols-outlined">add</span>View All</a>'
        );

        $(this).find('a').addClass('view-all-header');

    });


    $(document).on("click", '.last-issue', function() {

        $(this).closest('.digital-issue-item').find('.di-img-container').slideToggle();

        var clicked_arrow = $(this).closest('.last-issue').find('.material-symbols-outlined');

        if (clicked_arrow.css("rotate") == "none") {
            clicked_arrow.css({"rotate": "180deg", "transition-duration": "0.5s"});
        } else {
            clicked_arrow.css({"rotate": "none", "transition-duration": "0.5s"});
        }

    });
});

