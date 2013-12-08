<?php
/**
 * Additional helper functions that the framework or themes may use.  The functions in this file are functions
 * that don't really have a home within any other parts of the framework.
 *
 * @package Cell
 * @subpackage Functions
 */

/** Cell Post Date */
function cell_post_date() {
	
	$post_date = esc_html( get_the_date() ) . " " . esc_attr( get_the_time() );
	
	/** Output */
	$output = sprintf( '<span class="entry-date" title="%1$s"><a href="%2$s" title="%3$s" rel="bookmark">%1$s</a></span>', $post_date, esc_url( get_permalink() ), the_title_attribute( 'echo=0' ) );
	return $output;

}

/** Cell Post Author */
function cell_post_author() {
	
	$output = sprintf( '<span class="entry-meta-sep"> &sdot; </span><span class="entry-author author vcard"><a href="%1$s" title="'. __( 'by %2$s', 'cell' ) .'" rel="author">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );
	return $output;

}

/** Cell Post Edit Link */
function cell_post_edit_link() {

	/** Manipulation */	
	ob_start();
	if ( 'post' == get_post_type() ) :
	edit_post_link( __( 'Edit', 'cell' ), '<span class="entry-meta-sep"> &sdot; </span><span class="edit-link">', '</span>' );
	else:
	edit_post_link( __( 'Edit', 'cell' ), '<span class="edit-link">', '</span>' );
	endif;
	$output = ob_get_clean();
	
	return $output;

}

/** Cell Post Comments */
function cell_post_comments() {
	
	if ( ( ! comments_open() || post_password_required() ) ) {
		return;
	}

	ob_start();
	comments_number( __( 'Leave a Comment', 'cell' ), __( '1 Comment', 'cell' ), __( '% Comments', 'cell' ) );
	$comments = ob_get_clean();
	
	/** Output */
	$comments = sprintf( '<a href="%s">%s</a>', esc_url( get_comments_link() ), $comments );
	$output = sprintf( '<span class="entry-meta-sep"> &sdot; </span><span class="comments-link">%1$s</span>', $comments );
	return $output;
}

/** Cell Post Categories */
function cell_post_category() {
	
	$categories_list = get_the_category_list( ', ' );
	if ( ! $categories_list ) {
		return;
	}
		
	$output = sprintf( '<span class="cat-links"><span class="%1$s">'. __( 'Posted in:', 'cell' ) .'</span> %2$s</span>', 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
	return $output;
}

/** Cell Post Tags */
function cell_post_tags() {
	
	$tags_list = get_the_tag_list( '', ', ' );
	if ( ! $tags_list ) {
		return;
	}
		
	$output = sprintf( '<span class="entry-meta-sep"> &sdot; </span><span class="tag-links"><span class="%1$s">'. __( 'Tagged:', 'cell' ) .'</span> %2$s</span>', 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
	return $output;
}

/** Cell Link Pages */
function cell_link_pages() {
	return wp_link_pages( array( 
		
		'before' => '<div class="page-link"><span class="assistive-text">'. __( 'Pages:', 'cell' ) .'</span>',
		'after' => '</div>',
		'link_before' => '<span>',
		'link_after' => '</span>',
		'echo' => 0
		
		)
	);
}

/** Cell Post Style */
function cell_post_style() {
	
	$cell_options = cell_get_settings();
	
	if( $cell_options['cell_post_style'] == 'excerpt' ):		
		the_excerpt();	
	else:		
		the_content( __( 'Read More', 'cell' ) . ' <span class="meta-nav">&rarr;</span>' );	
	endif;

}

/** Cell Featured Image */
function cell_featured_image() {
	
	$cell_options = cell_get_settings();
	
	if( $cell_options['cell_post_style'] != 'excerpt' ):		
		return;
	endif;
	
	$img = cell_get_image( array( 'format' => 'html', 'size' => 'featured', 'attr' => array( 'class' => 'entry-image' ) ) );
	
	if( empty( $img ) ):		
		return;
	endif;
	
	printf( '<div class="entry-featured-image"><a href="%s" title="%s">%s</a></div>', esc_url( get_permalink() ), the_title_attribute( 'echo=0' ), $img );

}

/** Cell Loop Navigation */
function cell_loop_nav() {

	global $wp_query;	
	
	if ( $wp_query->max_num_pages > 1 ) :
		
		$cell_options = cell_get_settings();
		
		if ( $cell_options['cell_post_nav_style'] == 'numeric' ) :		
			
			cell_loop_nav_numeric();		
		
		else:		
			
			cell_loop_nav_next_prev();		
		
		endif;
	
	endif;

}

/** Cell Loop Navigation Numeric */
function cell_loop_nav_numeric() {
	
	global $wp_query;
	$big = 999999999; // Need an unlikely integer
	$args = array(
		'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	);
	
?>
<div id="loop-nav-numeric" class="nav-numeric">
  <h3 class="assistive-text"><?php _e( 'Post Navigation', 'cell' ); ?></h3>
  <?php echo paginate_links( $args ); ?>
  <div class="clear"></div>
</div> <!-- end #loop-nav-numeric -->
<?php	
}

/** Cell Loop Navigation Next/Prev */
function cell_loop_nav_next_prev() {
	
	ob_start();
	next_posts_link( '<span class="meta-nav">&larr;</span> '. __( 'Older Posts', 'cell' ) );
	$next_posts_link = ob_get_clean();
	
	ob_start();
	previous_posts_link( __( 'Newer Posts', 'cell' ) .' <span class="meta-nav">&rarr;</span>' );
	$previous_posts_link = ob_get_clean();
	
	$next_posts_link = ( empty( $next_posts_link ) )? '&nbsp;' : $next_posts_link;
	$previous_posts_link = ( empty( $previous_posts_link ) )? '&nbsp;' : $previous_posts_link;	

?>
<div id="loop-nav-next-prev">
  <h3 class="assistive-text"><?php _e( 'Post Navigation', 'cell' ); ?></h3>
  <div class="loop-nav-previous grid_4 alpha">
    <?php echo $next_posts_link; ?>
  </div>
  <div class="loop-nav-next grid_4 omega">
	  <?php echo $previous_posts_link; ?>
  </div>
  <div class="clear"></div>
</div> <!-- end #loop-nav-next-prev -->
<?php
}

/** Cell Loop Navigation Singular Post */
function cell_loop_nav_singular_post() {
	
	ob_start();
	previous_post_link( '%link', '<span class="meta-nav">&larr;</span> '. __( 'Previous Post', 'cell' ) );
	$previous_post_link = ob_get_clean();
	  
	ob_start();
	next_post_link( '%link', __( 'Next Post', 'cell' ) . ' <span class="meta-nav">&rarr;</span>' );
	$next_post_link = ob_get_clean();
	  
	$previous_post_link = ( empty( $previous_post_link ) )? '&nbsp;' : $previous_post_link;	
	$next_post_link = ( empty( $next_post_link ) )? '&nbsp;' : $next_post_link;

?>
<div id="loop-nav-singlular-post">
  <h3 class="assistive-text"><?php _e( 'Post Navigation', 'cell' ); ?></h3>
  <div class="loop-nav-previous grid_4 alpha">
    <?php echo $previous_post_link; ?>
  </div>
  <div class="loop-nav-next grid_4 omega">
	  <?php echo $next_post_link; ?>
  </div>
  <div class="clear"></div>    
</div><!-- end #loop-nav-singular-post -->
<?php
}

/** Cell Loop Navigation Singular */
function cell_loop_nav_singular() {
	global $post;
?>
<div id="loop-nav-singular">
  <h3 class="assistive-text"><?php _e( 'Post Navigation', 'cell' ); ?></h3>
  <div class="loop-nav-standard"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"> <?php _e( '&larr; Return to', 'cell' ); ?> <?php echo get_the_title( $post->post_parent ); ?></a></div>
</div><!-- end #loop-nav-singular -->
<?php
}

/** Cell Loop Navigation Singular Attachment */
function cell_loop_nav_singular_attachment() {
	
	ob_start();
	previous_image_link( 'thumbnail' );
	$previous_image_link = ob_get_clean();
	  
	ob_start();
	next_image_link( 'thumbnail' );
	$next_image_link = ob_get_clean();
	  
	$previous_image_link = ( empty( $previous_image_link ) )? '&nbsp;' : '<p>' . $previous_image_link . '</p>';	
	$next_image_link = ( empty( $next_image_link ) )? '&nbsp;' : '<p>' . $next_image_link . '</p>';

?>
<div id="loop-nav-singlular-attachment">
  <h3 class="assistive-text"><?php _e( 'Attachment Navigation', 'cell' ); ?></h3>
  <div class="loop-nav-previous grid_4 alpha">
    <?php echo $previous_image_link; ?>
  </div>
  <div class="loop-nav-next grid_4 omega">
	  <?php echo $next_image_link; ?>
  </div>
  <div class="clear"></div>    
</div><!-- end #loop-nav-singular-attachment -->
<?php
}

/** Cell Author */
function cell_author() {
if ( get_the_author_meta( 'description' ) && is_multi_author() ) :	
?>
<div id="author-info">
  
  <div id="author-avatar" class="grid_2 alpha">
    <div id="author-avatar-inside">  
	  <?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
    </div>
  </div> <!-- #author-avatar -->
  
  <div id="author-description" class="grid_5 omega">    
      <h3><?php printf( __( 'About %s', 'cell' ), get_the_author() ); ?></h3>
      <p><?php the_author_meta( 'description' ); ?></p>
      <div id="author-link">
        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf( __( 'View all posts by %s', 'cell' ) . ' <span class="meta-nav">&rarr;</span>', get_the_author() ); ?></a>
      </div> <!-- #author-link	-->  
  </div> <!-- #author-description -->
  
  <div class="clear"></div>
</div> <!-- #author-info -->
<?php
endif;
}

/** Cell Footer */
add_action( 'cell_footer', 'cell_footer_init' );
function cell_footer_init() {
	
	$cell_theme_data = cell_theme_data();
	$cell_options = cell_get_settings();	

?>
<div class="cell-blog grid_8 alpha">
  <?php echo htmlspecialchars_decode ( esc_html ( $cell_options['cell_copyright'] ) ); ?>
</div>
<div class="cell-project grid_4 omega">
  <?php _e( 'Designed by', 'cell' )?> <a href="<?php echo $cell_theme_data['AuthorURI']; ?>" title="DesignOrbital">DesignOrbital</a> &sdot; <a href="http://wordpress.org/" title="WordPress">WordPress</a>
</div>
<div class="clear"></div>
<?php	
}

/** Cell Comment List */
function cell_comment( $comment, $args, $depth ) {
  
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) {
		case 'pingback':
		case 'trackback':
?>
			<li class="post pingback">
				<p><?php _e( 'Pingback:', 'cell' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'cell' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
		break;
		default:
		?>
			
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				
				<div id="comment-<?php comment_ID(); ?>" class="comment">
	    
					<div class="comment-meta">
						<div class="comment-author vcard">
		    
							<?php
                            $avatar_size = 60;
                            if ( '0' != $comment->comment_parent ) {
                            	$avatar_size = 60;
                            }                            
                            echo get_avatar( $comment, $avatar_size );
							?>
                            
                            <?php                            
                            printf( '%1$s on %2$s <span class="says">%3$s</span>',
                            	sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                            	sprintf( '<a href="%1$s"><span pubdate datetime="%2$s">%3$s</span></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ), sprintf( '%1$s at %2$s', get_comment_date(), get_comment_time() ) ),
								__( 'said:', 'cell' )
                            );                            
                            ?>

							<?php edit_comment_link( __( 'Edit', 'cell' ), '<span class="edit-link">', '</span>' ); ?>
		  
						</div> <!-- end .comment-author .vcard -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'cell' ); ?></em><br />
						<?php endif; ?>

					</div> <!-- end .comment-meta -->

					<div class="comment-content">
					  <?php comment_text(); ?>
                    </div> <!-- end .comment-content -->

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'cell' ) . '<span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
		
				</div><!-- end #comment-<?php comment_ID(); ?> -->

		<?php
		break;
	
	} // switch ( $comment->comment_type )

}

/** Filter 'wp_title' to output contextual content. */
add_filter( 'wp_title', 'cell_wp_title', 10, 2 );
function cell_wp_title( $title, $separator ) {
	
	/** Don't affect wp_title() calls in feeds. */
	if ( is_feed() ) {
		return $title;
	}

	/**
	 * The $paged global variable contains the page number of a listing of posts.
	 * The $page global variable contains the page number of a single post that is paged.
	 * We'll display whichever one applies, if we're not looking at the first page.
	 */
	global $paged, $page;

	if ( is_search() ) {		
		
		/** If we're a search, let's start over: */
		$title = sprintf( 'Search results for %s', '"' . get_search_query() . '"' );
		/** Add a page number if we're on page 2 or more: */
		if ( $paged >= 2 ) {
			$title .= " ". $separator ." " . sprintf( 'Page %s', $paged );
		}
		/** Add the site name to the end: */
		$title .= " ". $separator ." " . get_bloginfo( 'name', 'display' );
		/** We're done. Let's send the new title back to wp_title(): */
		return $title;
	
	}

	/** Otherwise, let's start by adding the site name to the end: */
	$title .= get_bloginfo( 'name', 'display' );

	/** If we have a site description and we're on the home/front page, add the description: */
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " ". $separator ." " . $site_description;
	}

	/** Add a page number if necessary: */
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $separator " . sprintf( 'Page %s', max( $paged, $page ) );
	}

	/** Return the new title to wp_title(): */
	return $title;
}

/** Sets the post excerpt length. */
add_filter( 'excerpt_length', 'cell_excerpt_length' );
function cell_excerpt_length( $length ) {
	return 55;
}

/** Returns a "Read more" link for content */
add_filter( 'the_content_more_link', 'cell_content_more_link', 10, 2 );
function cell_content_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, '<span>'. __( 'Read More', 'cell' ) .'</span>', $more_link );
}

/** Returns a "Read more" link for excerpts */
function cell_continue_reading_link() {
	return '<span class="more-link-wrap"><a href="'. esc_url( get_permalink() ) . '" class="more-link"><span>'. __( 'Continue Reading', 'cell' ) .'</span></a></span>';
}

/** Replaces "[...]" (appended to automatically generated excerpts) with cell_continue_reading_link(). */
add_filter( 'excerpt_more', 'cell_auto_excerpt_more' );
function cell_auto_excerpt_more( $more ) {
	return ' <span class="ellipsis">&hellip;</span> ' . cell_continue_reading_link();
}	

/** Adds a pretty "Read more" link to custom post excerpts. */
add_filter( 'get_the_excerpt', 'cell_custom_excerpt_more' );
function cell_custom_excerpt_more( $output ) {
	
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= ' <span class="ellipsis">&hellip;</span> ' . cell_continue_reading_link();
	}
	return $output;

}

/** Remove WP Gallery CSS */
add_filter( 'use_default_gallery_style', '__return_false' );
?>