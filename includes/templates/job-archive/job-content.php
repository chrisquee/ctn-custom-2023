<?php
global $job;
do_action('get_job_data');
?>
<div class="job-listing col_12">
    <div class="job-listing-content">
        <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
        <p class="company"><?php echo $job->job_company; ?></p>
        <p class="meta"><?php echo $job->job_location; ?> | <?php echo $job->job_scope; ?></p>
        
        <p class="intro"><?php echo $job->job_description; ?></p>
        
        <div class="job-footer">
            <a class="job-more" href="<?php echo the_permalink(); ?>">FIND OUT MORE</a>
        </div>
        <div class="entry-meta job-posted">
                <?php echo human_time_diff(get_the_time ( 'U' ), current_time( 'timestamp' )); ?> ago
        </div><!-- .entry-meta -->
    </div>
</div>
