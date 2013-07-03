<?php
/**
 * Post Ratings Integration
 *
 * @link http://wordpress.org/extend/plugins/post-ratings/
 *
 * @package Foodie
 * @since Foodie 1.0
 */
 
if ( PostRatings()->getOptions( 'max_rating' ) != 5 ) {
	$options = PostRatings()->getOptions();
	
	$options[ 'max_rating' ] = 5;
	$options[ 'post_types' ] = array( 'post', 'page' );
	$options[ 'visibility' ] = array( 'singular' );
	$options[ 'after_post' ] = false;
	$options[ 'before_post' ] = false;
	
	update_option( 'post-ratings', $options );
}
 
/**
 * Output the rating options above the comment form.
 * This can be disabled via the Theme Options
 *
 * @since Foodie 1.0
 */
function foodie_rate_post() {
	global $post;
	
	$rating = PostRatings()->getRating( $post->ID );
	$rating = $rating[ 'rating' ];
	$max_rating = PostRatings()->getOptions( 'max_rating' );
?>
	<div id="rate">
		<div id="yours">
			<label for="your-vote"><?php _e( 'Your Vote:', 'foodie' ); ?></label>
			<?php echo PostRatings()->getControl( $post->ID ); ?>
		</div>
		
		<span class="divider">&mdash;</span>
		
		<div id="average">
			<label for="average"><?php _e( 'Average:', 'foodie' ); ?></label>
			<div class="ratings <?php if( is_singular() ) echo 'hreview-aggregate'; ?>" data-post="<?php the_ID(); ?>">
				<ul style="width:<?php echo ( $max_rating * 30 ); ?>px">
					<li class="rating" style="width:<?php echo ( $rating * 30 ); ?>px">
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}
add_action( 'comment_form_top', 'foodie_rate_post' );