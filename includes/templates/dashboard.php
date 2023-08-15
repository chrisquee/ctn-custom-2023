<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

get_header('small'); ?>

			<div id="primary" class="col-md-12 content-area no-padding">
				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>
						<?php echo cq_my_account_menu($endpoints, $dashboard_content); ?>
                        <?php include( 'dashboard/' . $dashboard_content . '.php' ); ?>

                        <?php // the_post_navigation(); ?>
                        
                    <?php endwhile; // end of the loop. ?>
					
			</article>
            </div><!-- #primary -->
           
        
        

<?php get_footer(); ?>
