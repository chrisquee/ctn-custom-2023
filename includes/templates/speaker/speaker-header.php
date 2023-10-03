<header class="entry-header speaker-header">
    <div class="row-eq-height">

        <div class="col-md-7 article-image">
            <div class="post-image">
                <a href="<?php $url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo $url[0]; ?>" title="<?php the_title_attribute(); ?>" itemprop="image" class="lightbox">
                <?php echo get_the_post_thumbnail( get_the_id(), 'main-post-image' ); ?>
                </a>
            </div>
        </div>

        <div class="col-md-5 article-title job-title destination-title">
                        
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        </div>
    </div>
</header><!-- .entry-header -->

<section class="article-links">
    <div class="col-md-10 no-padding hidden-sm-down">
	    <?php custom_breadcrumbs(); ?>
    </div>
</section>
