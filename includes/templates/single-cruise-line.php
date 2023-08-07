<?php
get_header(); 

?>

<div id="main-content-wrapper">

       <?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>
			
			    <?php include('cruise-line/cruise-line-header.php'); ?>
		
                <?php include('cruise-line/cruise-line-content.php'); ?>
                
                <?php include('cruise-line/cruise-line-dynamic.php'); ?>
                
                <?php include('cruise-line/cruise-line-gallery.php'); ?>
                
                <?php include('cruise-line/cruise-line-related.php'); ?>
            
                <?php include('cruise-line/cruise-line-ships.php'); ?>
            
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