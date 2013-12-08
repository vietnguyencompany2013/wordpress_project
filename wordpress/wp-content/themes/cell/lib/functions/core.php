<?php
/**
 * The core functions file for the Cell framework. Functions defined here are generally
 * used across the entire framework to make various tasks faster. This file should be loaded
 * prior to any other files because its functions are needed to run the framework.
 *
 * @package Cell
 * @subpackage Functions
 */

/** Function for setting the content width of a theme. */
function cell_set_content_width( $width = '' ) {
	global $content_width;
	$content_width = absint( $width );
}

/** Function for getting the theme's content width. */
function cell_get_content_width() {
	global $content_width;
	return $content_width;
}

/** Function for getting the theme's data */
function cell_theme_data( $path = 'template' ) {
	global $cell;
	
	/* If 'template' is requested, get the parent theme data. */
	if ( 'template' == $path ) {

		/* If the parent theme data isn't set, let grab it. */
		if ( empty( $cell->theme_data ) ) {
			
			$cell_theme_data = array();
			if( function_exists( 'wp_get_theme' ) ) {
			
				$theme_data = wp_get_theme();
				$cell_theme_data['Name'] = $theme_data->get( 'Name' );
				$cell_theme_data['ThemeURI'] = $theme_data->get( 'ThemeURI' );
				$cell_theme_data['AuthorURI'] = $theme_data->get( 'AuthorURI' );
				$cell_theme_data['Description'] = $theme_data->get( 'Description' );
				
				$cell->theme_data = $cell_theme_data;				
			
			} else {
			
				$theme_data = get_theme_data( CELL_DIR . 'style.css' );
				$cell_theme_data['Name'] = $theme_data['Name'];
				$cell_theme_data['ThemeURI'] = $theme_data['URI'];
				$cell_theme_data['AuthorURI'] = $theme_data['AuthorURI'];
				$cell_theme_data['Description'] = $theme_data['Description'];
				
				$cell->theme_data = $cell_theme_data;				
			
			}
		
		}

		/* Return the parent theme data. */
		return $cell->theme_data;
	}	

	/* Return false for everything else. */
	return false;
}
?>