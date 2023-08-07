<?php
/*echo '<pre>';
print_r($ship);
echo '</pre>';*/

if (isset($ship->ship_deckplans) && !empty($ship->ship_deckplans)) { ?>
<section id="ship-deckplans">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="no-padding cruise-line-deckplans">
                
                <h2>Deckplans</h2>
                
                <?php echo isset($ship->ship_deckplans_intro) && $ship->ship_deckplans_intro != '' ? $ship->ship_deckplans_intro : ''; ?>
                
                <?php foreach ($ship->ship_deckplans as $deckplans) { ?>
                <div class="col-md-12 no-padding deckplans-wrap cruise-ship-meta-wrap">
                    <div class="meta-title">
                        <h3><?php echo $deckplans['deckplans_name'] != '' ? $deckplans['deckplans_name'] : ''; ?></h3>
                    </div>
	                <div class="meta-images">
                    <?php
                                                                     
                        $images = $deckplans['deckplans_widgety_images'];                                      

                        $main_img_html = '<div class="slider lgallery slider-for">';
                        $mini_img_html = '<div class="slider slider-nav">';                                                    
                                                               
                        if ($images) {
                          foreach ($deckplans['deckplans_widgety_images'] as $image) {

                              $img_src_main = $ship->maybe_add_https($image[1]);
                              $img_src_light_box = $ship->maybe_add_https($image[0]);
                              $img_src_thumb = $ship->maybe_add_https($image[2]);

                               $main_img_html .= '<div data-src="' . $img_src_main . '"><a href="' . esc_url($img_src_light_box) . '" class="lightbox" data-src="' . esc_url($img_src_light_box) . '"><img src="' . esc_url($img_src_main) . '" class="img-responsive" alt="" width="800" height="500" /></a></div>';
                              
                              $mini_img_html .= sizeof($images) > 1 ? '<div><img src="' . esc_url($img_src_thumb) . '" class="img-responsive" alt="" srcset="' . esc_url($img_src_thumb) . ' 150w, ' . esc_url($img_src_thumb) . ' 300w" sizes="(max-width: 150px) 100vw, 150px" width="150" height="150"></div>' : '<div></div>';

                          }
                        }                                      

                        $main_img_html .= '</div>';
                        $mini_img_html .= '</div>';

                        echo $main_img_html;
                        echo $mini_img_html;
                    ?>
                    </div>
                    <div class="meta-content">
                        <?php echo $deckplans['deckplans_description'] != '' ? $deckplans['deckplans_description'] : ''; ?></h3>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>