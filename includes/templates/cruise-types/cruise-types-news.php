<?php 

$news_category = get_term_meta($cruise_type->term_id, 'cruise-type-news-category', true);

$args = array('post_type' => 'post',
              'numberposts' => 7,
              'category' => $news_category
            );
                  
$news_items = get_posts($args);

$html = '';

if (!empty($news_items)) {
    
    $html .= '<div class="container cruise-type-news">
                <div class="row">
                    <div class="col-md-12 no-padding">
                        <div class="sep-wrap clearfix">
                            <h2>Related News</h2>
                            <a href="" class="sep-link"></a>
                        </div>';
    
    $layout_array = array(1 => array('cols' => 3,
                                     'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                    ),
                          2 => array('cols' => 4,
                                     'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard', 4 => 'standard')
                                    ),
                        );
                        
    $html .= '<div class="row latest-wrapper cruise-type-row archive-top-articles">';
    $post_index = 0;

    $data = new cqShortcodes();

    foreach ($layout_array as $row_key => $row) {
        
        global $post;

        $col_class = 'col_' . 12/$row['cols'];
        $fallback_class = 'col-md-' . 12/$row['cols'];
        $fallback_class = '';

        $item_keys = array_keys($row['types']);
        $last_item = end($item_keys);

        foreach ($row['types'] as $type_key => $type) {
            
            if (isset($news_items[$post_index])) {
            
                $post = $news_items[$post_index];

                setup_postdata($post);

                $category = $data->get_cat_name_link(get_the_id());
                $mobile_view = $post_index == 0 ? '' : 'mobile_view';


                if ($type == 'overlay') {
                    $html .= '<div class="cq_overlay item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '" style="background-image: url(' . get_the_post_thumbnail_url(get_the_id(), 'large') . ')">
                                <a href="' . get_the_permalink(get_the_id()) . '">
                                    ' . get_the_post_thumbnail(get_the_id(), 'featured-box-bg-image') . '
                                </a>
                                <div class="item_content">
                                    <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                    <time datetime="' . get_the_date( 'c', get_the_id() ) . '">' . get_the_date( 'j F Y', get_the_id() ) . '</time>
                                    <h3><a href="' . get_the_permalink(get_the_id()) . '">' . get_the_title() . '</a></h3>
                                </div>
                              </div>';


                } else if ($type == 'standard' || $type == 'standard_no_img') {
                    $html .= '<div class="cq_standard item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">';

                    if ($type == 'standard') {
                        $html .= '  <a href="' . get_the_permalink(get_the_id()) . '">
                                    ' . get_the_post_thumbnail(get_the_id(), 'featured-box-bg-image') . '
                                    </a>';
                    }

                    $html .=   '<div class="item_content">
                                    <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                    <time datetime="' . get_the_date( 'c', get_the_id() ) . '">' . get_the_date( 'j F Y', get_the_id() ) . '</time>
                                    <h3><a href="' . get_the_permalink(get_the_id()) . '">' . get_the_title() . '</a></h3>
                                </div>
                                <a href="' . get_the_permalink(get_the_id()) . '" class="read-more">READ MORE</a>
                              </div>';
                } else if ($type == 'to_side') {
                    $html .= '<div class="cq_to_side item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">
                                <a href="' . get_the_permalink(get_the_id()) . '" class="side-img">
                                    ' . get_the_post_thumbnail(get_the_id(), 'featured-box-bg-image') . '
                                </a>
                                <div class="item_content">
                                    <div class="item_content_wrap">
                                        <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                        <time datetime="' . get_the_date( 'c', get_the_id() ) . '">' . get_the_date( 'j F Y', get_the_id() ) . '</time>
                                        <h3><a href="' . get_the_permalink(get_the_id()) . '">' . get_the_title() . '</a></h3>
                                        <p>' . get_the_excerpt( get_the_id() ) . '</p>
                                        <a href="' . get_the_permalink(get_the_id()) . '" class="read-more">READ MORE</a>
                                    </div>
                                </div>
                              </div>';
                }

                wp_reset_postdata();

                $post_index++;

            }
        }
    }
    
    $html .= '          </div>
                    </div>
                </div>
            </div>';
    
}

 echo $html;