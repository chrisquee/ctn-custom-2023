<?php
$about = get_term_meta($cruise_type->term_id, 'cruise-type-about', true);

if ($about != '') { ?>

<div class="cruise-type-regions">
        <div class="col-md-12 no-padding">
            
            <div class="sep-wrap clearfix">
                <h2 class="sep-title">About</h2>
            </div>
            
            <div class="region-about">
                <?php echo wpautop($about); ?>
            </div>
            
        </div>
</div>
<?php
}