<?php
global $job;
do_action('get_job_data');
?>
<div class="listing-container">

    <div class="listing-content">

        <p class="category">
            <span class="material-symbols-outlined">apartment</span>
            <?php echo $job->job_company; ?>
        </p>

        <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>

        <div class="logo-container">
            <?php echo wp_get_attachment_image( $job->job_logo, 'logo-no-crop' ); ?>
        </div>

        <div class="listing-icon-info">
        <p class="meta">
            <span class="material-symbols-outlined">location_on</span>
            <span class="location"><?php echo $job->job_location; ?></span>
        </p>
        <p class="meta">
            <span class="material-symbols-outlined">work</span>
            <?php echo $job->job_scope; ?>
        </p>
        </div>

        <p class="listing-description"><?php echo wp_trim_words( $job->job_description, 45, '...'); ?></p>

        <div class="listing-footer">
            <a href="<?php echo the_permalink(); ?>" class="button button-brand button-outline">
                <span class="material-symbols-outlined">arrow_forward</span>Find out more
            </a>
        </div>
        <!-- <div class="entry-meta">
        </div>.entry-meta -->
    </div>
</div>
