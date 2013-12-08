<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h2 class="entry-title entry-title-page"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    
  <div class="entry-content-wrapper clearfix">	
    
	<?php farad_featured_image(); ?>
    
    <?php if ( farad_post_edit_link() != '' ): ?>
    <div class="entry-meta entry-meta-top">
      <?php echo farad_post_edit_link(); ?>
    </div>
    <?php endif; ?>
    
    <div class="entry-content">
	  <?php farad_post_style(); ?>
    </div>
  
  </div>
  
  <?php echo farad_link_pages(); ?>
      
</div>