<?php
/**
 * Functions file for loading scripts and stylesheets.
 *
 * @package Cell
 * @subpackage Functions
 */

/** Register Cell Core scripts. */
add_action( 'wp_enqueue_scripts', 'cell_register_scripts', 1 );

/** Load Cell Core scripts. */
add_action( 'wp_enqueue_scripts', 'cell_enqueue_scripts' );

/** Register JavaScript and Stylesheet files for the framework. */
function cell_register_scripts() {

	/* Register the 'drop-downs' scripts if the current theme supports 'cell-core-menus'. */
	if ( current_theme_supports( 'cell-core-menus' ) ) {
		wp_register_script( 'cell-js-drop-downs', esc_url( CELL_JS_URI . 'drop-downs.js' ), array( 'jquery' ), '1.0', true );
	}
	
	/** Register '960.css' for grid. */
	wp_register_style( 'cell-css-960', esc_url( CELL_CSS_URI . '960.css' ) );
	
	/** Register Google Fonts. */
	wp_register_style( 'cell-google-fonts', esc_url( 'http://fonts.googleapis.com/css?family=Droid+Sans|Scada|Share' ) );
}

/** Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function. */
function cell_enqueue_scripts() {

	/** Load the comment reply script on singular posts with open comments if threaded comments are supported. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/** Load the 'drop-downs' script if the current theme supports 'cell-drop-downs'. */
	if ( current_theme_supports( 'cell-core-menus' ) ) {
		wp_enqueue_script( 'cell-js-drop-downs' );
	}
	
	/** Load '960.css' for grid. */
	wp_enqueue_style( 'cell-css-960' );
	
	/** Load Google Fonts. */
	wp_enqueue_style( 'cell-google-fonts' );
}

/** Analytic Code */
add_action( 'wp_footer', 'cell_analytic_code_init' );
function cell_analytic_code_init() {
	
	$cell_options = cell_get_settings();
	
	if( $cell_options['cell_analytic'] == 1 ) :	
	echo htmlspecialchars_decode ( $cell_options['cell_analytic_code'] );	
	echo '<!-- end analytic-code -->';	
	endif;

}
?>