<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-page"><?php the_title(); ?></h1>
  
  <?php if ( farad_post_edit_link() != '' ) : ?>  
  <div class="entry-meta entry-meta-top">
    <?php echo farad_post_edit_link(); ?> 
  </div>  
  <?php endif;?>
  
  <div class="entry-content-wrapper clearfix">	
    <div class="entry-content entry-content-single">
	  <?php the_content(); ?>
    </div>
  </div>
  
  <?php echo farad_link_pages(); ?>
  
</div>

<?php comments_template( '', true ); ?>