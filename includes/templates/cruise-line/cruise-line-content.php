
        <section class="cruise-line-about">

            <h2>About <?php echo get_the_title(); ?></h2>

            <?php echo get_post_meta(get_the_id(), 'cruise_line_about', true); ?>
        </section>
        
        
        <?php $video = rwmb_the_value( 'cruise_line_video', '', '', false );
        if ($video != '' && strpos($video, 'oembed-not-available') == false) { ?>
        
        <section class="container-fluid cruise-line-about cruise-line-video">
            <h2><?php echo get_the_title(); ?> Intro Video</h2>
            <div class="video-embed">
                <?php echo $video; ?>
            </div>
        </section>
        <?php } ?>

        
        <?php $cruise_line_about = get_post_meta(get_the_id(), 'cruise_line_choose', true); ?>
        <?php if (trim(strip_tags($cruise_line_about)) != '') { ?>
        
        <section class="container-fluid cruise-line-about">
            <h2>Why Choose <?php echo get_the_title(); ?></h2>

            <?php echo get_post_meta(get_the_id(), 'cruise_line_choose', true); ?>
        </section>
        <?php } ?>
        
        <?php $members_club = $cruise_line_about;
        if (trim(strip_tags($members_club)) != '') { ?>
        
        <section class="cruise-line-about cruise-line-video">
            <h2>Rewards Programmes</h2>

            <?php echo $members_club; ?>

        </section>
        <?php } ?>
    

    <section class="item-footer cruise-line-footer col-md-12">
    </section>
