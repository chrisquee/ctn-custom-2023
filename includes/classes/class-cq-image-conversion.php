<?php

class cqImageConversion {
    
    public static function init() {
        
        $self = new self();
        
        add_filter( 'wp_handle_upload', array( $self, 'handle_upload_convert_to_webp' ) );
        add_filter( 'upload_mimes', array( $self, 'add_svg_mime_types') );
        add_filter( 'image_editor_output_format', array( $self, 'image_editor_formats'), 99 );

    }
    
    public function handle_upload_convert_to_webp( $upload ) {
        
        //if (isset($_POST['post_id']) && is_numeric($_POST['post_id']) && $_POST['post_id'] > 0) {
            $is_animated_gif = false;
        
            if ($upload['type'] == 'image/gif') {
                $is_animated_gif = $this->is_animated_gif($upload['file']);  
            }
            
            if ( $upload['type'] == 'image/jpeg' || $upload['type'] == 'image/png' || ($upload['type'] == 'image/gif' && $is_animated_gif == false) ) {
                $file_path = $upload['file'];
                // Check if ImageMagick or GD is available
                if ( extension_loaded( 'imagick' ) || extension_loaded( 'gd' ) ) {
                    $image_editor = wp_get_image_editor( $file_path );
                    if ( ! is_wp_error( $image_editor ) ) {
                        $file_info = pathinfo( $file_path );
                        $dirname   = $file_info['dirname'];
                        $filename  = $file_info['filename'];
                        // Create a new file path for the WebP image
                        $new_file_path = $dirname . '/' . $filename . '.webp';
                        // Attempt to save the image in WebP format
                        $saved_image = $image_editor->save( $new_file_path, 'image/webp' );
                        if ( !is_wp_error( $saved_image ) && file_exists( $saved_image['path'] ) ) {
                            // Success: replace the uploaded image with the WebP image
                            $upload['file'] = $saved_image['path'];
                            $upload['url']  = str_replace( basename( $upload['url'] ), basename( $saved_image['path'] ), $upload['url'] );
                            $upload['type'] = 'image/webp';
                            // Optionally remove the original image
                            @unlink( $file_path );
                        }
                    }
                }
            }
        //}
        return $upload;
    }
    
    public function is_animated_gif($filename) {
        
        if(!($fh = @fopen($filename, 'rb'))) {
            return false;
        }

        $count = 0;
        //an animated gif contains multiple "frames", with each frame having a
        //header made up of:
        // * a static 4-byte sequence (\x00\x21\xF9\x04)
        // * 4 variable bytes
        // * a static 2-byte sequence (\x00\x2C)

        // We read through the file til we reach the end of the file, or we've found
        // at least 2 frame headers
        while(!feof($fh) && $count < 2) {
            $chunk = fread($fh, 1024 * 100); //read 100kb at a time
            $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk, $matches);
        }

        fclose($fh);
        
        return $count > 1;

    }
    
    public function add_svg_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    
    public function image_editor_formats( $formats ) {
        
        $formats['image/jpeg'] = 'image/webp';
        $formats['image/png'] = 'image/webp';

        return $formats;
    }
    
}
cqImageConversion::init();