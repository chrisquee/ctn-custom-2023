
<header class="entry-header cruise-type-header">
    <div class="row-eq-height">

        <div class="col-md-7 article-image">
            <div class="post-image">
                <?php 
                    $featured_image_id = get_term_meta(get_queried_object_id(), 'cruise-type-image-id', true); 
                    $description = get_term_meta(get_queried_object_id(), 'description', true); 
                    $object = get_queried_object();
                    //print_r($object);
                
                    $url = wp_get_attachment_image_src($featured_image_id, 'main-post-image');
                
                    $link_image = $url !== false && is_array($url) ? $url[0] : '';
                ?>
                <a href="<?php echo $link_image; ?>" title="" itemprop="image" class="lightbox">
                <?php echo wp_get_attachment_image( $featured_image_id, 'main-post-image' ); ?> 
                </a>
            </div>
        </div>

        <div class="col-md-5 article-title destination-title">
            
            <?php get_udg_sponsor(); ?>
            
            <p class="section-name">ULTIMATE DESTINATION GUIDE</p>

            <?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
            
            <?php echo wpautop(get_queried_object()->description); ?>

        </div>
    </div>
</header><!-- .entry-header -->

<section class="article-links">
    <div class="col-md-10 no-padding hidden-sm-down">
    	<?php custom_breadcrumbs(); ?>
    </div>
</section>