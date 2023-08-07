<header class="entry-header container">
    <div class="row-eq-height">

        <div class="col-md-7 article-image">
            <div class="post-image">
                <a href="<?php $url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo $url[0]; ?>" title="<?php the_title_attribute(); ?>" itemprop="image" class="lightbox">
                <?php echo get_the_post_thumbnail( $post->ID, 'main-post-image' ); ?> 
                </a>
            </div>
        </div>

        <div class="col-md-5 article-title destination-title">
            
            <?php get_udg_sponsor(); ?>
            
            <p class="section-name">ULTIMATE DESTINATION GUIDE</p>

            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            
            <?php echo wpautop($destination->destination_intro); ?>

        </div>
    </div>
</header><!-- .entry-header -->
<div class="container">
	<div class="row article-links">
		<div class="col-md-10     no-padding hidden-sm-down">
			<?php custom_breadcrumbs(); ?>
		</div>
	</div>
</div>