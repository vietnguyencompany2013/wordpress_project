<?php
/** Register Bandana Core scripts. */
add_action( 'wp_enqueue_scripts', 'bandana_register_scripts', 1 );

/** Load Bandana Core scripts. */
add_action( 'wp_enqueue_scripts', 'bandana_enqueue_scripts' );

/** Register JavaScript and Stylesheet files for the framework. */
function bandana_register_scripts() {

	/** Register the 'common' scripts. */
	wp_register_script( 'bandana-js-common', esc_url( BANDANA_JS_URI . 'common.js' ), array( 'jquery' ), '1.0', true );
	
	/** Register '960.css' for grid. */
	wp_register_style( 'bandana-css-960', esc_url( BANDANA_CSS_URI . '960.css' ) );
	
	/** Register Google Fonts. */
	$google_ssl = is_ssl()? 'https' : 'http';
	wp_register_style( 'bandana-google-fonts', esc_url( $google_ssl . '://fonts.googleapis.com/css?family=PT+Sans|Radley' ) );
}

/** Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function. */
function bandana_enqueue_scripts() {

	/** Load the comment reply script on singular posts with open comments if threaded comments are supported. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/** Load the 'common' scripts. */
	wp_enqueue_script( 'bandana-js-common' );
	
	/** Load '960.css' for grid. */
	wp_enqueue_style( 'bandana-css-960' );
	
	/** Load Google Fonts. */
	wp_enqueue_style( 'bandana-google-fonts' );
}

/** Analytic Code */
add_action( 'wp_footer', 'bandana_analytic_code_init' );
function bandana_analytic_code_init() {
	
	$bandana_options = bandana_get_settings();
	
	if( $bandana_options['bandana_analytic'] == 1 ) :	
	echo htmlspecialchars_decode ( $bandana_options['bandana_analytic_code'] );	
	echo '<!-- end analytic-code -->';	
	endif;

}
?>