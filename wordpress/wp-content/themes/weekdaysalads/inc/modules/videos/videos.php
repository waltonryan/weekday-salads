<?php
function foodie_has_video() {
	global $post;
	
	if ( 'off' == foodie_get_theme_option( 'use_video_embeds' ) )
		return false;
	
	$video = get_post_meta( $post->ID, 'video', true );
	
	if ( '' == $video )
		return false;
	
	return $video;
}

function foodie_the_video() {
	global $post;
	
	$video = foodie_has_video();
	
	$video = wp_oembed_get( esc_url( $video ), array( 'width' => 700 ) );
	
	echo $video;
}