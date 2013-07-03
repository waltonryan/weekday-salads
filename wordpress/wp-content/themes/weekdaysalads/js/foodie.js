jQuery(function($) {

	/**
	 * Enhance the appearenace and functionality
	 * of certain elements via some jQuery magic.
	 */
	var Foodie_Enhancements = {
		
		Init : function() {
			this.Galleries();
			this.Instructions();
			this.Copy();
			this.Comments();
		},
		
		Galleries : function() {
			$( '.flexslider' ).flexslider({
				controlNav : false,
				slideshow  : false,
			});
		},
				
		Instructions : function() {
			$( '.instructions' ).addClass( 'styled' );
			
			/** Starting at the list level resets the index */
			$( '.instructions' ).each(function() {
				$( this ).find( 'li' ).each(function(i ) {
					var i = i + 1;
					
					$( this ).prepend( '<span class="bullet">' + i + '</span>' );
				});
			});
		},
		
		Copy : function() {
			$( 'h3.section' ).each(function() {
				if ( $( this ).children().length == 0 )
					$( this ).wrapInner( '<span></span>' );
			});
		},
		
		Comments : function() {
			$( '#comment' ).focus(function() {
				$( this ).parent( 'p' ).addClass( 'focused' );
			}).blur(function() {
				$( this ).parent( 'p' ).removeClass( 'focused' );
			});
			
			if( $( '#comment' ).length > 0 ) {
				$( '#comment' ).autogrow();
			}
		}
	};
	
	Foodie_Enhancements.Init();
});