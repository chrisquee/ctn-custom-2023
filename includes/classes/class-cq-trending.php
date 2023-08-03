<?php

class cqTrending {
    
    private $plugin_name = 'cq-custom';
    
    public static function init() {
		$self = new self();
		add_action('wp_head', array($self, 'base_track_popular_posts'));
        add_filter( 'cron_schedules', array($self, 'add_new_intervals'));
        add_action('wp_head', array($self, 'cq_set_cron'));
        add_action('trending_cleanup', array($self, 'cq_clear_trending_data'));
        add_shortcode( 'cq_popular_posts', array($self, 'cq_popular_posts') );
  	}
    
    public function base_display_popular_posts( $size = 3 ) {

	   // Query arguments
      $popular_args = array(
              'posts_per_page' => $size,
              'meta_key' => '_base_popular_posts_count',
              'orderby' => 'meta_value_num',
              'meta_type' => 'NUMERIC',
              'order' => 'DESC'
      );

          // The query
          $popular_posts = new WP_Query( $popular_args );

          // The loop
          while ( $popular_posts->have_posts() ) {
              $popular_posts->the_post();
              echo '<div class="col-md-12 trending"><p><a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a></p>' . understrap_posted_on_mini() . '</div>';
          }

          // Reset post data
          wp_reset_postdata();
    }

  function base_get_popular_posts( $size = 4 , $must_include = '', $ad_space, $ad_shortcode ) {

      $must_include_array = explode(',', $must_include);
      $limit = (sizeof($must_include_array) > $size ? $size : sizeof($must_include_array));
      $total_size = $size;

      if ($must_include != '') {
          $query_args = array( 'post__in' => $must_include_array, 'posts_per_page' => $limit, 'post_type' => array('post', 'page'));
          $must_include_posts = new WP_Query( $query_args );
          $size = (int)$size - (int)$limit;
      }
      
      $pop_size = $size;
      // Query arguments
      $popular_args = array(
          'posts_per_page' => $pop_size,
          'meta_key' => '_base_popular_posts_count',
          'post__not_in' => $must_include_array,
          'orderby' => 'meta_value_num',
          'post_type' => array('post'),
          'meta_type' => 'NUMERIC',
          'order' => 'DESC',
          'date_query' => array(
            'after' => date('Y-m-d', strtotime('-2 years')) 
           )
      );

      // The query
      $popular_posts = new WP_Query( $popular_args );
      //$popular_post_html = '<ol class="trending-posts">';
      $trend_counter = 1;
      $grid_counter = 1;
      $popular_post_html = '';
      // The loop
      
      $shortcode = new cqShortcodes();

      if ($must_include != '') {
          if ($must_include_posts->have_posts()) {

              while ( $must_include_posts->have_posts() ) {
                  $must_include_posts->the_post();
                  
                  if ($trend_counter > $total_size) {
                    break;
                  }
                  
                  if ($trend_counter == 1 || $trend_counter == 2 ) {
                      $cols = 2;
                  } else {
                      $cols = 1;
                  }
                  
                  $grid_counter = $grid_counter == 5 ? 1 : $grid_counter;
                  
                  $category = $shortcode->get_cat_name_link(get_the_id());
                  
                  $col_class = 'col_' . $cols;
                  $fallback_class = 'col-md-' . $cols*3;
                  $fallback_class = '';
                  $mobile_view = $trend_counter == 1 ? '' : 'mobile_view';
                  
                  $count_class = 'tritem-' . $trend_counter; 
                  //$popular_post_html .= '<li class="col-md-12 trending ' . $count_class . '"><div class="trending-inner"><p><a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a></p>' . understrap_posted_on_mini() . '</div></li>';
                  
                  if ($total_size == $trend_counter && $ad_space == true) {
                      $ad_html = $ad_space == true && $ad_shortcode != '' ? do_shortcode('[the_ad_placement id="' . $ad_shortcode . '"]') : '';
                      $popular_post_html .= '<li class="cq_ad_space item_wrap ' . $col_class . ' ' . $fallback_class . ' trending-' . $grid_counter . '" style="background-color: #dadada;">
                                                ' . $ad_html . '
                                                <div class="ad_footer"><span>ADVERTISEMENT</span></div>
                                            </li>';
                      $trend_counter++;
                      continue;
                  }
                  
                  $cat_html = '';
                  
                  if ($category['cat_a_title'] != '') {
                    $cat_html = '<a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>';
                  }
                  
                  $popular_post_html .= '<li class="cq_overlay item_wrap ' . $col_class . ' ' . $fallback_class . ' trending-' . $grid_counter . ' ' . $mobile_view . '" style="background-image: url(' . get_the_post_thumbnail_url(get_the_id(), 'large') . ')">
                                            <a href="' . get_the_permalink(get_the_id()) . '">
                                                ' . get_the_post_thumbnail(get_the_id(), 'featured-box-bg-image') . '
                                            </a>
                                            <div class="item_content">
                                                ' . $cat_html . '
                                                <time datetime="' . get_the_date( 'c') . '">' . get_the_date( 'j F Y' ) . '</time>
                                                <h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                                            </div>
                                         </li>';
                  $trend_counter++;
                  $grid_counter++;
              }

          }
      }

      if ($size > 0) {

          while ( $popular_posts->have_posts() ) {
              $popular_posts->the_post();
              $count_class = 'tritem-' . $trend_counter;
              $grid_counter = $grid_counter == 5 ? 1 : $grid_counter;
              //$popular_post_html .= '<li class="col-md-12 trending ' . $count_class . '"><div class="trending-inner"><p><a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a></p>' . understrap_posted_on_mini() . '</div></li>';
              if ($trend_counter == 1 || $trend_counter == 2 ) {
                 $cols = 2;
              } else {
                 $cols = 1;
              }
              
              if ($trend_counter > $total_size) {
                  break;
              }
              
              $category = $shortcode->get_cat_name_link(get_the_id());

              if (substr( strtolower(get_the_title()), 0, 7 ) === "closed:") {
                  continue;
              }

              $col_class = 'col_' . $cols;
              $fallback_class = 'col-md-' . $cols*3;
              $fallback_class = '';
              $mobile_view = $trend_counter == 1 ? '' : 'mobile_view';

              $count_class = 'tritem-' . $trend_counter; 
              //$popular_post_html .= '<li class="col-md-12 trending ' . $count_class . '"><div class="trending-inner"><p><a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a></p>' . understrap_posted_on_mini() . '</div></li>';
              
              if ($total_size == $trend_counter && $ad_space == true) {
                  $ad_html = $ad_space == true && $ad_shortcode != '' ? do_shortcode('[the_ad_placement id="' . $ad_shortcode . '"]') : '';
                  $popular_post_html .= '<li class="cq_ad_space item_wrap ' . $col_class . ' ' . $fallback_class . ' trending-' . $grid_counter . '" style="background-color: #dadada;">
                                            ' . $ad_html . '
                                            <div class="ad_footer"><span>ADVERTISEMENT</span></div>
                                        </li>';
                  $trend_counter++;
                  continue;
               }
              
              $cat_html = '';
                  
              if ($category['cat_a_title'] != '') {
                $cat_html = '<a class="cat-link" href="' . $category['cat_a_link'] . '" target="' . $category['cat_a_target'] . '" title="' . $category['cat_a_title'] . '">' . $category['category'] . '</a>';
              }
              
              $popular_post_html .= '<li class="cq_overlay item_wrap ' . $col_class . ' ' . $fallback_class . ' trending-' . $grid_counter . ' ' . $mobile_view . '" style="background-image: url(' . get_the_post_thumbnail_url(get_the_id(), 'large') . ')">
                                        <a href="' . get_the_permalink(get_the_id()) . '" class="destination-link" title="' . get_the_title() . '"></a>
                                        <a href="' . get_the_permalink(get_the_id()) . '">
                                            ' . get_the_post_thumbnail(get_the_id(), 'featured-box-bg-image') . '
                                        </a>
                                        <div class="item_content">
                                            ' . $cat_html . '
                                            <time datetime="' . get_the_date( 'c') . '">' . get_the_date( 'j F Y' ) . '</time>
                                            <h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                                        </div>
                                     </li>';
              
              $trend_counter++;
              $grid_counter++;
          }
      }

      // Reset post data
      wp_reset_postdata();

      return $popular_post_html;
  }

    /**
     * Popular posts tracking
     *
     * Tracks the number of logged out user views for a post in a custom field
     */
    public function base_track_popular_posts() {

        // Only run the process for single posts, pages and post types when the user is logged out
        if ( is_singular() && !is_user_logged_in() ) {

            global $post;
            $custom_field = '_base_popular_posts_count';

            // Set/check session
            /* if ( !session_id() ) {
                session_start();
            }*/
            // Only track a one view per post for a single visitor session to avoid duplications

            $post_session_id = 'popular-posts-count-' . $post->ID;

            if ( !isset( $_SESSION[$post_session_id] ) ) {

                // Update view count 
                $view_count = get_post_meta( $post->ID, $custom_field, true );
                $stored_count = ( isset($view_count) && !empty($view_count) ) ? ( intval($view_count) + 1 ) : 1;
                $update_meta = update_post_meta( $post->ID, $custom_field, $stored_count );

                // Check for errors
                if ( is_wp_error($update_meta) )
                    error_log( $update_meta->get_error_message(), 0 );

                // Store session in "viewed" state
                $_SESSION[$post_session_id] = 1;
            }

            // Show view the count for testing purposes (add "?show_count=1" onto the URL)
            if ( isset($_GET['show_count']) && intval($_GET['show_count']) == 1 ) {
                echo '<p style="color:red; text-align:center; margin:1em 0;">';
                echo get_post_meta( $post->ID, $custom_field, true );
                echo ' views of this post</p>';
            }
        }
    }

    public function add_new_intervals($schedules) {
        // add weekly and monthly intervals
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => __('Once Weekly')
        );

        $schedules['monthly'] = array(
            'interval' => 2635200,
            'display' => __('Once a month')
        );

        return $schedules;
    }

    public function cq_set_cron() {
        if (! wp_next_scheduled ( 'trending_cleanup' )) {
        wp_schedule_event(time(), 'weekly', 'trending_cleanup');
        }
    }

//wp_clear_scheduled_hook( 'trending_cleanup' );

    public function cq_clear_trending_data() {

        global $wp_query;

        $posts = get_posts(array('numberposts' => -1) );

        foreach($posts as $p) {  

            $meta = get_post_meta($p->ID, '_base_popular_posts_count',true);

            if ($meta) { 

                update_post_meta( $p->ID, '_base_popular_posts_count', 1 );

            }
        }

    }

    public function cq_popular_posts($attributes) {

        $cq_popular_post_atts = shortcode_atts(array(
            'popular_number' => 4,
            'post_id' => '',
            'el_class' => '',
            'ad_space' => '',
            'ad_shortcode' => '',
            'carousel_theme' => 'Light'), $attributes);

        $size = $cq_popular_post_atts['popular_number'];
        $must_include = $cq_popular_post_atts['post_id'];
        $theme_class = $cq_popular_post_atts['carousel_theme'];
        $extra_class = $cq_popular_post_atts['el_class'];
        $ad_space = $cq_popular_post_atts['ad_space'];
        $ad_shortcode = $cq_popular_post_atts['ad_shortcode'];

        $popular_post_content = '<ul class="trending-posts ' . esc_attr($theme_class) . ' ' . esc_attr($extra_class) . '">';

        $popular_post_content .= $this->base_get_popular_posts( $size, $must_include, $ad_space, $ad_shortcode );

        $popular_post_content .= '			</ul>';

        //$popular_post_content = base_get_popular_posts( $size, $must_include );

        return $popular_post_content;

    }  
}
cqTrending::init();