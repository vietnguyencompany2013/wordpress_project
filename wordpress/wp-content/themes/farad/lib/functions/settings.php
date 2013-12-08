<?php
/** Farad Default Settings. */
function farad_settings_default()  {
			
	$default = array(
			
		'farad_nav_style' => 'numeric',
		
		'farad_post_style' => 'content',
		'farad_featured_image_control' => 'no',
		
		'farad_copyright_control' => 0,
		'farad_copyright' => '',
		
		'farad_reset_control' => 0
		
	);
	
	return $default;
	
}

/** Loads the Farad theme setting. */
function farad_get_settings() {
	global $farad;

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	if ( !isset( $farad->settings ) ) {
		$farad->settings = wp_parse_args( get_option( 'farad_options', farad_settings_default() ), farad_settings_default() );
	}
	
	/** return settings. */
	return $farad->settings;
}