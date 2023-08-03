<?php
$gallery = get_post_meta(get_the_id(), 'destination-gallery');

if ($gallery) { ?>
<div class="container destination-gallery">
    <div class="row">
        <div class="col-md-12 no-padding">
            <?php 
            
            $gallery = get_post_meta(get_the_id(), 'destination-gallery');
                
            $number = sizeof($gallery);
                
            if ( $number% 2 == 0 ) {
                $class = 'even';
            } else {
                $class = 'odd';
            } ?>
            
            <div class="gallery-wrap <?php echo $class; ?>">
                
            <?php
            foreach ($gallery as $key => $value) {
                
                $image_url = wp_get_attachment_image_url( $value, 'full' );
                
                echo '<div class="gallery-img">
                        <a href="' . esc_url($image_url) . '" class="lightbox">' . wp_get_attachment_image($value, 'featured-box-bg-image') . '</a>
                      </div>';
                
            }
                
            
            ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>