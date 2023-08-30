<?php
/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/plugin/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param   string  $template_name          Template to load.
 * @param   string  $string $template_path  Path to templates.
 * @param   string  $default_path           Default path to template files.
 * @return  string                          Path to the template file.
 */
function cq_locate_template( $template_name, $template_path = '', $default_path = '' ) {

  // Set variable to search in the templates folder of theme.
  if ( !$template_path ) :
    $template_path = 'templates/';
  endif;

  // Set default plugin templates path.
  if ( !$default_path ) :
    $default_path = plugin_dir_path( __DIR__ ) . 'templates/'; // Path to the template folder
  endif;

  // Search template file in theme folder.
  $template = locate_template( array(
    $template_path . $template_name,
    $template_name
  ) );

  // Get plugins template file.
  if ( ! $template ) :
    $template = $default_path . $template_name;
  endif;

  return apply_filters( 'cq_locate_template', $template, $template_name, $template_path, $default_path );

}

/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see cq_auction_locate_template()
 *
 * @param string  $template_name          Template to load.
 * @param array   $args                   Args passed for the template file.
 * @param string  $string $template_path  Path to templates.
 * @param string  $default_path           Default path to template files.
 */
function cq_get_template( $template_name, $args = array(), $endpoint = '', $tempate_path = '', $default_path = '' ) {

  $args = apply_filters('cq_template_args', $args, $template_name, $endpoint);
  
  if ( is_array( $args ) && isset( $args ) ) :
    extract( $args );
  endif;

  $template_file = cq_locate_template( $template_name, $tempate_path, $default_path );

  if ( ! file_exists( $template_file ) ) :
    _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
    return;
  endif;

  include $template_file;

}

/**
 * Template loader.
 *
 * The template loader will check if WP is loading a template
 * for a specific Post Type and will try to load the template
 * from out 'templates' directory.
 *
 * @since 1.0.0
 *
 * @param string  $template Template file that is being loaded.
 * @return  string          Template file that should be loaded.
 */
function cq_template_loader( $template ) {
    
  global $post;

  if ( is_singular( 'jobs' ) || is_post_type_archive( 'jobs' )) {
    $find = array();
    $file = '';

    if ( is_singular( 'jobs' ) ):
      $file = 'single-job.php';
    elseif ( is_archive( 'jobs' ) ):
      $file = 'archive-jobs.php';
    endif;
	  
	global $wp_query;   
  	$post_type = get_query_var('post_type');   

    if ( file_exists( cq_locate_template( $file ) ) ):
      $template = cq_locate_template( $file );
    endif;
  }
    
  if ( is_singular( 'destinations' ) || is_tax( 'cruise-type' ) || is_singular( 'cruise-line' ) || is_singular( 'cruise-ship' ) || is_singular( 'cq_speakers' ) || (is_post_type_archive('cruise-line') && !is_tax( 'cruise-type' )) ) {
      if ( is_singular( 'destinations' ) ) {
        $file = 'single-destination.php';
      }
      
      if (is_tax( 'cruise-type' ) ) {
          $file = 'archive-cruise-types.php';
      }
      
      if (is_archive( 'cruise-line' ) && !is_tax( 'cruise-type' )) {
          $file = 'archive-cruise-lines.php';
      }
      
      if (is_singular( 'cruise-line' ) ) {
          $file = 'single-cruise-line.php';
      }
      
      if (is_singular( 'cruise-ship' ) ) {
          $file = 'single-cruise-ship.php';
      }
      
      if (is_singular( 'cq_speakers' ) ) {
          $file = 'single-speaker.php';
      }
      
      if ( file_exists( cq_locate_template( $file ) ) ):
        $template = cq_locate_template( $file );
      endif;
  }
    
    if (is_singular( 'cq_interactive_item' ) ) {
        
        $file = 'single-interactive.php';
        
        if ( file_exists( cq_locate_template( $file ) ) ):
            $template = cq_locate_template( $file );
        endif;
    }
    
    if ( is_post_type_archive( 'cq_digital_issue' ) || is_tax('cq_publications')) {
      $file = 'taxonomy-cq_publications.php';
      
      if ( file_exists( cq_locate_template( $file ) ) ) {
        $template = cq_locate_template( $file );
      }
   }
    
  return $template;

}
add_filter( 'template_include', 'cq_template_loader' );


function cq_my_account_menu($endpoints, $curr_page = '') {
	
	$menu_html = '';
	$active_class = '';
	
	if (is_array($endpoints)):
	
	$menu_html .= '<ul id="account_menu">';
	
	foreach ($endpoints as $key => $value) {
		
		if (isset($value['add_menu']) && $value['add_menu'] == false) {
			continue;
		}
		
		if (isset($value['permissions'])) {
			if (!current_user_can($value['permissions']) && !current_user_can( 'manage_options' )) {
				continue;
			}
		}
		
		if ($value['url'] == $curr_page || in_array_r($curr_page, $value['children'] ?? '')) {
			$active_class = 'acc-active';
		} else {
			$active_class = '';
		}
        
        $append = '';
        
        $append = apply_filters('cq_dashboard_' . $value['url'] . '_append', $append, $value);
        
        $icon_html = '';
        if (isset($value['icon']) && $value['icon'] !== '') {
            $icon_html = '<i class="material-symbols-outlined">' . esc_attr($value['icon']) . '</i>';
        }
		
		$menu_html .= '<li class="account-menu-item ' . esc_attr($active_class) . '"><a href="' . esc_url(site_url( '/my-account/' . $value['url'])) . '">' . $icon_html . esc_html($value['name']) . $append . '</i></a>';
		
		if (isset($value['children']) && is_array($value['children'])) {
			$menu_html .= '<ul class="child_menu">';
			foreach($value['children'] as $item => $url) {
                if (isset($url['add_menu']) && $url['add_menu'] == false) {
                     continue;
                }
                
				if ($url['url'] == $curr_page) {
					$active_class = 'acc-active';
				} else {
					$active_class = '';
				}
                
                $child_icon_html = '';
                if (isset($url['icon']) && $url['icon'] !== '') {
                    $child_icon_html = '<i class="material-symbols-outlined">' . esc_attr($url['icon']) . '</i>';
                }
                
				$menu_html .= '<li class="account-menu-item ' . esc_attr($active_class) . '"><a href="' . esc_url(site_url( '/my-account/' . $url['url'])) . '">' . $child_icon_html . esc_html($url['name']) . $append . '</a></li>';
			}
            $menu_html .= '</ul>';
		}
		
		$menu_html .= '</li>';
		
	}
	
	$menu_html .= '</ul>';
	
	endif;
	
	return $menu_html;
	
}

function in_array_r($needle, $haystack, $strict = false) {
	if(is_array($haystack)) {
    	foreach ($haystack as $item) {
        	if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            	return true;
        	}
    	}
	}

    return false;
  }
  
function number_format_short( $n, $precision = 1 ) {
	
	$n = $n == '' ? 0 : $n;
	
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}

  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}

	return $n_format . $suffix;
}


function add_page_slug_body_class( $classes ) {
    global $post;
    
    if ( isset( $post ) ) {
        $classes[] = 'page-' . $post->post_name;
		$classes[] = 'type-' . get_post_type($post->ID);
    }
    return $classes;
}
add_filter( 'body_class', 'add_page_slug_body_class' );


function cq_default_image_src( $image, $attachment_id, $size, $icon ) {
    
    $options = get_option('cq-auctions');
    if ($options) {
        $default = $options['item_placeholder_image'];
        //echo '<!-- ' . $options['item_placeholder_image'] . ' -->';

        $image_id = attachment_url_to_postid( $default );

        $return = array();

        if (!$image && is_numeric($image_id)) {
            $return = wp_get_attachment_image_src($image_id, $size, $icon );

            return $return;
        }
    }
    
    return $image;
}
add_filter( 'wp_get_attachment_image_src', 'cq_default_image_src', 10, 4 );


function check_img_orientation ($image_id) {
    if (is_numeric($image_id) && $image_id != '') {
        $image = wp_get_attachment_image_src( $image_id, '');
        $image_w = $image[1];
        $image_h = $image[2];

        if ($image_w > $image_h) { 
            return 'landscape';
        }
        elseif ($image_w == $image_h) { 
            return 'square';
        }
        else { 
            return 'portrait';
        }
    }
}



 /**
 * Returns the number of posts a particular metakey is used for.
 * Optionally qualified by a specific value or values in an array of the meta key.
 *
 * @param string            $key
 * @param null|string|array $value
 *
 * @return mixed
 */
function get_meta_count( $key, $value = null) {
    global $wpdb;

    $where = get_meta_where($key, $value);
    $count = $wpdb->get_row("SELECT COUNT(*) AS THE_COUNT FROM $wpdb->postmeta WHERE $where");
    return $count->THE_COUNT;
}

/**
 * Returns the postmeta records for a particular metakey.
 * Optionally qualified by a specific value or values in an array of the meta key.
 *
 * @param string            $key
 * @param null|string|array $value
 *
 * @return mixed
 */
function get_meta ( $key, $value = null) {
    global $wpdb;
    $where = get_meta_where($key, $value);
    return $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE $where");
}

/**
 * Returns the where string for a metakey query
 *
 * @param string            $key
 * @param null|string|array $value
 *
 * @return string
 */
function get_meta_where( $key, $value) {
    $where = "meta_key = '$key'";

    if (null !== $value) {
        if (\is_array($value)) {
            \array_walk($value,'add_quote');
            $in = \implode(',', $value);  // Seperate values with a comma
            $where .= " AND meta_value IN ($in)";
        } else {
            $where .= " AND meta_value = '$value'";
        }
    }

    return $where;
}

/**
 * Puts quotes around each value in an array when used as a callback function
 *
 * @param $value
 * @param $key
 */
function add_quote( &$value, $key) {
    $value = "'$value'";
}

function get_udg_sponsor($echo = true) {
    
    $html = '';
    
     if( function_exists('the_ad_placement') ) { 
         
         ob_start();
         the_ad_placement('ultimate-destination-guide-sponsor');
         $sponsor = ob_get_contents();
         ob_end_clean();

        if ($sponsor != '') { 

        $html = '<div class="udg-sponsor-wrap">
            <p class="sponsored-by">SPONSORED BY</p>
            <div class="udg-sponsor">' .$sponsor . '
            </div>
        </div>';
      }
    }
    
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
    
    return;
}

function cq_digital_issue_widget() {
	
	$args = array('post_type' => 'cq_digital_issue',
			     'suppress_filters' => true,
			     'post_status' => 'publish',
                 'orderby' => 'date',
                 'order' => 'DESC',
			     'showposts' => 1 );
					  
	$posts = get_posts( $args );
	
	foreach( $posts as $post ): 
	
	setup_postdata($post);
    
    $issue_id = $post->ID;
    $external_link = get_post_meta($issue_id, 'di_external_link', true);
    $link = strpos($external_link, 'http', 0) !== false ? $external_link : get_permalink($issue_id);
    $target = strpos($link, site_url(), 0) !== false ? '_self' : '_blank';
	
	$cq_digital_issue_widget_html = '<div id="di-widget" class="digital-issue-widget">
										<div class="di-img">
											<a href="' . esc_url($link) . '" target="' . esc_attr($target) . '">
												<img src="' . esc_url(get_the_post_thumbnail_url( $post->ID, 'full' )) . '" alt="' . esc_attr($post->post_title) . '" />
											</a>
										</div>
										<div class="di-content col_2">
											<h4>Read our latest issue</h4>
											<a href="' . esc_url($link) . '" target="' . esc_attr($target) . '" class="small-btn">Read Now</a>
										</div>
									</div>';

	endforeach;
    
    wp_reset_postdata();
	
	echo $cq_digital_issue_widget_html;
}

function get_post_by_meta( $args = array() ) {
   
    // Parse incoming $args into an array and merge it with $defaults - caste to object ##
    $args = ( object )wp_parse_args( $args );
   
    // grab page - polylang will take take or language selection ##
    $args = array(
        'meta_query'        => array(
            array(
                'key'       => $args->meta_key,
                'value'     => $args->meta_value
            )
        ),
        'post_type'         => $args->post_type,
        'posts_per_page'    => '1'
    );
   
    // run query ##
    $posts = get_posts( $args );
   
    // check results ##
    if ( ! $posts || is_wp_error( $posts ) ) return false;
   
    // test it ##
    #pr( $posts[0] );
   
    // kick back results ##
    return $posts[0];
   
}

function get_post_by_slug( $post_name ) {
    
    $args = array(
        'post_name'   => $post_name,
        'numberposts' => 1,
        'fields' => 'ids'
    );
        
    $post_ids = get_posts($args);

    return array_shift($post_ids);
}

function events_filter_function($cat){
	$html = '<div class="clearfix listings-wrapper">';

	if($cat != 'All'):
		$term = get_term( $cat );
	endif;
	
	$currentdate = date("m/d/Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

	$args = array(
		'post_type' => 'events',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key' => 'event_start_date',
		'meta_compare' => '>=',
		'meta_value' => $currentdate,
		'orderby' => 'meta_value',
       	'order' => 'ASC',
	);
	if(isset($_REQUEST['eventtype']) && !empty($_REQUEST['eventtype'])){
		$args['meta_query'] = array(
			array(
				'key'     => 'event_type',
				'value'   => $_REQUEST['eventtype'],
				'compare' => '='
			)
		);
	}
	if(isset($_REQUEST['eventmode']) && !empty($_REQUEST['eventmode'])){
		$args['meta_query'][] = array(
			array(
				'key'     => 'event_category',
				'value'   => $_REQUEST['eventmode'],
				'compare' => '='
			)
		);
	}
	
	if(isset($term->name)){
		$args['tax_query'][] = array(
			array(
				'taxonomy' => 'event-category',
				'field'    => 'slug',
				'terms' => $term->name
			),
	);
	} else {
		if( isset($_REQUEST['eventcategory']) && !empty($_REQUEST['eventcategory']) ) {
			$args['tax_query'][] = array(
					array(
						'taxonomy' => 'event-category',
						'field'    => 'slug',
						'terms' => $_REQUEST['eventcategory']
					),
			);
		}
	}

	$query = new WP_Query( $args );

	if( $query->have_posts() ) :
		
		while( $query->have_posts() ): $query->the_post();

			global $post;
			
			$id = get_the_ID();
			
	
			$startd = get_post_meta( $id, "event_start_date", true);
			
			$startdate = date("d", $startd);
			
			$startdayOnly = date("D", $startd);
            $startdateMonthShort = date("M", $startd);
			$startdateMonth = date("M j Y", $startd);
            $startdateYear = date("Y", $startd);

			$endd = get_post_meta( $id, "event_end_date", true);
			$enddate = date("F j, Y", $endd);
			$evt_desc = get_post_meta( $id, "event_description", true);
			$evt_descsmall = substr($evt_desc, 0, 300);
			$cta_text = get_post_meta( $id, "cta_text", true);
			$cta_text_html = $cta_text != '' ? $cta_text : 'FIND OUT MORE';
			$cta_data = '';
			// if(rwmb_meta('event_url') != ''){
			// 	$cta_data = '<a href="' . esc_url(rwmb_meta('event_url')) . '" target="_blank" class="event-calendar-link hidden-sm-down">
			// 	<span class="material-symbols-outlined">arrow_forward</span>' . esc_html($cta_text_html) . '</a>';
			// }
			$evt_address = get_post_meta( $id, "event_address", true);

			$terms = get_the_terms($id, 'event-category' );
			if($terms):
				foreach ($terms as $term) {
					$category = $term->name;				
					$cat_html = '';
					
					if($category){
						$cat_html = $category;
					}
					break;
				}
			endif;


			$image_html = '';
			$images = rwmb_meta( 'event-logo', array('size' => 'full'), $post->ID ); // Prior to 4.8.0
			if ( !empty( $images ) ) {
				foreach ( $images as $image ) {
					$image['alt'] = get_the_title();
					$image_html = '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="' . $image['alt'] . '" />';
				}
			}

			$evt_addressDetail = '';
			if($evt_address){
				$evt_addressDetail = '<span class="material-symbols-outlined">location_on</span>
									<span class="location">' . $evt_address . '</span>';
			}
			// $profile_contnet = get_the_content();
			$newDate = date("m/d/Y", strtotime($startdateMonth));
			if (strtotime($currentdate) >= strtotime($newDate)){
				//echo "Previous Events";
			} else {
			$html .= '<div class="listing-container">
                        <div class="listing-content">
							<p class="category">
								<span class="material-symbols-outlined">arrow_outward</span>' 
								. $cat_html . 
							'</p>
                            <h3 class="entry-title">' . $post->post_title . '</h3>
							<div class="logo-container">' . $image_html . '</div>
							<div class="listing-icon-info">
								<p class="meta">' . $evt_addressDetail . '</p>
								<p class="meta">
									<span class="material-symbols-outlined">calendar_month</span>' . $startdateMonth . 
								'</p>
							</div>'. $evt_descsmall .
							'<div class="listing-footer">';

							if(strlen($evt_desc) == 0) {
								$html .= '<a href="' . esc_url(rwmb_meta('event_url')) . '" class="button button-brand button-outline" target=_blank>';
							} else {
								$html .= '<a href="' . get_the_permalink($id) . '" class="button button-brand button-outline" >';
											
							}

							$html.='<span class="material-symbols-outlined">arrow_forward</span>' . esc_html($cta_text_html) . 
							'</a>
                        	</div>
                        </div>

                  </div>';
			}
		
		endwhile;
		wp_reset_postdata();
	else :
		$html .="<div class='no-results'>
					<h3>No Events Found</h3>
					<p>We couldn't find what you were searching for. Try searching again</p>
				</div></div>";
	endif;
    
    if (wp_doing_ajax()) {
		echo $html;
        die;
    } else {
		return $html;
	}
}
add_action('wp_ajax_myfilter', 'events_filter_function');
add_action('wp_ajax_nopriv_myfilter', 'events_filter_function');