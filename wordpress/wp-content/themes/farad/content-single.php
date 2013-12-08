<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta entry-meta-top">
	<?php echo farad_post_date() . farad_post_author() . farad_post_comments() . farad_post_edit_link(); ?>
  </div>
  
  <div class="entry-content-wrapper clearfix">	
    <div class="entry-content entry-content-single">
	  <?php the_content(); ?>
    </div>
  </div>
  
  <?php echo farad_link_pages(); ?>
  
  <div class="entry-meta entry-meta-bottom">
  <?php echo farad_post_category() . farad_post_tags(); ?>
  </div><!-- .entry-meta -->

</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php farad_author(); ?> 

<?php comments_template( '', true ); ?>