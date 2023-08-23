<?php
    $args = array(
                'posts_per_page' => -1,
                'post_type' => 'cruise-line',
                'orderby' => array( 'menu_order' => 'DESC', 'title' => 'ASC' ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cruise-type',
                        'field' => 'term_id',
                        'terms' => $cruise_type->term_id,
                    )
                )
            );
    $cruise_lines = get_posts( $args ); 
    //print_r( $cruise_lines ); 
    if (!empty($cruise_lines)) {
?>

<section class="cruise-type-lines">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title"><span class="material-symbols-outlined">arrow_outward</span>Operators</h2>
                <a href="/cruise-lines/" class="sep-link view-all"><span class="material-symbols-outlined">add</span>See All</a>
            </div>
            <?php
              echo '<div class="cruise-lines-wrapper top">';
              $cruise_line_count = 0;
              foreach ( $cruise_lines as $line ) {
                  
                  if ($cruise_line_count == 16) {
                      echo '</div>
                            <div class="cruise-lines-see-more">    
                                <div class="cruise-lines-wrapper">';
                  }
            
                  $logo = get_the_post_thumbnail($line->ID, 'small');

                  if ($logo != '') { ?>

                    <div class="cruise-lines-item item_wrap">
                        <div class="cruise-lines-img">
                            <a href="<?php echo get_permalink($line); ?>">
                            <?php echo $logo; ?>
                            </a>
                        </div>
                    </div>
                    <?php
                    }
                    $cruise_line_count++;
              }
              echo '</div>';
        
              if ($cruise_line_count > 15) {
                  
                      echo '</div>
                      <a href="javascript:void(0);" class="more-cruise-lines closed">See More <span class="material-symbols-outlined">expand_more</span></a>';
                  }
            ?>
        </div>
    </div>
</section>
<?php }