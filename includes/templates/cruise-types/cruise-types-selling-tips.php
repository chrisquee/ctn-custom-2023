<?php 
$term_id = get_queried_object_id();        
$pairs = rwmb_meta( 'selling-tips', ['object_type' => 'term'], $term_id );

if ($pairs) { ?>

<div class="container destination-need-to-know">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2>Selling Tips</h2>
                <a href="" class="sep-link"></a>
            </div>
            
              <div class="selling-wrapper">
                  
              <?php foreach ( $pairs as $pair ) {
                  ?>
                  <div class="selling-item">
                      <h4><?php echo isset($pair[0]) && $pair[0] != '' ? esc_html($pair[0]) : ''; ?></h4> 
                      <p><?php echo isset($pair[1]) && $pair[1] != '' ? esc_html($pair[1]) : ''; ?></p>
                  </div>
                  <?php
              } ?>
                  
              </div>
            
        </div>
    </div>
</div>

<?php
}