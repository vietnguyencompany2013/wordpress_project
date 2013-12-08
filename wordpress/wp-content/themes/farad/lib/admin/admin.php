<?php
class FaradAdmin {
		
		/** Constructor Method */
		function __construct() {
	
			/** Load the admin_init functions. */
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			
			/* Hook the settings page function to 'admin_menu'. */
			add_action( 'admin_menu', array( &$this, 'settings_page_init' ) );		
	
		}
		
		/** Initializes any admin-related features needed for the framework. */
		function admin_init() {
			
			/** Registers admin JavaScript and Stylesheet files for the framework. */
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_register_scripts' ), 1 );
		
			/** Loads admin JavaScript and Stylesheet files for the framework. */
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
			
		}
		
		/** Registers admin JavaScript and Stylesheet files for the framework. */
		function admin_register_scripts() {
			
			/** Register Admin Stylesheet */
			wp_register_style( 'farad-admin-css-style', esc_url( FARAD_ADMIN_URI . 'style.css' ) );
			
			/** Register Admin Scripts */
			wp_register_script( 'farad-admin-js-farad', esc_url( FARAD_ADMIN_URI . 'common.js' ) );
			wp_register_script( 'farad-admin-js-jquery-cookie', esc_url( FARAD_JS_URI . 'jquery-cookie/jquery.cookie.js' ) );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for the framework. */
		function admin_enqueue_scripts() {			
		}
		
		/** Initializes all the theme settings page functionality. This function is used to create the theme settings page */
		function settings_page_init() {
			
			global $farad;
			
			/** Register theme settings. */
			register_setting( 'farad_options_group', 'farad_options', array( &$this, 'farad_options_validate' ) );
			
			/* Create the theme settings page. */
			$farad->settings_page = add_theme_page( 
				esc_html( __( 'Farad Options', 'farad' ) ),	/** Settings page name. */
				esc_html( __( 'Farad Options', 'farad' ) ),	/** Menu item name. */
				$this->settings_page_capability(),				/** Required capability */
				'farad-options', 								/** Screen name */
				array( &$this, 'settings_page' )				/** Callback function */
			);
			
			/* Check if the settings page is being shown before running any functions for it. */
			if ( !empty( $farad->settings_page ) ) {
				
				/** Add contextual help to the theme settings page. */
				add_action( 'load-'. $farad->settings_page, array( &$this, 'settings_page_contextual_help' ) );
				
				/* Load the JavaScript and stylesheets needed for the theme settings screen. */
				add_action( 'admin_enqueue_scripts', array( &$this, 'settings_page_enqueue_scripts' ) );
				
				/** Configure settings Sections and Fileds. */
				$this->settings_sections();
				
				/** Configure default settings. */
				$this->settings_default();				
				
			}
			
		}
		
		/** Returns the required capability for viewing and saving theme settings. */
		function settings_page_capability() {
			return 'edit_theme_options';
		}
		
		/** Displays the theme settings page. */
		function settings_page() {
			require( FARAD_ADMIN_DIR . 'page.php' );
		}
		
		/** Text for the contextual help for the theme settings page in the admin. */
		function settings_page_contextual_help() {
			
			/** Get the parent theme data. */
			$theme = farad_theme_data();
			$AuthorURI = $theme['AuthorURI'];
			$ThemeURI = $theme['ThemeURI'];
		
			/** Get the current screen */
			$screen = get_current_screen();
			
			/** Add theme reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'farad-theme',
				'title' => __( 'Theme Support', 'farad' ),
				'content' => implode( '', file( FARAD_ADMIN_DIR . 'help/support.html' ) ),				
				
				)
			);
			
			/** Add license reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'farad-license',
				'title' => __( 'License', 'farad' ),
				'content' => implode( '', file( FARAD_ADMIN_DIR . 'help/license.html' ) ),				
				
				)
			);
			
			/** Add changelog reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'farad-changelog',
				'title' => __( 'Changelog', 'farad' ),
				'content' => implode( '', file( FARAD_ADMIN_DIR . 'help/changelog.html' ) ),				
				
				)
			);
			
			/** Help Sidebar */
			$sidebar = '<p><strong>' . __( 'For more information:', 'farad' ) . '</strong></p>';
			if ( !empty( $AuthorURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $AuthorURI ) . '" target="_blank">' . __( 'Farad Project', 'farad' ) . '</a></p>';
			}
			if ( !empty( $ThemeURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $ThemeURI ) . '" target="_blank">' . __( 'Farad Official Page', 'farad' ) . '</a></p>';
			}			
			$screen->set_help_sidebar( $sidebar );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for displaying the theme settings page in the WordPress admin. */
		function settings_page_enqueue_scripts( $hook ) {
			
			/** Load Scripts For Farad Options Page */
			if( $hook === 'appearance_page_farad-options' ) {
				
				/** Load Admin Stylesheet */
				wp_enqueue_style( 'farad-admin-css-style' );
				
				/** Load Admin Scripts */
				wp_enqueue_script( 'farad-admin-js-farad' );
				wp_enqueue_script( 'farad-admin-js-jquery-cookie' );
				
			}
				
		}
		
		/** Configure settings Sections and Fileds */		
		function settings_sections() {
		
			/** Blog Section */
			add_settings_section( 'farad_section_blog', 'Blog Options', array( &$this, 'farad_section_blog_fn' ), 'farad_section_blog_page' );			
			
			add_settings_field( 'farad_field_nav_style', __( 'Navigation Style', 'farad' ), array( &$this, 'farad_field_nav_style_fn' ), 'farad_section_blog_page', 'farad_section_blog' );
			
			/** Post Section */
			add_settings_section( 'farad_section_post', 'Post Options', array( &$this, 'farad_section_post_fn' ), 'farad_section_post_page' );
			
			add_settings_field( 'farad_field_post_style', __( 'Post Style', 'farad' ), array( &$this, 'farad_field_post_style_fn' ), 'farad_section_post_page', 'farad_section_post' );
			add_settings_field( 'farad_field_featured_image_control', __( 'Post Featured Image', 'farad' ), array( &$this, 'farad_field_featured_image_control_fn' ), 'farad_section_post_page', 'farad_section_post' );
			
			/** Footer Section */
			add_settings_section( 'farad_section_footer', 'Footer Options', array( &$this, 'farad_section_footer_fn' ), 'farad_section_footer_page' );
			
			add_settings_field( 'farad_field_copyright_control', __( 'Use Copyright', 'farad' ), array( &$this, 'farad_field_copyright_control_fn' ), 'farad_section_footer_page', 'farad_section_footer' );
			add_settings_field( 'farad_field_copyright', __( 'Enter Copyright Text', 'farad' ), array( &$this, 'farad_field_copyright_fn' ), 'farad_section_footer_page', 'farad_section_footer' );
			
			/** General Section */
			add_settings_section( 'farad_section_general', 'General Options', array( &$this, 'farad_section_general_fn' ), 'farad_section_general_page' );
			
			add_settings_field( 'farad_field_reset_control', __( 'Reset Theme Options', 'farad' ), array( &$this, 'farad_field_reset_control_fn' ), 'farad_section_general_page', 'farad_section_general' );
		
		}
		
		/** Configure Settings */
		function settings_default() {

			$farad_options = get_option( 'farad_options' );
			if( !is_array( $farad_options ) ) {
				update_option( 'farad_options', farad_settings_default() );
			}
		
		}
		
		/** Farad Pre-defined Range */
		
		/* Boolean Yes | No */		
		function farad_boolean_pd() {			
			return array( 1 => __( 'yes', 'farad' ), 0 => __( 'no', 'farad' ) );		
		}
		
		/* Nav Style Range */		
		function farad_nav_style_pd() {			
			return array( 'numeric' => __( 'Numeric', 'farad' ), 'older-newer' => __( 'Older / Newer', 'farad' ) );			
		}
		
		/* Post Style Range */		
		function farad_post_style_pd() {			
			return array( 'content' => __( 'Content', 'farad' ), 'excerpt' => __( 'Excerpt', 'farad' ) );			
		}
		
		/* Featured Image Range */		
		function farad_featured_image_pd() {			
			return array( 'manual' => __( 'Use Featured Image', 'farad' ), 'auto' => __( 'Use Featured Image Automatically', 'farad' ), 'no' => __( 'No Featured Image', 'farad' ) );			
		}		
		
		/** Farad Options Validation */				
		function farad_options_validate( $input ) {
			
			/** Default */
			$default = farad_settings_default();

			/** Farad Predefined */
			$farad_boolean_pd = $this->farad_boolean_pd();
			$farad_nav_style_pd = $this->farad_nav_style_pd();
			$farad_post_style_pd = $this->farad_post_style_pd();
			$farad_featured_image_pd = $this->farad_featured_image_pd();						
			
			/* Validation: farad_nav_style */
			if ( ! array_key_exists( $input['farad_nav_style'], $farad_nav_style_pd ) ) {
				 $input['farad_nav_style'] = $default['farad_nav_style'];
			}
			
			/* Validation: farad_post_style */			
			if ( ! array_key_exists( $input['farad_post_style'], $farad_post_style_pd ) ) {
				 $input['farad_post_style'] = $default['farad_post_style'];
			}
			
			/* Validation: farad_featured_image_control */			
			if ( ! array_key_exists( $input['farad_featured_image_control'], $farad_featured_image_pd ) ) {
				 $input['farad_featured_image_control'] = $default['farad_featured_image_control'];
			}										
			
			/* Validation: farad_copyright_control */			
			if ( ! array_key_exists( $input['farad_copyright_control'], $farad_boolean_pd ) ) {
				 $input['farad_copyright_control'] = $default['farad_copyright_control'];
			}
			
			/* Validation: farad_copyright */
			if( !empty( $input['farad_copyright'] ) ) {
				$input['farad_copyright'] = htmlspecialchars ( $input['farad_copyright'] );
			}
			
			/* Validation: farad_reset_control */
			if ( ! array_key_exists( $input['farad_reset_control'], $farad_boolean_pd ) ) {
				 $input['farad_reset_control'] = $default['farad_reset_control'];
			}

			/** Reset Logic */
			if( $input['farad_reset_control'] == 1 ) {
				$input = $default;
			}
			
			return $input;
		
		}
		
		/** Blog Section Callback */				
		function farad_section_blog_fn() {
			echo '<div class="farad-section-desc">
			  <p class="description">'. __( 'Customize your blog by using the following settings.', 'farad' ) .'</p>
			</div>';
		}
		
		/* Nav Style Callback */		
		function farad_field_nav_style_fn() {
			
			$farad_options = farad_get_settings();
			$items = $this->farad_nav_style_pd();
			
			echo '<select id="farad_nav_style" name="farad_options[farad_nav_style]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $farad_options['farad_nav_style'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select navigation style.', 'farad' ) .'</small></div>';
		
		}
		
		/** Post Section Callback */				
		function farad_section_post_fn() {
			echo '<div class="farad-section-desc">
			  <p class="description">'. __( 'Customize your posts by using the following settings.', 'farad' ) .'</p>
			</div>';
		}
		
		/* Post Style Callback */		
		function farad_field_post_style_fn() {
			
			$farad_options = farad_get_settings();
			$items = $this->farad_post_style_pd();
			
			echo '<select id="farad_post_style" name="farad_options[farad_post_style]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $farad_options['farad_post_style'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select post style.', 'farad' ) .'</small></div>';
		
		}
		
		/* Featured Image Callback */		
		function farad_field_featured_image_control_fn() {
			
			$farad_options = farad_get_settings();
			$items = $this->farad_featured_image_pd();
			
			echo '<select id="farad_featured_image_control" name="farad_options[farad_featured_image_control]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $farad_options['farad_featured_image_control'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( '<strong>Use Featured Image:</strong> which is set in the post.', 'farad' ) .'</small></div>';
			echo '<div><small>'. __( '<strong>Use Featured Image Automatically:</strong> from the images uploaded to the post.', 'farad' ) .'</small></div>';
			echo '<div><small>'. __( '<strong>No Featured Image:</strong> for the post.', 'farad' ) .'</small></div>';
		
		}
		
		/** Footer Section Callback */				
		function farad_section_footer_fn() {
			echo '<div class="farad-section-desc">
			  <p class="description">'. __( 'Customize your footer by using the following settings.', 'farad' ) .'</p>
			</div>';
		}
		
		/* Copyright Control Callback */		
		function  farad_field_copyright_control_fn() {
			
			$farad_options = farad_get_settings();
			$items = $this->farad_boolean_pd();
			
			echo '<select id="farad_copyright_control" name="farad_options[farad_copyright_control]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $farad_options['farad_copyright_control'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select yes to override default copyright text.', 'farad' ) .'</small></div>';
		
		}
		
		/* Copyright Callback */
		function farad_field_copyright_fn() {
			
			$farad_options = farad_get_settings();
			echo '<textarea type="textarea" id="farad_copyright" name="farad_options[farad_copyright]" rows="7" cols="50">'. esc_html ( $farad_options['farad_copyright'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter the copyright text.', 'farad' ) .'</small></div>';
			echo '<div><small>Example: <strong>&amp;copy; Copyright '.date('Y').' - &lt;a href="'. esc_url( home_url( '/' ) ) .'"&gt;'. get_bloginfo('name') .'&lt;/a&gt;</strong></small></div>';
		
		}
		
		/** General Section Callback */				
		function farad_section_general_fn() {
			echo '<div class="farad-section-desc">
			  <p class="description">'. __( 'Here are the general settings to customize your blog.', 'farad' ) .'</p>
			</div>';
		}
		
		/* Reset Congrol Callback */		
		function farad_field_reset_control_fn() {
			
			$farad_options = farad_get_settings();			
			$items = $this->farad_boolean_pd();			
			echo '<label><input type="checkbox" id="farad_reset_control" name="farad_options[farad_reset_control]" value="1" /> '. __( 'Reset Theme Options.', 'farad' ) .'</label>';
		
		}
}

/** Initiate Admin */
new FaradAdmin();