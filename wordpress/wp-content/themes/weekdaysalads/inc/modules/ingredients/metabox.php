<?php
/**
 * Ingredients builder metabox. Handles the creation, saving, and
 * removing of ingredients.
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Create the metabox
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_ingredients_builder() {
	add_meta_box( 'foodie_ingredients', __( 'Ingredients', 'dealotto' ), 'foodie_metabox_post_ingredients_builder_box', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'foodie_metabox_post_ingredients_builder' );

/**
 * Fill the created metabox with content.
 *
 * This includes looping through all of the existing ingredients, while
 * providing the ability to add more via an empty field.
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_ingredients_builder_box( $post ) {
	/** Verification Field */
	wp_nonce_field( 'foodie-ingredients-builder', '_foodie_nonce' );

	/** Get Previous Value */
	$ingredients = get_post_meta( $post->ID, 'ingredients', true );
	$servings    = get_post_meta( $post->ID, 'servings', true );
	$price       = get_post_meta( $post->ID, 'price', true );
	
	if ( ! $servings )
		$servings = 1;
?>
	<div id="postcustomstuff">
	
		<p>
			<label for="foodie_servings"><?php _e( 'Number of Servings:', 'foodie' ); ?></label>
			<input type="number" step="1" min="1" id="foodie_servings" name="servings" class="small-text" value="<?php echo intval( $servings ); ?>" />
			&nbsp; &mdash; &nbsp;
			<label for="foodie_price"><?php printf( __( 'Price of Ingredients (%s):', 'foodie' ), foodie_get_currency() ); ?></label>
			<input type="number" step=".01" min="0" id="foodie_price" name="price" class="small-text" value="<?php echo $price; ?>" />
		</p>
	
		<p><strong><?php _e( 'Add Ingredients:', 'dealotto' ); ?></strong></p>
	
		<table id="newmeta" class="widefat ui-sortable">
			<thead>
				<tr>
					<th width="45%"><label><?php _e( 'Name', 'foodie' ); ?></label></th>
					<th width="35%"><label><?php _e( 'Description', 'foodie' ); ?></label></th>
					<th width="130px"><label><?php _e( 'Amount', 'foodie' ); ?></label></th>
					<th width="45px"></th>
				</tr>
			</thead>
			<tbody class="the-list" style="background:white;">
				<?php if ( $ingredients ) : foreach ( $ingredients as $id => $ingredient ) : $id++; ?>
				<tr class="alternate">
					<td>
						<input type="text" name="ingredients[<?php echo absint( $id ); ?>][name]" value="<?php echo esc_attr( $ingredient[ 'name' ] ); ?>" class="ingredient-name"style="width:95%" />
					</td>
					<td>
						<input type="text" name="ingredients[<?php echo absint( $id ); ?>][note]" value="<?php echo esc_attr( $ingredient[ 'note' ] ); ?>" class="ingredient-note"style="width:95%" />
					</td>
					<td style="min-width:130px;">
						<input type="text" class="code ingredient-amount" name="ingredients[<?php echo absint( $id ); ?>][amount]" value="<?php echo esc_attr( $ingredient[ 'amount' ] ); ?>" style="width:35px" />
						<?php foodie_unit_selector( array(
							'name' => 'ingredients[' . absint( $id ) . '][unit]',
							'selected' => $ingredient[ 'unit' ]
						) ); ?>
					</td>
					<td class="remove"><a href="#">Remove</a></td>
				</tr>
				<?php endforeach; endif; ?>
				<tr id="new-ingredient" class="alternate fixed">
					<td>
						<input type="text" name="ingredients[0][name]" value="" class="ingredient-name" style="width:95%" placeholder="White Rice" />
					</td>
					<td>
						<input type="text" name="ingredients[0][note]" value="" class="ingredient-note" style="width:95%" placeholder="Brown rice works as well" />
					</td>
					<td style="min-width:130px;">
						<input type="text" class="code ingredient-amount" name="ingredients[0][amount]" value="" style="width:35px" placeholder="1" />
						<?php foodie_unit_selector( array(
							'name' => 'ingredients[0][unit]'
						) ); ?>
					</td>
					<td class="remove"></td>
				</tr>
				<tr class="fixed">
					<td class="submit" colspan="4" style="clear:both; float:none;">
						<input type="submit" name="save" id="save-ingredients" class="" value="<?php _e( 'Add or Update Ingredients', 'foodie' ); ?>" />
						 <img src="<?php echo admin_url( 'images/wpspin_light.gif' ); ?>" id="saving-ingredients" alt="" style="margin: -1px 0 0 4px; display:none; vertical-align:middle">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<p style="margin:10px 0 6px;"><?php _e( 'Use the <code>[ingredients]</code> shortcode anywhere in the post body to display the list of ingredients.', 'foodie' ); ?></p>
<?php
}

/**
 * Save the metabox
 *
 * Don't worry about merging/creating/deleting ingredients from the array.
 * Just save over whatever is there with the current fields.
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_ingredients_builder_save( $post_id ) {
	if ( ! is_numeric( $post_id ) )
		$post_id = absint( $_POST[ 'post_id' ] );
	
	// Bail if not a POST action
	if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) )
		return;
		
	/** Don't save when autosaving */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;
			
	/** Make sure we are on a page */
	if ( 'post' != $_POST[ 'post_type' ] )
		return $post_id;
		
	/** Check Nonce */
	if ( ! wp_verify_nonce( $_POST[ '_foodie_nonce' ], 'foodie-ingredients-builder' ) )
		return $post_id;
	
	/** servings */
	$servings = absint( $_POST[ 'servings' ] );
	
	update_post_meta( $post_id, 'servings', $servings );
	
	/** price */
	$price = esc_attr( $_POST[ 'price' ] );
	
	update_post_meta( $post_id, 'price', $price );
	
	/** ingredients */
	$ingredients = stripslashes_deep( $_POST[ 'ingredients' ] );
	
	foreach ( $ingredients as $id => $ingredient ) {
		if ( '' == $ingredient[ 'name' ] )
			unset( $ingredients[ $id ] );		
	}
	
	update_post_meta( $post_id, 'ingredients', $ingredients );

	if ( defined( 'DOING_AJAX' ) )
		die( '0' );
}
add_action( 'save_post', 'foodie_metabox_post_ingredients_builder_save' );
add_action( 'wp_ajax_foodie_metabox_post_ingredients_builder_save', 'foodie_metabox_post_ingredients_builder_save' );

/**
 * When creating or editing a post, make sure to load the Ingredients
 * Builder custo JS for easy AJAX addition of ingredients.
 *
 * @since Foodie 1.0
 */
function foodie_ingredients_builder_script( $hook ) {
	$pages = array( 'post-new.php', 'post.php' );
	
	if ( ! in_array( $hook, $pages ) )
		return;
		
	wp_enqueue_script( 'ingredients-builder', get_template_directory_uri() . '/inc/modules/ingredients/js/ingredients-builder.js' );
}
add_action( 'admin_enqueue_scripts', 'foodie_ingredients_builder_script' );

/**
 * Custom styles
 *
 * @since Foodie 1.0
 */
function foodie_ingredients_builder_styles() {
?>
	<style>
		#foodie_ingredients tbody tr:not(.fixed) {
			cursor: move;
		}
		
		#foodie_ingredients tbody tr.ui-sortable-helper td,
		#foodie_ingredients tbody tr.ui-sortable-placeholder + tr td {
			border-top-color: #DFDFDF;
		}
		
		#foodie_ingredients tbody td.remove {
			vertical-align: middle;
		}
		
		#foodie_ingredients tbody tr:hover td.remove a {
			visibility: visible;
		}
		
		#foodie_ingredients tbody td.remove a {
			padding: 1px 2px;
			display: inline-block;
			color: red;
			border-bottom: 1px solid red;
			visibility: hidden;
		}
		
		#foodie_ingredients tbody td.remove a:hover {
			text-decoration: none;
			background: red;
			color: white;
		}
	</style>
<?php
}
add_action( 'admin_print_styles-post-new.php', 'foodie_ingredients_builder_styles' );
add_action( 'admin_print_styles-post.php', 'foodie_ingredients_builder_styles' );