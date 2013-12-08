<?php
/** Register Farad Core scripts. */
add_action( 'wp_enqueue_scripts', 'farad_register_scripts', 1 );

/** Load Farad Core scripts. */
add_action( 'wp_enqueue_scripts', 'farad_enqueue_scripts' );

/** Register JavaScript and Stylesheet files for the framework. */
function farad_register_scripts() {

	/** Register the 'Superfish Plugin' scripts. */
	wp_register_script( 'farad-js-superfish', esc_url( FARAD_JS_URI . 'superfish/superfish-combine.min.js' ), array( 'jquery' ), '1.5.9', true );
	
	/** Register the 'common' scripts. */
	wp_register_script( 'farad-js-common', esc_url( FARAD_JS_URI . 'common.js' ), array( 'jquery' ), '1.0', true );
	
	/** Register '960.css' for grid. */
	wp_register_style( 'farad-css-960', esc_url( FARAD_CSS_URI . '960.css' ) );
	
	/** Register 'style.css' for grid. */
	wp_register_style( 'farad-css-style', esc_url( get_stylesheet_uri() ) );
	
	/** Register Google Fonts. */
	$protocol = is_ssl()? 'https' : 'http';
	wp_register_style( 'farad-google-fonts', esc_url( $protocol . '://fonts.googleapis.com/css?family=Open+Sans|Lato' ) );
}

/** Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function. */
function farad_enqueue_scripts() {

	/** Load the comment reply script on singular posts with open comments if threaded comments are supported. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/** Load the 'Superfish Plugin' scripts. */
	wp_enqueue_script( 'farad-js-superfish' );
	
	/** Load the 'common' scripts. */
	wp_enqueue_script( 'farad-js-common' );
	
	/** Load '960.css' for grid. */
	wp_enqueue_style( 'farad-css-960' );
	
	/** Load 'style.css' for grid. */
	wp_enqueue_style( 'farad-css-style' );
	
	/** Load Google Fonts. */
	wp_enqueue_style( 'farad-google-fonts' );
}