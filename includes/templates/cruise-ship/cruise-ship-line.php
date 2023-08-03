<?php

/*echo '<pre>';
print_r($ship);
echo '</pre>';*/

?>

<section id="ship-line">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="container-fluid no-padding cruise-ship-line item_wrap">
                <div class="ship-line-logo">
                    <a href="<?php echo get_permalink($ship->ship_cruise_line); ?>">
                        <?php echo get_the_post_thumbnail($ship->ship_cruise_line, 'small'); ?>
                    </a>
                </div>
                <div class="ship-line-content">
                    <h3><a href="<?php echo get_permalink($ship->ship_cruise_line); ?>"><?php echo get_the_title($ship->ship_cruise_line); ?></a></h3>
                    <a href="<?php echo get_permalink($ship->ship_cruise_line); ?>" class="read-more">READ MORE</a>
                </div>
            </div>
        </div>
    </div>
</section>