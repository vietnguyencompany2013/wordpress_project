<?php get_header();	?>
<div class="container_wrap">
    
    <?php get_template_part( 'loop-meta' ); ?>
    
    <div class="container_12">
      <div id="content" class="grid_8">
        
        <?php if ( have_posts() ) : ?>
        
          <?php while ( have_posts() ) : the_post(); ?>
          
            <?php get_template_part( 'content', 'attachment' ); ?>
          
          <?php endwhile; ?>
        
        <?php else : ?>
                    
          <?php get_template_part( 'loop-error' ); ?>
        
        <?php endif; ?>
        
        <?php get_template_part( 'loop-nav' ); ?>
        
      </div> <!-- end #content -->
      <?php get_sidebar(); ?>
    </div>
  
</div>
<?php get_footer(); ?>