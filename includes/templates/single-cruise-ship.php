<?php
get_header();

global $ship;
do_action('get_ship_data');

?>

<div id="main-content-wrapper">

       <?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>
			
			    <?php include('cruise-ship/cruise-ship-header.php'); ?>
		        
                <div class="row">
                    <div class="col-md-8 no-padding">
                        <?php include('cruise-ship/cruise-ship-content.php'); ?>

                        <?php include('cruise-ship/cruise-ship-menu.php'); ?>

                        <?php include('cruise-ship/cruise-ship-accommodation.php'); ?>

                        <?php include('cruise-ship/cruise-ship-entertainment.php'); ?>

                        <?php include('cruise-ship/cruise-ship-dining.php'); ?>

                        <?php include('cruise-ship/cruise-ship-enrichment.php'); ?>

                        <?php include('cruise-ship/cruise-ship-health-fitness.php'); ?>

                        <?php include('cruise-ship/cruise-ship-deckplans.php'); ?>
                    </div>
                    <div class="col-md-4 ship-sidebar">
                        <?php include('cruise-ship/cruise-ship-line.php'); ?>
                        <?php include('cruise-ship/cruise-ship-facts.php'); ?>
                    </div>
                </div>
		</article><!-- #post-## -->
             
        <?php //include('destination/destination-related.php'); ?>
	
	    <?php
		  if (is_active_sidebar( 'cq_article_footer' ) ) { ?>
          <div class="container">
          	<div class="row-fluid">
          		<div class="col-md-12" role="complementary"> 
			<?php	dynamic_sidebar( 'cq_article_footer' ); ?>
        		</div>
          	</div>
          </div>  
		<?php } ?>

    <?php endwhile; // end of the loop. ?>
        <?php // get_sidebar(); ?>
    
    <?php get_template_part( 'loop-templates/content', 'subscribe-footer' ); ?>
     
</div><!-- Wrapper end -->

<?php get_footer(); ?>