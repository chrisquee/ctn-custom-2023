<?php

$issue_id = get_the_ID();
$external_link = get_post_meta($issue_id, 'di_external_link', true);
$link = strpos($external_link, 'http', 0) !== false ? $external_link : get_permalink($issue_id);
$target = strpos($link, site_url(), 0) !== false ? '_self' : '_blank';

?>
<div class="digital-issue-item">
    <div class="digital-issue-img">
        <a href="<?php echo esc_url( $link ); ?>" target="' . esc_attr($target) . '">
        <?php echo get_the_post_thumbnail(get_the_id(), 'full', array( 'class' => 'img-responsive' )); ?></a>
    </div>
    <a href="<?php echo esc_url( $link ); ?>" target="' . esc_attr($target) . '" class="button-brand button-fill button di-read" style="margin: 0;display: block;text-align: center;position: absolute;">READ NOW</a>
</div>