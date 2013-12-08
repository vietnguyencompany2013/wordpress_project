<?php
/**
 * Functions for dealing with theme settings on both the front end of the site and the admin.
 *
 * @package Cell
 * @subpackage Functions
 */

/** Loads the Cell theme setting. */
function cell_get_settings() {
	global $cell;

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	if ( !isset( $cell->settings ) ) {
		$cell->settings = get_option( 'cell_options' );
	}
	
	/** return settings. */
	return $cell->settings;
}
?>