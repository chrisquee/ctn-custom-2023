<div class="container">
	<div class="row article-links">
		<div class="col-md-6 no-padding hidden-sm-down back">
			<a href="javascript:history.back();" style="color: #a1234a;">BACK TO JOBS BOARD</a>
		</div>
        <div class="col-md-6 no-padding">
            <?php
              global $wp;
              $current_url = home_url(add_query_arg(array(), $wp->request));

              $posttitle = get_the_title($post->ID);
              $posturl = home_url(add_query_arg(array(), $wp->request));

              echo '<ul class="social-share-col">';
              echo '<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='.@urlencode($posturl).'" title="Facebook" target="_blank"><span class="fa fa-facebook"></span></a></li>';
              echo '<li class="twitter"><a href="https://twitter.com/intent/tweet/?text='.@urlencode($posttitle).'&amp;url='.@urlencode($posturl).'&amp;via=cruisetradenews&hashtags=avbusinessnews" title="Twitter" target="_blank"><span class="fa fa-twitter"></span></a></li>';
              echo '<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url='.@urlencode($posturl).'&title='.@urlencode($posttitle) . '" title="LinkedIn" target="_blank"><span class="fa fa-linkedin"></span></a></li>';
              echo '<li class="whatsapp"><a href="https://wa.me/?text='.@urlencode('Hi, I found this on cruisetradenews.com, and thought you might be interested - ' . $posttitle . ' - ' . $posturl).'" title="Whatsapp" target="_blank"><span class="fa fa-whatsapp"></span></a></li>';
								
              echo '</ul>';
			?>
        </div>
	</div>
</div>
<div class="container">
    <div class="row meta-row">
        <div class="entry-meta job-posted">
            Posted <?php echo human_time_diff(get_the_time ( 'U' ), current_time( 'timestamp' )); ?> ago
        </div><!-- .entry-meta -->
    </div>
</div>

<div class="container">
    	<div class="row">
    		<div class="col-md-8 no-padding">

                <header class="entry-header">
                    <div class="row-fluid row-eq-height">
                        <div class="col-md-12 article-title job-title">
                            <?php echo wp_get_attachment_image( $job->job_logo, 'logo-no-crop' ); ?>
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                            <h3 class="job-company"><?php echo esc_html($job->job_company); ?></h3>

                            <div class="job-details">
                                <?php 
                                if ($job->job_location != '') {
                                    echo '<p>' . $job->job_location;
                                }
                                if ($job->job_type_name != '') {
                                    echo ' | ' . $job->job_type_name;
                                }
                                if ($job->job_scope != '') {
                                    echo ' | ' . $job->job_scope . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </header><!-- .entry-header -->
