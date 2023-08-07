<?php if (!empty($destination->destination_meta['destination-gallery'])) { ?>
<section class="destination-gallery">
    <div class="row">
        <div class="col-md-12 no-padding">
            <?php 
                
            $number = sizeof($destination->destination_meta['destination-gallery']);
                
            if ( $number% 2 == 0 ) {
                $class = 'even';
            } else {
                $class = 'odd';
            } ?>
            
            <div class="gallery-wrap <?php echo $class; ?>">
                
            <?php
            foreach ($destination->destination_meta['destination-gallery'] as $key => $value) {
                
                $image_url = wp_get_attachment_image_url( $value, 'full' );
                
                echo '<div class="gallery-img">
                        <a href="' . esc_url($image_url) . '" class="lightbox">' . wp_get_attachment_image($value, 'featured-box-bg-image') . '</a>
                      </div>';
                
            }
                
            
            ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>