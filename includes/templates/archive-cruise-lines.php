<?php
get_header();
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div id="content" class="container-fluid no-padding">

		<div class="row">

			<div id="primary" class="col-md-12  content-area no-padding">

				<article <?php post_class( 'row'); ?>>
                    
                    <div class="container">
                      <div class="row article-links hidden-sm-down">
                          <div class="col-md-6 no-padding hidden-sm-down">
                              <?php custom_breadcrumbs(); ?>
                          </div>
                      </div>
                    </div>
                    
					<header class="page-header default-header">
						<div class="container">
							<div class="row archive-row clearfix">
								<div class="col-md-12 header-content">
									<?php
									the_archive_title( '<h1 class="page-title">', '</h1>' );
									?>
								</div>
								
								<?php if (get_the_archive_description() != '') : ?>
								
									<div class="col-md-8 no-padding">
										<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
									</div>
								
								<?php endif; ?>
								
							</div>
						</div>
					</header><!-- .page-header -->

					<!-- .page-header -->
					<main id="main" class="site-main container" role="main">

						<?php /* Start the Loop */ ?>
                    <?php if ( have_posts() ) : 
                            
                            $article_count = 0;
                        ?>
                        
						<div id="post-list" class="">
                            
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */


							if ( $article_count == 0 ) {
								echo '<div class="row latest-wrapper cruise-lines-wrapper clearfix">';
							}
							?>

							<?php
							include('cruise-line/cruise-line-listing.php');
							?>


							<?php

							if ( $article_count == 4 ) {
                                echo '</div>';
								$article_count = 0;
							} else {
								$article_count++;
							}
							?>

							<?php endwhile; ?>
				
				<?php
				if ( $article_count != 0 || $article_count != 3 ) {
					echo '</div>';
				}
				?>
                        </div>
                        
                    </main>
				<!-- #main -->
                </article>
				<div class="row-fluid">
					<div class="col-md-12">
						<div class="row-fluid">
							<div class="col-md-12 pagination-container">
								<?php
								if ( $wp_query->max_num_pages > 1 ) {
									//echo '<div class="cq_loadmore button button-black align-center">More Articles</div>';
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

				<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>			

			<?php // get_sidebar(); ?>

		</div>
		<!-- .row -->

	</div>
	<!-- Container end -->

</div> <!-- Wrapper end -->

<?php get_footer(); ?>