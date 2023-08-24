<?php
function cq_user_profile_fields( $fields = '' ) {
	
	$fields = array(
				array('type' => 'text',
					  'id' => 'user_login',
					  'label' => 'Username',
					  'class' => 'username-text',
					  'desc' => 'Your username. This cannot be changed.'),
				 array('type' => 'email',
					  'id' => 'user_email',
					  'label' => 'Email Address',
					  'class' => 'email-text',
					  'desc' => 'Your preferred email address for any communication',
                      'required' => 'required'),
				array('type' => 'text',
					  'id' => 'first_name',
					  'label' => 'First Name',
					  'class' => 'first-name-text',
                      'required' => 'required',
					  'desc' => ''),
		        array('type' => 'text',
					  'id' => 'last_name',
					  'label' => 'Last Name',
                      'required' => 'required',
					  'class' => 'last-name-text',
					  'desc' => ''),
                array('type' => 'tel',
					  'id' => 'contact_phone',
					  'label' => 'Telephone Number',
                      'required' => 'required',
					  'class' => 'contact-phone-text',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_line_1',
					  'label' => 'Address Line 1',
                      'required' => 'required',
					  'class' => 'billing_address_1',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_line_2',
					  'label' => 'Address Line 2',
					  'class' => 'billing_address_2',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_town',
					  'label' => 'Town',
                      'required' => 'required',
					  'class' => 'billing_town',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_county',
					  'label' => 'County',
					  'class' => 'billing_county',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_postcode',
					  'label' => 'Post Code',
					  'class' => 'billing_postcode',
					  'desc' => ''),
				array('type' => 'select',
					  'id' => 'address_country',
                      'required' => 'required',
					  'label' => 'Country',
					  'options' => get_country_list(),
					  'class' => 'billing_country',
					  'desc' => ''),
	);
	
	$fields = apply_filters('cq_fields_password', $fields);
	
	return $fields;
	
}
add_filter( 'cq_fields_profile', 'cq_user_profile_fields', 10 );

/**
 * wpfep_add_password_tab_fields()
 * adds the password update fields to the passwords tab
 * @param (array) $fields are the current array of fields added to this filter.
 * @return (array) $fields are the modified array of fields to pass back to the filter
 */
function cq_user_password_fields( $fields ) {
	
	$fields[] = array(
		'id' => 'user_pass',
		'label' => 'Change Password',
		'desc' => 'New Password - You will be logged out from the site after changing',
		'type' => 'password',
		'class' => 'user_pass',
	);
	
	$fields[] = array(
		'type' => 'nonce',
		'id' => 'nonce',
		'label' => '',
		'class' => '',
		'desc' => '');
	
	return $fields;

}
add_filter( 'cq_fields_password', 'cq_user_password_fields', 10 );

function cq_business_fields( $fields ) {
    
    $user_id = get_current_user_id();
	
    if (current_user_can('trade_seller')) {
        $fields[] = array(
            'id' => 'business_name',
            'label' => 'Business Name',
            'desc' => 'Your business name you would like displayed',
            'type' => 'text',
            'class' => 'business_name',
        );
        
        $fields[] = array(
            'id' => 'trustpilot_id',
            'label' => 'Trustpilot ID',
            'desc' => 'Your Trustpilot ID for displying ratings',
            'type' => 'text',
            'class' => 'trustpilot_id',
        );
        $fields[] = array(
            'id' => 'customer_service_email',
            'label' => 'Customer Service Email',
            'desc' => 'Your email for customer service',
            'type' => 'email',
            'class' => 'customer_service_email',
        );
        
        $fields[] = array(
            'id' => 'customer_service_phone',
            'label' => 'Customer Service Phone Number',
            'desc' => 'Your telephone number for customer service',
            'type' => 'text',
            'class' => 'customer_service_phone',
        );
        
        $fields[] = array(
            'id' => 'business_website',
            'label' => 'Your Website',
            'desc' => 'your website address. Please include http:// or https://',
            'type' => 'text',
            'class' => 'customer_service_phone',
        );
        
        if (get_user_meta($user_id, 'enable_logo_upload', true ) == '1') {
            $fields[] = array(
                'type' => 'file_image',
                'id' => 'business_logo',
                'label' => 'Add your logo',
                'class' => 'business_logo',
                'desc' => 'Your business logo to be displayed');
        }
        
        /*if ($user_id == 2) {
            $fields[] = array(
                'type' => 'stripe_connect',
                'id' => 'business_logo',
                'label' => 'Connect with Stripe',
                'class' => 'business_logo',
                'desc' => 'Connect with stripe to get paid');
        }*/
    }
	
	return $fields;

}
add_filter( 'cq_fields_password', 'cq_business_fields', 10 );

function output_checkout_fields() {
    
    $fields = array(
				array('type' => 'text',
					  'id' => 'first_name',
					  'label' => 'First Name',
                      'required' => 'required',
					  'class' => 'first-name-text',
					  'desc' => ''),
		        array('type' => 'text',
					  'id' => 'last_name',
					  'label' => 'Last Name',
                      'required' => 'required',
					  'class' => 'last-name-text',
					  'desc' => ''),
                array('type' => 'tel',
					  'id' => 'contact_phone',
					  'label' => 'Telephone Number',
                      'required' => 'required',
					  'class' => 'contact-phone-text',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_line_1',
                      'required' => 'required',
					  'label' => 'Address Line 1',
					  'class' => 'billing_address_1',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_line_2',
                      'required' => 'required',
					  'label' => 'Address Line 2',
					  'class' => 'billing_address_2',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_town',
					  'label' => 'Town',
                      'required' => 'required',
					  'class' => 'billing_town',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_county',
					  'label' => 'County',
					  'class' => 'billing_county',
					  'desc' => ''),
				array('type' => 'text',
					  'id' => 'address_postcode',
					  'label' => 'Post Code',
					  'class' => 'billing_postcode',
					  'desc' => ''),
				array('type' => 'select',
					  'id' => 'address_country',
                      'required' => 'required',
					  'label' => 'Country',
					  'options' => get_country_list(),
					  'class' => 'billing_country',
					  'desc' => ''),
	);
    
    output_user_fields($fields, true);
    
}


function output_user_fields($fields = array(), $non_account = false) {
	
	$user_id = get_current_user_id();
	
	//$fields = array();
	
    if (empty($fields)) {
	   $fields = cq_user_profile_fields( $fields );
    }
	$field_count = 1;
	?>

		<section class="submit-section">
        	<div class="row">
	
	<?php
	foreach ($fields as $field) { ?>
			
		<?php if ($field['id'] == 'user_login' || ($non_account == true && $field['id'] == 'first_name' )) { ?>
			<div class="col-md-12 user-heading">
				<h3>Basic Details</h3>
			</div>
		<?php } elseif ($field['id'] == 'address_line_1') { ?>
        </section>
        <section class="submit-section">
        	<div class="row">
				<div class="col-md-12 user-heading">
					<h3>Address Details</h3>
				</div>
		<?php } elseif ($field['id'] == 'user_pass') { ?>
        	</section>
        	<section class="submit-section">
        		<div class="row">
					<div class="col-md-12 user-heading">
						<h3>Password</h3>
					</div>
		<?php } elseif ($field['id'] == 'business_name') { ?>
            </section>
             <section class="submit-section">
        		<div class="row">
					<div class="col-md-12 user-heading">
						<h3>Business Information</h3>
					</div>
        <?php } ?>
		
		<div class="col-md-6 user-field-wrapper">
		
			<?php  render_field( $field, $field['class'] . '-wrap', $user_id ); ?>
		
		</div>
			
		
		
	<?php
								 
		if ($field_count == 2) { 
        	if ($field['id'] != 'contact_phone' && $field['id'] != 'address_country' && $field['id'] != 'luser_pass_check') { ?>
			</div>
			<div class="row">
      <?php } else { ?>
         	   </div>
      <?php } ?>      
	  <?php 
			$field_count = 1;
			continue;				   
		}
		$field_count++;
	} ?>
		
      </section>  
<?php
}


function render_field( $field, $classes, $user_id, $no_label = false ) {
		
	?>
	
	<div class="user-field<?php echo esc_attr( $classes ); ?>" id="cq-profile-field-<?php echo esc_attr( $field[ 'id' ] ); ?>">
				
		<?php
			
			/* get the reserved meta ids */
			$reserved_ids = apply_filters(
				'cq_reserved_ids',
				array(
					'user_login',
					'user_email',
					'user_url'
				)
			);
    
            $user_id = $user_id == '' ? get_current_user_id() : $user_id;
    
            $required = isset($field['required']) && $field['required'] != '' ? $field['required'] : '';
			
			/* if the current field id is in the reserved list */
			if( in_array( $field[ 'id' ], $reserved_ids ) ) {
				
				$field_name = $field[ 'id' ];
				
				$userdata = get_userdata( $user_id );
				
				//print_r($userdata);
				
				$current_field_value = $userdata->$field_name;
			
			/* not a reserved id - treat normally */
			} else {
				
				/* get the current value */
				$current_field_value = get_user_meta( $user_id, $field[ 'id' ], true );
				
			}
			
			/* output the input label */
            if (!$no_label) {
			?>
			<label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'label' ] ); ?></label>
			<?php
            }
								
			/* being a switch statement to alter the output depending on type */
			switch( $field[ 'type' ] ) {
				
				/* if this is a wysiwyg setting */
				case 'wysiwyg':
						
					/* set some settings args for the editor */
			    	$editor_settings = array(
			    		'textarea_rows' => apply_filters( 'wpfep_wysiwyg_textarea_rows', '5', $field[ 'id' ] ),
			    		'media_buttons' => apply_filters( 'wpfep_wysiwyg_media_buttons', false, $field[ 'id' ] ),
			    	);
			    	
			    	/* buld field name */
			    	$wysiwyg_name = $tab_id . '[' . $field[ 'id' ] . ']';
			    						    	
			    	/* display the wysiwyg editor */
					?>
					<label for="<?php echo $field[ 'id' ]; ?>]"><?php echo esc_html($field[ 'label' ]); ?></label>
		
					<?php
			    	wp_editor(
			    		$current_field_value, // default content
			    		$wysiwyg_name, // id to give the editor element
			    		$editor_settings // edit settings from above
			    	);
				
					break;
				
				/* if this should be rendered as a select input */
				case 'select':
											
					?>
			    	<select name="<?php echo $field[ 'id' ]; ?>" id="<?php echo $field[ 'id' ]; ?>" <?php echo $required; ?>>
			    	
			    	<?php
			    	/* get the setting options */
			    	$options = $field[ 'options' ];
			    	
			        /* loop through each option */
			        foreach( $options as $option ) {
				        ?>
						<option value="<?php echo esc_attr( $option[ 'value' ] ); ?>" <?php selected( $current_field_value, $option[ 'value' ] ); ?>><?php echo esc_html( $option[ 'name' ] ); ?></option>
						<?php
			        }
			        ?>
			    	</select>
			        <?php
					
					break;
				
				/* if the type is set to a textarea input */  
			    case 'textarea':
			    	
			    	?>
					<textarea name="<?php echo esc_attr( $tab_id ); ?>[<?php echo $field[ 'id' ]; ?>]" rows="<?php echo apply_filters( 'wpfep_textarea_rows', '5', $field[ 'id' ] ); ?>" cols="50" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text" <?php echo $required; ?>><?php echo esc_textarea( $current_field_value ); ?></textarea>
			        
			        <?php
				        
			        /* break out of the switch statement */
			        break;
				
				/* if the type is set to a textarea input */  
			    case 'checkbox':
			    
			    	?>
					<input type="checkbox" name="<?php echo esc_attr( $tab_id ); ?>[<?php echo $field[ 'id' ]; ?>]" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" value="1" <?php checked( $current_field_value, '1' ); ?> <?php echo $required; ?> />
					<?php
			    	
			    	/* break out of the switch statement */
			        break;
				
				case 'nonce':
			    
			    	
					wp_nonce_field('cq_profile_update_', 'cq_user_profile_nonce');
					
			    	
			    	/* break out of the switch statement */
			        break;
			       
			    /* if the type is set to a textarea input */  
			    case 'email':
			    
			    	?>
					<input type="email" name="<?php echo $field[ 'id' ]; ?>" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text" value="<?php echo esc_attr( $current_field_value ); ?>" <?php echo $required; ?> />

					<?php
			    	
			    	/* break out of the switch statement */
			        break;
                    
                case 'tel':
			    
			    	?>
					<input type="tel" name="<?php echo $field[ 'id' ]; ?>" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text" value="<?php echo esc_attr( $current_field_value ); ?>" <?php echo $required; ?> />

					<?php
			    	
			    	/* break out of the switch statement */
			        break;
                    
                case 'file_image':
                    
                    $logo_id = get_user_meta( $user_id, 'business_logo', true );
                    if (is_numeric($logo_id)) {
                        $logo_attributes = wp_get_attachment_image_src( $logo_id );
                        $logo_src = $logo_attributes[0];
                    } else {
                        $logo_src = plugins_url( 'cq-auctions/img/no-image.jpg' );
                    }
			    
			    	?>
					<input type="file" name="<?php echo $field[ 'id' ]; ?>" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text"  /><button id="logo-upload" class="btn btn-primary" data-nonce="<?php echo wp_create_nonce( 'ajax-logo-upload-nonce' ); ?>">Add Logo</button>
                    <div class="logo-thumbnail"><img src="<?php echo $logo_src; ?>" id="logo-img"></div>
					<?php
			    	
			    	/* break out of the switch statement */
			        break;
                    
                
			       
			    /* if the type is set to a textarea input */  
			    case 'password':
			    
			    	?>
					<input type="password" name="<?php echo $field[ 'id' ]; ?>" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text" autocomplete="new-password" value="" placeholder="New Password" />
					
					<input type="password" name="<?php echo $field[ 'id' ]; ?>_check" id="<?php echo esc_attr( $field[ 'id' ] ); ?>_check" class="regular-text" autocomplete="new-password" value="" placeholder="Repeat New Password" />

					<?php
			    	
			    	/* break out of the switch statement */
			        break;
                    
                /* if the type is set to a stripe connect input */  
			    case 'stripe_connect':
			         $account_link = new CQStripeAccount();
                     $setup_url = $account_link->create_stripe_account();
			    	?>
					<a href="<?php echo $setup_url->url; ?>" class="stripe-connect slate"><span>Connect with</span></a>

					<?php
			    	
			    	/* break out of the switch statement */
			        break;
				
				/* any other type of input - treat as text input */ 
				default:
					$disabled = '';
					if ($field[ 'id' ] == 'user_login') {
						$disabled = 'disabled';
					}
				
					?>
					<input type="text" name="<?php echo $field[ 'id' ]; ?>" id="<?php echo esc_attr( $field[ 'id' ] ); ?>" class="regular-text" value="<?php echo esc_attr( $current_field_value ); ?>" <?php echo $disabled; ?> <?php echo $required; ?> />
					<?php	
				
			}
			
			/* if we have a description lets output it */
			if( $field[ 'desc' ] ) {
				
				?>
				<p class="description"><?php echo esc_html( $field[ 'desc' ] ); ?></p>
				<?php
				
			} // end if have description
		
		?>
		
	</div>
	
	<?php
	
}

function save_fields() {
	
	$user_id = get_current_user_id();
	
	/* check the nonce */
	if( (!isset( $_POST[ 'cq_user_profile_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'cq_user_profile_nonce' ], 'cq_profile_update_' )) && (!isset( $_POST[ 'checkout_security' ] ) || ! wp_verify_nonce( $_POST[ 'checkout_security' ], 'ajax-buy-nonce' )))
		return;
	
	/* set an array to store messages in */
	$messages = array();
	
	/* get the POST data */
	$post_data = $_POST;
	
	/**
	 * remove the following array elements from the data
	 * password
	 * nonce name
	 * wp refere - sent with nonce
	 */
	unset( $post_data[ 'password' ] );
	unset( $post_data[ 'user_login' ] );
	unset( $post_data[ 'cq_user_profile_nonce' ] );
	unset( $post_data[ '_wp_http_referer' ] );
    unset( $post_data[ 'business_logo' ] );
    unset( $post_data[ 'auction_id' ] );
	unset( $post_data[ 'total_price' ] );
    unset( $post_data[ 'checkout_security' ] );
    
	/* lets check we have some data to save */
	if( empty( $post_data ) )
		return;
		
	/**
	 * setup an array of reserved meta keys
	 * to process in a different way
	 * they are not meta data in wordpress
	 * reserved names are user_url and user_email as they are stored in the users table not user meta
	 */
	$reserved_ids = apply_filters(
		'cq_reserved_ids',
		array(
			'user_login',
			'user_email'
		)
	);

	/**
	 * set an array of registered fields
	 */
	$registered_fields = cq_user_profile_fields();
	//}

	/* set an array of registered keys */
	$registered_keys = wp_list_pluck( $registered_fields, 'id' );
		
		/**
		 * loop through this tabs array
		 * the ket here is the meta key to save to
		 * the value is the value we want to actually save
		 */
		foreach( $post_data as $key => $value ) {
			
			/* if the key is the save sumbit - move to next in array */
			if( $key == 'cq_save_profile' || $key == 'wpfep_nonce_action' )
				continue;

			/* if the key is not in our list of registered keys - move to next in array */
			if ( !in_array( $key, $registered_keys ) )
				continue;

			/* check whether the key is reserved - handled with wp_update_user */
			if( in_array( $key, $reserved_ids ) ) {
				
				$result = wp_update_user(
					array(
						'ID' => $user_id,
						$key => $value
					)
				);
				
				/* check for errors */
				if ( is_wp_error( $result ) ) {
					
					/* update failed */
					$messages[ 'update_failed' ] = '<p class="error">' . $result->get_error_message() . '</p>';
				
				}
			
			/* just standard user meta - handle with update_user_meta */
			} else {

				/* lookup field options by key */
				$registered_field_key = array_search( $key, array_column( $registered_fields, 'id' ) );

				/* sanitize user input based on field type */
				switch ( $registered_fields[$registered_field_key]['type'] ) {
					case 'wysiwyg':
						$value = wp_filter_post_kses( $value );
						break;
					case 'select':
						$value = sanitize_text_field( $value );
						break;
					case 'textarea':
						$value = wp_filter_nohtml_kses( $value );
						break;
					case 'checkbox':
						$value = isset( $value ) && '1' === $value ? true : false;
						break;
					case 'email':
						$value = sanitize_email( $value );
						break;
					default:
						$value = sanitize_text_field( $value );
				}

				/* update the user meta data */
				
				$meta = update_user_meta( $user_id, $key, $value );
				
				/* check the update was succesfull */
				if ( $value != get_user_meta( $user_id, $key, true ) ) {
					
					/* update failed */
					$messages[ 'update_failed' ] = '<p class="error">There was a problem with updating your profile.</p>';
					
				}
				
			}
			
		} // end tab loop
	
	if (isset($_POST['user_pass']) && $_POST['user_pass'] != '' ) {
		
		$messages =  array_merge($messages, cq_profile_save_password( $user_id ));
		
	}
	
	/* check if we have an messages to output */
	if( !empty( $messages ) ) {
		
		?>
		<div class="messages alert alert-danger">
		<?php
		
		/* lets loop through the messages stored */
		foreach( $messages as $message ) {
			
			/* output the message */
			$GLOBALS['auction_messages'][] = $message;
			//echo $message;
			
		}
		
		?>
		</div><!-- // messages -->
		<?php
		
	} else {
		
		$GLOBALS['auction_messages'][] = 'Your profile was updated successfully!';
		
	}
	
}
add_action( 'wp_loaded', 'save_fields', 5, 2 );

function cq_display_messages() {
	
	global $auction_messages;
	
	if (is_array($auction_messages)):
		foreach( $auction_messages as $message ) {
			echo '<div class="messages alert alert-success"><p class="updated">' . $message . '</p></div>';
		}
	endif;
}
add_action( 'cq_show_messages', 'cq_display_messages', 10, 2 );

function cq_profile_save_button() {
	
	?>
	<section class="submit-section">
		<div class="cq-save row">
			<div class="col-md-12">
				<label class="wpfep_save_description">Save your updates.</label>
				<input type="submit" class="button button-brand button-fill submit_button" name="cq_save_profile" value="Update" >
			</div>
		</div>
    </section>    
	
	<?php
	
}
add_action( 'cq_after_profile_fields', 'cq_profile_save_button', 10, 2 );


function cq_profile_save_password( $user_id ) {
	
	/* set an array to store messages in */
	$messages = array();
	
	if( !isset( $_POST[ 'cq_user_profile_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'cq_user_profile_nonce' ], 'cq_profile_update_' ) )
		return;
	
	/* get the posted data from the password tab */
	$data = $_POST;
	
	/* store both password for ease of access */
	$password = $data[ 'user_pass' ];
	$password_check = $data[ 'user_pass_check' ];
	
	/* first lets check we have a password added to save */
	if( empty( $password ) )
		return;
	
	/* now lets check the password match */
	if( $password != $password_check ) {
		
		/* add message indicating no match */
		$messages[ 'password_mismatch' ] = '<p class="error">Please make sure the passwords match.</p>';
		
	}
	
	/* get the length of the password entered */
	$pass_length = strlen( $password );
	
	/* check the password match the correct length */
	if( $pass_length < apply_filters( 'cq_password_length', 8 ) ) {
		
		/* add message indicating length issue!! */
		$messages[ 'password_length' ] = '<p class="error">Please make sure your password is a minimum of ' . apply_filters( 'cq_password_length', 8 ) . ' characters long.</p>';
		
	}
	
	/**
	 * match the password against a regex of complexity
	 * at least 1 upper, 1 lower case letter and 1 number
	 */
	$pass_complexity = preg_match( apply_filters( 'cq_password_regex', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d,.;:]).+$/' ), $password );
	
	/* check whether the password passed the regex check of complexity */
	if( $pass_complexity == false ) {
		
		/* add message indicating complexity issue */
		$messages[ 'password_complexity' ] = '<p class="error">Your password must contain at least 1 uppercase, 1 lowercase letter and at least 1 number</p>';
		
	}
	
	/* check we have any messages in the messages array - if we have password failed at some point */
	if( empty( $messages ) ) {
		
		/**
		 * ok if we get this far we have passed all the checks above
		 * the password can now be updated and redirect the user to the login page
		 */
		
		wp_set_password( $password, $user_id );
		wp_redirect( home_url() .'?logged_out=true&password_changed=true' );
	
	/* messages not empty therefore password failed */
	} else {
		
		return $messages;
		
	}
	
}

function get_country_list() {
	
	$countries = array(
					array( 'value' => 'GB', 'name' => 'United Kingdom'),
                    array( 'value' => 'US', 'name' => 'United States'),
                    array( 'value' => 'CA', 'name' => 'Canada'),
                    array( 'value' => 'AU', 'name' => 'Australia'),
                    array( 'value' => 'FR', 'name' => 'France'),
                    array( 'value' => 'DE', 'name' => 'Germany'),
                    array( 'value' => 'IS', 'name' => 'Iceland'),
                    array( 'value' => 'IE', 'name' => 'Ireland'),
                    array( 'value' => 'IT', 'name' => 'Italy'),
                    array( 'value' => 'ES', 'name' => 'Spain'),
                    array( 'value' => 'SE', 'name' => 'Sweden'),
                    array( 'value' => 'AT', 'name' => 'Austria'),
                    array( 'value' => 'BE', 'name' => 'Belgium'),
                    array( 'value' => 'FI', 'name' => 'Finland'),
                    array( 'value' => 'CZ', 'name' => 'Czech Republic'),
                    array( 'value' => 'DK', 'name' => 'Denmark'),
                    array( 'value' => 'NO', 'name' => 'Norway'),
                    array( 'value' => 'CH', 'name' => 'Switzerland'),
                    array( 'value' => 'NZ', 'name' => 'New Zealand'),
                    array( 'value' => 'RU', 'name' => 'Russian Federation'),
                    array( 'value' => 'PT', 'name' => 'Portugal'),
                    array( 'value' => 'NL', 'name' => 'Netherlands'),
                    array( 'value' => 'IM', 'name' => 'Isle of Man'),
                    array( 'value' => 'AF', 'name' => 'Afghanistan'),
                    array( 'value' => 'AX', 'name' => 'Aland Islands '),
                    array( 'value' => 'AL', 'name' => 'Albania'),
                    array( 'value' => 'DZ', 'name' => 'Algeria'),
                    array( 'value' => 'AS', 'name' => 'American Samoa'),
                    array( 'value' => 'AD', 'name' => 'Andorra'),
                    array( 'value' => 'AO', 'name' => 'Angola'),
                    array( 'value' => 'AI', 'name' => 'Anguilla'),
                    array( 'value' => 'AQ', 'name' => 'Antarctica'),
                    array( 'value' => 'AG', 'name' => 'Antigua and Barbuda'),
                    array( 'value' => 'AR', 'name' => 'Argentina'),
                    array( 'value' => 'AM', 'name' => 'Armenia'),
                    array( 'value' => 'AW', 'name' => 'Aruba'),
                    array( 'value' => 'AZ', 'name' => 'Azerbaijan'),
                    array( 'value' => 'BS', 'name' => 'Bahamas'),
                    array( 'value' => 'BH', 'name' => 'Bahrain'),
                    array( 'value' => 'BD', 'name' => 'Bangladesh'),
                    array( 'value' => 'BB', 'name' => 'Barbados'),
                    array( 'value' => 'BY', 'name' => 'Belarus'),
                    array( 'value' => 'BZ', 'name' => 'Belize'),
                    array( 'value' => 'BJ', 'name' => 'Benin'),
                    array( 'value' => 'BM', 'name' => 'Bermuda'),
                    array( 'value' => 'BT', 'name' => 'Bhutan'),
                    array( 'value' => 'BO', 'name' => 'Bolivia, Plurinational State of'),
                    array( 'value' => 'BQ', 'name' => 'Bonaire, Sint Eustatius and Saba'),
                    array( 'value' => 'BA', 'name' => 'Bosnia and Herzegovina'),
                    array( 'value' => 'BW', 'name' => 'Botswana'),
                    array( 'value' => 'BV', 'name' => 'Bouvet Island'),
                    array( 'value' => 'BR', 'name' => 'Brazil'),
                    array( 'value' => 'IO', 'name' => 'British Indian Ocean Territory'),
                    array( 'value' => 'BN', 'name' => 'Brunei Darussalam'),
                    array( 'value' => 'BG', 'name' => 'Bulgaria'),
                    array( 'value' => 'BF', 'name' => 'Burkina Faso'),
                    array( 'value' => 'BI', 'name' => 'Burundi'),
                    array( 'value' => 'KH', 'name' => 'Cambodia'),
                    array( 'value' => 'CM', 'name' => 'Cameroon'),
                    array( 'value' => 'CV', 'name' => 'Cape Verde'),
                    array( 'value' => 'KY', 'name' => 'Cayman Islands'),
                    array( 'value' => 'CF', 'name' => 'Central African Republic'),
                    array( 'value' => 'TD', 'name' => 'Chad'),
                    array( 'value' => 'CL', 'name' => 'Chile'),
                    array( 'value' => 'CN', 'name' => 'China'),
                    array( 'value' => 'CX', 'name' => 'Christmas Island'),
                    array( 'value' => 'CC', 'name' => 'Cocos (Keeling) Islands'),
                    array( 'value' => 'CO', 'name' => 'Colombia'),
                    array( 'value' => 'KM', 'name' => 'Comoros'),
                    array( 'value' => 'CG', 'name' => 'Congo'),
                    array( 'value' => 'CD', 'name' => 'Congo, the Democratic Republic of the'),
                    array( 'value' => 'CK', 'name' => 'Cook Islands'),
                    array( 'value' => 'CR', 'name' => 'Costa Rica'),
                    array( 'value' => 'CI', 'name' => 'Cote d\'Ivoire'),
                    array( 'value' => 'HR', 'name' => 'Croatia'),
                    array( 'value' => 'CU', 'name' => 'Cuba'),
                    array( 'value' => 'CW', 'name' => 'Curaçao'),
                    array( 'value' => 'CY', 'name' => 'Cyprus'),
                    array( 'value' => 'DJ', 'name' => 'Djibouti'),
                    array( 'value' => 'DM', 'name' => 'Dominica'),
                    array( 'value' => 'DO', 'name' => 'Dominican Republic'),
                    array( 'value' => 'EC', 'name' => 'Ecuador'),
                    array( 'value' => 'EG', 'name' => 'Egypt'),
                    array( 'value' => 'SV', 'name' => 'El Salvador'),
                    array( 'value' => 'GQ', 'name' => 'Equatorial Guinea'),
                    array( 'value' => 'ER', 'name' => 'Eritrea'),
                    array( 'value' => 'EE', 'name' => 'Estonia'),
                    array( 'value' => 'ET', 'name' => 'Ethiopia'),
                    array( 'value' => 'FK', 'name' => 'Falkland Islands (Malvinas)'),
                    array( 'value' => 'FO', 'name' => 'Faroe Islands'),
                    array( 'value' => 'FJ', 'name' => 'Fiji'),
                    array( 'value' => 'GF', 'name' => 'French Guiana'),
                    array( 'value' => 'PF', 'name' => 'French Polynesia'),
                    array( 'value' => 'TF', 'name' => 'French Southern Territories'),
                    array( 'value' => 'GA', 'name' => 'Gabon'),
                    array( 'value' => 'GM', 'name' => 'Gambia'),
                    array( 'value' => 'GE', 'name' => 'Georgia'),
                    array( 'value' => 'GH', 'name' => 'Ghana'),
                    array( 'value' => 'GI', 'name' => 'Gibraltar'),
                    array( 'value' => 'GR', 'name' => 'Greece'),
                    array( 'value' => 'GL', 'name' => 'Greenland'),
                    array( 'value' => 'GD', 'name' => 'Grenada'),
                    array( 'value' => 'GP', 'name' => 'Guadeloupe'),
                    array( 'value' => 'GU', 'name' => 'Guam'),
                    array( 'value' => 'GT', 'name' => 'Guatemala'),
                    array( 'value' => 'GG', 'name' => 'Guernsey'),
                    array( 'value' => 'GN', 'name' => 'Guinea'),
                    array( 'value' => 'GW', 'name' => 'Guinea-Bissau'),
                    array( 'value' => 'GY', 'name' => 'Guyana'),
                    array( 'value' => 'HT', 'name' => 'Haiti'),
                    array( 'value' => 'HM', 'name' => 'Heard Island and McDonald Islands'),
                    array( 'value' => 'VA', 'name' => 'Holy See (Vatican City State)'),
                    array( 'value' => 'HN', 'name' => 'Honduras'),
                    array( 'value' => 'HK', 'name' => 'Hong Kong'),
                    array( 'value' => 'HU', 'name' => 'Hungary'),
                    array( 'value' => 'IN', 'name' => 'India'),
                    array( 'value' => 'ID', 'name' => 'Indonesia'),
                    array( 'value' => 'IR', 'name' => 'Iran, Islamic Republic of'),
                    array( 'value' => 'IQ', 'name' => 'Iraq'),
                    array( 'value' => 'IL', 'name' => 'Israel'),
                    array( 'value' => 'JM', 'name' => 'Jamaica'),
                    array( 'value' => 'JP', 'name' => 'Japan'),
                    array( 'value' => 'JE', 'name' => 'Jersey'),
                    array( 'value' => 'JO', 'name' => 'Jordan'),
                    array( 'value' => 'KZ', 'name' => 'Kazakhstan'),
                    array( 'value' => 'KE', 'name' => 'Kenya'),
                    array( 'value' => 'KI', 'name' => 'Kiribati'),
                    array( 'value' => 'KP', 'name' => 'Korea, Democratic People\'s Republic of'),
                    array( 'value' => 'KR', 'name' => 'Korea, Republic of'),
                    array( 'value' => 'KW', 'name' => 'Kuwait'),
                    array( 'value' => 'KG', 'name' => 'Kyrgyzstan'),
                    array( 'value' => 'LA', 'name' => 'Lao People\'s Democratic Republic'),
                    array( 'value' => 'LV', 'name' => 'Latvia'),
                    array( 'value' => 'LB', 'name' => 'Lebanon'),
                    array( 'value' => 'LS', 'name' => 'Lesotho'),
                    array( 'value' => 'LR', 'name' => 'Liberia'),
                    array( 'value' => 'LY', 'name' => 'Libyan Arab Jamahiriya'),
                    array( 'value' => 'LI', 'name' => 'Liechtenstein'),
                    array( 'value' => 'LT', 'name' => 'Lithuania'),
                    array( 'value' => 'LU', 'name' => 'Luxembourg'),
                    array( 'value' => 'MO', 'name' => 'Macao'),
                    array( 'value' => 'MK', 'name' => 'Macedonia'),
                    array( 'value' => 'MG', 'name' => 'Madagascar'),
                    array( 'value' => 'MW', 'name' => 'Malawi'),
                    array( 'value' => 'MY', 'name' => 'Malaysia'),
                    array( 'value' => 'MV', 'name' => 'Maldives'),
                    array( 'value' => 'ML', 'name' => 'Mali'),
                    array( 'value' => 'MT', 'name' => 'Malta'),
                    array( 'value' => 'MH', 'name' => 'Marshall Islands'),
                    array( 'value' => 'MQ', 'name' => 'Martinique'),
                    array( 'value' => 'MR', 'name' => 'Mauritania'),
                    array( 'value' => 'MU', 'name' => 'Mauritius'),
                    array( 'value' => 'YT', 'name' => 'Mayotte'),
                    array( 'value' => 'MX', 'name' => 'Mexico'),
                    array( 'value' => 'FM', 'name' => 'Micronesia, Federated States of'),
                    array( 'value' => 'MD', 'name' => 'Moldova, Republic of'),
                    array( 'value' => 'MC', 'name' => 'Monaco'),
                    array( 'value' => 'MN', 'name' => 'Mongolia'),
                    array( 'value' => 'ME', 'name' => 'Montenegro'),
                    array( 'value' => 'MS', 'name' => 'Montserrat'),
                    array( 'value' => 'MA', 'name' => 'Morocco'),
                    array( 'value' => 'MZ', 'name' => 'Mozambique'),
                    array( 'value' => 'MM', 'name' => 'Myanmar'),
                    array( 'value' => 'NA', 'name' => 'Namibia'),
                    array( 'value' => 'NR', 'name' => 'Nauru'),
                    array( 'value' => 'NP', 'name' => 'Nepal'),
                    array( 'value' => 'NC', 'name' => 'New Caledonia'),
                    array( 'value' => 'NI', 'name' => 'Nicaragua'),
                    array( 'value' => 'NE', 'name' => 'Niger'),
                    array( 'value' => 'NG', 'name' => 'Nigeria'),
                    array( 'value' => 'NU', 'name' => 'Niue'),
                    array( 'value' => 'NF', 'name' => 'Norfolk Island'),
                    array( 'value' => 'MP', 'name' => 'Northern Mariana Islands'),
                    array( 'value' => 'OM', 'name' => 'Oman'),
                    array( 'value' => 'PK', 'name' => 'Pakistan'),
                    array( 'value' => 'PW', 'name' => 'Palau'),
                    array( 'value' => 'PS', 'name' => 'Palestinian Territory, Occupied'),
                    array( 'value' => 'PA', 'name' => 'Panama'),
                    array( 'value' => 'PG', 'name' => 'Papua New Guinea'),
                    array( 'value' => 'PY', 'name' => 'Paraguay'),
                    array( 'value' => 'PE', 'name' => 'Peru'),
                    array( 'value' => 'PH', 'name' => 'Philippines'),
                    array( 'value' => 'PN', 'name' => 'Pitcairn'),
                    array( 'value' => 'PL', 'name' => 'Poland'),
                    array( 'value' => 'PR', 'name' => 'Puerto Rico'),
                    array( 'value' => 'QA', 'name' => 'Qatar'),
                    array( 'value' => 'RE', 'name' => 'Reunion'),
                    array( 'value' => 'RO', 'name' => 'Romania'),
                    array( 'value' => 'RW', 'name' => 'Rwanda'),
                    array( 'value' => 'BL', 'name' => 'Saint Barthélemy'),
                    array( 'value' => 'SH', 'name' => 'Saint Helena'),
                    array( 'value' => 'KN', 'name' => 'Saint Kitts and Nevis'),
                    array( 'value' => 'LC', 'name' => 'Saint Lucia'),
                    array( 'value' => 'MF', 'name' => 'Saint Martin (French part)'),
                    array( 'value' => 'PM', 'name' => 'Saint Pierre and Miquelon'),
                    array( 'value' => 'VC', 'name' => 'Saint Vincent and the Grenadines'),
                    array( 'value' => 'WS', 'name' => 'Samoa'),
                    array( 'value' => 'SM', 'name' => 'San Marino'),
                    array( 'value' => 'ST', 'name' => 'Sao Tome and Principe'),
                    array( 'value' => 'SA', 'name' => 'Saudi Arabia'),
                    array( 'value' => 'SN', 'name' => 'Senegal'),
                    array( 'value' => 'RS', 'name' => 'Serbia'),
                    array( 'value' => 'SC', 'name' => 'Seychelles'),
                    array( 'value' => 'SL', 'name' => 'Sierra Leone'),
                    array( 'value' => 'SG', 'name' => 'Singapore'),
                    array( 'value' => 'SX', 'name' => 'Sint Maarten (Dutch part)'),
                    array( 'value' => 'SK', 'name' => 'Slovakia'),
                    array( 'value' => 'SI', 'name' => 'Slovenia'),
                    array( 'value' => 'SB', 'name' => 'Solomon Islands'),
                    array( 'value' => 'SO', 'name' => 'Somalia'),
                    array( 'value' => 'ZA', 'name' => 'South Africa'),
                    array( 'value' => 'GS', 'name' => 'South Georgia and the South Sandwich Islands'),
                    array( 'value' => 'LK', 'name' => 'Sri Lanka'),
                    array( 'value' => 'SD', 'name' => 'Sudan'),
                    array( 'value' => 'SR', 'name' => 'Suriname'),
                    array( 'value' => 'SJ', 'name' => 'Svalbard and Jan Mayen'),
                    array( 'value' => 'SZ', 'name' => 'Swaziland'),
                    array( 'value' => 'SY', 'name' => 'Syrian Arab Republic'),
                    array( 'value' => 'TW', 'name' => 'Taiwan, Province of China'),
                    array( 'value' => 'TJ', 'name' => 'Tajikistan'),
                    array( 'value' => 'TZ', 'name' => 'Tanzania, United Republic of'),
                    array( 'value' => 'TH', 'name' => 'Thailand'),
                    array( 'value' => 'TL', 'name' => 'Timor-Leste'),
                    array( 'value' => 'TG', 'name' => 'Togo'),
                    array( 'value' => 'TK', 'name' => 'Tokelau'),
                    array( 'value' => 'TO', 'name' => 'Tonga'),
                    array( 'value' => 'TT', 'name' => 'Trinidad and Tobago'),
                    array( 'value' => 'TN', 'name' => 'Tunisia'),
                    array( 'value' => 'TR', 'name' => 'Turkey'),
                    array( 'value' => 'TM', 'name' => 'Turkmenistan'),
                    array( 'value' => 'TC', 'name' => 'Turks and Caicos Islands'),
                    array( 'value' => 'TV', 'name' => 'Tuvalu'),
                    array( 'value' => 'UG', 'name' => 'Uganda'),
                    array( 'value' => 'UA', 'name' => 'Ukraine'),
                    array( 'value' => 'AE', 'name' => 'United Arab Emirates'),
                    array( 'value' => 'UM', 'name' => 'United States Minor Outlying Islands'),
                    array( 'value' => 'UY', 'name' => 'Uruguay'),
                    array( 'value' => 'UZ', 'name' => 'Uzbekistan'),
                    array( 'value' => 'VU', 'name' => 'Vanuatu'),
                    array( 'value' => 'VE', 'name' => 'Venezuela, Bolivarian Republic of'),
                    array( 'value' => 'VN', 'name' => 'Viet Nam'),
                    array( 'value' => 'VG', 'name' => 'Virgin Islands, British'),
                    array( 'value' => 'VI', 'name' => 'Virgin Islands, U.S.'),
                    array( 'value' => 'WF', 'name' => 'Wallis and Futuna'),
                    array( 'value' => 'EH', 'name' => 'Western Sahara'),
                    array( 'value' => 'YE', 'name' => 'Yemen'),
                    array( 'value' => 'ZM', 'name' => 'Zambia'),
                    array( 'value' => 'ZW', 'name' => 'Zimbabwe')
    );
	
	return $countries;
	
}

function handle_file_upload(){
    
    if ( !is_admin() ) {
        check_ajax_referer('ajax-img-upload-nonce', 'security');
    }
    
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    } else {
        $user_id = get_current_user_id();
    }

    if(!(is_array($_POST) && is_array($_FILES) && defined('DOING_AJAX') && DOING_AJAX)){
        return;
    }

    if(!function_exists('wp_handle_upload')){
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $response = array();
    
    // We are only allowing images
    $allowedMimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
    );
 
    $fileInfo = wp_check_filetype(basename($_FILES['file']['name']), $allowedMimes);
    
    if (!empty($fileInfo['type'])) {
        $uploadedfile = $_FILES['file'];
        $upload_overrides = array('test_form' => false, 'mimes' => $allowedMimes);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        // echo $movefile['url'];
        if ($movefile && !isset($movefile['error'])) {
            $attachment_id = insert_logo($movefile['file'], $user_id);
            $response['url'] = $movefile['url'];
            
            $image_src = wp_get_attachment_image_src($attachment_id);
            
            $response['thumbnail_src'] = $image_src[0];
            $response['image_id'] = $attachment_id;
            $response['message'] = 'success';
        } else {
            /**
             * Error generated by _wp_handle_upload()
             * @see _wp_handle_upload() in wp-admin/includes/file.php
             */
            $response['message'] = 'Error - Filetype not allowed.';
        }
    } else {
        $response['message'] = 'Error - The filetype seems to be incorrect';
    }
    

    echo json_encode($response);
    die();
}
add_action('wp_ajax_business_logo_upload', 'handle_file_upload');

function insert_logo($path, $user_id, $add_as_logo = true, $meta_key = 'business_logo') {
    
    // $filename should be the path to a file in the upload directory.
    $filename = $path;

 
    // Check the type of file. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype( basename( $filename ), null );
 
// Get the path to the upload directory.
    $wp_upload_dir = wp_upload_dir();
 
// Prepare an array of post data for the attachment.
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
 
    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $filename);
 
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
 
    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    
    if ($add_as_logo) {
        update_user_meta($user_id, $meta_key, $attach_id);
    }
    
    return $attach_id;
     
}

add_action( 'edit_user_profile', 'cq_custom_user_profile_fields' );
add_action( 'show_user_profile', 'cq_custom_user_profile_fields' );
function cq_custom_user_profile_fields( $user ) {
    
    $enable_logo_upload = esc_attr( get_user_meta( $user->ID, 'enable_logo_upload', true ) );
    
    $logo_enabled_checked = $enable_logo_upload == '1' ? ' checked="checked"' : '';
    
    $enable_store = esc_attr( get_user_meta( $user->ID, 'enable_store', true ) );
    
    $store_enabled_checked = $enable_store == '1' ? ' checked="checked"' : '';
    
    $logo_id = get_user_meta( $user->ID, 'business_logo', true );
    
    $logo_attachment = wp_get_attachment_image_src( $logo_id, 'thumbnail', false );
    
    $logo_src = is_numeric($logo_id) ? $logo_attachment[0] : 'https://via.placeholder.com/150x150.png?text=No+Logo';
    
    $country_field = array('type' => 'select',
					       'id' => 'address_country',
					       'label' => 'Country',
					       'options' => get_country_list(),
					       'class' => 'billing_country',
					       'desc' => '');
    
    echo '<div id="seller-fields-section">
            <h3 class="heading">Business Fields</h3>';
    
    ?>
    <table class="form-table">
	    <tr>
            <th><label for="business_name">Business Name</label></th>
	        <td><input type="text" class="input-text form-control" name="business_name" id="business_name" value="<?php echo esc_attr( get_user_meta( $user->ID, 'business_name', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="business_website">Business Website</label></th>
	        <td><input type="text" class="input-text form-control" name="business_website" id="business_website" value="<?php echo esc_attr( get_user_meta( $user->ID, 'business_website', true ) ); ?>" /></td>
	    </tr>
    </table>
    </div>
            
    <?php echo '<div id="address-fields-section">
            <h3 class="heading">Contact Details</h3>';
    
    ?>
    <table class="form-table">
	    <tr>
            <th><label for="business_name">Address Line 1</label></th>
	        <td><input type="text" class="input-text form-control" name="address_line_1" id="address_line_1" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address_line_1', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="trustpilot_id">Address Line 2</label></th>
	        <td><input type="text" class="input-text form-control" name="address_line_2" id="address_line_2" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address_line_2', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="customer_service_email">Town</label></th>
	        <td><input type="text" class="input-text form-control" name="address_town" id="address_town" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address_town', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="customer_service_phone">County</label></th>
	        <td><input type="text" class="input-text form-control" name="address_county" id="address_county" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address_county', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="business_website">Post Code</label></th>
	        <td><input type="text" class="input-text form-control" name="address_postcode" id="address_postcode" value="<?php echo esc_attr( get_user_meta( $user->ID, 'address_postcode', true ) ); ?>" /></td>
	    </tr>
        <tr>
            <th><label for="address_country">Country</label></th>
	        <td><?php render_field($country_field, '', $user->ID, true); ?></td>
	    </tr>
        <tr>
            <th><label for="contact_phone">Telephone</label></th>
	        <td><input type="tel" class="input-text form-control" name="contact_phone" id="contact_phone" value="<?php echo esc_attr( get_user_meta( $user->ID, 'contact_phone', true ) ); ?>" /></td>
	    </tr>
    </table>
    </div>
    <?php
}

add_action('personal_options_update', 'cq_update_user_profile_fields');
add_action('edit_user_profile_update', 'cq_update_user_profile_fields');
add_action('user_register', 'cq_update_user_profile_fields');
function cq_update_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }
    
    $business_name = isset($_REQUEST['business_name']) && $_REQUEST['business_name'] != '' ? sanitize_text_field($_REQUEST['business_name']) : '';
    $business_website = isset($_REQUEST['business_website']) && $_REQUEST['business_website'] != '' ? sanitize_text_field($_REQUEST['business_website']) : '';
    $address_line_1 = isset($_REQUEST['address_line_1']) && $_REQUEST['address_line_1'] != '' ? sanitize_text_field($_REQUEST['address_line_1']) : '';
    $address_line_2 = isset($_REQUEST['address_line_2']) && $_REQUEST['address_line_2'] != '' ? sanitize_text_field($_REQUEST['address_line_2']) : '';
    $address_town = isset($_REQUEST['address_town']) && $_REQUEST['address_town'] != '' ? sanitize_text_field($_REQUEST['address_town']) : '';
    $address_county = isset($_REQUEST['address_county']) && $_REQUEST['address_county'] != '' ? sanitize_text_field($_REQUEST['address_county']) : '';
    $address_postcode = isset($_REQUEST['address_postcode']) && $_REQUEST['address_postcode'] != '' ? sanitize_text_field($_REQUEST['address_postcode']) : '';
    $address_country = isset($_REQUEST['address_country']) && $_REQUEST['address_country'] != '' ? sanitize_text_field($_REQUEST['address_country']) : '';
    $contact_phone = isset($_REQUEST['contact_phone']) && $_REQUEST['contact_phone'] != '' ? sanitize_text_field($_REQUEST['contact_phone']) : '';
 
    update_user_meta($user_id, 'business_name', $business_name);
    update_user_meta($user_id, 'business_website', $business_website);
    
    update_user_meta($user_id, 'address_line_1', $address_line_1);
    update_user_meta($user_id, 'address_line_2', $address_line_2);
    update_user_meta($user_id, 'address_town', $address_town);
    update_user_meta($user_id, 'address_county', $address_county);
    update_user_meta($user_id, 'address_postcode', $address_postcode);
    update_user_meta($user_id, 'address_country', $address_country);
    update_user_meta($user_id, 'contact_phone', $contact_phone);
    
}

add_action( 'admin_head', function(){
    ob_start(); ?>
    <style>
        .user-admin-color-wrap,
        .user-rich-editing-wrap,
        .user-syntax-highlighting-wrap,
        .user-comment-shortcuts-wrap,
        .user-admin-bar-front-wrap {
            display: none;
        }
    </style>
    <?php ob_end_flush();
});

function activate_store($user_id) {
    
    $store_active = get_user_meta( $user_id, 'enable_store', true );
    
}

function handle_admin_file_upload($user_id = ''){
    
    if ($user_id == '') {
        $user_id = get_current_user_id();
    }

    if(!(is_array($_POST) && is_array($_FILES) && defined('DOING_AJAX') && DOING_AJAX)){
        return;
    }

    if(!function_exists('wp_handle_upload')){
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $response = array();
    
    // We are only allowing images
    $allowedMimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
    );
 
    $fileInfo = wp_check_filetype(basename($_FILES['file']['name']), $allowedMimes);
    
    if (!empty($fileInfo['type'])) {
        $uploadedfile = $_FILES['file'];
        $upload_overrides = array('test_form' => false, 'mimes' => $allowedMimes);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        // echo $movefile['url'];
        if ($movefile && !isset($movefile['error'])) {
            $attachment_id = insert_logo($movefile['file'], $user_id);
        } else {
            /**
             * Error generated by _wp_handle_upload()
             * @see _wp_handle_upload() in wp-admin/includes/file.php
             */
            $response['message'] = 'Error - The file couldn;t be uploaded';
            add_action( 'admin_notices', 'file_error_notice' );
        }
    } else {
        $response['message'] = 'Error - The filetype seems to be incorrect';
        add_action( 'admin_notices', 'file_error_notice', $response['message']);
    }
    

    return;
}

function file_error_notice($error) {
    ?>
    <div class="error notice">
        <p><?php _e( $error, 'cq_custom' ); ?></p>
    </div>
    <?php
}
?>