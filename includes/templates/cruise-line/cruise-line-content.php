<div class="container">
    <div class="row">
        <div class="col-md-8 no-padding">
            <div class="container-fluid cruise-line-about">
            
                <h2>About <?php echo get_the_title(); ?></h2>
            
                <?php echo get_post_meta(get_the_id(), 'cruise_line_about', true); ?>
            </div>
            <?php $video = rwmb_the_value( 'cruise_line_video', '', '', false );
            if ($video != '' && strpos($video, 'oembed-not-available') == false) { ?>
            <div class="container-fluid cruise-line-about cruise-line-video">
                <h2><?php echo get_the_title(); ?> Intro Video</h2>
                <div class="video-embed">
                    <?php echo $video; ?>
                </div>
            </div>
            <?php } ?>
            <?php $cruise_line_about = get_post_meta(get_the_id(), 'cruise_line_choose', true); ?>
            <?php if (trim(strip_tags($cruise_line_about)) != '') { ?>
            <div class="container-fluid cruise-line-about">
                <h2>Why Choose <?php echo get_the_title(); ?></h2>
            
                <?php echo get_post_meta(get_the_id(), 'cruise_line_choose', true); ?>
            </div>
            <?php } ?>
            <?php $members_club = $cruise_line_about;
            
            if (trim(strip_tags($members_club)) != '') { ?>
            <div class="container-fluid cruise-line-about cruise-line-video">
                <h2>Rewards Programmes</h2>
                
                <?php echo $members_club; ?>
                
            </div>
            <?php } ?>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>
