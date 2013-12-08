<?php get_header();	?>

<?php get_template_part( 'loop-meta' ); ?>
  
<div class="container_16 clearfix">
  
  <div class="grid_11">
    <div id="content">	  
	  
	  <?php if ( have_posts() ) : ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
        
          <?php 
		  if( get_post_type() == 'page' ) {			
			get_template_part( 'content-search', 'page' );			  		  
		  } else {
			get_template_part( 'content' );			
		  }
		  ?>
        
        <?php endwhile; ?>
      
      <?php else : ?>
                  
        <?php get_template_part( 'loop-error' ); ?>
      
      <?php endif; ?>
      
      <?php farad_loop_nav(); ?>
    
    </div> <!-- end #content -->
  </div> <!-- end .grid_11 -->
  
  <?php get_sidebar(); ?>

</div> <!-- end .container_16 -->
  
<?php get_footer(); ?>