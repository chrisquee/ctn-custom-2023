<?php
/*echo '<pre>';
print_r($ship);
echo '</pre>';*/

if (isset($ship->ship_dining) && !empty($ship->ship_dining)) { ?>
<section id="ship-dining">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="no-padding cruise-line-dining">
                
                <h2>Dining</h2>
                
                <?php echo isset($ship->ship_dining_intro) && $ship->ship_dining_intro != '' ? $ship->ship_dining_intro : ''; ?>
                
                <?php foreach ($ship->ship_dining as $dining) { ?>
                <div class="col-md-12 no-padding dining-wrap cruise-ship-meta-wrap">
                    <div class="meta-title">
                        <h3><?php echo $dining['dining_name'] != '' ? $dining['dining_name'] : ''; ?></h3>
                    </div>
	                <div class="meta-images">
                    <?php
                        //print_r($dining);
                        //$images = explode(',', $auction_meta['image_gallery'][0]);

                        //$images = $dining['dining_images'];
                        $images = $dining['dining_widgety_images'];                                      

                        $main_img_html = '<div class="slider lgallery slider-for">';
                        $mini_img_html = '<div class="slider slider-nav">';                                                    

                        $main_image_id = $dining['dining_images'][0] ?? '';

                        /*if ($images) {
                          foreach ($dining['dining_images'] as $image) {

                              $img_src = wp_get_attachment_image_src( $image, 'main-post-image' );

                              $main_img_html .= '<div data-src="' . $img_src[0] . '"><a href="' . wp_get_attachment_url( $image, 'landing-page-bg' ) . '" class="lightbox" data-src="' . wp_get_attachment_url( $image, 'landing-page-bg' ) . '">' . wp_get_attachment_image( $image, 'main-post-image', "", array( "class" => "img-responsive" ) ) . '</a></div>';

                              $mini_img_html .= sizeof($images) > 1 ? '<div>' . wp_get_attachment_image( $image, 'thumbnail', "", array( "class" => "img-responsive" ) ) . '</div>' : '<div></div>';

                          }
                        }*/
                                                               
                        if ($images) {
                          foreach ($dining['dining_widgety_images'] as $image) {

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
                        <?php echo $dining['dining_description'] != '' ? $dining['dining_description'] : ''; ?></h3>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>