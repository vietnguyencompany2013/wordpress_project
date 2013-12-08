<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta">
    
	<?php if ( 'post' == get_post_type() ) : ?>
	<?php echo cell_post_date() . cell_post_comments() . cell_post_author(); ?>
    <?php if ( is_sticky() ) : printf( '<span class="entry-meta-sep"> &sdot; </span> <span class="entry-meta-featured">%1$s</span>', __( 'Featured', 'cell' ) ); endif; ?>
    <?php endif; ?>      
    
	<?php echo cell_post_edit_link(); ?>
  
  </div><!-- .entry-meta -->
  
  <div class="entry-content">
  	<?php the_content(); ?>
	<div class="clear"></div>				
  </div> <!-- end .entry-content -->
  
  <?php echo cell_link_pages(); ?>
  
  <?php if ( 'post' == get_post_type() ) : ?>
  <div class="entry-meta-bottom">
  <?php echo cell_post_category() . cell_post_tags(); ?>
  </div><!-- .entry-meta -->
  <?php endif; ?>     

</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php cell_author(); ?> 

<?php comments_template( '', true ); ?>