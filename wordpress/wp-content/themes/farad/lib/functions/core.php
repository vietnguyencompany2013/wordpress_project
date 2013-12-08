<?php
/** Function for setting the content width of a theme. */
function farad_set_content_width( $width = '' ) {
	global $content_width;
	$content_width = absint( $width );
}

/** Function for getting the theme's content width. */
function farad_get_content_width() {
	global $content_width;
	return $content_width;
}

/** Function for getting the theme's data */
function farad_theme_data() {
	global $farad;
	
	/** If the parent theme data isn't set, let grab it. */
	if ( empty( $farad->theme_data ) ) {
		
		$farad_theme_data = array();
		$theme_data = wp_get_theme( 'farad' );
		$farad_theme_data['Name'] = $theme_data->get( 'Name' );
		$farad_theme_data['ThemeURI'] = $theme_data->get( 'ThemeURI' );
		$farad_theme_data['AuthorURI'] = $theme_data->get( 'AuthorURI' );
		$farad_theme_data['Description'] = $theme_data->get( 'Description' );
		
		$farad->theme_data = $farad_theme_data;
	
	}

	/** Return the parent theme data. */
	return $farad->theme_data;
}