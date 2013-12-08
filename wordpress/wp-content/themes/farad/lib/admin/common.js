(function($){
	
	/** Options Tabs */
	function faradOptionsTabs() {
		
		var relid = $.cookie( 'farad_tab_relid' );
		
		if( relid >= 1  ) {
			faradOptionsTabControl( relid );
		} else {
			faradOptionsTabControl( 0 );
		}
		
		$( '.farad-group-tab-link-a' ).click( function() {
			
			relid = $(this).attr( 'data-rel' );
			$.cookie( 'farad_tab_relid', relid );
			faradOptionsTabControl( relid );		
			
		});
		
	}
	
	function faradOptionsTabControl( relid ) {
		
		$( '.farad-group-tab' ).each( function() {
				
			if( $(this).attr( 'id' ) == relid + '_section_group' ) {					
				$(this).delay( 400 ).fadeIn( 1200 );				
			} else{					
				$(this).fadeOut( 'fast' );
			}
			
		});
		
		$( '.farad-group-tab-link-li' ).each( function() {
			
			if( $(this).attr('id') != relid + '_section_group_li' && $(this).hasClass( 'active' ) ) {					
				$(this).removeClass( 'active' );				
			}
			
			if( $(this).attr('id') == relid + '_section_group_li' ) {					 
				 $(this).addClass('active');				
			}
		
		});
		
	}
	
	/** jQuery Document Ready */
	$(document).ready(function(){		
		faradOptionsTabs();		
	});

	/** jQuery Windows Load */
	$(window).load(function(){
	});	

})(jQuery);