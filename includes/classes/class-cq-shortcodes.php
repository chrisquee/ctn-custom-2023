<?php
class cqShortcodes {
	
	private $plugin_name = 'cq-custom';
    public $home_page_post_ids = array();
	
	public static function init() {
		$self = new self();
		add_shortcode('cq_large_cta', array($self, 'cq_large_cta_shortcode'));
		add_shortcode('cq_title_separator', array($self, 'cq_title_separator_shortcode'));
        add_shortcode('cq_featured_news', array($self, 'cq_featured_news_shortcode'));
        add_shortcode('cq_latest_news', array($self, 'cq_latest_news_shortcode'));
        add_shortcode('cq_latest_digital_issues', array($self, 'cq_latest_digital_issues_shortcode'));
        add_shortcode('cq_latest_issue', array($self, 'cq_latest_issue_shortcode'));
        add_shortcode('cq_latest_post_row', array($self, 'cq_latest_post_row_shortcode') );
        add_shortcode('cq_publication_box', array($self, 'cq_publication_box_shortcode') );
        add_shortcode('cq_in_page_menu', array($self, 'cq_in_page_menu_shortcode'));
        add_shortcode('cq_events_list', array($self, 'cq_events_list_shortcode'));
        add_shortcode('cq_category_carousel', array($self, 'cq_category_carousel_shortcode'));
        add_shortcode('cq_category_carousel_item', array($self, 'cq_category_carousel_item_shortcode'));
        add_shortcode('cq_category_grid', array($self, 'cq_category_grid_shortcode'));
        add_shortcode('cq_category_grid_item', array($self, 'cq_category_grid_item_shortcode'));
        add_shortcode('cq_category_link_block', array($self, 'cq_category_block_shortcode'));
        add_shortcode('cq_newsletter_block', array($self, 'cq_newsletter_block_shortcode'));
        add_shortcode('cq_single_ad_space', array($self, 'cq_single_ad_space_shortcode'));
        add_shortcode('cq_post_timeline', array($self, 'cq_post_timeline_shortcode'));
        add_shortcode('cq_featured_regions', array($self, 'cq_featured_regions_shortcode'));
        add_shortcode('cq_featured_regions_item', array($self, 'cq_featured_regions_item_shortcode'));
        add_shortcode('cq_single_region', array($self, 'cq_single_region_shortcode'));
        add_shortcode('cq_featured_destinations', array($self, 'cq_featured_destinations_shortcode'));
        add_shortcode('cq_featured_destinations_item', array($self, 'cq_featured_destinations_item_shortcode'));
        add_shortcode('cq_featured_cruise_lines', array($self, 'cq_featured_cruise_lines_shortcode'));
        add_shortcode('cq_featured_cruise_lines_item', array($self, 'cq_featured_cruise_lines_item_shortcode'));
        add_shortcode('cq_featured_cruise_ships', array($self, 'cq_featured_ships_shortcode'));
        add_shortcode('cq_featured_cruise_ships_item', array($self, 'cq_featured_ships_item_shortcode'));
        add_shortcode('cq_udg_full_width_block', array($self, 'cq_udg_full_width_block_shortcode'));
        add_shortcode('cq_speaker_list', array($self, 'cq_speakers_list_shortcode') );
        add_shortcode('cq_custom_agenda', array($self, 'cq_custom_agenda_shortcode') );
        add_shortcode('cq_custom_agenda_day', array($self, 'cq_custom_agenda_day_shortcode') );
        add_shortcode('cq_standard_carousel', array($self, 'cq_standard_carousel_shortcode') );
        add_shortcode('cq_grid_links', array($self, 'cq_grid_links_shortcode'));
        add_shortcode('cq_latest_jobs_row', array($self, 'cq_latest_jobs_row_shortcode') );
        add_shortcode('cq_call_to_action', array($self, 'cq_call_to_action_shortcode') );
        add_shortcode('cq_grid_links_item', array($self, 'cq_grid_links_item_shortcode'));
        add_filter('embed_oembed_html', array($self, 'cq_wrap_oembed'), 99, 4 );
        add_filter('the_content', array($self, 'cq_wrap_iframe') );
  	}
    
    public function cq_large_cta_shortcode($attributes) {
        
        $cq_cta_atts = shortcode_atts(
                            array(
                                'cq_fw_cta_bg_img' => '',
                                'fw_cta_title' => '',
                                'title_size' => 'h1',
                                'fw_cta_subtitle' => '',
                                'content_position' => '',
                                'text_colour' => 'text-light',
                                'fw_cta_button_1_link' => '',
                                'fw_cta_button_2_link' => ''
                            ), $attributes);
        
        switch ($cq_cta_atts['content_position']) {
            
            case 'center' :

                $con_class = 'col-md-8 offset-md-2 to-center';
                break;

            case 'left' :
                $con_class = 'col-md-6 to-left';
                break;

            case 'right' :
                $con_class = 'col-md-6 offset-md-6 to-right';
                break;

            default:
                case 'left' :
                $con_class = 'col-md-6 to-left';

        }
        
        $button_html = '';
        $title_size = esc_attr($cq_cta_atts['title_size']);
        
        $image_attributes = wp_get_attachment_image_src( $cq_cta_atts['cq_fw_cta_bg_img'], 'featured-box-bg-image' );
	    $cta_img_url = $image_attributes[0];
        
        $button_1 = $this->get_link_params($cq_cta_atts['fw_cta_button_1_link']);
        $button_2 = $this->get_link_params($cq_cta_atts['fw_cta_button_2_link']);
        $colour_class = esc_attr($cq_cta_atts['text_colour']);
        $subtitle_html = $cq_cta_atts['fw_cta_subtitle'] != '' ? '<p>' . esc_html($cq_cta_atts['fw_cta_subtitle']) . '</p>' : '';
        
        if ($button_1['text'] != '') {
            $button_html .= '<a href="' . $button_1['a_link'] . '" class="button button-orange button_1" ' . $button_1['a_target'] . ' ' . $button_1['a_title'] . '>' . esc_html($button_1['text']) . '</a>';
        }
        
        if ($button_2['text'] != '') {
            $button_html .= '<a href="' . $button_2['a_link'] . '" class="button button-blue button_1" ' . $button_2['a_target'] . ' ' . $button_2['a_title'] . '>' . esc_html($button_2['text']) . '</a>';
        }
	
	    $output_html = '<div class="row no-padding cq-cta-wrap ' . $colour_class . '" style="background-image: url(' . $cta_img_url . ');">
                            
                                <div class="cq-cta-content ' . $con_class . '">
                                    <' . $title_size . '>' . esc_html($cq_cta_atts['fw_cta_title']) . '</' . $title_size . '>
                                    ' . $subtitle_html . '
                                    <div class="cta-button-container">
                                        ' . $button_html . '
                                    </div>
                                </div>
                        </div>';
        
        return $output_html;
        
        
    }
    
    public function cq_title_separator_shortcode($attributes) {
        
        $cq_sep_atts = shortcode_atts(
                            array(
                                'separator_title' => '',
                                'see_more_link' => ''
                            ), $attributes);
        
        if (is_array($cq_sep_atts['see_more_link'])) {
            $separator_link = array();
            $separator_link['a_link'] = $cq_sep_atts['see_more_link']['url'];
            $separator_link['a_target'] = $cq_sep_atts['see_more_link']['target'] ?? '_self';
            $separator_link['a_title'] = 'View More';
            $separator_link['text'] = 'View More';    
        } else {
            $separator_link = $this->get_link_params($cq_sep_atts['see_more_link']);
        }
        $separator_link_html = '';
        
        if ($separator_link['a_link'] != '') {
            $separator_link_html = '<a href="' . $separator_link['a_link'] . '" class="view-all" ' . $separator_link['a_target'] . ' ' . $separator_link['a_title'] . '><span class="material-symbols-outlined">add</span>' . esc_html($separator_link['text']) . '</a>';
        }
        
        $title_separator_html = '<div class="sep-wrap clearfix">
                    
                                    <h2 class="sep-title"><span class="material-symbols-outlined">arrow_outward</span>'
                                    . esc_html($cq_sep_atts['separator_title']) . '</h2>' . $separator_link_html . '
                                 </div>';
        
        return $title_separator_html;
        
    }
    
    public function cq_featured_news_shortcode($attributes) {
        
        global $post;
        
        $atts = shortcode_atts(
                            array(
                                'featured_post_category' => '',
                                'post_id' => '',
                                'ad_space' => false,
                                'ad_shortcode' => ''
                            ), $attributes);
        
        $must_include_array = array();
        $size = 5;
        
        if ($atts['post_id'] != '') {
            
            $must_include_array = explode(',', $atts['post_id']);
            
        }
            
        $exclude_array = array_merge($must_include_array, $this->home_page_post_ids);

        $query_args = array( 'post_type' => 'post',
                             'suppress_filters' => true,
                             'post_status' => 'publish',
                             'post__not_in' => $exclude_array,
                             'posts_per_page' => 5
                            );
        
        if (is_numeric($atts['featured_post_category'])) {
			$query_args['cat'] = $atts['featured_post_category'];
		}

        $latest_posts = new WP_Query( $query_args );

        $latest_post_ids = wp_list_pluck( $latest_posts->posts, 'ID' );

        $all_posts_array = array_merge($must_include_array, $latest_post_ids);
        
        $post_list_args = array(
			'post_type' => 'post',
			'suppress_filters' => true,
			'post_status' => 'publish',
            'post__in' => $all_posts_array,
            'orderby' => 'post__in',
			'posts_per_page' => 5
    	);
    
		$post_list = new WP_Query($post_list_args);
        
        $html = '';
        
        if ($post_list->have_posts()) {
        
            $html .= '<div class="featured-wrapper">';
            $post_index = 0;
            
            $ad_active = false;
            if ($atts['ad_shortcode'] != '') {
                if (function_exists('placement_has_ads')) {
                    $ad_active = placement_has_ads($atts['ad_shortcode']);
                }

            }
            
            while($post_list->have_posts()) {
                
                $post_list->the_post();
                $thumb_id = get_post_thumbnail_id();
                $post_id = get_the_ID();
                $this->home_page_post_ids[] = $post_id;
                
                $category = get_the_category();
                $category_title = $category[0]->name;
                $category_link = get_category_link($category[0]->term_id);
                
                $primary_category = smart_category_top_parent_id($category[0]->term_id);
                $primary_category_title = get_category($primary_category)->name;
                $primary_category_link = get_category_link($primary_category);
                
                if ($category_title != $primary_category_title) {
                    $category_html = '<a href="' . $primary_category_link . '">' . $primary_category_title . '</a>
                                      <a href="' . $category_link . '" class="cat-hidden">/ ' . $category_title . '</a>';
                } else {
                    $category_html = '<a href="' . $primary_category_link . '">' . $primary_category_title . '</a>';
                }
                
                if ($post_index == 0) {
                    
                    $html .= '<div class="featured-item main-item index-' . $post_index . '">
                                
                                <div class="item-content">
                                    <div class="item-info">
                                        <div class="item-title">
                                            <h1><a href="' . get_the_permalink() . '" class="title-gradient">' . get_the_title() . '</a></h1>
                                        </div>

                                        <div class="item-category cat-link">
                                            <span class="material-symbols-outlined">arrow_outward</span>
                                            ' .$category_html . '
                                        </div>
                                    </div>

                                    <div class="item-author author-text">
                                        ' . get_the_author() . '
                                    </div>
                                </div>
                                
                                <div class="item-image">
                                    <a href="' . get_the_permalink() . '">
                                    ' . get_the_post_thumbnail($post_id, 'featured-box-bg-image') . '
                                    </a>
                                </div>
                    
                             </div>';
                    
                } else {
                    
                    if ($post_index == 1) {
                       $html .= '<div class="secondary-items-wrap">';
                    }
                    
                    if ($post_index >= 3 && $atts['ad_space'] == true && $ad_active == true) {
                         $ad_html = $atts['ad_space'] == true && $atts['ad_shortcode'] != '' ? do_shortcode('[the_ad_placement id="' . $atts['ad_shortcode'] . '"]') : '';
                         $html .= '<div class="cq_ad_space">
                                   ' . $ad_html . '
                                   </div>';
                        break;
                    }
                    
                    $html .= '<div class="featured-item secondary-item index-' . $post_index . '">
                                <div class="item-info">
                                    <div class="item-title">
                                        <h5><a href="' . get_the_permalink() . '" class="title-gradient">' . get_the_title() . '</a></h5>
                                    </div>

                                    <div class="item-category cat-link">
                                        <span class="material-symbols-outlined">arrow_outward</span>
                                        ' .$category_html . '
                                    </div>
                                </div>
                                
                                <div class="item-author author-text">
                                    ' . get_the_author() . '
                                </div>
                    
                             </div>';
                    
                }
                
                $post_index++;
                
            }
            
            wp_reset_postdata();
            
            if ($post_index > 0) {
                $html .= '</div>';
            }
                    
            
            $html .= '</div>';
            
        }
        
        return $html;
        
    }
    
    /*public function cq_latest_news_shortcode($attributes) {
        
        global $post;
        
        $atts = shortcode_atts(
                            array(
                                'latest_post_category' => '',
                                'latest_post_layout' => '',
                                'ad_space' => false,
                                'ad_shortcode' => '',
                                'post_id' => '',
                                'category_not' => '',
                            ), $attributes);
        
        $post_list_args = array(
			'post_type' => 'post',
			'suppress_filters' => true,
			'post_status' => 'publish',
			'showposts' => 12,
            'post__not_in' => $this->home_page_post_ids,
    	);
        
        if ($atts['category_not'] != '') {
            $suppress_categories = explode(',', $atts['category_not']);
            
            $post_list_args['category__not_in'] = $suppress_categories;
        }
		
		if ($atts['latest_post_category'] != '') {
			$post_list_args['cat'] = $atts['latest_post_category'];
		}
        
        $must_include_list = new stdClass();
		
        if ($atts['post_id'] != '') {
            $must_include = explode(',', $atts['post_id']);
            
            $must_include_args = array(
                 'post_type' => array('post', 'page'),
			     'suppress_filters' => true,
			     'post_status' => 'publish',
			     'showposts' => 12,
                 'post__in' => $must_include,
    	   );
            
           $must_include_list = new WP_Query($must_include_args);
            
        }
    
		$post_list = new WP_Query($post_list_args);
        
        if ($must_include_list) {
        
            $post_list = (object) array_merge_recursive((array)$must_include_list, (array)$post_list);
            
        }
        
        $layout_array = unserialize(base64_decode($atts['latest_post_layout']));
        
        $number_posts = 0;
        
        foreach ($layout_array as $layout) {
            $number_posts += count($layout['types']);
        }
        
        $post_index = 0;
        $post_count = 0;
            
        $html = '<div class="row latest-wrapper">';
            
        $row_keys = array_keys($layout_array);
        $last_row = end($row_keys);
        
        foreach ($post_list->posts as $key => $pst) {
            if (!in_array($pst->ID, $this->home_page_post_ids) && $post_count < $number_posts) {
                if (($atts['ad_space'] != true) || ($atts['ad_space'] == true && $post_count < ($number_posts - 1) )) {
                    $this->home_page_post_ids[] = $pst->ID;
                }
                $post_count++;
            } else {
                unset($post_list->posts[$key]);
            }
        }
        
        $post_list->posts = array_values($post_list->posts);
            
        foreach ($layout_array as $row_key => $row) {

            $col_class = 'col_' . 6/$row['cols'];
            $fallback_class = 'col-md-' . 12/$row['cols'];
            $fallback_class = '';

            $item_keys = array_keys($row['types']);
            $last_item = end($item_keys);

            foreach ($row['types'] as $type_key => $type) {

                if (isset($post_list->posts[$post_index])) {

                    $article = $post_list->posts[$post_index];
                    $category = $this->get_cat_name_link($article->ID);
                    $mobile_view = $post_index == 0 ? '' : 'mobile_view';

                    $cat_html = !empty($category) && $category['cat_a_title'] != '' ? '<a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>' : '';

                    if ($last_row == $row_key && $last_item == $type_key && $atts['ad_space'] == true) {
                         $ad_html = $atts['ad_space'] == true && $atts['ad_shortcode'] != '' ? do_shortcode('[the_ad_placement id="' . $atts['ad_shortcode'] . '"]') : '';
                         $html .= '<div class="cq_ad_space item_wrap ' . $col_class . ' ' . $fallback_class . '" style="background-color: #dadada;">
                                   ' . $ad_html . '
                                     <div class="ad_footer"><span>ADVERTISEMENT</span></div>
                                   </div>';
                        continue;
                    }

                    if ($type == 'overlay') {
                        $html .= '<div class="cq_overlay item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '" style="background-image: url(' . get_the_post_thumbnail_url($article->ID, 'featured-box-bg-image') . ')">
                                    <a href="' . get_the_permalink($article->ID) . '" class="item_link"></a>
                                    <a href="' . get_the_permalink($article->ID) . '">
                                        ' . get_the_post_thumbnail($article->ID, 'featured-box-bg-image') . '
                                    </a>
                                    <div class="item_content">
                                        ' . $cat_html . '
                                        <time datetime="' . get_the_date( 'c', $article->ID ) . '">' . get_the_date( 'j F Y', $article->ID ) . '</time>
                                        <h3><a href="' . get_the_permalink($article->ID) . '">' . $article->post_title . '</a></h3>
                                    </div>
                                  </div>';


                    } else if ($type == 'standard' || $type == 'standard_no_img') {
                        $html .= '<div class="cq_standard item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">';

                        if ($type == 'standard') {
                            $html .= '  <a href="' . get_the_permalink($article->ID) . '">
                                        ' . get_the_post_thumbnail($article->ID, 'featured-box-bg-image') . '
                                        </a>';
                        }

                        $html .=   '<div class="item_content">
                                        ' . $cat_html . '
                                        <time datetime="' . get_the_date( 'c', $article->ID ) . '">' . get_the_date( 'j F Y', $article->ID ) . '</time>
                                        <h3><a href="' . get_the_permalink($article->ID) . '">' . $article->post_title . '</a></h3>
                                    </div>
                                    <a href="' . get_the_permalink($article->ID) . '" class="read-more">READ MORE</a>
                                  </div>';
                    } else if ($type == 'to_side') {
                        $html .= '<div class="cq_to_side item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">
                                    <a href="' . get_the_permalink($article->ID) . '" class="side-img">
                                        ' . get_the_post_thumbnail($article->ID, 'featured-box-bg-image') . '
                                    </a>
                                    <div class="item_content">
                                        <div class="item_content_wrap">
                                            ' . $cat_html . '
                                            <time datetime="' . get_the_date( 'c', $article->ID ) . '">' . get_the_date( 'j F Y', $article->ID ) . '</time>
                                            <h3><a href="' . get_the_permalink($article->ID) . '">' . $article->post_title . '</a></h3>
                                            <p>' . get_the_excerpt( $article->ID ) . '</p>
                                            <a href="' . get_the_permalink($article->ID) . '" class="read-more">READ MORE</a>
                                        </div>
                                    </div>
                                  </div>';
                    }

                    $post_index++;
                }
            }

        }

        $html .= '</div>';
        
        
        wp_reset_postdata();
        
        return $html;
        
    }*/
    
    public function cq_latest_news_shortcode($attributes) {
        
        global $post;
        
        $atts = shortcode_atts(
                            array(
                                'latest_post_category' => '',
                                'desktop_display' => 'full_width',
                                'mobile_display' => 'with_image',
                                'load_more' => false
                            ), $attributes);
        
        $show_posts = $atts['desktop_display'] == 'cards' ? 3 : 2;
        
        $post_list_args = array(
			'post_type' => 'post',
			'suppress_filters' => true,
			'post_status' => 'publish',
            'post__not_in' => $this->home_page_post_ids,
			'showposts' => $show_posts
    	);
		
		if ($atts['latest_post_category'] != '') {
			$post_list_args['cat'] = $atts['latest_post_category'];
		}
	   
        $desktop_class = esc_attr($atts['desktop_display']);
        $mobile_class = esc_attr($atts['mobile_display']);
    
		$post_list = new WP_Query($post_list_args);
            
        if ($post_list->have_posts()) {

            $html = '<div class="latest-wrapper ' . $desktop_class . ' ' . $mobile_class . '">';
            
            while($post_list->have_posts()) {
                $post_list->the_post();
                
                $thumb_id = get_post_thumbnail_id();
                $post_id = get_the_ID();
                $this->home_page_post_ids[] = $post_id;
                
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
            
            if ($atts['load_more'] == true) {
                
                $html .= '<div class="load-more-wrapper"><a href="#" class="load-more" data-cat="' . esc_attr($atts['latest_post_category']) . '" data-page="1" data-perpage="' . $show_posts . '"><span class="material-symbols-outlined">add</span> LOAD MORE</a></div>';
                
            }
            
        }
        
        wp_reset_postdata();
        
        return $html;
        
    }
    
    public function cq_category_carousel_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $html = '<div class="latest-wrapper cq_category_carousel owl-carousel" data-items="5"  data-mobile-items="2" data-margin="15">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_category_carousel_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'category_id' => '',
                            ), $attributes);
        
        $html = '';
        
        if ($atts['category_id'] != '') {
            
            $category_id = $atts['category_id'];
            $category = get_term( $category_id );
            
            $image_id = get_term_meta($category_id, 'category-image-id', true);
            
            $image_data = wp_get_attachment_image_src( $image_id, 'category-carousel-image' );
            
            $html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . $image_data[0] . ')">
                        <a href="' . esc_url(get_term_link( $category )) . '" class="destination-link" title="' . esc_html($category->name) . '"></a>
                        <div class="item_content">
                            <h3><a href="' . esc_url(get_term_link( $category )) . '">' . esc_html($category->name) . '</a></h3>
                        </div>
                      </div>';
        }
                
        return $html;
    }
    
    public function cq_category_grid_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $elements = substr_count($content, '[');
        
        $oddeven = $elements % 2 == 0 && $elements % 5 != 0 ? 'even' : 'odd';
        
        $html = '<div class="latest-wrapper cq_category_grid elements-' . $elements . ' ' . $oddeven . '">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_category_grid_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'category_id' => '',
                            ), $attributes);
        
        $html = '';
        
        if ($atts['category_id'] != '') {
            
            $category_id = $atts['category_id'];
            $category = get_term( $category_id );
            
            $image_id = get_term_meta($category_id, 'category-image-id', true);
            
            $image_data = wp_get_attachment_image_src( $image_id, 'category-carousel-image' );
            
            $img_src = is_array($image_data) ? $image_data[0] : '';
            
            
            $html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . $img_src . ')">
                        <a href="' . esc_url(get_term_link( $category )) . '" class="category_link" title="' . esc_html($category->name) . '"></a>
                        <div class="item_content">
                            <h3><a href="' . esc_url(get_term_link( $category )) . '">' . esc_html($category->name) . '</a></h3>
                        </div>
                      </div>';
        }
                
        return $html;
    }
    
    public function cq_latest_digital_issues_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'to_show' => '3',
                                'publication' => 'All',
                                'collapse_digital_issues' => 'false'
                            ), $attributes);
        
        $items = $atts['to_show'];
		$list_count = 1;
        $digital_issue_html = '';
		
		$issue_list_args = array(
			'post_type' => 'cq_digital_issue',
			'suppress_filters' => true,
			'post_status' => 'publish',
			'showposts' => $items
    	);
		
		if ($atts['publication'] != 'All' && $atts['publication'] != '') {
			$tax_query = array(
				array(
           			'taxonomy' => 'cq_publications',
           			'field' => 'term_id',
           			'terms' => $atts['publication'], 
           			'operator' => 'IN'
   			 	)
			);
			$issue_list_args['tax_query'] = $tax_query;
		}
		
		//$auction_list_args['orderby'] = array('date_clause' => 'ASC', 'time_clause' => 'ASC');
    
		$issue_list = new WP_Query($issue_list_args);
        
        if ($issue_list->have_posts()) {

            $digital_issue_html = '<div class="digital-issue-container">';
            $digital_issue_count = 0;
            
            while($issue_list->have_posts()) {
                $issue_list->the_post();
                $thumb_id = get_post_thumbnail_id();
                $issue_id = get_the_ID();

                $publications = get_the_terms($issue_id, 'cq_publications');
                $print_title = $publications[0]->name;
                
                $display_title = get_post_meta($issue_id, 'di_display_title', true);
                $display_title_value = $display_title !== false && $display_title != '' ? $display_title : get_the_title();

                $collapse_digital_issues = $atts['collapse_digital_issues'];
                $add_class = $digital_issue_count == 0 && $collapse_digital_issues == "false" ? " " : "mobile-view";

                $digital_issue_html .= '<div class="digital-issue-item ' . $add_class . '">
                                            <div class="digital-issue-img">
                                                <a href="' . esc_url( get_permalink($issue_id) ) . '">
                                                ' . get_the_post_thumbnail($issue_id, 'medium', array( 'class' => 'img-responsive' )) . '</a>
                                            </div>
                                            <div class="digital-issue-footer">
                                                <h3><span class="material-symbols-outlined">arrow_outward</span>' . $print_title . '</h3>
                                                <h2><a href="' . esc_url( get_permalink($issue_id) ) . '">' . $display_title_value . '</a></h2>
                                                <a class="view-all-issues-link" href="' . esc_url( get_term_link($publications[0]->term_id) ) . '">View all issues</a>

                                            </div>
                                        </div>';


                if($collapse_digital_issues == "true") {
                    $digital_issue_html .= '<div class="digital-issue-item show-on-mobile">
                                                <h3 class="collapsed-category">
                                                <span class="material-symbols-outlined">arrow_outward</span>' . $print_title . '</h3>
                                                <h2 class="collapsed-heading">' . $display_title_value . '</h2>

                                                <div class="di-links-container">
                                                    <a class="col-last-issue last-issue">Last Issue
                                                        <span class="material-symbols-outlined">arrow_drop_down</span>
                                                    </a>
                                                    <a class="col-last-issue" href="' . esc_url( get_permalink($issue_id) ) . '">View all</a>
                                                </div>
                                                <div class="digital-issue-img di-img-container">
                                                        <a href="' . esc_url( get_permalink($issue_id) ) . '">
                                                        ' . get_the_post_thumbnail($issue_id, 'medium', array( 'class' => 'img-responsive' )) . '</a>
                                                    </div>
                                                <hr>
                                            </div>';                                      
                }
                
                $digital_issue_count ++;
            }
            
            wp_reset_postdata();

            if($collapse_digital_issues == "false") {
                $digital_issue_html .='<h2 class="load-more-header"><span class="material-symbols-outlined">add</span>Load More</h2>';
            }
            
            $digital_issue_html .= '</div>';
    
        }

        return $digital_issue_html;
    }
    
    public function cq_latest_issue_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'publication' => '',
                                'style' => 'large',
                            ), $attributes);
		
		$issue_list_args = array(
			'post_type' => 'cq_digital_issue',
			'suppress_filters' => true,
			'post_status' => 'publish',
			'showposts' => 1
    	);
		
		if ($atts['publication'] != '') {
			$tax_query = array(
				array(
           			'taxonomy' => 'cq_publications',
           			'field' => 'term_id',
           			'terms' => $atts['publication'], 
           			'operator' => 'IN'
   			 	)
			);
			$issue_list_args['tax_query'] = $tax_query;
		}
		
		//$auction_list_args['orderby'] = array('date_clause' => 'ASC', 'time_clause' => 'ASC');
    
		$issue_list = new WP_Query($issue_list_args);
        
        $digital_issue_html = '';
        
        if ($issue_list->have_posts()) {
            
            if ($atts['style'] == 'large') {
                
                $digital_issue_html = '<div class="latest-issue digital-issue-large">';
                
                while($issue_list->have_posts()) {
                    $issue_list->the_post();
                    $thumb_id = get_post_thumbnail_id();
                    $issue_id = get_the_ID();
                    $this->home_page_post_ids[] = $issue_id;
                    $external_link = get_post_meta($issue_id, 'di_external_link', true);
                    $link = strpos($external_link, 'http', 0) !== false ? $external_link : get_permalink($issue_id);
                    $target = strpos($link, site_url(), 0) !== false ? '_self' : '_blank';

                    $digital_issue_html .= '<div class="digital-issue-item">
                                                <div class="digital-issue-img">
                                                    <a href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '">
                                                    ' . get_the_post_thumbnail($issue_id, 'full', array( 'class' => 'img-responsive' )) . '</a>
                                                </div>
                                                <div class="item_content">
                                                    <div class="item_content_wrap">
                                                        <a class="cat-link" href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '" title="Latest Issue">Latest Issue</a>
                                                        <h3><a href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '">' . get_the_title() . '</a></h3>
                                                        ' . get_the_excerpt() . '
                                                        <div class="directory-header-button-container">
                                                            <a href="' . esc_url( $link ) . '" target="' . esc_attr($target) . '" class="button button-blue button_1">READ NOW</a>
                                                            <a href="' . esc_url( site_url('/digital-issues/') ) . '" target="' . esc_attr($target) . '" class="button button-blue button_2">ALL ISSUES</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';


                }
                $digital_issue_html .= '</div>';
            } else {
                
                $digital_issue_html = '<div class="latest-issue digital-issue-compact">';
                
                while($issue_list->have_posts()) {
                    $issue_list->the_post();
                    $thumb_id = get_post_thumbnail_id();
                    $issue_id = get_the_ID();
                    $terms = get_terms( 'cq_digital_issue' );

                    $digital_issue_html .= '<div class="digital-issue-item">
                                                <div class="digital-issue-img">
                                                    <a href="' . esc_url( get_permalink($issue_id) ) . '">
                                                    ' . get_the_post_thumbnail($issue_id, 'full', array( 'class' => 'img-responsive' )) . '</a>
                                                </div>
                                            </div>';
                }
                
                $digital_issue_html .= '</div>';
            }
            
            
            //$digital_issue_html .= '</div>';
        }
        
        wp_reset_postdata();
        
        return $digital_issue_html;
        
    }
    
    public function cq_latest_post_row_shortcode( $attributes ) {
        
        $home_page_post_ids = array();
        $home_page_post_ids = $this->home_page_post_ids;

        $atts = shortcode_atts(array(
            'to_show' => '1',
            'style' => 'standard',
            'latest_post_category' => ''), $attributes);

        $col_class = 'col_' . 12/$atts['to_show'];
        $fallback_class = 'col-md-' . 12/$atts['to_show'];
        $fallback_class = '';
        
        $vertical_class = $atts['style'] == 'vertical' ? 'vertical' : '';
        $gap_class = $atts['to_show'] == '1' ? 'no_gap' : '';
        $post_index = 0;

        $cq_latest_post_row_content = '<div class="row latest-post-row ' .$vertical_class . ' ' . $gap_class . '">';

        if ($atts['latest_post_category'] != '') {
            $query_args = array('cat' => $atts['latest_post_category'], 'post__not_in' => $home_page_post_ids, 'order' => 'DESC', 'ignore_sticky_posts' => 1, 'posts_per_page' => $atts['to_show']);
        } else {
            $sticky = get_option( 'sticky_posts' );
            $sticky = array_slice( $sticky, 0, 1 );
            $query_sticky = array(
                'post__in' => $sticky,
                'ignore_sticky_posts' => 1,
            );
            $query_sticky = new WP_Query($query_sticky);

            $query_args = array('post__not_in' => $home_page_post_ids, 'order' => 'DESC', 'ignore_sticky_posts' => 1, 'posts_per_page' => $atts['to_show'] );
        }

        $post_query = new WP_query($query_args);

        if($post_query->have_posts()) {
            while($post_query->have_posts()) { 

                $post_query->the_post();

                $id = get_the_ID();
                $category = $this->get_cat_name_link($id);
                $this->home_page_post_ids[] = $id;
                $mobile_view = $post_index == 0 ? '' : 'mobile_view';

                $home_page_post_ids[] = $id;
                
                switch ($atts['style']) {
                
                    case 'overlay' :

                        $cq_latest_post_row_content .= '<div class="cq_overlay item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '" style="background-image: url(' . get_the_post_thumbnail_url($id, 'featured-box-bg-image') . ')">
                                                          <a href="' . get_the_permalink($id) . '" class="item_link" title="' . get_the_title() . '"></a>
                                                          <div class="item_content">
                                                              <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                                              <time datetime="' . get_the_date( 'c', $id ) . '">' . get_the_date( 'j F Y', $id ) . '</time>
                                                              <h3><a href="' . get_the_permalink($id) . '">' . get_the_title() . '</a></h3>
                                                          </div>
                                                        </div>';
                        break;
                        
                    case 'vertical' :

                        $cq_latest_post_row_content .= '<div class="cq_vertical item_wrap col_12 ' . $fallback_class . '">
                                                          <div class="item_image">
                                                              <a href="' . get_the_permalink($id) . '">
                                                                  ' . get_the_post_thumbnail($id, 'featured-box-bg-image') . '
                                                              </a>
                                                          </div>
                                                          <div class="item_content">
                                                              <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                                              <h3><a href="' . get_the_permalink($id) . '">' . get_the_title() . '</a></h3>
                                                              <time datetime="' . get_the_date( 'c', $id ) . '">' . get_the_date( 'j F Y', $id ) . '</time>
                                                          </div>
                                                        </div>';
                        break;
                
                    case 'standard' :
                    default :
                        
                        $cq_latest_post_row_content .= '<div class="cq_standard item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">
                                                          <a href="' . get_the_permalink($id) . '">
                                                              ' . get_the_post_thumbnail($id, 'featured-box-bg-image') . '
                                                          </a>
                                                          <div class="item_content">
                                                              <a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>
                                                              <time datetime="' . get_the_date( 'c', $id ) . '">' . get_the_date( 'j F Y', $id ) . '</time>
                                                              <h3><a href="' . get_the_permalink($id) . '">' . get_the_title() . '</a></h3>
                                                          </div>
                                                          <a href="' . get_the_permalink($id) . '" class="read-more">READ MORE</a>
                                                        </div>';
                        
                        
                }
                
                $post_index++;
            }
        }

        $cq_latest_post_row_content .= '	</div>';

        wp_reset_query();
        wp_reset_postdata();

        return $cq_latest_post_row_content;

    }
    
    public function cq_publication_box_shortcode($attributes) {
        
        $atts = shortcode_atts(
                  array(
                      'cq_pub_logo' => '',
                      'title' => '',
                      'description' => '',
                      'style' => 'pub_small',
                      'background_color' => '',
                      'see_more_link' => '',
                      'button_colour' => '',
                      'button_text_colour' => '#ffffff'
                  ), $attributes);
        
        
        $button_html = '';
        
        $image_attributes = wp_get_attachment_image_src( $atts['cq_pub_logo'], 'large' );
	    $pub_img_url = $image_attributes[0];
        $pub_img = wp_get_attachment_image( $atts['cq_pub_logo'], 'medium', "", array( "class" => "img-responsive" ) );
        $bg_style = '';
        
        $button = $this->get_link_params($atts['see_more_link']);
        
        if ($button) {
            $button_html .= '<a href="' . $button['a_link'] . '" class="button" style="background-color: ' . $atts['button_colour'] . '; color: ' . $atts['button_text_colour'] . ';" ' . $button['a_target'] . ' ' . $button['a_title'] . '>' . esc_html($button['text']) . '</a>';
        }
        
        if ($atts['background_color'] != '') {
            $bg_style = 'style="background-color: ' . $atts['background_color'] . '; padding: 1rem;"';
        }
        
        $h_size = $atts['style'] == 'pub_small' ? 'h2' : 'h1';
	
	    $output_html = '<div class="cq-pub-content ' . esc_attr($atts['style']) . '">
                            <div class="col_12 pub-container" ' . $bg_style . '>
                                    <div class="pub-logo">' . $pub_img . '</div> 
                                    <div class="pub-content">
                                        <' . $h_size . '>' . esc_html($atts['title']) . '</' . $h_size .'>
                                        <p>' . esc_html($atts['description']) . '</p>
                                    </div>
                                    <div class="pub-button-container">
                                        ' . $button_html . '
                                    </div>
                            </div>
                        </div>';
        
        return $output_html;
        
        
    }
    
     public function cq_category_block_shortcode($attributes) {
        
        $atts = shortcode_atts(
                  array(
                      'category_id' => '',
                      'background_color' => '',
                  ), $attributes);
        
        
        $button_html = '';
        
        $bg_style = '';
        $category = get_term( $atts['category_id'], 'category' );
        $cat_link = get_category_link($category);
        
        $button_html .= '<a href="' . esc_url($cat_link) . '" class="button button-blue" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a>';
        
        if ($atts['background_color'] != '') {
            $bg_style = 'style="background-color: ' . $atts['background_color'] . '; padding: 1rem;"';
        }
        
	    $output_html = '<div class="cq-pub-content">
                            <div class="col_12 pub-container" ' . $bg_style . '>
                                    
                                    <div class="pub-content">
                                        <h2>' . esc_html($category->name) . '</h2>
                                        <p>' . esc_html($category->description) . '</p>
                                    </div>
                                    <div class="pub-button-container">
                                        ' . $button_html . '
                                    </div>
                            </div>
                        </div>';
        
        return $output_html;
        
        
    }
    
    public function cq_in_page_menu_shortcode( $attributes ) {
        
        extract(shortcode_atts(array( 'menu_id' => null, ), $attributes));
            
        return wp_nav_menu( array( 'menu' => $menu_id, 'container_class' => 'in_page_menu_wrap', 'echo' => false ) );
        
    }
    
    public function cq_events_list_shortcode($attributes) {

        $atts = shortcode_atts(array(
                'max_events'     => '5',
                'future_only' => '1',
                'max_height' => '300px',
                'border_color' => '#f2f2f2',
                'category' => ''
            ), $attributes);

        $now = time();

        $query_args =  array(
            'post_type' => 'events',
            'meta_key'  => 'event_end_date',
            'meta_query' => array(
                array(
                    'key' => 'event_end_date',
                    'value' => $now,
                    'compare' => '>='
                    ),


                ),
            'posts_per_page' => $attributes['max_events'],
            'orderby'   => 'meta_value_num',
            'order'     => 'ASC',
        );
        
        if ($atts['category'] != '') {
			$tax_query = array(
				array(
           			'taxonomy' => 'event-category',
           			'field' => 'term_id',
           			'terms' => $atts['category'], 
           			'operator' => 'IN'
   			 	)
			);
			$query_args['tax_query'] = $tax_query;
		}
        
        $query = new WP_Query($query_args);
        
        $col_class = 'col_' . 12/$atts['max_events'];
        $fallback_class = 'col-md-' . 12/$atts['max_events'];
        $fallback_class = '';
        
        $gap_class = $atts['max_events'] == '1' ? 'no_gap' : '';
        $post_index = 0;

        $html = '<div class="row latest-post-row event-container ' . $gap_class . '">';

        if ( $query->have_posts() ) {
            //$html .= '<div class="container-fluid event-container" style="max-height: ' . esc_attr($attributes['max_height']) . '; border: 1px solid ' . esc_attr($attributes['border_color']) . ';">';

            $post_count = 0;

            while ( $query->have_posts() ) {

                $query->the_post();
                global $post;

                $startd = get_post_meta( $post->ID, "event_start_date", true);
                $startdate = date("F j, Y", $startd);

                $endd = get_post_meta( $post->ID, "event_end_date", true);
                $enddate = date("F j, Y", $endd);
                
                $terms = get_the_terms($post->ID, 'event-category' );
                
                foreach ($terms as $term) {
                    $category = $term->name;
                    break;
                }
                
                $mobile_view = $post_count == 0 ? '' : 'mobile_view';

                $image_html = '';
                $images = rwmb_meta( 'event-logo', array('size' => 'full'), $post->ID ); // Prior to 4.8.0
                            if ( !empty( $images ) ) {
                                foreach ( $images as $image ) {
                                $image['alt'] = get_the_title();
                                $image_html = "<a href='{$image['url']}'><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a>";
                                }
                            }

                $profile_contnet = get_the_content();
                
                 $html .= '<div class="cq_standard item_wrap ' . $col_class . ' ' . $fallback_class . ' ' . $mobile_view . '">
                              <a href="' . rwmb_meta('event_url') . '" target="_blank">
                                  ' . get_the_post_thumbnail($post->ID, 'featured-box-bg-image') . '
                              </a>
                              <div class="item_content">
                                  <a class="cat-link" href="" target="" title="' . $category . '">' . $category . '</a>
                                  <p>' . $startdate . ' | ' . rwmb_meta('event_address') . '</p>
                                  <h3>' . $post->post_title . '</h3>
                              </div>
                              <a href="' . rwmb_meta('event_url') . '" class="read-more">FIND OUT MORE</a>
                          </div>';

                /*if ($start_date == $end_date) {
                    $date_html = $start_date;
                } else {*/
                    //$date_html = '<i class="t-icon icon-calendar-insert"></i> ' . $startdate . ' to ' . $enddate;
                //}

                /*$html .=  '<div class="row-fluid event-listing clearfix event-' . $post_count . '">';

                if ($image_html != '') {				
                    $html .= 			'<div class="col-md-4 event-logo">' . $image_html . '</div>';
                }
                $html .=				'<div class="col-md-12 event-heading"><h3>' . get_the_title() . '</h3></div>
                                <div class="row-fluid">';

                $html .=					'<div class="col-md-4 event-date">' . $date_html . '</div>
                                    <div class="col-md-5 event-address"><i class="fa fa-map-marker"></i> ' . rwmb_meta('event_address') . '</div>';

                if ($profile_content != '') {
                    $html .= '<div class="col-md-12 event-content"><p>' . esc_html($profile_content) . '</p></div>';
                }

                if (rwmb_meta('event_url') != '') {
                    $html .= '<div class="col-md-3 event-link"><a href="' . rwmb_meta('event_url') . '" class="btn btn-default event_link_button" target="_blank">Visit Website</a></div>';
                }

                $html .= 	'</div>
                         </div>';*/

                $post_count++;
            }
            $html .= '</div>';

        }
        
        wp_reset_postdata();

        return $html;
    }
    
    public function cq_newsletter_block_shortcode($attributes) {
        
        $html = '<div class="container no-padding clearfix">
                    <div class="row">
                        <div class="col-md-12 rel-slider no-padding">
                            <div class="row no-padding cq-cta-wrap text-light" style="background-image: url(https://ctndev.qinternet.uk/resources/uploads/2021/10/CTN-Register-Background.jpg);">                   
                                    <div class="cq-cta-content col-md-8 offset-md-2 to-center">
                                        <h2>Subscribe to our newsletter</h2>
                                        <p>Keep up to date with all the latest news and incentives in the Cruise Trade News Newsletter.</p>
                                        ' . do_shortcode('[cq_newsletter_form]') . '
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>';
        
        return $html;
        
    }
    
    public function cq_single_ad_space_shortcode($attributes) {
        
        $atts = shortcode_atts(
                  array(
                      'ad_shortcode' => '',
                  ), $attributes);
        
        $ad_html = $atts['ad_shortcode'] != '' ? do_shortcode('[the_ad_placement id="' . $atts['ad_shortcode'] . '"]') : '';
        $html = '<div class="latest-post-row no_gap">
                        <div class="cq_ad_space single_ad item_wrap col_12 col-md-12" style="background-color: #dadada;">
                            ' . $ad_html . '
                            <div class="ad_footer"><span>ADVERTISEMENT</span></div>
                        </div>
                  </div>';
        
        return $html;
        
    }
    
    public function cq_post_timeline_shortcode($attributes) {
        
        $atts = shortcode_atts(
                  array(
                      'max_posts' => '',
                      'category' => ''
                  ), $attributes);
        
        $content_post_html = '';
        
        $query_args =  array(
            'post_type' => 'post',
            'posts_per_page' => $atts['max_posts'],
            'orderby'   => 'date',
            'order'     => 'DESC',
        );
        
        if ($atts['category'] != '') {
			$tax_query = array(
				array(
           			'taxonomy' => 'category',
           			'field' => 'term_id',
           			'terms' => $atts['category'], 
           			'operator' => 'IN'
   			 	)
			);
			$query_args['tax_query'] = $tax_query;
		}
        
        $query = new WP_Query($query_args);
        
         if ( $query->have_posts() ) {

            $post_count = 0;
            $content_post_html = '<div class="timeline-wrapper">
                                        <div class="timeline-line"></div>';

            while ( $query->have_posts() ) {

                $query->the_post();
                global $post;
                
                $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                
                $gallery_images = rwmb_meta( 'destination-gallery', array( 'size' => 'featured-box-bg-image' ) );
                $author_id = get_the_author_meta( 'ID' );
                
                //print_r($gallery_images);
                
                if (isset($img_url[0])) {
	
                    $main_img_html = '<div class="slider lgallery slider-for">';
                    $mini_img_html = '<div class="slider slider-nav">';

                    $featured_image_id = get_post_thumbnail_id();

                    if (is_int($featured_image_id)) {
                        $main_img_html .= '<div data-src="' . wp_get_attachment_url( $featured_image_id, 'landing-page-bg' ) . '"><a href="' . wp_get_attachment_url( $featured_image_id, 'landing-page-bg' ) . '" class="lightbox" data-src="' . wp_get_attachment_url( $featured_image_id, 'landing-page-bg' ) . '">' . wp_get_attachment_image( $featured_image_id, 'featured-box-bg-image', "", array( "class" => "img-responsive", "itemprop" => "image" ) ) . '</a></div>';

                        $mini_img_html .= sizeof($gallery_images) > 0 ? '<div>' . wp_get_attachment_image( $featured_image_id, 'thumbnail', "", array( "class" => "img-responsive" ) ) . '</div>' : '';
                    }

                    if ($gallery_images) {
                      foreach ($gallery_images as $image) {

                          $img_src = wp_get_attachment_image_src( $image['ID'], 'landing-page-bg' );

                          $main_img_html .= '<div data-src="' . $img_src[0] . '"><a href="' . wp_get_attachment_url( $image['ID'], 'landing-page-bg' ) . '" class="lightbox" data-src="' . wp_get_attachment_url( $image['ID'], 'landing-page-bg' ) . '">' . wp_get_attachment_image( $image['ID'], 'featured-box-bg-image', "", array( "class" => "img-responsive" ) ) . '</a></div>';

                          $mini_img_html .= '<div>' . wp_get_attachment_image( $image['ID'], 'thumbnail', "", array( "class" => "img-responsive" ) ) . '</div>';

                      }
                    }

                    $main_img_html .= '</div>';
                    $mini_img_html .= '</div>';
                    
                } else {
                    $main_img_html = '';
                    $mini_img_html = '';
                }
                
                $content_post_html .= '<div class="timeline-content-section">
                                        <div class="timeline-date">' . get_the_date('\<\s\p\a\n\>j\<\/\s\p\a\n\>\<\s\p\a\n\>M\<\/\s\p\a\n\>') . '</div>
                                        <div class="timeline-content-wrapper">
                                            <div class="row">
                                                <div class="timeline-content-heading">
                                                    <h3>' . esc_html(get_the_title()) . '</h3>
                                                </div>
                                                ' . $main_img_html .  $mini_img_html . '
                                                <div class="timeline-content">
                                                    <div class="content-author">
                                                        <span>By <a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '"><strong>' . esc_html( get_the_author() ) . '</strong></a></span>
                                                    </div>
                                                    <div class="content-description">
                                                    ' . apply_filters('the_content', get_the_content()) . '
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
        
            }
             
            $content_post_html .= '</div>';
         }
        
        return $content_post_html;
    }
    
    public function cq_featured_regions_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $html = '<div class="latest-wrapper cq_category_carousel cq_featured_regions owl-carousel" data-items="5"  data-mobile-items="2" data-margin="15">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_featured_regions_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'region_id' => '',
                            ), $attributes);
        
        $html = '';
        
        if ($atts['region_id'] != '') {
            
            $region_id = $atts['region_id'];
            $region = get_term( $region_id );
            
            $image_id = get_term_meta($region_id, 'cruise-type-image-id', true);
            
            $image_data = wp_get_attachment_image_src( $image_id, 'category-carousel-image' );
            
            $html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . $image_data[0] . ')">
                        <a href="' . esc_url(get_term_link( $region )) . '" class="destination-link" title="' . esc_html($region->name) . '"></a>
                        <div class="item_content">
                            <h3><a href="' . esc_url(get_term_link( $region )) . '">' . esc_html($region->name) . '</a></h3>
                        </div>
                      </div>';
        }
                
        return $html;
    }
    
    public function cq_single_region_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'style' => 'compact',
                                'orientation' => 'left',
                                'region_id' => '',
                            ), $attributes);
        
        
        extract($atts);
        $region_html = '';
        
        if ($region_id != '' && $region_id > 0) {
            
            $region = get_term($region_id);
            $featured_image_id = get_term_meta( $region_id, 'cruise-type-image-id', true ); 
            $description = get_term_meta( $region_id, 'description', true );
            $url = wp_get_attachment_image_src($featured_image_id, 'main-post-image');
            
            switch ($style) {
                    
                case 'large':
                    
                    $open_html = '<div class="row-eq-height single-cruise-type-wrapper ' . $orientation . '">';

                    $image_html = '<div class="col-md-7 article-image">
                                      <div class="post-image">
                                          <a href="' . $url[0] . '" title="" itemprop="image" class="lightbox">'
                                          . wp_get_attachment_image( $featured_image_id, 'main-post-image' ) .
                                          '</a>
                                      </div>
                                  </div>';

                    $content_html = '<div class="article-title destination-title">'

                        . get_udg_sponsor() .

                        '<p class="section-name">ULTIMATE DESTINATION GUIDE</p>

                        <h1 class="entry-title">' . esc_html($region->name) . '</h1>

                        ' . wpautop($region->description) . '
                        
                        <a href="' . esc_url(get_term_link( $region, 'cruise-type' )) . '" class="destination-link button button-blue button_1" title="' . esc_html($region->name) . '">See More</a>

                    </div>';
                    
                    $close_html = '</div>';
                    
                    if ($orientation == 'left') {
                        
                        $region_html = $open_html . $image_html . $content_html . $close_html;
                        
                    } else {
                        
                        $region_html = $open_html . $content_html . $image_html . $close_html;
                        
                    }
                    
                    break;
                default:
                    
                    $region_html .= '<div class="latest-wrapper single-cruise-type-wrapper">
                                        <div class="cq_overlay item_wrap col_6" style="background-image: url(' .  wp_get_attachment_image_src( $featured_image_id, 'main-post-image' )[0] . ')">
                                            <a href="' . esc_url(get_term_link( $region, 'cruise-type' )) . '" class="destination-link" title="' . esc_html($region->name) . '"></a>
                                            <div class="item_content">
                                                <h3><a href="' . esc_url(get_term_link( $region, 'cruise-type' )) . '">' . esc_html($region->name) . '</a></h3>
                                            </div>
                                        </div>
                                    </div>';
                    
            }
            
        }
        
        return $region_html;
        
    }
    
    public function cq_udg_full_width_block_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'orientation' => 'left',
                                'title' => '',
                                'description' => '',
                                'button_link' => '',
                                'image' => '',
                            ), $attributes);
        
        
        extract($atts);
        
        $block_html = '';
        
        if ($title != '') {
            
            $link = vc_build_link($button_link);     
                    
            $open_html = '<div class="row-fluid udg_full_width_block row-eq-height ' . $orientation . '">';

            $image_html = '<div class="col-md-7 article-image">
                              <div class="post-image">
                                  <a href="' . $link['url'] . '" title="" itemprop="image">'
                                  . wp_get_attachment_image( $image, 'main-post-image' ) .
                                  '</a>
                              </div>
                          </div>';

            $content_html = '<div class="article-title destination-title">'

                . get_udg_sponsor() .

                '<p class="section-name">ULTIMATE DESTINATION GUIDE</p>

                <h1 class="entry-title">' . esc_html($title) . '</h1>

                ' . wpautop($description) . '

                <a href="' . esc_url($link['url']) . '" class="destination-link button button-blue button_1" title="' . esc_html($link['title']) . '">' . esc_html($link['title']) . '</a>

            </div>';

            $close_html = '</div>';

            if ($orientation == 'left') {

                $block_html = $open_html . $image_html . $content_html . $close_html;

            } else {

                $block_html = $open_html . $content_html . $image_html . $close_html;

            }
            
        }
        
        return $block_html;
        
    }
    
    public function cq_featured_destinations_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $html = '<div class="latest-wrapper cq_category_carousel archive-carousel destination-carousel" data-items="5"  data-mobile-items="2" data-margin="15">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_featured_destinations_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'destination_id' => '',
                            ), $attributes);
        
        
        extract($atts);
        $destination_html = '';
        
        if ($destination_id != '' && $destination_id > 0) {
            
            $destination = get_post($destination_id);
            
            $destination_html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . get_the_post_thumbnail_url($destination->ID, 'category-carousel-image') . ')">
                                     <a href="' . esc_url(get_permalink( $destination->ID )) . '" class="destination-link" title="' . esc_html(get_the_title($destination->ID)) . '>"></a>
                                         <div class="item_content">
                                            <h3><a href="' . esc_url(get_permalink($destination->ID)) . '">' . esc_html(get_the_title($destination->ID)) . '</a></h3>
                                         </div>

                                  </div>';
            
        }
        
        return $destination_html;
        
    }
    
    public function cq_featured_cruise_lines_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $html = '<div class="cruise-lines-wrapper">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_featured_cruise_lines_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'cruise_line_id' => '',
                            ), $attributes);
        
        
        extract($atts);
        $cruise_line_html = '';
        
        if ($cruise_line_id != '' && $cruise_line_id > 0) {
            
            $args = array(
                'post_type' => 'cruise-ship',
                'orderby' => 'title',
                'order' => 'ASC',
                'posts_per_page' => 30,
                'meta_key' => 'cruise_line',
                'meta_value' => $cruise_line_id,
                'fields' => 'ids',
            );
            
            $ships = get_posts($args);
            
            $ship_no = sizeof($ships);
            
            $ship_text = $ship_no > 1 ? 'ships' : 'ship';
            
            $cruise_line = get_post($cruise_line_id);
            
            $logo = get_the_post_thumbnail($cruise_line_id, 'small');
        
            if ($logo != '') { 

              $cruise_line_html .= '<div class="cruise-lines-item item_wrap">
                  <div class="ships">
                    <span>' . $ship_no . ' ' . $ship_text . '</span>
                  </div>
                  <div class="cruise-lines-img">
                      <a href="' . get_permalink($cruise_line_id) . '">
                      ' . $logo . '
                      </a>
                  </div>
              </div>';

            }
            
        }
        
        return $cruise_line_html;
        
    }
    
    public function cq_featured_ships_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(
                            array(
                                'el_class' => '',
                            ), $attributes);
        
        $html = '<div class="latest-wrapper cq_category_carousel archive-carousel ship-carousel" data-items="5"  data-mobile-items="2" data-margin="15">';
        $html .= do_shortcode($content);
        $html .= '</div>';
          
        return $html;
        
    }
    
    public function cq_featured_ships_item_shortcode($attributes) {
        
        $atts = shortcode_atts(
                            array(
                                'cruise_ship_id' => '',
                            ), $attributes);
        
        
        extract($atts);
        $ship_html = '';
        
        if ($cruise_ship_id != '' && $cruise_ship_id > 0) {
            
            $ship = get_post($cruise_ship_id);
            $cruise_line = get_post_meta($cruise_ship_id, 'cruise_line', true);
            
            $ship_html .= '<div class="cq_overlay item_wrap" style="background-image: url(' . get_the_post_thumbnail_url($ship->ID, 'category-carousel-image') . ')">
                                     <div class="operator-logo">
                                     ' . get_the_post_thumbnail($cruise_line, 'logo-no-crop') . '
                                     </div>
                                     <a href="' . esc_url(get_permalink( $ship->ID )) . '" class="destination-link" title="' . esc_html(get_the_title($ship->ID)) . '"></a>
                                         <div class="item_content">
                                            <h3><a href="' . esc_url(get_permalink($ship->ID)) . '">' . esc_html(get_the_title($ship->ID)) . '</a></h3>
                                         </div>

                                  </div>';
            
        }
        
        return $ship_html;
        
    }
    
    public function get_link_params($data) {
        
        $output = array();
        $data = ($data == '||') ? '' : $data;
	
	    $params = vc_build_link( $data );
	    $output['a_link'] = $params['url'];
	    $output['a_title'] = ($params['title'] == '') ? '' : 'title="' . $params['title'] . '"';
	    $output['a_target'] = ($params['target'] == '') ? '' : 'target="' . $params['target'] . '"';
        $output['text'] = $params['title'];
        
        return $output;
        
    }
    
    public function get_cat_name_link($id) {
        
        //$terms = get_the_terms( $id, 'category' );
        
        $term_id = $this->get_primary_taxonomy_id($id, 'category');
        
        $term = get_term($term_id, 'category');
		
        $atts = array('category' => '', 
                      'term_id' => '',
                      'cat_a_link' => '',
                      'cat_a_title' => '',
                      'cat_a_target' => '');
			
			//foreach ($terms as $term) {
        if (isset($term->name)) {
            $atts['category'] = $term->name;
            $atts['term_id'] = $term->term_id;
				
			//}
			
			$atts['cat_a_link'] = get_category_link($atts['term_id']);
			$atts['cat_a_title'] = $atts['category'];
			$atts['cat_a_target'] = '_self';
        }
        
        return $atts;
        
    }
    
    public function get_primary_taxonomy_id( $post_id, $taxonomy ) {
        $prm_term = '';
        if (class_exists('WPSEO_Primary_Term')) {
            $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
            $prm_term = $wpseo_primary_term->get_primary_term();
        }
        if ( !is_object($wpseo_primary_term) || empty( $prm_term ) ) {
            $terms = get_the_terms( $post_id, 'category' );
            if ( $terms ) {
                foreach ($terms as $term) {
                    if (isset($term->name)) {
                        $term_id = $term->term_id;
                        break;
                    }
                }
                return $term_id;
            } else {
                return '';
            }
        }
        return $wpseo_primary_term->get_primary_term();
    }
    
    function cq_wrap_oembed( $html, $url, $attr, $post_id ) {
        if ( false !== strpos( $url, "://youtube.com") || false !== strpos( $url, "://youtu.be" ) ) {   
	       $html = '<div class="video-embed">' . $html . '</div>';
        }
        
        return $html;
    }
    
    function cq_wrap_iframe( $content ) {
        
        if ($content) {
            // Match any iframes or embeds
            $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
            preg_match_all( $pattern, $content, $matches );
            foreach ( $matches[0] as $match ) {
                if ( false !== strpos( $match, "://youtube.com") || false !== strpos( $match, "://youtu.be" ) ) {
                    $wrappedframe = '<div class="video-embed">' . $match . '</div>';
                    $content = str_replace($match, $wrappedframe, $content);
                }
            }
        }
        return $content;
    }
    
    public function cq_speakers_list_shortcode($attributes) {
	
        global $wpdb;

        $cq_speakers_list_atts = shortcode_atts(array(
            'no_items' => '5',
            'category_id' => '',
            'session_order' => 'DESC',
            'add_class' => ''), $attributes);

        $query_order = $cq_speakers_list_atts['session_order'];
        $query_orderby = ($cq_speakers_list_atts['session_order'] == 'rand') ? 'rand' : 'title';
        $cq_speakers_list_items = $cq_speakers_list_atts['no_items'];
        $category_id = $cq_speakers_list_atts['category_id'];
        $speaker_list_content = '';

        $query_args = array(
            'post_type' => 'cq_speakers',
            'numberposts' => -1,
            'orderby' => $query_orderby,
            );
        
        if ($category_id != '') {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'cq_speaker_category',
                    'field' => 'term_id',
                    'terms' => $category_id,
                    'include_children' => false
                    )
                );
        }
        
        if ($query_order != '') {
            $query_args['order'] = $query_order;
        }

        $speaker_items = get_posts($query_args);

        if ($speaker_items) {

            $speaker_list_content .= '<div class="owl-carousel speaker-list owl-theme row-fluid no-padding" data-items="4" data-mobile-items="1">';

            foreach ($speaker_items as $post) {

                setup_postdata( $post );

                $speaker_name = esc_html($post->post_title);
                $speaker_job = rwmb_meta( 'speaker-job-title', '', $post->ID );
                $speaker_company = rwmb_meta( 'speaker-company', '', $post->ID );
                $speaker_href = esc_url( get_permalink($post->ID));

                $speaker_list_content .= '<div class="speaker-item item_wrap">
                                            <div class="speaker-content speaker-pic">
                                                <a href="' . get_permalink($post->ID) . '">
                                                ' . get_the_post_thumbnail( $post->ID, 'cq-square-img-sm', array( 'class' => 'speaker-img' ) ) . '
                                                </a>
                                            </div>
                                            <div class="speaker-content speaker-name">
                                                <h4><a href="' . get_permalink($post->ID) . '">' . $speaker_name . '</a></h4>
                                            </div>
                                            <div class="speaker-content speaker-job">
                                                <p><strong>' . $speaker_job . '</strong><br />' . $speaker_company . '</p>
                                            </div>
                                        </div>';


            }
            wp_reset_postdata();	

            $speaker_list_content .= '</div>';

        }

        return $speaker_list_content;
    }
    
    public function cq_custom_agenda_shortcode($attributes, $content = null) {
    
        $atts = shortcode_atts(array(
            'add_class' => ''), $attributes);

        $agenda_html = '<section class="row-fluid agenda-container ' . esc_attr($atts['add_class']) . '">
                            <div class="tab-wrap">'
                            . do_shortcode($content) . 
                           '</div>
                       </section>';

        return $agenda_html;
    }

    public function cq_custom_agenda_day_shortcode($attributes) {

        $atts = shortcode_atts(array(
            'title' => '',
            'date' => '',
            'agenda_day' => '',
            'add_class' => ''), $attributes);

        extract($atts);

        $agenda_days = vc_param_group_parse_atts( $agenda_day );

        $agenda_tab_count = 1;

        $agenda_day_html = '<section class="row-fluid agenda-container ' . esc_attr($atts['add_class']) . '">
                                <div class="tab-wrap">
                                    <!--<div class="tab-header">-->';
        
        $day_count = count($agenda_days);
        
        foreach ($agenda_days as $day) {

            $checked = $agenda_tab_count ==  1 ? 'checked' : '';
            $add_class = '';
            
            if ( $day_count == 1 ) {
                $add_class = 'hidden-xl-down';
            }

            $agenda_day_html .= '<input type="radio" id="tab' . $agenda_tab_count . '" name="tabGroup1" class="tab ' . $add_class . '" ' . $checked . '>
                                 <label for="tab' . $agenda_tab_count . '" class="' . $add_class . '"><span class="">' . esc_html($day['title']) . '</span></label>';


            $agenda_tab_count++;

        }

         $agenda_day_html .= '    <!--</div>-->';

        //$agenda_day_html .= print_r($agenda_days, true);

        foreach ($agenda_days as $day) {

            $day_date = date("l d F Y", strtotime($day['date']));

            $agenda_day_html .= '<div class="tab__content">
                                        <div class="date"><h3>' . esc_html($day_date) . '</div>
                                        <div class="agenda-content">
                                            <ul class="agenda-times">';

            $items = vc_param_group_parse_atts($day['agenda_items']);
            
            foreach ($items as $item) {
                
                $speaker_html = '';
                $synopsis_html = '';
                $times = '';
                $session_title = '';
                
                if (isset($item['speakers'])) {
                    $speakers = json_decode(urldecode($item['speakers']));

                    if ($speakers) {

                        foreach ($speakers as $speaker) {

                            if (isset($speaker->speaker) && is_numeric($speaker->speaker) && $speaker->speaker > 0) {
                                $speaker_position = array();
                                $speaker_name = get_the_title($speaker->speaker);
                                $speaker_job_title = get_post_meta($speaker->speaker, 'speaker-job-title', true);
                                $speaker_company = get_post_meta($speaker->speaker, 'speaker-company', true);
                                
                                if ($speaker_job_title != '') {
                                    $speaker_position[] = esc_html($speaker_job_title);
                                }
                                
                                if ($speaker_company != '') {
                                    $speaker_position[] = esc_html($speaker_company);
                                }

                                $speaker_html .= '<p class="speaker"><strong>' . $speaker_name . '</strong>';
                                
                                if (!empty($speaker_position)) {
                                    $speaker_html .= ' - ' . implode(', ', $speaker_position);
                                }
                                
                                $speaker_html .= '</p>';
                            }
                        }

                    }
                }

                if ($item['start_time'] != '' && $item['end_time'] != '') {
                    $times = $item['start_time'] . ' - ' . $item['end_time'];
                } else {
                     $times = $item['start_time'];
                }
                
                if (isset($item['session_title']) && $item['session_title'] != '') {
                    $session_title = esc_html($item['session_title']);
                }
                
                if (isset($item['synopsis']) && $item['synopsis'] != '') {
                    $synopsis_html = esc_html($item['synopsis']);
                }

                $agenda_day_html .= '<li class="agenda-time item_wrap">
                                        <div class="agenda-time-header">
                                            <p>' . esc_html($times) . '</p>
                                        </div>
                                        <div class="agenda-time-content">
                                            <div class="row">
                                                <div class="col-md-3 session">
                                                <p><strong>' . $session_title . '</strong></p>
                                                </div>
                                                <div class="col-md-5 synopsis">
                                                    <div class="synopsis-wrap meta-content">
                                                        ' . wpautop($synopsis_html) . '
                                                    </div>
                                                </div>
                                                <div class="col-md-4 speakers">
                                                ' . $speaker_html . '
                                                </div>
                                            </div>
                                        </div>
                                     </li>';

            }

            $agenda_day_html .= '      </ul>
                                    </div>
                                 </div>';
        }

        $agenda_day_html .= '</div>
                       </section>';


        return $agenda_day_html;
    }
    
    public function cq_standard_carousel_shortcode($attributes) {
	
        global $wpdb;

        $cq_standard_carousel_atts = shortcode_atts(array(
            'no_items' => '5',
            'carousel_id' => '108',
            'carousel_order' => 'title',
            'autoscroll' => 'false',
            'scroll_timing' => 2,
            'add_class' => ''), $attributes);

        $query_order = $cq_standard_carousel_atts['carousel_order'];
        $query_orderby = ($cq_standard_carousel_atts['carousel_order'] == 'rand') ? 'rand' : 'title';
        $standard_carousel_items = $cq_standard_carousel_atts['no_items'];
        $carousel_id = $cq_standard_carousel_atts['carousel_id'];
        $autoscroll = $cq_standard_carousel_atts['autoscroll'];
        $autoscroll_timing = $cq_standard_carousel_atts['scroll_timing'];

        $query_args = array(
            'post_type' => 'cq_carousel',
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'cq_carousels',
                    'field' => 'term_id',
                    'terms' => $carousel_id, // Where term_id of Term 1 is "1".
                    'include_children' => false
                    )
                ),
            'orderby' => $query_orderby,
            );
        if ($query_order != '') {
            $query_args['order'] = $query_order;
        }

        $carousel_items = get_posts($query_args);

        $standard_carousel_content = '';

        if ($carousel_items) {

            $standard_carousel_content .= '<div class="cq-owl-carousel owl-carousel" data-items="' . $standard_carousel_items . '" data-autoscroll="' . $autoscroll  . '" data-scrolltiming="' . $autoscroll_timing . '">';

            foreach ($carousel_items as $post) {

                setup_postdata( $post );
                $img_href = rwmb_meta( 'varousel-item-link', '', $post->ID );

                $standard_carousel_content .= '<div><a href="' . $img_href . '" target="_blank"><img src="' . get_the_post_thumbnail_url( $post->ID, 'full' ) . '" class="cq-carousel item_wrap" /></a></div>';


            }
            wp_reset_postdata();	

            $standard_carousel_content .= '</div>';

        }

        return $standard_carousel_content;
    }
    
    public function cq_grid_links_shortcode($attributes, $content = null) {
        
        $atts = shortcode_atts(array(
            'grid_style' => 'cards',
            'el_class' => ''), $attributes);
        
        extract($atts);
        
        $html = '';
        
        if ($grid_style == 'cards') {
            $html .= '<div class="grid-links grid-links-cards">';
        } else {
            $html .= '<div class="grid-links grid-links-large">';
        }
        
        $html .= do_shortcode($content);
        
        $html .= '</div>';
        
        return $html;
    }
    
    public function cq_grid_links_item_shortcode($attributes) {
        
        $atts = shortcode_atts(array(
            'image_id' => '',
            'title' => '',
            'description' => '',
            'is_download' => 'no',
            'link' => '',
            'file_picker' => ''), $attributes);
        
        extract($atts);
        
        $html = '';
        
        if ($is_download == 'no') {
            $url_link = vc_build_link($link);
            $link_html = '<a href="' . esc_url($url_link['url']) . '" class="linkout" target="' . esc_attr($url_link['target']) . '">';
        } else {
            $link_html_img = '<a href="' . esc_url(wp_get_attachment_url($file_picker)) . '" class="download" target="_blank" download>';
            $file_url = wp_get_attachment_url($file_picker);
            $link_html = '<a href="' . esc_url(wp_get_attachment_url($file_picker)) . '" class="download button button-blue" target="_blank" download>';
            
            $filetype = wp_check_filetype( $file_url );
            
            if ($filetype['ext'] == 'pdf' && $image_id == '') {
                $image_id = $file_picker;
            }
        }
        
        $html = '<div class="grid-link-item item_wrap">
                    <div class="grid-link-item-image">
                    ' . $link_html_img . wp_get_attachment_image( $image_id, 'featured-box-bg-image', '', array( "class" => "img-responsive" ) ) . '</a>
                    
                    </div>
                    <div class="grid-link-item-content">
                        <h3>' . esc_html($title) . '</h3>
                        ' . wpautop($description) . '
                    </div>
                    <div class="grid-link-item-action">
                       ' . $link_html . 'DOWNLOAD <i class="fa fa-download" aria-hidden="true"></i>
</a> 
                    </div>
                </div>';
        
        return $html;
        
    }
    
    /* BOF Latest Jobs */
    public function cq_latest_jobs_row_shortcode( $attributes ) {
        
        $job_page_post_ids = array();
        $job_page_post_ids = $this->home_page_post_ids;
       
        $atts = shortcode_atts(array(
            'to_show' => '3',
            'column_show' => '1',
            'latest_jobs_category' => ''), $attributes);
           
        $col_class = 'col_' . 12/$atts['column_show'];
        $fallback_class = 'col-md-' . 12/$atts['column_show'];
        $fallback_class = '';
        
        $vertical_class = 'vertical';
        $gap_class = $atts['to_show'] == '1' ? 'no_gap' : '';
        $post_index = 0;
        if($atts['to_show'] > 6){
            $gridtemplaterow = 'gridtemplaterow3';
        } else if ($atts['to_show'] > 3 && $atts['to_show'] < 7){
            $gridtemplaterow = 'gridtemplaterow2';
        } else if ($atts['to_show'] == 3 && $atts['column_show'] == 1){
            $gridtemplaterow = 'gridtemplaterow3';
        } else {
            $gridtemplaterow = 'gridtemplaterow1';
        }
        
        $gridtemplaterow = 'gridtemplaterow' . $atts['column_show'];
        
        global $wpdb;
        if ($atts['latest_jobs_category'] != '') {
          
            $post_query = new WP_Query(
                array(
                    'post_type' => 'jobs',
                    'posts_per_page' => $atts['to_show'],
                    'order' => 'DESC',
                    'meta_query' => array(
                        array(
                          'key' => 'cq_job_type',
                          'value' => $atts['latest_jobs_category'],
                          'compare' => '='
                        )
                    )
                )
            );
        } else {
            $sticky = get_option( 'sticky_posts' );
            $sticky = array_slice( $sticky, 0, 1 );
            $query_sticky = array(
                'post__in' => $sticky,
                'ignore_sticky_posts' => 1,
            );
            $query_sticky = new WP_Query($query_sticky);

            $post_query = new WP_Query(
                array(
                    'post_type' => 'jobs',
                    'posts_per_page' => $atts['to_show'],
                    'order' => 'DESC',
                )
            );
        }
       
        $cq_latest_jobs_row_content = '<div class="row latest-post-row latest-jobpost ' . $gap_class . ' '.$gridtemplaterow.'">';
        if($post_query->have_posts()) {
            while($post_query->have_posts()) { 

                $post_query->the_post();
               
                $job_id = get_the_ID();
                $category = $this->get_cat_name_link($job_id);
                $this->home_page_post_ids[] = $job_id;
                $mobile_view = $post_index == 0 ? '' : 'mobile_view';
                $job_page_post_ids[] = $job_id;
                $job_meta = get_post_meta( $job_id );
                
                global $job;
                do_action('get_job_data');
                $cq_latest_jobs_row_content .= '<div class="cq_vertical item_wrap  ' . $col_class . ' '  . $fallback_class . '">
                    <div class="item_image">
                        <a href="' . get_the_permalink($job_id) . '">
                            ' . wp_get_attachment_image( $job->job_logo, 'full' ) . '
                        </a>
                    </div>
                    <div class="item-spacing"></div>
                    <div class="item_content">
                        <a class="cat-link" href="javascript:void(0);"  title="' . $job->job_type_name . '">' . $job->job_type_name . '</a>
                        <h3><a href="' . get_the_permalink($job_id) . '">' . get_the_title() . '</a></h3>
                        <small>Added '.human_time_diff(get_the_time ( 'U' ), current_time( 'timestamp' )).' ago</small>
                    </div>
                </div>';
                  
                $post_index++;
            }
        }
        $cq_latest_jobs_row_content .= '	</div>';
        wp_reset_query();
        wp_reset_postdata();
        return $cq_latest_jobs_row_content;
    }
     /* EOF Latest Jobs */
    /* BOF call to action */
    public function cq_call_to_action_shortcode( $attributes ) {
       
        $atts = shortcode_atts(array(
            'custom_background' => '#fff',
            'custom_text' => '#000',
            'cq_fw_takeover_img' => '',
            'cq_link' => '',
            'cq_heading' => '',
            'cq_content' => '',
            'cq_width_screen'=>'',
            'cq_button_text' => 'Text on the button',
            ), $attributes);
        
        $column_link_array = vc_build_link($atts['cq_link']);
        $target = $column_link_array['target'];
        $tile = $column_link_array['title'];
        $url = $column_link_array['url'];
        $image_url = wp_get_attachment_image_url( $atts["cq_fw_takeover_img"], 'full' );
        $html = '';
        
        $html = '<section class="vc_cta3-container fullwidthaddtoaction vc_cta3-size-' . esc_html($atts['cq_width_screen']) . '">
                    <div href="'. $url . '" target="'. $target . '" title="'. $tile . '" class="" style="min-height: 480px;background-color: ' . esc_html($atts['custom_background']) . '; background-image:url(' . $image_url . '); background-repeat: no-repeat; background-size: cover; background-position: center;"> 
                        <h2 style="color: ' . esc_html($atts['custom_text']) . '">'. esc_html( $atts['cq_heading'] ) . '</h2>
                        <div style="color: ' . esc_html($atts['custom_text']) . '">'. esc_html($atts['cq_content']) . '</div>
                        <a class="button button-orange" style="color: ' . esc_html($atts['custom_text']) . ';" href="'. $url . '" target="'. $target . '" title="'. $tile . '">' . esc_html($atts['cq_button_text']) . '</a> 
                    </div> 
                </section>';   
        return $html;
    }
    /* EOF call to action */
}
cqShortcodes::init();