<?php 

$news_category = get_term_meta($cruise_type->term_id, 'cruise-type-news-category', true);

$args = array('post_type' => 'post',
              'posts_per_page' => 5,
              'category' => $news_category
            );

$html = '';
                  
$post_list = new WP_Query($args);
            
if ($post_list->have_posts()) {

    $desktop_class = 'cards';
    $mobile_class = 'with_image';

    $html .= '<div class="sep-wrap clearfix">
                    <h2 class="sep-title">Related News</h2>
                </div>';

    $html .= '<div class="latest-wrapper ' . $desktop_class . ' ' . $mobile_class . '">';

    while($post_list->have_posts()) {
        $post_list->the_post();

        $thumb_id = get_post_thumbnail_id();
        $post_id = get_the_ID();

        $category = get_the_category();
        $category_title = $category[0]->name;
        $category_link = get_category_link($category[0]->term_id);

        $primary_category = smart_category_top_parent_id($category[0]->term_id);
        $primary_category_title = get_category($primary_category)->name;
        $primary_category_link = get_category_link($primary_category);
        $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', get_the_content());

        if ($category_title != $primary_category_title) {
            $category_html = '<a href="' . $primary_category_link . '">' . $primary_category_title . '</a>
                              <a href="' . $category_link . '" class="cat-hidden">/ ' . $category_title . '</a>';
        } else {
            $category_html = '<a href="' . $primary_category_link . '">' . $primary_category_title . '</a>';
        }


        $html .= '<article id="post-' . get_the_ID() . '" class="latest-item">
                      <div class="item-image">
                          <a href="' . esc_url( get_permalink() ) .'" title="' . get_the_title() . '" class="latest-img-overlay">
                              ' . get_the_post_thumbnail( get_the_ID(), 'featured-box-bg-image' ) . '
                          </a>
                      </div>
                      <div class="item-content">
                        <div class="item-info">
                            <div class="item-title">
                                <h3><a href="' . get_the_permalink() . '" class="title-gradient">' . get_the_title() . '</a></h3>
                            </div>

                            <div class="item-category cat-link">
                                <span class="material-symbols-outlined">arrow_outward</span>
                                ' .$category_html . '
                            </div>
                        </div>
                        <p>' . wp_trim_words( $excerpt, 40, '...') . '</p>
                        <div class="item-author author-text">
                            ' . get_the_author() . '
                        </div>
                      </div>
                  </article>';

    }

    $html .= '</div>';

}

echo $html;