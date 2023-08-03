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

<div class="wrapper" id="full-width-page-wrapper">

	<div id="content" class="container-fluid no-padding">

		<div class="row">

			<div id="primary" class="col-md-12  content-area no-padding">

				<article <?php post_class( 'row'); ?>>

					<header class="page-header default-header">
                        <div class="container">
                            <div class="row-fluid archive-row clearfix">
                                <div class="col-md-12 header-content directory-header">
                                    <h1 class="page-title">Jobs Board</h1>
                                    <p>Welcome to the Cruise Trade News jobs board. Here you can browse the latest jobs on offer throughout the cruise industry.</p>
                                    <p>Listing is free so if you would like to list your available positions please register and submit your vacancies.</p>
                                    <div class="directory-header-button-container">
                                        <a href="<?php echo site_url('/register/'); ?>" class="button button-blue button_1" title="Subscribe">List a job</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

					<div class="container default-header-description">
                        
                        <?php do_action('cq_before_list'); ?>

					<!-- .page-header -->
					<main id="main" class="site-main" role="main">
                        <div class="sep-wrap clearfix">
                            <h2>Jobs Found</h2>
                            <a href="#" class="sep-link" title="See More"><?php echo $wp_query->post_count . ' found'; ?></a>
                        </div>
                        
                        <?php if ( have_posts() ) : ?>
						<?php /* Start the Loop */ ?>
                        <div class="row">
						<div id="post-list" class="jobs-list col-md-8 no-padding">

							<?php 
						$header_count = 0;
						$article_count = 0;
						
						while ( have_posts() ) : the_post(); ?>

							<?php
							
							if ( $article_count == 0 ) {
								echo '<div class="row archive-row latest-wrapper clearfix">';
							}
							?>

							<?php
							 include('job-archive/job-content.php');
							?>


							<?php

							if ( $article_count == 3 ) {
                                echo '</div>';
								$article_count = 0;
							} else {
								$article_count++;
							}
							?>

							<?php endwhile; ?>
						</div>

				<?php
				if ( $article_count != 0 || $article_count != 4 ) {
					echo '</div>';
				}
				?>
            <div class="col-md-4 sidebar-ads">
                <?php dynamic_sidebar('job-board-ads'); ?>
            </div>
                        </div>
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
                <div class="row archive-row latest-wrapper clearfix">
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
	<!-- Container end -->

</div> <!-- Wrapper end -->

<?php get_footer(); ?>