<?php 

$image = rwmb_meta( 'feature_image', array( 'size' => 'featured-box-bg-image' ) ); 
$feature_heading = rwmb_meta('feature_heading');
$feature_description = rwmb_meta('feature_description');

if (!empty($image) && $feature_heading != '' && $feature_description != '') {

?>
<div class="container destination-feature">
    <div class="row-fluid row-eq-height">

        <div class="col-md-7 article-image">
            <div class="post-image">
                
                <a href="<?php echo $image['url']; ?>" title="<?php echo $image['title']; ?>" itemprop="image" class="lightbox">
                <?php echo wp_get_attachment_image($image['ID'], 'featured-box-bg-image') ?> 
                </a>
            </div>
        </div>

        <div class="col-md-5 article-title destination-title">	

            <h3><?php echo esc_html(rwmb_meta('feature_heading')); ?></h3>
            
            <?php echo esc_html(rwmb_meta('feature_description')); ?>

        </div>
    </div>
</div>
<?php } ?>