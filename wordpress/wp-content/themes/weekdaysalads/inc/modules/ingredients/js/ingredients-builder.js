jQuery(function($) {
	var Metabox = $( '#foodie_ingredients .inside' ),
		Table   = Metabox.find( 'table' ),
		Tbody   = Table.children( 'tbody' ),
		Adding  = Tbody.children( 'tr#new-ingredient' ),
		Loader  = $( '#saving-ingredients' ),

		Foodie_Ingredients_Builder = {
				
			Init : function() {
				this.Sortable();
				this.Commands();
			},
			
			Commands : function() {
				/** save */
				$( '#save-ingredients' ).click(function(e) {
					/** if there is nothing new, just save what is there */
					if ( Adding.find( '.ingredient-name' ).val() == '' )
						Foodie_Ingredients_Builder.Save();
					else
						Foodie_Ingredients_Builder.Insert_Item();
					
					return e.preventDefault();
				});
				
				/** remove an item */
				$( 'td.remove a' ).live( 'click', function(e) {
					/** hide and remove row */
					$( this ).parent().parent().fadeOut( 'slow' ).remove();
					
					/** save */
					Foodie_Ingredients_Builder.Save();
					
					return e.preventDefault();
				});
				
				/** servings increase */
				$( '#foodie_servings' ).change(function() {
					Foodie_Ingredients_Builder.Save();
				});
			},
			
			Insert_Item : function() {
				/** clone what has been entered */
				var ingredient = Adding.clone(),
					newname    = Math.floor( Math.random() * 100 );
				
				/** remove IDs and classes, and add a remove link */
				ingredient
					.removeClass( 'fixed' )
					.attr( 'id', '' )
					.find( 'td.remove' )
					.html( '<a href="#">Remove</a>' );
				
				/** insert the cloned row, and remove any placeholds */
				ingredient
					.insertBefore( Adding )
					.find( '.ingredient-unit' ).val( Adding.find( 'select' ).val() )
					.end()
					.find( 'input, select' ).each(function() {
						var name = $( this ).attr( 'name' );
						
						name = name.replace( /\[(\d+)\]/, function() {
							return '[' + newname + ']'
						});
						
						$( this )
							.attr( 'name', name )
							.attr( 'placeholder', '' );
					});
				
				/** reset the blank row to add more */
				Adding.find( 'td input' ).val( '' );
				
				/** save everything */
				Foodie_Ingredients_Builder.Save();
			},
			
			Sortable : function() {
				Tbody.sortable({
					items       : 'tr:not(.fixed)',
					axis        : 'y',
					containment : 'parent',
					stop        : function( event, ui ){
						Foodie_Ingredients_Builder.Save();
					},
					helper      : function( e, tr ) {
						var originals = tr.children();
						var helper    = tr.clone();
						
						helper.children().each(function(index){
							$(this).width( originals.eq( index ).width() );
						});
						
						return helper;
					}
				});
			},
			
			Save : function() {
				Loader.fadeIn();
				
				var ingredients = new Array(),
					servings    = $( '#foodie_servings' ).val(),
					price       = $( '#foodie_price' ).val();
				
				/** loop through each row and create the array to POST */
				Tbody.children( 'tr:not(.fixed)' ).each(function() {
					var row    = $( this ),
						name   = row.find( '.ingredient-name' ).val(),
						note   = row.find( '.ingredient-note' ).val(),
						amount = row.find( '.ingredient-amount' ).val(),
						unit   = row.find( '.ingredient-unit' ).val();
					
					if ( name == 'undefined' || name == '' )
						return;
					
					ingredients.push( {
						'name'   : name,
						'note'   : note,
						'amount' : amount,
						'unit'   : unit
					} );
				})
				
				/** gather all of the information */
				var data = {
					action        : 'foodie_metabox_post_ingredients_builder_save',
					_foodie_nonce : Metabox.find( '#_foodie_nonce' ).val(),
					ingredients   : ingredients,
					servings      : servings,
					price         : price,
					post_type     : 'post',
					post_id       : $( '#post_ID' ).val()
				}
				
				/** make the POST request */
				$.post( ajaxurl, data, function( result ) {
					Loader.fadeOut();
				});
			}
			
		};
		
	Foodie_Ingredients_Builder.Init();
});