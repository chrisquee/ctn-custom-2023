<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

get_header(); 

global $destination;
do_action('get_destination_data');
//print_r($destination);

?>




<div class="wrapper" id="single-wrapper">

       <?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>
			
			<div class="container-fluid article-header">
			    <?php include('destination/destination-header.php'); ?>
		
                <?php include('destination/destination-content.php'); ?>
			
            </div>
		</article><!-- #post-## -->
             
        <?php include('destination/destination-related.php'); ?>
	
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