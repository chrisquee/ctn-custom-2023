<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();

?>

<div id="primary" class="col-md-12  content-area no-padding">

    <article <?php post_class( 'row'); ?>>

        <header class="page-header default-header">
                <div class="row-fluid clearfix">
                    <div class="col-md-12 header-content directory-header">
                        <h1 class="page-title">Jobs Board</h1>
                        <p class="job-board-description">Welcome to the Cruise Trade News jobs board. Here you can browse the latest jobs on offer throughout the cruise industry.
                            Listing is free so if you would like to list your available positions please register and submit your vacancies 
                            <a href="<?php echo site_url('/register/'); ?>" title="Subscribe">here</a>.
                        </p>
                    </div>
                </div>
        </header>

        <div class="container default-header-description">

            <?php do_action('cq_before_list'); ?>

        <!-- .page-header -->
            <main id="main" class="site-main" role="main">
                <div class="sep-wrap clearfix">
                    <h2 class="sep-title">
                        <span class="material-symbols-outlined">arrow_outward</span>Jobs Found
                    </h2>

                    <a href="#" class="view-all" title="See More">
                        <?php echo $wp_query->post_count . ' found'; ?>
                    </a>
                </div>

                <?php if ( have_posts() ) : ?>
                <?php /* Start the Loop */ ?>

                <div id="post-list">

                    <?php 
                    $header_count = 0;
                    $article_count = 0;

                    while ( have_posts() ) : the_post();

                         include('job-archive/job-content.php');
                    
                    endwhile; ?>
                </div>

        <?php
        if ( $article_count != 0 || $article_count != 4 ) {
            echo '</div>';
        }
        ?>
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="row-fluid">
                    <div class="col-md-12 pagination-container">
                        <?php
                        if ( $wp_query->max_num_pages > 1 ) {
                            //echo '<div class="cq_loadmore button button-black align-center">More Jobs</div>';
                        } // you can use <a> as well
                        ?>
                        <noscript>
                            <?php  cq_post_pagination(); // the_posts_navigation(); ?>
                        </noscript>
                    </div>
                </div>
            </div>
        </div>
        <?php else : ?>
        <div class="row latest-wrapper clearfix">
        <?php include('job-archive/job-none.php'); ?>
                </div>
        <?php endif; ?>

        </main>
    <!-- #main -->



<?php // get_sidebar(); ?>

        </div>
<!-- .row -->
    </article>
    
</div>
	

<?php get_footer(); ?> 