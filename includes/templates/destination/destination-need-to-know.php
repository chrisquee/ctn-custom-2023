<?php

$pairs = rwmb_meta( 'need_to_know' );

if ($pairs) { ?>
<div class="container destination-need-to-know">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <h2>Need to know</h2>
            
            <?php 
              echo '<div class="know-wrapper">';
              foreach ( $pairs as $pair ) {
                  ?>
                  <div class="know-item">
                      <h4><?php echo esc_html($pair[0]); ?></h4> 
                      <p><?php echo esc_html($pair[1]); ?></p>
                  </div>
                  <?php
              }
              echo '</div>';
            ?>
        </div>
    </div>
</div>
<?php } ?>