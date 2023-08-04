<?php
/**
 * @package understrap
 */
?>
    	<div class="row">
    		<div class="col-md-10 no-padding">
    	
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
                        echo '<p><span class="material-symbols-outlined">link</span><a href="' . $job->job_url . '" target="_blank">' . $job->job_url . '</a></p>';
                    }
                    if ($job->job_email != '') {
                        echo '<p><span class="material-symbols-outlined">mail</span><a href="mailto:' . $job->job_email . '" target="_blank">' . $job->job_email . '</a></p>';
                    }
                    ?>
						
	            </div>
                
	        </div><!-- col-md-8 offset 2 -->
	        <div class="col-md-4">
    
            </div>
			
	    </div><!-- Row -->
