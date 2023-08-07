<?php 
$term_id = get_queried_object_id();   
$image = rwmb_meta( 'cruise_type_feature_image', array( 'size' => 'featured-box-bg-image', 'object_type' => 'term' ), $term_id ); 
$feature_heading = rwmb_meta('cruise_type_feature_heading', ['object_type' => 'term'], $term_id);
$feature_description = rwmb_meta('cruise_type_feature_description', ['object_type' => 'term'], $term_id);

if ( $feature_heading != '' && $feature_description != '') {
    
    $desc_class = !empty($image) ? 'col-md-5' : 'col-md-12 no-image';

?>
<section class="destination-feature">
    <div class="row-fluid row-eq-height">
        
        <?php if (!empty($image)) { ?>
        <div class="col-md-7 article-image">
            <div class="post-image">
                
                <a href="<?php echo $image['url']; ?>" title="<?php echo $image['title']; ?>" itemprop="image" class="lightbox">
                <?php echo wp_get_attachment_image($image['ID'], 'featured-box-bg-image') ?> 
                </a>
            </div>
        </div>
        <?php } ?>

        <div class="<?php echo $desc_class; ?> article-title destination-title">	

            <h3><?php echo esc_html($feature_heading); ?></h3>
            
            <?php echo esc_html($feature_description); ?>

        </div>
    </div>
</section>
<?php } ?>