<?php

if (!empty($destination->destination_cruise_lines)) { ?>
<section class="destination-cruise-lines">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <h2><?php echo $destination->destination_title; ?> Cruise Operators</h2>
            
            <?php //print_r($destination->destination_cruise_lines);
            
              echo '<div class="cruise-lines-wrapper">';
              foreach ( $destination->destination_cruise_lines as $line ) { ?>
                  
                  <div class="cruise-lines-item item_wrap">
                      <div class="cruise-lines-img">
                          <a href="<?php echo get_permalink($line); ?>">
                          <?php echo get_the_post_thumbnail($line, 'small'); ?>
                          </a>
                      </div>
                  </div>
                  <?php
                  
              }
              echo '</div>';
            ?>
        </div>
    </div>
</section>
<?php } ?>