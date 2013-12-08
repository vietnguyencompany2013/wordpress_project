<?php
if ( !is_singular() ):
	bandana_loop_nav();	
elseif ( is_singular( 'post' ) ) :
	bandana_loop_nav_singular_post();
endif;
?>