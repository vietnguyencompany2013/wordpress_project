<?php if ( is_category() ) : ?>      

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Category Archives: %s', 'cell' ), '<span>' . ucwords( strtolower ( single_cat_title( '', false ) ) ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php echo category_description(); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_tag() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Tag Archives: %s', 'cell' ), '<span>' . ucwords( strtolower ( single_tag_title( '', false ) ) ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php echo tag_description(); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php 
elseif ( is_author() ) :
$user_id = get_query_var( 'author' );
?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Author Archives: %s', 'cell' ), '<span>' . ucwords( strtolower ( get_the_author_meta( 'display_name', $user_id ) ) ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_search() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Search Results: %s', 'cell' ), '<span>' . ucwords( strtolower ( esc_attr ( get_search_query() ) ) ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php printf( __( 'You are browsing the search results for %s', 'cell' ), esc_attr( get_search_query() ) ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_day() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Daily Archives: %s', 'cell' ), '<span>' . get_the_date() . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by date.', 'cell' ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_month() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Monthly Archives: %s', 'cell' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by month.', 'cell' ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_year() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php printf( __( 'Yearly Archives: %s', 'cell' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?></h1>
      <div class="loop-meta-description"><?php _e( 'You are browsing the site archives by year.', 'cell' ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php elseif ( is_archive() ) : ?>

<div class="container_12">
  <div class="grid_12">
    <div id="loop-meta">
      <h1 class="loop-meta-title"><?php _e( 'Archives', 'cell' ); ?></h1>
      <div class="loop-meta-description"><?php _e( 'You are browsing the site archives.', 'cell' ); ?></div>
    </div> <!-- #loop-meta -->
  </div>
</div>

<?php endif; ?>