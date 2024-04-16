<?php 

class cqGutenberg {
    
    public static function init() {
        
        $self = new self();
        
        add_action( 'enqueue_block_editor_assets', array($self, 'enqueue_editor_assets') );
        add_action( 'init', array($self, 'cq_register_blocks') );
        
        
    }
    
    public function enqueue_editor_assets() {

        wp_enqueue_script( 'cq-gutenberg-js', plugins_url( '/assets/js/admin.min.js', dirname(__FILE__, 2) ), array( 'wp-blocks', 'wp-element' ), time(), true );

    }
    
    public function cq_register_blocks() {
        
        register_block_type( 'cq/newsetter-block', array(
            'render_callback' => array($this, 'cq_newsletter_block_render'),
            'attributes' => array(
                'style' => array(
                    'type' => 'string'
                ),
                'title' => array(
                    'type' => 'string'
                ),
                'subtitle' => array(
                    'type' => 'string'
                ),
                'block_image' => array(
                    'type' => 'integer'
                ),
                'block_image_url' => array(
                    'type' => 'string'
                ),
                'el_class' => array(
                    'type' => 'string'
                ),
            ),
            
        ) );
        
        register_block_type( 'cq/events-block', array(
            'render_callback' => array($this, 'cq_events_block_render'),
        ) );
        
        register_block_type( 'cq/title-separator', array(
            'render_callback' => array($this, 'cq_title_separator_render'),
        ) );
        
       /* $registry = WP_Block_Type_Registry::get_instance();
        
        print_r($registry->get_all_registered());*/
        
    }
    
    public function cq_events_block_render($attributes = array()) {
        
        $shortcode = new cqShortcodes();

        return $shortcode->cq_events_list_shortcode($attributes);

    }
    
    public function cq_title_separator_render($attributes = array()) {
        
        $shortcode = new cqShortcodes();

        return $shortcode->cq_title_separator_shortcode($attributes);

    }
    
    public function cq_newsletter_block_render($attributes = array()) {
        
        $shortcode = new cqShortcodes();

        return $shortcode->cq_newsletter_block_shortcode($attributes);

    }
    
}
cqGutenberg::init();