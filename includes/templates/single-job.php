<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

get_header(); 

global $job;
do_action('get_job_data');
//print_r($job);

?>




<div class="wrapper" id="single-wrapper">
    
       <?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>
			
			<div class="container-fluid article-header">
			    <?php include('job/job-header.php'); ?>
		
        <?php include('job/job-content.php'); ?>
			
            </div>
		</article><!-- #post-## -->
                    
	
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
     
</div><!-- Wrapper end -->

<?php get_footer(); ?>
