<?php

$points = rwmb_meta( 'cruise_line-sections' );
            
if ($points) {
?>
<section class="destination-what-we-love">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <h2>What we love about <?php echo get_the_title(); ?></h2>
            
            <?php 
              echo '<div class="points-wrapper">';
              foreach ( $points as $point ) {
                  $class = 'row-span-1';
                  if (isset($point['section-image']) && $point['section-image'] != '') {
                      $class = 'row-span-2';
                  }
                  
                  ?>
                  <div class="point-item <?php echo $class; ?>">
                <?php if (isset($point['section-image']) && $point['section-image'] != '') { ?>
                      <div class="point-img">
                          <?php echo wp_get_attachment_image($point['section-image'], 'featured-box-bg-image'); ?>
                      </div>
                <?php } ?>
                      <div class="point-content">
                          <h4><?php echo esc_html($point['section-heading']); ?></h4> 
                          <p><?php echo $point['section-description']; ?></p>
                      </div>
                  </div>
                  <?php
              }
              echo '</div>';
            ?>
        </div>
    </div>
</section
<?php
}