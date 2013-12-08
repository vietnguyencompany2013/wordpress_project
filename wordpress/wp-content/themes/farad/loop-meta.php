<?php if ( is_category() ) : ?>  

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . ucwords( strtolower ( single_cat_title( '', false ) ) ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php echo category_description(); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_tag() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . ucwords( strtolower ( single_tag_title( '', false ) ) ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php echo tag_description(); ?></div>
      </div>
    </div>
  </div>
</div>

<?php 
elseif ( is_author() ) :
$user_id = get_query_var( 'author' );
?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . ucwords( strtolower ( get_the_author_meta( 'display_name', $user_id ) ) ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_search() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . ucwords( strtolower ( esc_attr ( get_search_query() ) ) ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php printf( __( 'You are browsing the search results for %s', 'farad' ), esc_attr( get_search_query() ) ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_day() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . get_the_date() . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by date.', 'farad' ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_month() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by month.', 'farad' ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_year() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php printf( __( '%s', 'farad' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?></h1>
        <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by year.', 'farad' ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_archive() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php _e( 'Archives', 'farad' ); ?></h1>
        <div class="loop-meta-description"><?php _e( 'You are browsing the site archives.', 'farad' ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php elseif ( is_404() ) : ?>

<div id="loop-meta">
  <div id="loop-meta-inside">
    <div class="container_16">
      <div class="grid_16">    
        <h1 class="loop-meta-title"><?php _e( '404', 'farad' ); ?></h1>
        <div class="loop-meta-description"><?php _e( 'Whoah! You broke something!', 'farad' ); ?></div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>