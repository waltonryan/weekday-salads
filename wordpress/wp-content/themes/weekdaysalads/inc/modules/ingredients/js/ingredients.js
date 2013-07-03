jQuery(function($) {
	var Ingredients_List = function() {
		$( '.ingredients li' ).each(function() {
			var item = $( this );
			
			$( '<span></span>', {
				'rel'   : item.attr( 'id' ),
				'class' : 'check'
			}).appendTo( item );
		});
	}
	
	Ingredients_List();
});