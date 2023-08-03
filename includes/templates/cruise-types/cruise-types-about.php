<?php
$about = get_term_meta($cruise_type->term_id, 'cruise-type-about', true);

if ($about != '') { ?>

<div class="cruise-type-regions">
        <div class="col-md-8 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title">About</h2>
                <a href="" class="sep-link"></a>
            </div>
            
            <div class="region-about">
                <?php echo wpautop($about); ?>
            </div>
            
        </div>
        <div class="col-md-4 sidebar-ads">
            <?php dynamic_sidebar('udg-ads'); ?>
        </div>
</div>
<?php
}