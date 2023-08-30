<?php 

$image = rwmb_meta( 'feature_image', array( 'size' => 'featured-box-bg-image' ) ); 
$feature_heading = rwmb_meta('feature_heading');
$feature_description = rwmb_meta('feature_description');

if ($feature_heading != '' && $feature_description != '') {
    
    $desc_class = !empty($image) ? 'col-md-5' : 'col-md-12 no-image';

?>
<section class="destination-feature">
    <div class="destination-feature-block row-eq-height left">
        
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

            <h3><?php echo esc_html(rwmb_meta('feature_heading')); ?></h3>
            
            <?php echo wpautop(rwmb_meta('feature_description')); ?>

        </div>
    </div>
</section>
<?php } ?>