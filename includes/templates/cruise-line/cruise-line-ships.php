<?php
$args = array(
            'post_type' => 'cruise-ship',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => 30,
            'meta_key' => 'cruise_line',
            'meta_value' => get_the_id()
        );
                  
$ships = get_posts($args);

if ( !empty($ships) ) : ?>

<div class="container destination-related">
    <div class="row">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2><?php echo get_the_title(); ?> Ships</h2>
                <a href="" class="sep-link"></a>
            </div>
            
                <div class="latest-wrapper cq_category_carousel archive-carousel" data-items="5"  data-mobile-items="2" data-margin="15">
            
                <?php foreach ( $ships as $ship ) : ?>
            
                        <div class="cq_overlay item_wrap" style="background-image: url('<?php echo get_the_post_thumbnail_url($ship->ID, 'category-carousel-image'); ?>')">
                           <a href="<?php echo esc_url(get_permalink($ship->ID)); ?>" class="destination-link" title="<?php echo esc_html(get_the_title($ship->ID)); ?>"></a>
                               <div class="item_content">
                                  <h3><a href="<?php echo esc_url(get_permalink($ship->ID)); ?>"><?php echo esc_html(get_the_title($ship->ID)); ?></a></h3>
                               </div>
                            
                        </div>
            
                    
                <?php endforeach; ?>
                    
                </div>
        </div>
    </div>
</div>
<?php endif; ?>