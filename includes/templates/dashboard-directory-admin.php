<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

get_header(); ?>
<div class="wrapper">
    
    <div id="content" class="container-fluid no-padding">

        <div class="row-fluid">
			<div id="primary" class="col-md-12 content-area seller-dashboard no-padding">
				
				<nav id="sidebar" class="sidebar">
					<?php echo cq_my_account_menu($endpoints, $dashboard_content); ?>
                    <div class="menu-open"><i class="fa fa-bars"></i> Menu</div>
				</nav>
				
				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid main-panel'); ?>>
                        
						<?php include( 'dashboard/' . $dashboard_content . '.php' ); ?>

                        <?php // the_post_navigation(); ?>
                        
                    <?php endwhile; // end of the loop. ?>
					
				</article> 
            </div><!-- #primary -->
           
        
        <?php // get_sidebar(); ?>

        </div><!-- .row -->
        
    </div><!-- Container end -->
	
	
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>
