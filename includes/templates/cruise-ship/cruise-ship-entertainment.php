<?php
/*echo '<pre>';
print_r($ship);
echo '</pre>';*/

if (isset($ship->ship_entertainment) && !empty($ship->ship_entertainment)) { ?>
<section id="ship-entertainment">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="no-padding cruise-line-entertainment">
                
                <h2>Entertainment</h2>
                
                <?php echo isset($ship->ship_entertainment_intro) && $ship->ship_entertainment_intro != '' ? $ship->ship_entertainment_intro : ''; ?>
                
                <?php foreach ($ship->ship_entertainment as $entertainment) { ?>
                <div class="col-md-12 no-padding entertainment-wrap cruise-ship-meta-wrap">
                    <div class="meta-title">
                        <h3><?php echo $entertainment['entertainment_name'] != '' ? $entertainment['entertainment_name'] : ''; ?></h3>
                    </div>
	                <div class="meta-images">
                    <?php
                        //print_r($entertainment);
                        //$images = explode(',', $auction_meta['image_gallery'][0]);

                        //$images = $entertainment['entertainment_images'];
                        $images = $entertainment['entertainment_widgety_images']; 

                        $main_img_html = '<div class="slider lgallery slider-for">';
                        $mini_img_html = '<div class="slider slider-nav">';                                                    

                        $main_image_id = $entertainment['entertainment_images'][0] ?? '';

                        /*if ($images) {
                          foreach ($entertainment['entertainment_images'] as $image) {

                              $img_src = wp_get_attachment_image_src( $image, 'main-post-image' );

                              $main_img_html .= '<div data-src="' . $img_src[0] . '"><a href="' . wp_get_attachment_url( $image, 'landing-page-bg' ) . '" class="lightbox" data-src="' . wp_get_attachment_url( $image, 'landing-page-bg' ) . '">' . wp_get_attachment_image( $image, 'main-post-image', "", array( "class" => "img-responsive" ) ) . '</a></div>';

                              $mini_img_html .= sizeof($images) > 1 ? '<div>' . wp_get_attachment_image( $image, 'thumbnail', "", array( "class" => "img-responsive" ) ) . '</div>' : '<div></div>';

                          }
                        }*/
                                                                             
                        if ($images) {
                          foreach ($entertainment['entertainment_widgety_images'] as $image) {

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
                        <?php echo $entertainment['entertainment_description'] != '' ? $entertainment['entertainment_description'] : ''; ?></h3>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>