<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <div class="entry-content-wrapper clearfix">	
    
    <div class="entry-meta entry-meta-top">
	  <?php echo farad_post_format() . farad_post_date(); ?>
    </div>
    
    <div class="entry-content">
	  <?php the_content(); ?>
    </div>
  
  </div>  
      
</div>