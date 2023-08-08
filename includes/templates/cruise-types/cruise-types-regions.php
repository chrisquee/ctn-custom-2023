<?php 
$about_class = "col-md-12";

ob_start();

dynamic_sidebar( 'udg-ads' );

$sidebar = ob_get_clean();

if ($sidebar == '<div class="ad-widget"></div>' || !is_active_sidebar('udg-ads')) {
    $about_class = "col-md-12";
} ?>

<section class="cruise-type-regions">
    <div class="row">
        <div class="<?php echo $about_class; ?> no-padding">
            
            
            <?php
            $args = array('parent' => $cruise_type->term_id, 'hide_empty' => false,);
            $terms = get_terms( 'cruise-type', $args ); 
            //print_r( $terms ); ?>
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title"><?php echo $cruise_type->name; ?></h2>
                <a href="" class="sep-link"></a>
            </div>
            
            <?php $cruise_type_about = get_term_meta($cruise_type->term_id, 'cruise-type-about', true);
            
            if ($cruise_type_about) { ?>
            <div class="region-about">
                <?php echo wpautop($cruise_type_about); ?>
            </div>
            
            <?php } ?>
            
            <?php

            $cat_html = '<div class="latest-wrapper cq_category_carousel archive-carousel region-carousel" data-items="5"  data-mobile-items="2" data-margin="15">';

            foreach($terms as $term) { 

                $term_id = $term->term_id;
                $image_id = get_term_meta($term_id, 'cruise-type-image-id', true);
                $image_data = wp_get_attachment_image_src( $image_id, 'category-carousel-image' );

                $cat_html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . $image_data[0] . ')">
                                 <a href="' . esc_url(get_term_link( $term )) . '" class="destination-link" title="' . esc_html($term->name) . '"></a>
                                     <div class="item_content">
                                        <h3><a href="' . esc_url(get_term_link( $term )) . '">' . esc_html($term->name) . '</a></h3>
                                     </div>
                                 
                              </div>';

            }

            $cat_html .= '</div>';
            $cat_html .= '<div class="hidden-lg-up container-fluid alignright no-padding swipe-more"><p>SWIPE FOR MORE</p></div>';

            echo $cat_html;

            ?>
            
            
        </div>
        <?php if (is_active_sidebar('udg-ads')) { ?>
        <div class="col-md-4 sidebar-ads">
            <?php dynamic_sidebar('udg-ads'); ?>
        </div>
        <?php } ?>
    </div>
</section>