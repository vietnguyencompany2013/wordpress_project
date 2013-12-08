<?php
/** Loads the Bandana theme setting. */
function bandana_get_settings() {
	global $bandana;

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	if ( !isset( $bandana->settings ) ) {
		$bandana->settings = get_option( 'bandana_options' );
	}
	
	/** return settings. */
	return $bandana->settings;
}
?>