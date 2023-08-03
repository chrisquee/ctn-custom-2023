<?php

class CqUserNotices {
    
    public $notices = array();
    
    public function __construct() {
        
        add_action('show_notices', array($this, 'notices_html'), 99, 1);
        
    }
    
    public function add_notice($key, $type, $message, $link = '', $link_text = 'Details') {
        
        $this->notices[$key] = array('type' => $type, 'message' => $message, 'link' => $link, 'link_text' => $link_text);
        
        return;
        
    }
    
    public function remove_notice($key) {
        
        unset($this->notices[$key]);
        
        return;
        
    }
    
    public function notices_html() {
        
        $html = '';
        
        if (!empty($this->notices)) {
            
            $html = '<div class="notice-wrapper">
                        <ul id="user-notices">';
            
            foreach ($this->notices as $key => $value) {
                
                $link_text = $value['link'] != '' ? '<a href="' . esc_url($value['link']) . '" class="notice-link ' . esc_attr($value['type']) . '">' . esc_html($value['link_text']) . '</a>' : '';
                
                $html .= '<li class="notice ' . esc_attr($value['type']) . '">' . esc_html($value['message']) . $link_text . '</li>';
                
            }
            
            $html .= '  </ul>
                      </div>';
        }
        if ( wp_doing_ajax() ) {
            return $html;
        } else {
            echo $html;
        }
        
    }
    
}