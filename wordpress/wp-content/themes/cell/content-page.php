<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <?php $entry_title = ( cell_post_edit_link() == "" )? 'entry-title entry-title-single entry-title-page' : 'entry-title entry-title-single'; ?>
  <h1 class="<?php echo $entry_title; ?>"><?php the_title(); ?></h1>
  
  <?php if ( cell_post_edit_link() != "" ) : ?>  
  <div class="entry-meta"> 
    <?php echo cell_post_edit_link(); ?> 
  </div>  
  <?php endif;?>
  
  <div class="entry-content">
  	<?php the_content(); ?>
	<div class="clear"></div>				
  </div> <!-- end .entry-content -->
  
  <?php echo cell_link_pages(); ?>
  
</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php comments_template( '', true ); ?>