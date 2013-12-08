<?php
/** Theme Custom Header */
$custom_header_support = array( 
	
	'default-image' => '%s/images/headers/header-default.png',
	'default-text-color' => '',
	'width' => apply_filters( 'farad_header_image_width', 280 ),
	'height' => apply_filters( 'farad_header_image_height', 46 ),
	'flex-height' => true,
	'header-text' => false,
	'wp-head-callback' => 'farad_header_style',
	'admin-head-callback' => 'farad_admin_header_style',
	'admin-preview-callback' => 'farad_admin_header_image'
	
);

add_theme_support( 'custom-header', $custom_header_support );

/** Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI. */
register_default_headers( array(
	
	'farad' => array(
		'url' => '%s/images/headers/header-default.png',
		'thumbnail_url' => '%s/images/headers/header-default-thumb.png',
		'description' => __( 'Farad', 'farad' )
	)

) );

/** Styles the header image and text displayed on the blog. */
function farad_header_style() {
}

/** Styles the header image displayed on the Appearance > Header admin panel. */
function farad_admin_header_style() {
?>
<style type="text/css">
.appearance_page_custom-header #header-image-wrapper {
	width: 940px;
	overflow: hidden;
	border: none;
}

#header-image-wrapper img {
	max-width: 100%;
	height: auto;
}

#header-custom-text-wrapper {
	margin: 18px 0;
}

#header-custom-text-wrapper a {
	text-decoration: none;
}

#header-custom-text-wrapper .site-name  {
	display: block;
	font-family: 'Oswald', sans-serif;
	font-size: 28px; 
	line-height: 34px; 
}

#header-custom-text-wrapper .site-description {
	display: block;
}
</style>
<?php
}

/** Styles the header image and text displayed on the blog preview. */
function farad_admin_header_image() {
?>
<div id="header-image-wrapper">	
  <?php if ( get_header_image() ) : ?>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" onclick="return false;"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
  <?php else: ?>
  <div id="header-custom-text-wrapper">
    <span class="site-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" onclick="return false;" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
    <span class="site-description"><?php bloginfo( 'description' ); ?></span>
  </div><!-- end of #logo -->
  <?php endif; ?>
</div>
<?php
}