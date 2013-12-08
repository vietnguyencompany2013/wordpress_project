<?php
/** Load the Core Files */
require_once( trailingslashit( get_template_directory() ) . 'lib/init.php' );
new Cell();

/** Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'cell_theme_setup' );

/** Theme setup function. */
function cell_theme_setup() {
	
	/** Add theme support for core framework features. */
	add_theme_support( 'cell-core-menus', array( 'cell-primary-menu' ) );
	add_theme_support( 'cell-core-sidebars', array( 'cell-primary-sidebar' ) );
	add_theme_support( 'cell-core-featured-image' );
	add_theme_support( 'cell-core-custom-header' );
	
	/** Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	
	/** Add theme support for Custom Background. */
	if ( function_exists( 'get_custom_header' ) ) {
		add_theme_support( 'custom-background', array( 'default-color' => 'e2e2e2', 'default-image' => '%s/images/circles.png', 'wp-head-callback' => 'cell_custom_background_callback' ) );
	} else {
		add_custom_background( 'cell_custom_background_callback' );
	}
	
	/** Set content width. */
	cell_set_content_width( 580 );
	
	/** Add custom image sizes. */
	add_action( 'init', 'cell_add_image_sizes' );	

}

/** Adds custom image sizes */
function cell_add_image_sizes() {
	add_image_size( 'featured', 568, 200, true );
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 */
function cell_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) ) {
		return;
	}

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php
}
?>