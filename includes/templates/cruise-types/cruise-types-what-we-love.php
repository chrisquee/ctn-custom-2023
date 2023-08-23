<?php
$term_id = get_queried_object_id();  
$points = rwmb_meta( 'cruise_type_interest', ['object_type' => 'term'], $term_id );
            
if ($points) { ?>

<div class="container destination-what-we-love">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title"><span class="material-symbols-outlined">arrow_outward</span>Pre and post cruise ideas</h2>
                <a href="" class="sep-link"></a>
            </div>
            
            <?php 
        
              echo '<div class="points-wrapper">';
              foreach ( $points as $point ) {
                  $class = 'row-span-1';
                  if (isset($point['image']) && $point['image'] != '') {
                      $class = 'row-span-2';
                  }
                  
                  ?>
                  <div class="point-item <?php echo $class; ?>">
                <?php if (isset($point['image']) && $point['image'] != '') { ?>
                      <div class="point-img">
                          <?php echo wp_get_attachment_image($point['image'], 'featured-box-bg-image'); ?>
                      </div>
                <?php } ?>
                      <div class="point-content">
                          <h4><?php echo esc_html($point['heading']); ?></h4> 
                          <p><?php echo esc_html($point['description']); ?></p>
                      </div>
                  </div>
                  <?php
              }
              echo '</div>';
            ?>
        </div>
    </div>
</div>
<?php } ?>