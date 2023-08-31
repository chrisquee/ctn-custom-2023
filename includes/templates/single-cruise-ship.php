<?php
get_header();

global $ship;
do_action('get_ship_data');

?>

<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('row-fluid'); ?>>

        <?php include('cruise-ship/cruise-ship-header.php'); ?>

        <div id="ship-conent">
            <?php include('cruise-ship/cruise-ship-content.php'); ?>

            <div class="ship-sidebar">
                <?php include('cruise-ship/cruise-ship-line.php'); ?>
            </div>
        </div>
    
        <?php include('cruise-ship/cruise-ship-facts.php'); ?>

        <?php include('cruise-ship/cruise-ship-menu.php'); ?>

        <?php include('cruise-ship/cruise-ship-accommodation.php'); ?>

        <?php include('cruise-ship/cruise-ship-entertainment.php'); ?>

        <?php include('cruise-ship/cruise-ship-dining.php'); ?>

        <?php include('cruise-ship/cruise-ship-enrichment.php'); ?>

        <?php include('cruise-ship/cruise-ship-health-fitness.php'); ?>

        <?php include('cruise-ship/cruise-ship-deckplans.php'); ?>
            
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
     


<?php get_footer(); ?>