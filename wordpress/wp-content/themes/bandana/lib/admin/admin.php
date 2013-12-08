<?php
class BandanaAdmin {
		
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
			wp_register_style( 'bandana-admin-css-style', esc_url( BANDANA_ADMIN_URI . 'style.css' ) );
			
			/** Register Admin Scripts */
			wp_register_script( 'bandana-admin-js-bandana', esc_url( BANDANA_ADMIN_URI . 'common.js' ), array( 'jquery-ui-tabs' ) );
			wp_register_script( 'bandana-admin-js-jquery-cookie', esc_url( BANDANA_JS_URI . 'jquery.cookie.js' ), array( 'jquery' ) );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for the framework. */
		function admin_enqueue_scripts() {			
		}
		
		/** Initializes all the theme settings page functionality. This function is used to create the theme settings page */
		function settings_page_init() {
			
			global $bandana;
			
			/** Register theme settings. */
			register_setting( 'bandana_options_group', 'bandana_options', array( &$this, 'bandana_options_validate' ) );
			
			/* Create the theme settings page. */
			$bandana->settings_page = add_theme_page( 
				esc_html( __( 'Bandana Options', 'bandana' ) ),	/** Settings page name. */
				esc_html( __( 'Bandana Options', 'bandana' ) ),	/** Menu item name. */
				$this->settings_page_capability(),				/** Required capability */
				'bandana-options', 								/** Screen name */
				array( &$this, 'settings_page' )				/** Callback function */
			);
			
			/* Check if the settings page is being shown before running any functions for it. */
			if ( !empty( $bandana->settings_page ) ) {
				
				/** Add contextual help to the theme settings page. */
				add_action( 'load-'. $bandana->settings_page, array( &$this, 'settings_page_contextual_help' ) );
				
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
			require( BANDANA_ADMIN_DIR . 'page.php' );
		}
		
		/** Text for the contextual help for the theme settings page in the admin. */
		function settings_page_contextual_help() {
			
			/** Get the parent theme data. */
			$theme = bandana_theme_data();
			$AuthorURI = $theme['AuthorURI'];
			$ThemeURI = $theme['ThemeURI'];
		
			/** Get the current screen */
			$screen = get_current_screen();
			
			/** Add theme reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-theme',
				'title' => __( 'Theme Support', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/support.html' ) ),				
				
				)
			);
			
			/** Add license reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-license',
				'title' => __( 'License', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/license.html' ) ),				
				
				)
			);
			
			/** Add changelog reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-changelog',
				'title' => __( 'Changelog', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/changelog.html' ) ),				
				
				)
			);
			
			/** Help Sidebar */
			$sidebar = '<p><strong>' . __( 'For more information:', 'bandana' ) . '</strong></p>';
			if ( !empty( $AuthorURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $AuthorURI ) . '" target="_blank">' . __( 'Bandana Project', 'bandana' ) . '</a></p>';
			}
			if ( !empty( $ThemeURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $ThemeURI ) . '" target="_blank">' . __( 'Bandana Official Page', 'bandana' ) . '</a></p>';
			}			
			$screen->set_help_sidebar( $sidebar );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for displaying the theme settings page in the WordPress admin. */
		function settings_page_enqueue_scripts( $hook ) {
			
			/** Load Scripts For Bandana Options Page */
			if( $hook === 'appearance_page_bandana-options' ) {
				
				/** Load Admin Stylesheet */
				wp_enqueue_style( 'bandana-admin-css-style' );
				
				/** Load Admin Scripts */
				wp_enqueue_script( 'bandana-admin-js-bandana' );
				wp_enqueue_script( 'bandana-admin-js-jquery-cookie' );
				
			}
				
		}
		
		/** Configure settings Sections and Fileds */		
		function settings_sections() {
		
			/** Blog Section */
			add_settings_section( 'bandana_section_blog', 'Blog Options', array( &$this, 'bandana_section_blog_fn' ), 'bandana_section_blog_page' );			
			
			add_settings_field( 'bandana_field_post_style', __( 'Post Style', 'bandana' ), array( &$this, 'bandana_field_post_style_fn' ), 'bandana_section_blog_page', 'bandana_section_blog' );
			add_settings_field( 'bandana_field_post_nav_style', __( 'Post Navigation Style', 'bandana' ), array( &$this, 'bandana_field_post_nav_style_fn' ), 'bandana_section_blog_page', 'bandana_section_blog' );
			
			/** General Section */
			add_settings_section( 'bandana_section_general', 'General Options', array( &$this, 'bandana_section_general_fn' ), 'bandana_section_general_page' );
			
			add_settings_field( 'bandana_field_analytic', __( 'Use Analytic', 'bandana' ), array( &$this, 'bandana_field_analytic_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
			add_settings_field( 'bandana_field_analytic_code', __( 'Enter Analytic Code', 'bandana' ), array( &$this, 'bandana_field_analytic_code_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
			
			add_settings_field( 'bandana_field_copyright', __( 'Use Copyright', 'bandana' ), array( &$this, 'bandana_field_copyright_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
			add_settings_field( 'bandana_field_copyright_code', __( 'Enter Copyright Text', 'bandana' ), array( &$this, 'bandana_field_copyright_code_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
			
			add_settings_field('bandana_field_reset', __( 'Reset Theme Options', 'bandana' ), array( &$this, 'bandana_field_reset_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
		
		}
		
		/** Configure default settings. */		
		function settings_default() {
			global $bandana;
			
			$bandana_reset = false;
			$bandana_options = bandana_get_settings();
			
			/** Bandana Reset Logic */
			if ( !is_array( $bandana_options ) ) {			
				$bandana_reset = true;			
			} 						
			elseif ( $bandana_options['bandana_reset'] == 1 ) {			
				$bandana_reset = true;			
			}			
			
			/** Let Reset Bandana */
			if( $bandana_reset == true ) {
				
				$default = array(
					
					'bandana_post_style' => 'content',
					'bandana_post_nav_style' => 'numeric',
					
					'bandana_analytic' => 0,
					'bandana_analytic_code' => '',
					
					'bandana_copyright' => 0,
					'bandana_copyright_code' => '',
					
					'bandana_reset' => 0,
					
				);
				
				update_option( 'bandana_options' , $default );
			
			}
		
		}
		
		/** Bandana Pre-defined Range */
		
		/* Boolean Yes | No */		
		function bandana_pd_boolean() {			
			return array( 1 => __( 'yes', 'bandana' ), 0 => __( 'no', 'bandana' ) );		
		}
		
		/* Post Style Range */		
		function bandana_pd_post_style() {			
			return array( 'content' => __( 'Content', 'bandana' ), 'excerpt' => __( 'Excerpt (Magazine Style)', 'bandana' ) );			
		}
		
		/* Post Navigation Style Range */		
		function bandana_pd_post_nav_style() {			
			return array( 'numeric' => __( 'Numeric', 'bandana' ), 'older-newer' => __( 'Older / Newer', 'bandana' ) );			
		}
		
		/** Bandana Options Validation */				
		function bandana_options_validate( $input ) {
			
			/* Validation: bandana_post_style */
			$bandana_pd_post_style = $this->bandana_pd_post_style();
			if ( ! array_key_exists( $input['bandana_post_style'], $bandana_pd_post_style ) ) {
				 $input['bandana_post_style'] = 'excerpt';
			}
			
			/* Validation: bandana_post_nav_style */
			$bandana_pd_post_nav_style = $this->bandana_pd_post_nav_style();
			if ( ! array_key_exists( $input['bandana_post_nav_style'], $bandana_pd_post_nav_style ) ) {
				 $input['bandana_post_nav_style'] = 'numeric';
			}								
			
			/* Validation: bandana_analytic */
			$bandana_pd_boolean = $this->bandana_pd_boolean();
			if ( ! array_key_exists( $input['bandana_analytic'], $bandana_pd_boolean ) ) {
				 $input['bandana_analytic'] = 0;
			}
			
			/* Validation: bandana_analytic_code */
			if( !empty( $input['bandana_analytic_code'] ) ) {
				$input['bandana_analytic_code'] = htmlspecialchars ( $input['bandana_analytic_code'] );
			}
			
			/* Validation: bandana_copyright */
			$bandana_pd_boolean = $this->bandana_pd_boolean();
			if ( ! array_key_exists( $input['bandana_copyright'], $bandana_pd_boolean ) ) {
				 $input['bandana_copyright'] = 0;
			}
			
			/* Validation: bandana_copyright_code */
			if( !empty( $input['bandana_copyright_code'] ) ) {
				$input['bandana_copyright_code'] = htmlspecialchars ( $input['bandana_copyright_code'] );
			}
			
			/* Validation: bandana_reset */
			$bandana_pd_boolean = $this->bandana_pd_boolean();
			//if ( ! array_key_exists( bandana_undefined_index_fix ( $input['bandana_reset'] ), $bandana_pd_boolean ) ) {
			if ( ! array_key_exists( $input['bandana_reset'], $bandana_pd_boolean ) ) {
				 $input['bandana_reset'] = 0;
			}
			
			add_settings_error( 'bandana_options', 'bandana_options', __( 'Settings Saved.', 'bandana' ), 'updated' );
			
			return $input;
		
		}
		
		/** Blog Section Callback */				
		function bandana_section_blog_fn() {}
		
		/* Post Style Callback */		
		function bandana_field_post_style_fn() {
			
			$bandana_options = get_option('bandana_options');
			$items = $this->bandana_pd_post_style();			
			
			foreach( $items as $key => $val ) {
			?>
            <label><input type="radio" id="bandana_post_style[]" name="bandana_options[bandana_post_style]" value="<?php echo $key; ?>" <?php checked( $key, $bandana_options['bandana_post_style'] ); ?> /> <?php echo $val; ?></label><br />
            <?php
			}		
		
		}
		
		/* Post Style Navigaiton Callback */		
		function bandana_field_post_nav_style_fn() {
			
			$bandana_options = get_option('bandana_options');
			$items = $this->bandana_pd_post_nav_style();			
			
			foreach( $items as $key => $val ) {
			?>
            <label><input type="radio" id="bandana_post_nav_style[]" name="bandana_options[bandana_post_nav_style]" value="<?php echo $key; ?>" <?php checked( $key, $bandana_options['bandana_post_nav_style'] ); ?> /> <?php echo $val; ?></label><br />
            <?php
			}
		
		}
		
		/** General Section Callback */				
		function bandana_section_general_fn() {}
		
		/* Analytic Callback */		
		function  bandana_field_analytic_fn() {
			
			$bandana_options = get_option( 'bandana_options' );
			$items = $this->bandana_pd_boolean();
			
			echo '<select id="bandana_analytic" name="bandana_options[bandana_analytic]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_analytic'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select yes to add your Analytic code.', 'bandana' ) .'</small></div>';
		
		}
		
		function bandana_field_analytic_code_fn() {
			
			$bandana_options = get_option('bandana_options');
			echo '<textarea type="textarea" id="bandana_analytic_code" name="bandana_options[bandana_analytic_code]" rows="7" cols="50">'. htmlspecialchars_decode ( $bandana_options['bandana_analytic_code'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter the Analytic code.', 'bandana' ) .'</small></div>';
		
		}
		
		/* Copyright Text Callback */		
		function  bandana_field_copyright_fn() {
			
			$bandana_options = get_option( 'bandana_options' );
			$items = $this->bandana_pd_boolean();
			
			echo '<select id="bandana_copyright" name="bandana_options[bandana_copyright]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_copyright'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select yes to override default Copyright text.', 'bandana' ) .'</small></div>';
		
		}
		
		function bandana_field_copyright_code_fn() {
			
			$bandana_options = get_option('bandana_options');
			echo '<textarea type="textarea" id="bandana_copyright_code" name="bandana_options[bandana_copyright_code]" rows="7" cols="50">'. esc_html ( $bandana_options['bandana_copyright_code'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter the Copyright Text.', 'bandana' ) .'</small></div>';
			echo '<div><small>Example: <strong>&amp;copy; Copyright '.date('Y').' - &lt;a href="'. home_url( '/' ) .'"&gt;'. get_bloginfo('name') .'&lt;/a&gt;</strong></small></div>';
		
		}		
		
		/* Theme Reset Callback */		
		function bandana_field_reset_fn() {
			
			$bandana_options = get_option('bandana_options');			
			$items = $this->bandana_pd_boolean();			
			echo '<label><input type="checkbox" id="bandana_reset" name="bandana_options[bandana_reset]" value="1" /> '. __( 'Reset Theme Options.', 'bandana' ) .'</label>';
		
		}
}

/** Initiate Admin */
new BandanaAdmin();
?>