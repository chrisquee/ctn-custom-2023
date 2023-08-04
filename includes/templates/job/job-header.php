<div class="back">
    <div class="col-md-12">
        <a href="javascript:history.back();" class="back-to-job-board">
            <span class="material-symbols-outlined">arrow_back</span>JOBS BOARD
        </a>
    </div>
</div>

<header class="entry-header">
    <div class="row-fluid row-eq-height">

        <div class="col-md-12">

            <div class="company-logo-div">
                 <?php echo wp_get_attachment_image( $job->job_logo, 'logo-no-crop' ); ?>
            </div>

            <h3 class="listing-category">
                <span class="material-symbols-outlined">apartment</span>
                <?php echo esc_html($job->job_company); ?>
            </h3>

            <?php the_title( '<h1 class="listing-title">', '</h1>' ); ?>

            <!-- <div class="entry-meta job-posted">
                Posted <?php echo time_ago(get_the_time()); ?>
            </div>.entry-meta -->
            
            <div class="listing-details">
                <?php 
                if ($job->job_location != '') {
                    echo '<p><span class="material-symbols-outlined">location_on</span>' . $job->job_location . '</p>';
                }
                if ($job->job_type_name != '') {
                    echo '<p><span class="material-symbols-outlined">work</span>' . $job->job_type_name . '</p>';
                }
                if ($job->job_scope != '') {
                    echo '<p><span class="material-symbols-outlined">schedule</span>' . $job->job_scope . '</p>';
                }
                ?>
            </div>
        </div>


    </div>
</header><!-- .entry-header -->


