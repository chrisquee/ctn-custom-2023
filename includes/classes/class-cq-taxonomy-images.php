<?php
/**
 * Plugin class
 **/
if ( !class_exists( 'cq_taxonomy_images' ) ) {

class cq_taxonomy_images {

  public function __construct() {
    //
  }
 
 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public static function init() {
    $self = new self();
   add_action( 'cruise-type_add_form_fields', array ( $self, 'add_category_image' ), 10, 2 );
   add_action( 'cruise-type_add_form_fields', array ( $self, 'related_news_category' ), 10, 2 );
   add_action( 'cruise-type_add_form_fields', array ( $self, 'add_category_about' ), 10, 2 );
   add_action( 'created_cruise-type', array ( $self, 'save_category_image' ), 10, 2 );
   add_action( 'cruise-type_edit_form_fields', array ( $self, 'update_category_image' ), 10, 2 );
   add_action( 'cruise-type_edit_form_fields', array ( $self, 'update_category_about' ), 10, 2 );
   add_action( 'cruise-type_edit_form_fields', array ( $self, 'update_related_news_category' ), 10, 2 );
   add_action( 'edited_cruise-type', array ( $self, 'updated_category_image' ), 10, 2 );
     
   add_action( 'cruise-line_add_form_fields', array ( $self, 'add_category_image' ), 10, 2 );
   add_action( 'cruise-line_add_form_fields', array ( $self, 'related_news_category' ), 10, 2 );
   add_action( 'created_cruise-line', array ( $self, 'save_category_image' ), 10, 2 );
   add_action( 'cruise-line_edit_form_fields', array ( $self, 'update_category_image' ), 10, 2 );
   add_action( 'cruise-line_edit_form_fields', array ( $self, 'update_related_news_category' ), 10, 2 );
   add_action( 'edited_cruise-line', array ( $self, 'updated_category_image' ), 10, 2 );
     
   add_action( 'region_add_form_fields', array ( $self, 'add_category_image' ), 10, 2 );
   add_action( 'region_add_form_fields', array ( $self, 'related_news_category' ), 10, 2 );
   add_action( 'created_region', array ( $self, 'save_category_image' ), 10, 2 );
   add_action( 'region_edit_form_fields', array ( $self, 'update_category_image' ), 10, 2 );
   add_action( 'region_edit_form_fields', array ( $self, 'update_related_news_category' ), 10, 2 );
   add_action( 'edited_region', array ( $self, 'updated_category_image' ), 10, 2 );
     
   add_action( 'course-category_add_form_fields', array ( $self, 'add_category_image' ), 10, 2 );
   add_action( 'created_course-category', array ( $self, 'save_category_image' ), 10, 2 );
   add_action( 'course-category_edit_form_fields', array ( $self, 'update_category_image' ), 10, 2 );
   add_action( 'edited_course-category', array ( $self, 'updated_category_image' ), 10, 2 );
     
   add_action( 'admin_enqueue_scripts', array( $self, 'load_media' ) );
   add_action( 'admin_footer', array ( $self, 'add_script' ) );
 }

public function load_media() {
 wp_enqueue_media();
}
 
 /*
  * Add a form field in the new category page
  * @since 1.0.0
 */
 public function add_category_image ( $taxonomy ) { ?>
<!--   <div class="form-field term-group">-->
   <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top">	   
     <label for="<?php echo $taxonomy; ?>-image-id"><?php _e('Image', 'hero-theme'); ?></label>
	</th>
                <td>
     <input type="hidden" id="<?php echo $taxonomy; ?>-image-id" name="<?php echo $taxonomy; ?>-image-id" class="custom_media_url" value="">
     <div id="<?php echo $taxonomy; ?>-image-wrapper"><img src="" /></div>
     <p>
       <input type="button" class="button button-secondary ac_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
       <input type="button" class="button button-secondary ac_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
    </p>
				</td>
	   </tr>
</table>
<!--   </div>-->
 <?php
 }
    
 public function add_category_about ( $taxonomy ) { ?>
<!--   <div class="form-field term-group">-->
   <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top">	   
     <label for="<?php echo $taxonomy; ?>-about">About Text</label>
	</th>
                <td>
     <?php $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => $taxonomy . '-about' );
           $value = !is_object($taxonomy) ? '' : get_term_meta($taxonomy->term_id, $taxonomy . '-about', true);
           wp_editor(wp_kses_post($value , ENT_QUOTES, 'UTF-8'), $taxonomy . '-about', $settings); ?>
     <br /><span class="description"><?php _e('Add some test about this item,'); ?></span>
				</td>
	   </tr>
</table>
<!--   </div>-->
 <?php
 }
 
 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_category_image ( $term_id, $tt_id ) {
    
    $term = get_term( $term_id );
    $taxonomy = $term->taxonomy;
    
   if( isset( $_POST[$taxonomy . '-image-id'] ) && '' !== $_POST[$taxonomy . '-image-id'] ){
     $image = $_POST[$taxonomy . '-image-id'];
     add_term_meta( $term_id, $taxonomy . '-image-id', $image, true );
   }
     
   if( isset( $_POST[$taxonomy . '-news-category'] ) && '' !== $_POST[$taxonomy . '-news-category'] ){
     $category_id = $_POST[$taxonomy . '-news-category'];
     add_term_meta( $term_id, $taxonomy . '-news-category', $category_id, true );
   }
     
   if( isset( $_POST[$taxonomy . '-about'] ) && $_POST[$taxonomy . '-about'] != '' ) {
     $text = sanitize_textarea_field($_POST[$taxonomy . '-about']);
     add_term_meta( $term_id, $taxonomy . '-about', $text, true );
   }
}
 
 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_category_image ( $term, $taxonomy ) { ?>
<table class="form-table">
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="<?php echo $taxonomy; ?>-image-id"><?php _e( 'Image', 'CQ_Custom' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta( $term->term_id, $taxonomy . '-image-id', true ); ?>
       <input type="hidden" id="<?php echo $taxonomy; ?>-image-id" name="<?php echo $taxonomy; ?>-image-id" value="<?php echo $image_id; ?>">
       <div id="<?php echo $taxonomy; ?>-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } else {
             echo '<img src="" />';
                } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ac_media_button" id="ac_media_button" name="ac_media_button" data-uploader_title="Add a category image" data-uploader_button_text="Add image" value="<?php _e( 'Add Image', 'CQ_Custom' ); ?>" />
         <input type="button" class="button button-secondary ac_media_remove" id="ac_media_remove" name="acx_media_remove" value="<?php _e( 'Remove Image', 'CQ_Custom' ); ?>" />
       </p>
     </td>
   </tr>
</table>
 <?php
 }
    
    
  public function update_category_about ( $term, $taxonomy ) { ?>
<!--   <div class="form-field term-group">-->
   <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top">	   
     <label for="<?php echo $taxonomy; ?>-about">About Text</label>
	</th>
                <td>
     <?php $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => $taxonomy . '-about' );
           $value = !is_object($term) ? '' : get_term_meta($term->term_id, $taxonomy . '-about', true);
           wp_editor(wp_kses_post($value , ENT_QUOTES, 'UTF-8'), $taxonomy . '-about', $settings); ?>
     <br /><span class="description"><?php _e('Add some text about this item,'); ?></span>
				</td>
	   </tr>
</table>
<!--   </div>-->
 <?php
 }


/*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_category_image ( $term_id, $tt_id ) {
     
    $term = get_term( $term_id );
    $taxonomy = $term->taxonomy;
     
   if( isset( $_POST[$taxonomy . '-image-id'] ) && '' !== $_POST[$taxonomy . '-image-id'] ){
     $image = $_POST[$taxonomy . '-image-id'];
     update_term_meta( $term_id, $taxonomy . '-image-id', $image );
   } else {
     update_term_meta( $term_id, $taxonomy . '-image-id', '' );
   }
     
    if( isset( $_POST[$taxonomy . '-logo-image-id'] ) && '' !== $_POST[$taxonomy . '-logo-image-id'] ){
     $image = $_POST[$taxonomy . '-logo-image-id'];
     update_term_meta( $term_id, $taxonomy . '-logo-image-id', $image );
   } else {
     update_term_meta( $term_id, $taxonomy . '-logo-image-id', '' );
   }
     
    if( isset( $_POST[$taxonomy . '-news-category'] )) {
     $category_id = $_POST[$taxonomy . '-news-category'];
     update_term_meta( $term_id, $taxonomy . '-news-category', $category_id );
   }
     
   if( isset( $_POST[$taxonomy . '-about'] ) ) {
     $about_text = $_POST[$taxonomy . '-about'];
     update_term_meta( $term_id, $taxonomy . '-about', $about_text );
   }
     
     return;
 }

  public function related_news_category( $taxonomy ) { 

        $categories = get_categories( array(
            'orderby' => 'name',
            'order'   => 'ASC'
        ) );
      
      $options = '';
 
      foreach( $categories as $category ) {
        
          $options .= '<option value="' . $category->term_id . '">' . esc_html($category->name) . '</option>';
          
      }
    
    
    ?>
<!--   <div class="form-field term-group">-->
   <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top">	   
     <label for="<?php echo $taxonomy; ?>-news-category"><?php _e('Select related news category', 'hero-theme'); ?></label>
	</th>
                <td>
     <select id="<?php echo $taxonomy; ?>-news-category" name="<?php echo $taxonomy; ?>-news-category"><?php echo $options; ?></select>
     
				</td>
	   </tr>
</table>
<!--   </div>-->
 <?php
 }
    
   public function update_related_news_category( $term, $taxonomy ) { 

        $categories = get_categories( array(
            'orderby' => 'name',
            'order'   => 'ASC'
        ) );
      
      $options = '';
      $selected = '';
       
      $category_id = get_term_meta( $term->term_id, $taxonomy . '-news-category', true );
 
      foreach( $categories as $category ) {
          
          $selected = $category_id == $category->term_id ? 'selected' : '';
          
        
          $options .= '<option value="' . $category->term_id . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
          
      }
    
    
    ?>
<!--   <div class="form-field term-group">-->
   <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top">	   
     <label for="<?php echo $taxonomy; ?>-news-category"><?php _e('Select related news category', 'hero-theme'); ?></label>
	</th>
                <td>
     <select id="<?php echo $taxonomy; ?>-news-category" name="<?php echo $taxonomy; ?>-news-category"><?php echo $options; ?></select>
     
				</td>
	   </tr>
</table>
<!--   </div>-->
 <?php
 }
/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { 
     
     if (isset($_GET['taxonomy']) && $_GET['taxonomy'] != '') {
         $taxonomy = sanitize_text_field($_GET['taxonomy']);
     
    ?>
   <script>
     jQuery(document).ready( function($) {
             var file_frame; // variable for the wp.media file_frame
            // attach a click event (or whatever you want) to some element on your page
            $( '.ac_media_button' ).on( 'click', function( event ) {
                event.preventDefault();
                // if the file_frame has already been created, just reuse it
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                file_frame = wp.media.frames.file_frame = wp.media({
                    title: $( this ).data( 'uploader_title' ),
					allowLocalEdits: true,
            		displaySettings: true,
                    button: {
                        text: $( this ).data( 'uploader_button_text' ),
                    },
					library: {
            			type: 'image'
        			},
                    multiple: false // set this to true for multiple file selection
                });
				
				file_frame.on( 'open', function() {
                    var images = $( '#<?php echo $taxonomy; ?>-image-id' ).val();
                    if ( !images ) {
                        return;
                    }

                    var image_ids = images.split( ',' );
                    var library = file_frame.state().get( 'library' );
                    image_ids.forEach( function( id ) {
                        attachment = wp.media.attachment( id );
                        attachment.fetch();
                        library.add( attachment ? [ attachment ] : [] );
                    } );
                } );

                file_frame.on( 'select', function() {
                    attachment = file_frame.state().get('selection').first().toJSON();
					console.log(attachment);
					$( '#<?php echo $taxonomy; ?>-image-id').val(attachment.id);
                    $( '#<?php echo $taxonomy; ?>-image-wrapper' ).html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    $( '#<?php echo $taxonomy; ?>-image-wrapper img' ).attr('src', attachment.sizes.thumbnail.url);
					
                });

                file_frame.open();
            });
         
            $( '.ac_media_remove' ).on( 'click', function( event ) {
                  event.preventDefault();
			     $( '#<?php echo $taxonomy; ?>-image-id').val('');
                 $( '#<?php echo $taxonomy; ?>-image-wrapper' ).html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });
		  });
 </script>
 <?php }
     
     }
	

}
cq_taxonomy_images::init();
 
}