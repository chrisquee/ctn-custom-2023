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

$raw_title = get_the_archive_title();

if ($raw_title == 'Digital Issue') {
    $archive_title = 'All Digital Issues';
} else {
    $archive_title = $raw_title;
}
?>

<article <?php post_class( 'row-fluid'); ?>>

    <header class="page-header default-header">
                <div class="header-content">
                    <h1 class="page-title"><?php echo $archive_title; ?></h1>
                </div>

                <?php if (get_the_archive_description() != '') : ?>

                        <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

                <?php endif; ?>


    </header><!-- .page-header -->

    <!-- .page-header -->
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

    <?php 
        $header_count = 0;
        $article_count = 0;
        $post_count = $wp_the_query->post_count;

        while ( have_posts() ) : the_post(); ?>

            <?php

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
                                                    <p>' . wp_trim_words(get_the_content($issue_id), 40) . '</p>
                                                    <div class="directory-header-button-container">
                                                        <a href="' . esc_url( $link ) . '" class="button button-category button-outline" target="' . esc_attr($target) . '"><span class="material-symbols-outlined">arrow_forward</span>READ NOW</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';



                $digital_issue_html .= '</div>';

                echo $digital_issue_html;

                echo '<div id="publication-archive-ads"></div>';

                if ($post_count > 1) {
                    echo '<div class="sep-wrap clearfix">
                            <h2 class="sep-title"><span class="material-symbols-outlined">arrow_outward</span>Previous Editions</h2>
                          </div>
                    <p>Click on the cover to read previous editions.</p>
                    
                    <div id="post-list" class="archive-row">';
                }

                $header_count++;

                continue;
                
            } else { 

                include('digital-issues/digital-issue-content.php');

                $article_count++;
                
            }
            ?>

            <?php endwhile; ?>
        </div>

<?php
if ( $article_count != 0 || $article_count != 4 ) {
    //echo '</div>';
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

</article>
				<!-- #main -->

			

			


<?php get_footer(); ?>