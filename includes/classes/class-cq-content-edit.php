<?php
class cqContentEdit {
	
	private $plugin_name = 'cq-custom';
	
	public static function init() {
		$self = new self();
		remove_filter( 'get_the_excerpt', 'wp_trim_excerpt');
        add_filter( 'get_the_excerpt', array( $self, 'cq_wp_trim_excerpt' ));
        add_filter( 'wpseo_metabox_prio', array( $self, 'yoasttobottom') );
        add_filter( 'get_the_archive_title', array( $self, 'remove_archive_prefix') );
        add_filter('get_image_tag_class',array( $self, 'add_lightbox_image_class') );
  	}

    function cq_wp_trim_excerpt( $text = '' ) {
        $raw_excerpt = $text;

        if ( '' == $text ) {
            $text = get_the_content( '' );
            $text = strip_shortcodes( $text );
            $text = apply_filters( 'the_content', $text );
            $text = str_replace( ']]>', ']]&gt;', $text );
            $excerpt_length = apply_filters( 'excerpt_length', 55 );
            $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );

            $allowable = array('<br>', '<p>');
            $text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );
            $text = trim( strip_tags( $text, $allowable ) );

            if ( 'characters' == _x( 'words', 'word count: words or characters?' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
                $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
                preg_match_all( '/./u', $text, $words_array );
                $words_array = array_slice( $words_array[0], 0, $excerpt_length + 1 );
                $sep = '';
            } else {
                $words_array = preg_split( "/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
                $sep = ' ';
            }

            if ( count( $words_array ) > $excerpt_length ) {
                array_pop( $words_array );
                $text = implode( $sep, $words_array );
                $text = $text . $excerpt_more;
            } else {
                $text = implode( $sep, $words_array );
            }
        }

        return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
    }
    
    // Move Yoast to bottom
    public function yoasttobottom() {
        return 'low';
    }

    function add_lightbox_image_class ($class){
        $class .= ' lightbox';
        return $class;
    }
    
    public function remove_archive_prefix() {    
        if ( is_category() ) {    
                $title = single_cat_title( '', false );    
            } elseif ( is_tag() ) {    
                $title = single_tag_title( '', false );    
            } elseif ( is_tax() ) {    
                $title = single_term_title( '', false );    
            } elseif ( is_author() ) {    
                $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
            } elseif ( is_tax() ) { //for custom post types
                $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
            } elseif (is_post_type_archive()) {
                $title = post_type_archive_title( '', false );
            }
        return $title;    
    }
}
cqContentEdit::init();                  