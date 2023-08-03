<?php 

class cqInteractive {
    
    public $hotspot_counter = 0;
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'create_cq_interactive_postype'));
        add_action( 'init', array( $self, 'create_cq_interactive_content_postype'));
        add_action('admin_enqueue_scripts', array( $self, 'enqueue_scripts'));
        add_action('wp_ajax_get_image_url', array( $self, 'get_image_url'));
        add_action('wp_ajax_get_interactive_content', array( $self, 'content_ajax_html'));
        add_action('wp_ajax_nopriv_get_interactive_content', array( $self, 'content_ajax_html'));
        add_action('render_cq_interactive', array( $self, 'render_cq_interactive'));
        add_action('manage_cq_interactive_item_posts_custom_column', array( $self, 'add_column_shortcode'), 10, 2); 
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_metaboxes') );
        add_filter('manage_cq_interactive_item_posts_columns', array( $self, 'add_shortcode_column') );
        add_shortcode('cq_interactive_embed', array( $self, 'cq_interactive_item_shortcode'));
    }
    
    public function create_cq_interactive_postype() {
 
        $labels = array(
            'name' => _x('Interactive', 'post type general name'),
            'singular_name' => _x('Interactive Item', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Interactive Item'),
            'edit_item' => __('Edit Interactive Item'),
            'new_item' => __('New Interactive Item'),
            'view_item' => __('View Interactive Item'),
            'search_items' => __('Search Interactive Item'),
            'not_found' =>  __('No Interactive Items found'),
            'not_found_in_trash' => __('No Interactive Items found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Interactive Items'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => false,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-games',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "interactive" ),
            'supports'=> array('title', 'thumbnail') ,
            'show_in_nav_menus' => true,
        );

        register_post_type( 'cq_interactive_item', $args);

    }
    
    public function create_cq_interactive_content_postype() {
 
        $labels = array(
            'name' => _x('Interactive Content', 'post type general name'),
            'singular_name' => _x('Interactive Content', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Interactive Content'),
            'edit_item' => __('Edit Interactive Content'),
            'new_item' => __('New Interactive Content'),
            'view_item' => __('View Interactive Content'),
            'search_items' => __('Search Interactive Content'),
            'not_found' =>  __('No Interactive Content found'),
            'not_found_in_trash' => __('No Interactive Content found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Interactive Content'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-text',
            'show_in_menu' => 'edit.php?post_type=cq_interactive_item',
            'hierarchical' => false,
            'supports'=> array('title', 'thumbnail', 'editor', 'post-thumbnails') ,
            'show_in_nav_menus' => true,
        );

        register_post_type( 'interactive_content', $args);

    }
    
    public function add_shortcode_column($columns) {
        return array_merge($columns, ['shortcode' => 'Shortcode']);
    }
    
    public function add_column_shortcode($column_key, $post_id) {
        if ($column_key == 'shortcode') {
            if (is_numeric($post_id)) {
                echo '<span style="color:green;">[cq_interactive_embed id="' . $post_id . '"]</span>';
            }
        }
    }
    
    public function cq_metaboxes($meta_boxes) {
        
        $meta_boxes[] = array(
            'id' => 'interactive-image',
            'title' => esc_html__( 'Interactive Image', 'CQ_Custom' ),
            'pages'    => array( 'cq_interactive_item' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'          => 'interactive_image',
                    'desc'        => 'Please add a featured image first',
                    'type'        => 'custom_html',
                    'std'         => '<div id="interactive_image_canvas"></div>',
                    'callback' => array( $this, 'setup_admin_interactive_image')
                ),  
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'interactive-image-hotspots',
            'title' => esc_html__( 'Hotspots', 'CQ_Custom' ),
            'pages'    => array( 'cq_interactive_item' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'          => 'image_hotspots',
                    'desc'        => 'Add rows to create hotspot markers',
                    'type'        => 'group',
                    'class' => 'coordinates-group',
                    'clone' => true,
                    'fields' => array(
                        array(
                            'name' => 'position',
                            'id'   => 'hotspot',
                            'class' => 'coordinates',
                            'type' => 'text_list',
                            'options' => array('Xpos' => '',
                                               'Ypos' => '')
                        ),
                        array(
                            'title' => 'Content',
                            'name' => 'Hotspot Content',
                            'id' => 'hotspot_content',
                            'type' => 'post',
                            'post_type' => 'interactive_content',
                            'field_type'  => 'select_advanced',
                        )
                    ),  
                ),
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'interactive-content-gallery',
            'title' => esc_html__( 'Gallery Images', 'CQ_Custom' ),
            'pages'    => array( 'interactive_content' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'          => 'interactive-content-gallery',
                    'desc'        => 'Add gallery images',
                    'type'        => 'image_advanced',
                    'image_size'  => 'thumbnail',
                    'max_file_uploads' => 10,
                    'max_status' => true
                ),
            )
        );
        
        return $meta_boxes;
    }
    
    public function setup_admin_interactive_image() {
        
        if (isset($_GET['post'])) {
            
            $post_id = sanitize_text_field($_GET['post']);
            
            $img_html = '<img src="' . get_the_post_thumbnail_url($_GET['post'], 'full') . '"  class="interactive-img" />';
            
            $hotspots = get_post_meta($post_id, 'image_hotspots', true);
            
            $hotspots_html = '';
            
            $data_id = 0;
            
            if (is_array($hotspots)) {
                $hotspots_html .= '<ol id="hotspots">';
                foreach ( $hotspots as $hotspot) {
                    $hotspots_html .= '<li class="hotspot" data-id="' . $data_id . '" style="display: inline-block; width:20px; height: 20px; background-color: red; position: absolute; left: ' . $hotspot['hotspot'][0] . '; top: ' . $hotspot['hotspot'][1] . ';"></li>';
                    $data_id++;
                    $this->hotspot_counter++;
                }
                $hotspots_html .= '</ol>';
            } else {
                $hotspots_html = '<ol id="hotspots"><li class="hotspot" data-id="0" style="display: inline-block; width:20px; height: 20px; background-color: red; position: absolute;"></li></ol>';
            }
            
            $html = '<div id="interactive_image_canvas"><ul id="hotspots">
                    ' . $hotspots_html . $img_html . '
                    </div>';
            
        } else {
            $html = '<div id="interactive_image_canvas"><ol id="hotspots"><li class="hotspot" data-id="0" style="display: inline-block; width:20px; height: 20px; background-color: red; position: absolute;"></li></ol></div>';
        }
        
        return $html;
        
    }
    
    function enqueue_scripts(){
        
        global $pagenow;
        
        if ( (isset($_GET['post_type']) && $_GET['post_type'] == 'cq_interactive_item') || (isset($_GET['post']) && 'cq_interactive_item' == get_post_type($_GET['post']) )  ) {
            wp_enqueue_script('jquery-ui-droppable');
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script( 'cq-interactive', plugins_url('/cq-custom/assets/js/cq-interactive-js.js', 'cq-custom'), array( 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-droppable' ), '1.0.0', true );
            wp_enqueue_style( 'jquery-ui-datepicker', plugins_url('/cq-custom/assets/css/cq-interactive-css.css', 'cq-custom'), array(), '1.11.6', 'all');
            wp_localize_script('cq-interactive', 'hotspot_object', array('hotspot_id' => $this->hotspot_counter));
        }
    }
    
    function get_image_url() {
        
        $image_id = $_REQUEST['image_id'];
        
        if ($image_id > 0) {
            $image_attributes = wp_get_attachment_image_src( $image_id, 'full' );
        
            echo '<img src="' . $image_attributes[0] . '" class="interactive-img" />';
        }
        
        die;
        
    }
    
    public function render_cq_interactive() {
        
        global $post;
        
        $hotspots = get_post_meta($post->ID, 'image_hotspots', true);
        $hotspots_html = '';
        
        if (is_array($hotspots)) {
            $hotspots_html .= '<ol id="hotspots">';
            foreach ( $hotspots as $hotspot) {
                
                $content_id = isset($hotspot['hotspot_content']) && $hotspot['hotspot_content'] != '' ? esc_attr($hotspot['hotspot_content']) : '';
                
                $hotspots_html .= '<li class="hotspot" data-content_id="' . $content_id . '" style="position: absolute; left: ' . $hotspot['hotspot'][0] . '; top: ' . $hotspot['hotspot'][1] . ';"></li>';
                
                $this->hotspot_counter++;
            }
            $hotspots_html .= '</ol>';
         
        }
        
        $main_img_html = preg_replace( '/(width|height|srcset|sizes)="[^"]*"/', '', get_the_post_thumbnail( $post->ID, 'full' ) );
        
        $html = '<div class="wrapper advent-calendar-wrapper" id="landing-page-wrapper">
                    <ul id="mobile-scroll">
                        <li class="nav-up"><span class="lnr lnr-arrow-up"></span></li>
                        <li class="nav-left"><span class="lnr lnr-arrow-left"></span></li>
                        <li class="nav-desc"><span>Scroll to look around</span></li>
                        <li class="nav-right"><span class="lnr lnr-arrow-right"></span></li>
                        <li class="nav-down"><span class="lnr lnr-arrow-down"></span></li>
                    </ul>
                    <a id="back_button" href="javascript:history.go(-1)" title="Return to previous page"><span class="fa fa-arrow-left"></span> Go back</a>
                    <h3 id="interactive-item-title">' . get_the_title() . '</h3>
                    <p class="interactive-description"><span class="fa fa-question"></span></p>
                    <div  id="content" class="container-fluid no-padding">
                        <div id="interactive_content_box">
                            <a class="close-icon"><div class="popup-close"><span></span><span></span><span></span></div></a>
                            <div id="interactive_content_container"></div>
                        </div>
                        <div id="primary" class="no-padding">
                            ' . $hotspots_html . 
                            $main_img_html .
                        '</div>
                    </div>
                </div>
                ';
        
        echo $html;
    }
    
    public function content_ajax_html() {
		
		global $wpdb;
		
		
		if (isset($_POST['data']['content_id'])) {
		
            $content_id = $_POST['data']['content_id'];

            $content_post = get_post($content_id);
            
            if ($content_post) {
                global $post;
                $content_title = get_the_title($content_id);
                $img_url = wp_get_attachment_image_src(get_post_thumbnail_id($content_id), 'full');
                
                $gallery_images = rwmb_meta( 'interactive-content-gallery', array( 'size' => 'featured-box-bg-image' ), $content_id );
                
                if (isset($img_url[0])) {
                    $img_html = '<div class="interactive-content-img owl-carousel">
                                    <a href="' . $img_url[0] . '" title="' . the_title_attribute() . '" itemprop="image" class="lightbox">
                                    ' . get_the_post_thumbnail($content_id, 'large') . '
                                    </a>';
                    
                    if (!empty($gallery_images)) {
                        foreach ( $gallery_images as $image ) {
                            $img_html .= '<a href="' . $image['full_url'] . '" itemprop="image" class="lightbox"><img src="' . $image['url'] . '"></a>';
                        }
                    }
                    
                    $img_html .= '</div>';
                    
                } else {
                    $img_html = '';
                }

                $content_post_html = '<div class="container-fluid interactive-content-section">
                                    <div class="interactive-content-wrapper">
                                        <div class="row">
                                            <div class="interactive-content-heading">
                                                <h3>' . esc_html($content_title) . '</h3>
                                            </div>
                                            ' . $img_html . '
                                            <div class="interactive-content">
                                                <div class="content-description">
                                                ' . apply_filters('the_content', $content_post->post_content) . '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            } else {
                $content_post_html = '<div class="container-fluid interactive-content-section">
                                <div class="interactive-content-wrapper">
                                    <div class="row">
                                        <div class="interactive-content">
                                            <div class="content-description">
                                            <p>No information yet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }

            echo $content_post_html;
		}
		
		die;
	}
    
    public function cq_interactive_item_shortcode($attributes) {
        
        $atts = shortcode_atts(array('id' => ''), $attributes);
        
        $post_id = esc_html($atts['id']);
        $html = '';
        
        if (is_numeric($post_id)) {
            
            $html .= '<figure class="interactive-link">
                        <div class="interactive-img">
                            <a href="' . get_permalink($post_id) . '" class="interactive-img-link-icon" title="View"><span class="fa fa-external-link"></span></a>
                            <a href="' . get_permalink($post_id) . '" class="interactive-img-link" title="View">
                            ' . get_the_post_thumbnail( $post_id, 'medium' ) . '
                            </a>
                            <a href="' . get_permalink($post_id) . '" class="interactive-img-title" title="View">' . get_the_title($post_id) . '</a>
                        </div>
                    </figure>';
        }
        
        return $html;
        
    }
}
cqInteractive::init();