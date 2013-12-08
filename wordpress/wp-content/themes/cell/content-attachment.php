<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta">
    
	<?php if ( 'attachment' == get_post_type() ) : ?>
	<?php echo cell_post_date() . cell_post_comments() . cell_post_author(); ?>
    <?php if ( is_sticky() ) : printf( '<span class="entry-meta-sep"> &sdot; </span> <span class="entry-meta-featured">%1$s</span>', __( 'Featured', 'cell' ) ); endif; ?>
    <?php endif; ?>      
    
	<?php echo cell_post_edit_link(); ?>
  
  </div><!-- .entry-meta -->
  
  <?php cell_loop_nav_singular(); ?>
  
  <div class="entry-content entry-attachment">
  	<p><a href="<?php echo wp_get_attachment_url( $post->ID ); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></p>
    <?php the_excerpt(); ?>
	<div class="clear"></div>				
  </div> <!-- end .entry-content -->
  
  <?php echo cell_link_pages(); ?>
  
  <?php if ( 'post' == get_post_type() ) : ?>
  <div class="entry-meta-bottom">
  <?php echo cell_post_category() . cell_post_tags(); ?>
  </div><!-- .entry-meta -->
  <?php endif; ?>     

</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php cell_loop_nav_singular_attachment(); ?>

<?php comments_template( '', true ); ?>