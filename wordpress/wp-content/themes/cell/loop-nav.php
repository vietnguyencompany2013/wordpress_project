<?php
if ( !is_singular() ):

	cell_loop_nav();
	
elseif ( is_singular( 'post' ) ) :

	cell_loop_nav_singular_post();

endif;
?>