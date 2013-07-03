<?php
/**
 * Ingredients builder shortcode.
 *
 * To use: When creating a post, simply add the `[ingredients]` shortcode
 * where you would like the list of ingredients to appear.
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Create the metabox
 *
 * @since Foodie 1.0
 */
function foodie_shortcode_ingredients( $atts ) {
	global $post;
	
	wp_enqueue_script( 'foodie-ingredients-js', get_template_directory_uri() . '/inc/modules/ingredients/js/ingredients.js', array( 'jquery' ), '20120530', true );
		
	$ingredients = get_post_meta( $post->ID, 'ingredients', true );
	$servings    = get_post_meta( $post->ID, 'servings', true );
	$price       = get_post_meta( $post->ID, 'price', true );
	
	if ( empty( $ingredients ) )
		return;
	
	ob_start();
?>
	<h3 class="section"><span><?php _e( 'Ingredients', 'foodie' ); ?></span> <small><?php echo apply_filters( 'foodie_price_output', sprintf( '%s%02.2f (%d Servings)', foodie_get_currency(), $price, $servings ) ); ?></small></h3>

	<div id="ingredients-<?php echo $post->ID; ?>">
	
		<ul class="ingredients">
			
			<?php 
				foreach ( $ingredients as $ingredient ) :
					$name   = esc_attr( $ingredient[ 'name' ] );
					$note   = esc_attr( $ingredient[ 'note' ] );
					$amount = esc_attr( $ingredient[ 'amount' ] );
					$unit   = esc_attr( $ingredient[ 'unit' ] );
			?>
			<li id="<?php echo sanitize_title( $name ); ?>" <?php if ( $note ) : ?>class="multi"<?php endif; ?>>
				<span class="name"><?php echo $name; ?></span>
				<?php if ( $note ) : ?><small><?php echo $note; ?></small><?php endif; ?>
				
				<span class="amount"><?php printf( '%d %s', $amount, foodie_get_unit( $unit, $amount ) ); ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	
	</div>
	
<?php
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}
add_shortcode( 'ingredients', 'foodie_shortcode_ingredients' );