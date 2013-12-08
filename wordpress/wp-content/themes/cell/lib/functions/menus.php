<?php
/**
 * The menus functions deal with registering nav menus within WordPress for the core framework.
 *
 * @package Cell
 * @subpackage Functions
 */

/** Register nav menus. */
add_action( 'init', 'cell_register_menus' );

/** Registers the the core menus */
function cell_register_menus() {

	/** Get theme-supported menus. */
	$menus = get_theme_support( 'cell-core-menus' );
	
	/** If there is no array of menus IDs, return. */
	if ( !is_array( $menus[0] ) ) {
		return;
	}
	
	/* Register the 'primary' menu. */
	if ( in_array( 'cell-primary-menu', $menus[0] ) ) {
		register_nav_menu( 'cell-primary-menu', __( 'Cell Primary Menu', 'cell' ) );
	}
	
}
?>