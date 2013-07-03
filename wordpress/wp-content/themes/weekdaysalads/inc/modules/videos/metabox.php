<?php
/**
 * Video embeds metabox
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Create the metabox
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_video() {
	add_meta_box( 'foodie_video', __( 'Video', 'dealotto' ), 'foodie_metabox_post_video_box', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'foodie_metabox_post_video' );

/**
 * Fill the created metabox with content.
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_video_box( $post ) {
	/** Verification Field */
	wp_nonce_field( 'foodie-video', '_foodie_video_nonce' );

	/** Get Previous Value */
	$video = get_post_meta( $post->ID, 'video', true );
	$video = trim( html_entity_decode( esc_textarea( $video ) ) );
?>
	<label class="screen-reader-text" for="video"><?php _e( 'Video', 'foodie' ); ?></label>
	<textarea rows="1" cols="40" name="video" tabindex="6" id="video" style="width: 98%; height: 4em"><?php echo $video; ?></textarea>	
	
	<p><?php printf( __( 'For <a href="%s">oEmbed-enabled</a> video sites, simply paste the URL of the video above. Otherwise, paste the HTML embed code, making sure it has a width of <code>750px</code>.', 'foodie' ), 'http://codex.wordpress.org/Embeds' ); ?></p>
<?php
}

/**
 * Save the metabox
 *
 * @since Foodie 1.0
 */
function foodie_metabox_post_video_save( $post_id ) {
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
	if ( ! wp_verify_nonce( $_POST[ '_foodie_video_nonce' ], 'foodie-video' ) )
		return $post_id;
	
	/** video */
	$video = esc_html( $_POST[ 'video' ] );
		
	update_post_meta( $post_id, 'video', $video );
}
add_action( 'save_post', 'foodie_metabox_post_video_save' );