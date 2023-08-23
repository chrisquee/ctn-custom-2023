<section class="cruise-type-regions">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title"><span class="material-symbols-outlined">arrow_outward</span>Destinations</h2>
            </div>
            
            <?php // echo wpautop(get_term_meta($cruise_type->term_id, 'cruise-type-about', true)); ?>
            
            <?php 
            $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'destinations',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'cruise-type',
                            'field' => 'term_id',
                            'terms' => $cruise_type->term_id,
                        )
                    )
                );
            $destinations = get_posts( $args );
            ?>
            
            <?php if ( !empty($destinations) ) : ?>
            
                    <div class="latest-wrapper cq_category_carousel archive-carousel destination-carousel" data-items="5"  data-mobile-items="2" data-margin="15">
            
                <?php foreach ( $destinations as $destination ) : ?>
            
                        <div class="cq_overlay item_wrap" style="background-image: url('<?php echo get_the_post_thumbnail_url($destination->ID, 'category-carousel-image'); ?>')">
                           <a href="<?php echo esc_url(get_permalink( $destination->ID )); ?>" class="destination-link" title="<?php echo esc_html(get_the_title($destination->ID)); ?>"></a>
                               <div class="item_content">
                                  <h3><a href="<?php echo esc_url(get_permalink($destination->ID)); ?>"><?php echo esc_html(get_the_title($destination->ID)); ?></a></h3>
                               </div>
                           
                        </div>
            
                    
                <?php endforeach; ?>
                    
                    </div>
            
            <?php endif; ?>
            
        </div>
    </div>
</section>