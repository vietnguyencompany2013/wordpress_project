<?php
/**
 * Theme administration functions.
 *
 * @package Cell
 * @subpackage Admin
 */

class CellAdmin {
		
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
			wp_register_style( 'cell-admin-css-style', esc_url( CELL_ADMIN_URI . 'style.css' ) );
			wp_register_style( 'cell-admin-css-ui-smoothness', esc_url( CELL_JS_URI . 'ui/css/smoothness/jquery-ui-1.8.18.custom.css' ) );
			
			/** Register Admin Scripts */
			wp_register_script( 'cell-admin-js-cell', esc_url( CELL_ADMIN_URI . 'cell.js' ), array( 'jquery-ui-tabs' ) );
			wp_register_script( 'cell-admin-js-jquery-cookie', esc_url( CELL_JS_URI . 'jquery.cookie.js' ), array( 'jquery' ) );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for the framework. */
		function admin_enqueue_scripts() {			
		}
		
		/** Initializes all the theme settings page functionality. This function is used to create the theme settings page */
		function settings_page_init() {
			
			global $cell;
			
			/** Register theme settings. */
			register_setting( 'cell_options_group', 'cell_options', array( &$this, 'cell_options_validate' ) );
			
			/* Create the theme settings page. */
			$cell->settings_page = add_theme_page( 
				esc_html( __( 'Cell Options', 'cell' ) ),	/** Settings page name. */
				esc_html( __( 'Cell Options', 'cell' ) ),	/** Menu item name. */
				$this->settings_page_capability(),				/** Required capability */
				'cell-options', 								/** Screen name */
				array( &$this, 'settings_page' )				/** Callback function */
			);
			
			/* Check if the settings page is being shown before running any functions for it. */
			if ( !empty( $cell->settings_page ) ) {
				
				/** Add contextual help to the theme settings page. */
				add_action( 'load-'. $cell->settings_page, array( &$this, 'settings_page_contextual_help' ) );
				
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
			require( CELL_ADMIN_DIR . 'page.php' );
		}
		
		/** Text for the contextual help for the theme settings page in the admin. */
		function settings_page_contextual_help() {
			
			/** Get the parent theme data. */
			$theme = cell_theme_data();
			$AuthorURI = $theme['AuthorURI'];
			$ThemeURI = $theme['ThemeURI'];
		
			/** Get the current screen */
			$screen = get_current_screen();
			
			/** Help Tab */
			$screen->add_help_tab( array(
				
				'id' => 'theme-settings-support',
				'title' => __( 'Theme Support', 'cell' ),
				'content' => implode( '', file( CELL_ADMIN_DIR . 'help/support.html' ) ),				
				
				)
			);
			
			/** Help Sidebar */
			$sidebar = '<p><strong>' . __( 'For more information:', 'cell' ) . '</strong></p>';
			if ( !empty( $AuthorURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $AuthorURI ) . '" target="_blank">' . __( 'Cell Project', 'cell' ) . '</a></p>';
			}
			if ( !empty( $ThemeURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $ThemeURI ) . '" target="_blank">' . __( 'Cell Official Page', 'cell' ) . '</a></p>';
			}			
			$screen->set_help_sidebar( $sidebar );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for displaying the theme settings page in the WordPress admin. */
		function settings_page_enqueue_scripts( $hook ) {
			
			/** Load Scripts For Cell Options Page */
			if( $hook === 'appearance_page_cell-options' ) {
				
				/** Load Admin Stylesheet */
				wp_enqueue_style( 'cell-admin-css-style' );
				wp_enqueue_style( 'cell-admin-css-ui-smoothness' );
				
				/** Load Admin Scripts */
				wp_enqueue_script( 'cell-admin-js-cell' );
				wp_enqueue_script( 'cell-admin-js-jquery-cookie' );
				
			}
				
		}
		
		/** Configure settings Sections and Fileds */		
		function settings_sections() {
		
			/** Blog Section */
			add_settings_section( 'cell_section_blog', 'Blog Options', array( &$this, 'cell_section_blog_fn' ), 'cell_section_blog_page' );			
			
			add_settings_field( 'cell_field_post_style', __( 'Post Style', 'cell' ), array( &$this, 'cell_field_post_style_fn' ), 'cell_section_blog_page', 'cell_section_blog' );
			add_settings_field( 'cell_field_post_nav_style', __( 'Post Navigation Style', 'cell' ), array( &$this, 'cell_field_post_nav_style_fn' ), 'cell_section_blog_page', 'cell_section_blog' );
			
			/** General Section */
			add_settings_section( 'cell_section_general', 'General Options', array( &$this, 'cell_section_general_fn' ), 'cell_section_general_page' );
			
			add_settings_field( 'cell_field_analytic', __( 'Use Analytic', 'cell' ), array( &$this, 'cell_field_analytic_fn' ), 'cell_section_general_page', 'cell_section_general' );
			add_settings_field( 'cell_field_analytic_code', __( 'Enter Analytic Code', 'cell' ), array( &$this, 'cell_field_analytic_code_fn' ), 'cell_section_general_page', 'cell_section_general' );
			add_settings_field( 'cell_field_copyright', __( 'Enter Copyright Text', 'cell' ), array( &$this, 'cell_field_copyright_fn' ), 'cell_section_general_page', 'cell_section_general' );
			add_settings_field('cell_field_reset', __( 'Reset Theme Options', 'cell' ), array( &$this, 'cell_field_reset_fn' ), 'cell_section_general_page', 'cell_section_general' );
		
		}
		
		/** Configure default settings. */		
		function settings_default() {
			global $cell;
			
			$cell_reset = false;
			$cell_options = cell_get_settings();
			
			/** Cell Reset Logic */
			if ( !is_array( $cell_options ) ) {			
				$cell_reset = true;			
			} 						
			elseif ( $cell_options['cell_reset'] == 1 ) {			
				$cell_reset = true;			
			}			
			
			/** Let Reset Cell */
			if( $cell_reset == true ) {
				
				$default = array(
					
					'cell_post_style' => 'content',
					'cell_post_nav_style' => 'numeric',
					
					'cell_analytic' => 0,
					'cell_analytic_code' => 'Analytic Code',
					
					'cell_copyright' => '&copy; Copyright '. date( 'Y' ) .' - <a href="'. home_url( '/' ) .'">'. get_bloginfo( 'name' ) .'</a>',
					
					'cell_reset' => 0,
					
				);
				
				update_option( 'cell_options' , $default );
			
			}
		
		}
		
		/** Cell Pre-defined Range */
		
		/* Boolean Yes | No */		
		function cell_pd_boolean() {			
			return array( 1 => __( 'yes', 'cell' ), 0 => __( 'no', 'cell' ) );		
		}
		
		/* Post Style Range */		
		function cell_pd_post_style() {			
			return array( 'content' => __( 'Content', 'cell' ), 'excerpt' => __( 'Excerpt (Magazine Style)', 'cell' ) );			
		}
		
		/* Post Navigation Style Range */		
		function cell_pd_post_nav_style() {			
			return array( 'numeric' => __( 'Numeric', 'cell' ), 'older-newer' => __( 'Older / Newer', 'cell' ) );			
		}
		
		/** Cell Options Validation */				
		function cell_options_validate( $input ) {
			
			/* Validation: cell_post_style */
			$cell_pd_post_style = $this->cell_pd_post_style();
			if ( ! array_key_exists( $input['cell_post_style'], $cell_pd_post_style ) ) {
				 $input['cell_post_style'] = 'excerpt';
			}
			
			/* Validation: cell_post_nav_style */
			$cell_pd_post_nav_style = $this->cell_pd_post_nav_style();
			if ( ! array_key_exists( $input['cell_post_nav_style'], $cell_pd_post_nav_style ) ) {
				 $input['cell_post_nav_style'] = 'numeric';
			}								
			
			/* Validation: cell_analytic */
			$cell_pd_boolean = $this->cell_pd_boolean();
			if ( ! array_key_exists( $input['cell_analytic'], $cell_pd_boolean ) ) {
				 $input['cell_analytic'] = 0;
			}
			
			/* Validation: cell_analytic_code */
			if( !empty( $input['cell_analytic_code'] ) ) {
				$input['cell_analytic_code'] = htmlspecialchars ( $input['cell_analytic_code'] );
			}
			
			/* Validation: cell_copyright */
			if( !empty( $input['cell_copyright'] ) ) {
				$input['cell_copyright'] = esc_html ( $input['cell_copyright'] );
			}
			
			/* Validation: cell_reset */
			$cell_pd_boolean = $this->cell_pd_boolean();
			//if ( ! array_key_exists( cell_undefined_index_fix ( $input['cell_reset'] ), $cell_pd_boolean ) ) {
			if ( ! array_key_exists( $input['cell_reset'], $cell_pd_boolean ) ) {
				 $input['cell_reset'] = 0;
			}
			
			add_settings_error( 'cell_options', 'cell_options', __( 'Settings Saved.', 'cell' ), 'updated' );
			
			return $input;
		
		}
		
		/** Blog Section Callback */				
		function cell_section_blog_fn() {
			_e( 'Cell Blog Options', 'cell' );
		}
		
		/* Post Style Callback */		
		function cell_field_post_style_fn() {
			
			$cell_options = get_option('cell_options');
			$items = $this->cell_pd_post_style();			
			
			foreach( $items as $key => $val ) {
			?>
            <label><input type="radio" id="cell_post_style[]" name="cell_options[cell_post_style]" value="<?php echo $key; ?>" <?php checked( $key, $cell_options['cell_post_style'] ); ?> /> <?php echo $val; ?></label><br />
            <?php
			}		
		
		}
		
		/* Post Style Navigaiton Callback */		
		function cell_field_post_nav_style_fn() {
			
			$cell_options = get_option('cell_options');
			$items = $this->cell_pd_post_nav_style();			
			
			foreach( $items as $key => $val ) {
			?>
            <label><input type="radio" id="cell_post_nav_style[]" name="cell_options[cell_post_nav_style]" value="<?php echo $key; ?>" <?php checked( $key, $cell_options['cell_post_nav_style'] ); ?> /> <?php echo $val; ?></label><br />
            <?php
			}
		
		}
		
		/** General Section Callback */				
		function cell_section_general_fn() {
			_e( 'Cell General Options', 'cell' );
		}
		
		/* Analytic Callback */		
		function  cell_field_analytic_fn() {
			
			$cell_options = get_option( 'cell_options' );
			$items = $this->cell_pd_boolean();
			
			echo '<select id="cell_analytic" name="cell_options[cell_analytic]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $cell_options['cell_analytic'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select yes to add your Analytic code.', 'cell' ) .'</small></div>';
		
		}
		
		function cell_field_analytic_code_fn() {
			
			$cell_options = get_option('cell_options');
			echo '<textarea type="textarea" id="cell_analytic_code" name="cell_options[cell_analytic_code]" rows="7" cols="50">'. htmlspecialchars_decode ( $cell_options['cell_analytic_code'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter the Analytic code.', 'cell' ) .'</small></div>';
		
		}
		
		/* Copyright Text Callback */		
		function cell_field_copyright_fn() {
			
			$cell_options = get_option('cell_options');
			echo '<textarea type="textarea" id="cell_copyright" name="cell_options[cell_copyright]" rows="7" cols="50">'. esc_html ( $cell_options['cell_copyright'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter Copyright Text.', 'cell' ) .'</small></div>';
			echo '<div><small>Example: <strong>&amp;copy; Copyright '.date('Y').' - &lt;a href="'. home_url( '/' ) .'"&gt;'. get_bloginfo('name') .'&lt;/a&gt;</strong></small></div>';
		
		}		
		
		/* Theme Reset Callback */		
		function cell_field_reset_fn() {
			
			$cell_options = get_option('cell_options');			
			$items = $this->cell_pd_boolean();			
			echo '<label><input type="checkbox" id="cell_reset" name="cell_options[cell_reset]" value="1" /> '. __( 'Reset Theme Options.', 'cell' ) .'</label>';
		
		}
}

/** Initiate Admin */
new CellAdmin();
?>