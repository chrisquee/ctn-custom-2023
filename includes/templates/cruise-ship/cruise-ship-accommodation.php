<?php
//echo '<pre>';
//print_r($ship);
//echo '</pre>';

if (isset($ship->ship_accommodation) && !empty($ship->ship_accommodation)) { ?>
<section id="ship-accommodation">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="no-padding cruise-line-accomodation">
                
                <h2>Accommodation</h2>
                
                <?php echo isset($ship->ship_accommodation_intro) && $ship->ship_accommodation_intro != '' ? $ship->ship_accommodation_intro : ''; ?>
                
                <?php foreach ($ship->ship_accommodation as $accomodation) { ?>
                <div class="col-md-12 no-padding accomodation-wrap cruise-ship-meta-wrap">
                    <div class="meta-title">
                        <h3><?php echo $accomodation['accomodation_name'] != '' ? $accomodation['accomodation_name'] : ''; ?></h3>
                    </div>
	                <div class="meta-images">
                    <?php
                        //print_r($accomodation);
                        //$images = explode(',', $auction_meta['image_gallery'][0]);

                        $images = $accomodation['accomodation_widgety_images'];

                        $main_img_html = '<div class="slider lgallery slider-for">';
                        $mini_img_html = '<div class="slider slider-nav">';       

                        $main_image_id = $accomodation['accomodation_images'][0] ?? '';

                        if ($images) {
                          foreach ($accomodation['accomodation_widgety_images'] as $image) {

                              $img_src_main = $ship->maybe_add_https($image[0]);
                              $img_src_thumb = $ship->maybe_add_https($image[1]);

                              $main_img_html .= '<div data-src="' . $img_src_main . '"><a href="' . esc_url($img_src_main) . '" class="lightbox" data-src="' . esc_url($img_src_main) . '"><img src="' . esc_url($img_src_main) . '" class="img-responsive" alt="" width="800" height="500" /></a></div>';
                              
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
                        <?php echo $accomodation['accomodation_description'] != '' ? $accomodation['accomodation_description'] : ''; ?></h3>
                    </div>
                    <?php if (isset($accomodation['accomodation_facilities']) && !empty($accomodation['accomodation_facilities'])) { ?>
                    <div class="meta-facilities">
                        <h4>Facilities</h4>
                        <ul class="accomodation-facilities">
                            <?php foreach ($accomodation['accomodation_facilities'] as $facility) { 
                                     if (!is_array($facility)) { ?>
                                <li class="facility"><?php echo esc_html($facility); ?></li>
                                
                               <?php }
                                  } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>