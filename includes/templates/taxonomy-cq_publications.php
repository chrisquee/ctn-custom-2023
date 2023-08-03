<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Get the current category ID, e.g. if we're on a category archive page


get_header();

$archive_title = get_the_archive_title() == 'Digital Issue' ? 'Digital' : get_the_archive_title();

?>

<div class="wrapper" id="full-width-page-wrapper">

	<div id="content" class="container-fluid no-padding">

		<div class="row-fluid">

			<div id="primary" class="col-md-12  content-area no-padding">

				<?php if ( have_posts() ) : ?>
				<article <?php post_class( 'row-fluid'); ?>>
                    
                    <div class="container">
                      <div class="row article-links hidden-sm-down">
                          <div class="col-md-6 no-padding hidden-sm-down">
                              <?php custom_breadcrumbs(); ?>
                          </div>
                      </div>
                    </div>

					<header class="page-header default-header">
						<div class="container">
							<div class="row-fluid archive-row clearfix">
								<div class="col-md-12 header-content">
									<h1 class="page-title"><?php echo $archive_title; ?> Issues</h1>
								</div>
								
								<?php if (get_the_archive_description() != '') : ?>
								
									<!--<div class="col-md-12 offset-md-0 hidden-sm-down no-padding">
										<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
									</div>-->
								
								<?php endif; ?>
								
							</div>
						</div>
					</header><!-- .page-header -->

					<div class="container default-header-description">

					<!-- .page-header -->
					<main id="main" class="site-main" role="main">
						<div class="container hidden-xl-down">
							<div class="row-fluid clearfix">
								<div class="col-md-12">
									<?php
									if ( is_category() ) {
										$this_category = get_category( $cat );
									}
									?>
									<?php
									if ( $this_category->category_parent ) {
										//$this_category = wp_list_categories('orderby=id&show_count=0
										//    &title_li=&use_desc_for_title=1&child_of='.$this_category->category_parent.
										//    "&echo=0");
										$this_category = wp_list_categories( array( 'orderby' => 'id', 'depth' => 0, 'show_count' => 0,
											'use_desc_for_title' => 1, 'child_of' => $this_category->cat_ID, 'echo' => 0, 'title_li' => '' ) );
									} else {
										//$this_category = wp_list_categories('orderby=id&depth=1&show_count=0
										//    &title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID.
										//    "&echo=0");
										$this_category = wp_list_categories( array( 'orderby' => 'id', 'depth' => 1, 'show_count' => 0,
											'use_desc_for_title' => 1, 'child_of' => $this_category->cat_ID, 'echo' => 0, 'title_li' => '' ) );
									}


									if ( $this_category && $this_category != '<li class="cat-item-none">No categories</li>' ) {
										?>

									<ul class="sub-cat-menu">
										<?php echo $this_category; ?>

									</ul>

									<?php } ?>
								</div>
							</div>
						</div>

						<?php /* Start the Loop */ ?>

						<div id="post-list" class="">

							<?php 
						$header_count = 0;
						$article_count = 0;
                        $post_count = $wp_the_query->post_count;
						
						while ( have_posts() ) : the_post(); ?>

							<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */

							if ( $header_count == 0 ) {
                                
                                $digital_issue_html = '<div class="latest-issue digital-issue-large">';
                                $thumb_id = get_post_thumbnail_id();
                                $issue_id = get_the_ID();
                                $external_link = get_post_meta($issue_id, 'di_external_link', true);
                                $link = strpos($external_link, 'http', 0) !== false ? $external_link : get_permalink($issue_id);
                                $target = strpos($link, site_url(), 0) !== false ? '_self' : '_blank';

                                $digital_issue_html .= '<div class="digital-issue-item">
                                                            <div class="digital-issue-img">
                                                                <a href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '">
                                                                ' . get_the_post_thumbnail($issue_id, 'full', array( 'class' => 'img-responsive' )) . '</a>
                                                            </div>
                                                            <div class="item_content">
                                                                <div class="item_content_wrap">
                                                                    <h3><a href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '">' . get_the_title() . '</a></h3>
                                                                    ' . nl2br(get_the_excerpt()) . '
                                                                    <div class="directory-header-button-container">
                                                                        <a href="' . esc_url( $link ) . '" class="button button-blue button_1" target="' . esc_attr($target) . '">READ NOW</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';


                            
                                $digital_issue_html .= '</div>';
                                
                                echo $digital_issue_html;
                                
                                if ($post_count > 1) {
                                    echo '<div class="sep-wrap clearfix">
                                        <h2>Previous Editions</h2>
                                        <a href="" class="sep-link"></a>
                                     </div>
                                    <p>Click on the cover to read previous editions.</p>';
                                }
                                
                                $header_count++;
                                
                                continue;
							} else {


                                if ( $article_count == 0 ) {

                                    echo '<div class="row archive-row latest-wrapper clearfix">';
                                } 
							
							    include('digital-issues/digital-issue-content.php');
							

                                if ( $article_count == 3 ) {
                                    echo '</div>';
                                    $article_count = 0;
                                } else {
                                    $article_count++;
                                }
                            }
							?>

							<?php endwhile; ?>
						</div>
				</article>
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

				</main>
				<!-- #main -->

			

			<?php // get_sidebar(); ?>

		</div>
		<!-- .row -->

	</div>
	<!-- Container end -->

</div> <!-- Wrapper end -->

<?php get_footer(); ?>