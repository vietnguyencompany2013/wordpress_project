<?php
/** Register nav menus. */
add_action( 'init', 'farad_register_menus' );

/** Registers the the core menus */
function farad_register_menus() {

	/* Register the 'primary' menu. */
	register_nav_menu( 'farad-primary-menu', __( 'Farad Primary Menu', 'farad' ) );
	
}