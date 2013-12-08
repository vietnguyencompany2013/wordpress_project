<?php get_header();	?>

<div class="container_16">
  
  <div class="grid_11">
    <div id="content">	  
	  
	  <?php if ( have_posts() ) : ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
        
          <?php get_template_part( 'content', 'attachment' ); ?>
        
        <?php endwhile; ?>
      
      <?php else : ?>
                  
        <?php get_template_part( 'loop-error' ); ?>
      
      <?php endif; ?>
      
    </div>
  </div>
  
  <?php get_sidebar(); ?>

</div>
  
<?php get_footer(); ?>