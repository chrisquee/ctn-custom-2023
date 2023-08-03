<?php

$the_terms = get_the_terms( get_the_ID(), 'cruise-type' );
$the_terms_ids = array();
if(isset($the_terms) && !empty($the_terms)){
    foreach($the_terms as $the_term){
        if ($the_term->parent != 0) {
            $the_terms_ids[] = $the_term->term_id;
        }
    }
}

$args = array(
            'post_type' => 'destinations',
            'posts_per_page' => 5,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'cruise-type',
                    'field' => 'term_id',
                    'terms' => $the_terms_ids
                    )
                )
        );
                  
$related = get_posts($args);

if ( !empty($related) ) : ?>

<div class="container destination-related">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2>Other Destinations</h2>
                <a href="" class="sep-link"></a>
            </div>
            
                <div class="latest-wrapper cq_category_carousel archive-carousel" data-items="5"  data-mobile-items="2" data-margin="15">
            
                <?php foreach ( $related as $destination ) : ?>
            
                        <div class="cq_overlay item_wrap" style="background-image: url('<?php echo get_the_post_thumbnail_url($destination->ID, 'category-carousel-image'); ?>')">
                           <a href="<?php echo esc_url(get_permalink( $destination->ID )); ?>" class="destination-link" title="<?php echo esc_html(get_the_title($destination->ID)); ?>"></a>
                               <div class="item_content">
                                  <h3><a href="<?php echo esc_url(get_permalink($destination->ID)); ?>"><?php echo esc_html(get_the_title($destination->ID)); ?></a></h3>
                               </div>
                           
                        </div>
            
                    
                <?php endforeach; ?>
                    
                </div>
        </div>
    </div>
</div>
<?php endif; ?>