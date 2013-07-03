<?php
/**
 * Custom template tags for this theme.
 *
 * Functions in this file appear throughout the template files,
 * and usually aren't attached to a hook. Because of this, they can
 * be overwritten by redefining the same function in a child theme.
 *
 * @package Foodie
 * @since Foodie 1.0
 */
 
if ( ! function_exists( 'foodie_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Foodie 1.0
 */
function foodie_content_nav( $nav_id ) {
	global $wp_query;

	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';
	else
		$nav_class = 'site-navigation paging-navigation';
?>

	<?php if ( is_single() ) : // navigation links for single posts ?>
	
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'foodie' ); ?></h1>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'foodie' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'foodie' ) . '</span>' ); ?>
		</nav>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<script>
			jQuery(function($) {
				$(window).scroll(function(){
					if ( $(window).scrollTop() >= ( $(document).height() - ( $(window).height() ) ) ) {
						$( '.paging-navigation' ).fadeIn();
					} else {
						$( '.paging-navigation' ).fadeOut();
					}
				});
			});
		</script>
	
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'foodie' ); ?></h1>
			
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'foodie' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'foodie' ) ); ?></div>
			<?php endif; ?>
		</nav>

	<?php endif; ?>

	<?php
}
endif;

if ( ! function_exists( 'foodie_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Foodie 1.0
 */
function foodie_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'foodie' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'foodie' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php printf( __( '%1$s <time pubdate datetime="%3$s">&mdash;%2$s ago</time>', 'foodie' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ), human_time_diff( get_comment_time( 'U' ) ), get_comment_time( 'C' ) ); ?>
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .comment-author .vcard -->
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'foodie' ); ?></em>
					<br />
				<?php endif; ?>
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for foodie_comment()

if ( ! function_exists( 'foodie_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Foodie 1.0
 */
function foodie_posted_on( $location = null ) {
	$dont_show_cats = array(
		'archive',
		'page'
	);
	
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> %5$s', 'foodie' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		! in_array( $location, $dont_show_cats ) ? sprintf( __( '- Posted in %1$s', 'foodie' ), get_the_category_list( ', ' ) ) : ''
	);
}
endif;