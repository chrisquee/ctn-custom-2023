
<header class="entry-header container">
    <div class="row row-eq-height">

        <div class="col-md-7 article-image">
            <div class="post-image">
                <?php $featured_image_id = get_term_meta(get_queried_object_id(), 'cruise-type-image-id', true); 
                      $description = get_term_meta(get_queried_object_id(), 'description', true); 
                $object = get_queried_object();
                //print_r($object);
                ?>
                <a href="<?php $url = wp_get_attachment_image_src($featured_image_id, 'main-post-image'); echo $url[0]; ?>" title="" itemprop="image" class="lightbox">
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

<div class="container">
	<div class="row article-links">
		<div class="col-md-10     no-padding hidden-sm-down">
			<?php custom_breadcrumbs(); ?>
		</div>
        <div class="col-md-2 no-padding">
            <?php
              global $wp;
              $current_url = home_url(add_query_arg(array(), $wp->request));

              $posttitle = get_the_title($post->ID);
              $posturl = home_url(add_query_arg(array(), $wp->request));

              echo '<ul class="social-share-col">';
              echo '<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='.@urlencode($posturl).'" title="Facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>';
              echo '<li class="twitter"><a href="https://twitter.com/intent/tweet/?text='.@urlencode($posttitle).'&amp;url='.@urlencode($posturl).'&amp;via=cruisetradenews&hashtags=avbusinessnews" title="Twitter" target="_blank"><span class="fa fa-twitter"></span></a></li>';
              echo '<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url='.@urlencode($posturl).'&title='.@urlencode($posttitle) . '" title="LinkedIn" target="_blank"><span class="fa fa-linkedin"></span></a></li>';
              echo '<li class="whatsapp"><a href="https://wa.me/?text='.@urlencode('Hi, I found this on cruisetradenews.com, and thought you might be interested - ' . $posttitle . ' - ' . $posturl).'" title="Whatsapp" target="_blank"><span class="fa fa-whatsapp"></span></a></li>';
								
              echo '</ul>';
			?>
        </div>
	</div>
</div>