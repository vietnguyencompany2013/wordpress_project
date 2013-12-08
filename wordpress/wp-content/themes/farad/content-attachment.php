<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta entry-meta-top">   
	  <?php echo farad_post_date() . farad_post_comments() . farad_post_author() . farad_post_edit_link(); ?>
  </div>
  
  <div class="entry-content-wrapper clearfix">	
    
    <?php farad_loop_nav_singular(); ?>
    
    <div class="entry-content entry-attachment entry-content-single">
	  <p><a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" rel="prettyPhoto"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></p>
      <?php the_excerpt(); ?>
    </div>
  
  </div>
  
</div>

<?php farad_loop_nav_singular_attachment(); ?>

<?php comments_template( '', true ); ?>