/**
 * Functions file for loading custom Admin JS.
 *
 * @package Cell
 * @subpackage Functions
 */

(function($){
	
	/** jQuery Document Ready */
	$(document).ready(function(){
		
		$( '#cell_tabs' ).tabs({
			cookie: { expires: 1 }
		});
		
	});

	/** jQuery Windows Load */
	$(window).load(function(){
	});	

})(jQuery);