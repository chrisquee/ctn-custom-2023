<?php
/**
 * @package understrap
 */
?>
    
				<div class="entry-content description">

					<?php the_content(); ?>
						
	            </div><!-- .entry-content -->
                
                <div class="job-apply">

					<h3>How to apply</h3>
                    
                    <?php echo wpautop($job->application_instructions); ?>
						
	            </div>

                <div class="job-contacts">

					<?php 
                    if ($job->job_url != '') {
                        $job_url_parsed = parse_url($job->job_url);
                        echo '<p><a href="' . $job->job_url . '" target="_blank"><span class="fa fa-desktop"></span> ' . $job_url_parsed['host'] . '</a></p>';
                    }
                    if ($job->job_email != '') {
                        echo '<p><a href="mailto:' . $job->job_email . '" target="_blank"><span class="fa fa-envelope"></span> ' . $job->job_email . '</a></p>';
                    }
                    ?>
						
	            </div>
                
	        </div><!-- col-md-8 -->
	        <div class="col-md-4 sidebar-ads">
                <?php dynamic_sidebar('job-board-ads'); ?>
            </div>
			
	    </div><!-- Row -->
	</div> <!-- Container -->
