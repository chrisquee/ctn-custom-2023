jQuery(function($) {
    
    var hotspot_id = 0;
    
    $(".hotspot").draggable({
        stop: pixel2pc,
        containment: 'parent',
    });
    
    $(".coordinates-group").on('click', '.add-clone', function() {
        //var hotspot_count = $('ol#hotspots li').length
        var hotspot_id = getHotspotDataValue();
        $("ol#hotspots").append('<li class="hotspot" data-id="'+hotspot_id+'"></li>');
        
        //reIndex();
        
        $(".hotspot").draggable({
            stop: pixel2pc,
            containment: 'parent',
        });
    });
    
    $(".coordinates-group").on('click', '.remove-clone', function() {
        var remove_id = $(".coordinates-group .remove-clone").index(this);
       alert( $(".coordinates-group .remove-clone").index(this) );
       $('ol#hotspots li.hotspot[data-id="'+remove_id+'"]').remove();
       
       //reIndex();
           
    });
    
    $(document).on('thumbnailUpdated', function(val) {
        
        var image_id = $("input#_thumbnail_id").val();
        
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: ajaxurl,
            data: { 
                'action': 'get_image_url', //calls wp_ajax_nopriv_ajaxlogin
                'image_id': image_id, 
                },
            success: function(src) {
                console.log(src);
                /*if ($("#interactive_image_canvas").html() == '') {
                    $('#interactive_image_canvas').append('<ol id="hotspots"><li class="hotspot" data-id="0"></li></ol>');
                }*/
                $("#interactive_image_canvas img.interactive-img").remove();
                $('#interactive_image_canvas').append(src);
            }
        });
    })
    
});

//if (jQuery("body").hasClass("post-type-cq_interactive_item")) {
    
    var thumbnail = jQuery("input#_thumbnail_id");

    jQuery("input#_thumbnail_id").data("value", thumbnail.val());

    setInterval(function() {
        var data = jQuery("input#_thumbnail_id").data("value"),
            val = jQuery("input#_thumbnail_id").val();
        
        console.log(val+' id');

        if (data !== val) {
            jQuery("input#_thumbnail_id").data("value", val);
            jQuery("input#_thumbnail_id").trigger("thumbnailUpdated", [val] );
        }
    }, 500);
//}

function reIndex() {
    var index = 0;
        
   jQuery("ol#hotspots li.hotspot").each( function(i) {
       jQuery(this).attr('data-id', index);
       index++;
   });
}

function getHotspotDataValue() {
    
    var Hid = 0;
    
    jQuery("ol#hotspots li.hotspot").each( function() {
       Hid = jQuery(this).attr('data-id');
    });
    
    Hid++;
    
    return Hid;
}

function pixel2pc(){
   
   var width = jQuery(this).width() / 2;
   var height = jQuery(this).height() / 2;
    
   var l = ( 100 * parseFloat(jQuery(this).css("left") + width) / parseFloat(jQuery(this).parent().css("width")) )+ "%" ;
   var t = ( 100 * parseFloat(jQuery(this).css("top") + height) / parseFloat(jQuery(this).parent().css("height")) )+ "%" ;
   jQuery(this).css("left" , l);
   jQuery(this).css("top" , t);
   var hotspot_id_x = jQuery(this).attr('data-id');
   var hotspot_id_y = hotspot_id_x + 1;

    console.log(hotspot_id_x);

   jQuery("input[name='image_hotspots["+hotspot_id_x+"][hotspot][]']").eq(0).val(l);
   jQuery("input[name='image_hotspots["+hotspot_id_x+"][hotspot][]']").eq(1).val(t);
}