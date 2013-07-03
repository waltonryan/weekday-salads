<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to foodie_comment() which is
 * located in the functions.php file.
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

	<div id="comments" class="comments-area">

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'foodie' ); ?></p>
	<?php endif; ?>

	<?php
		if(  'on' == foodie_get_theme_option( 'use_ratings' ) && class_exists( 'PostRatings' ) )
			$title = sprintf( __( '<span>Rate and Comment</span> <small>%d Replies</small>', 'foodie' ), get_comments_number() );
		else
			$title = sprintf( __( '<span>Comment</span> <small>%d Replies</small>', 'foodie' ), get_comments_number() );
		
		$fields =  array(
			'heading' => '<h4 class="your-information">' . __( 'Your Information', 'foodie' ) . '</h4>',
			'author' => '<p class="comment-form-author">
							<label for="author" class="label-hidden">' . __( 'Name', 'foodie' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
							<input id="author" name="author" type="text" placeholder="' . __( 'Your Name...', 'foodie' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
						</p>',
			'email'  => '<p class="comment-form-email">
							<label for="email" class="label-hidden">' . __( 'Email', 'foodie' ) . ( $req ? '<span class="required">*</span>' : '' ) .'</label>
							<input id="email" name="email" type="text" placeholder="' . __( 'Email Address...', 'foodie' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
						</p>',
			'url'    => '<p class="comment-form-url">
								<label for="url" class="label-hidden">' . __( 'Website', 'foodie' ) . '</label>
								<input id="url" name="url" type="text" placeholder="' . __( 'http:// (optional)', 'foodie' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
						</p>'
		);
		$fields = implode( '', $fields );
		
		$comment_form_args = apply_filters( 'foodie_comment_form_args', array(
			'title_reply' => $title,
			'logged_in_as' => '', /** recreated in comment_notes_after */
			'fields' => array(),
			'comment_field' => '<div class="comment-form-submit"><p class="comment-form-comment">
									<label for="comment" class="label-hidden">Comment</label>
									<textarea id="comment" name="comment" cols="45" rows="3" aria-required="true" placeholder="' . __( 'What did you think?', 'foodie' ) . '" onclick></textarea>
								</p></div>',
			'comment_notes_after' => $fields,
			'comment_notes_before' => ''
		) );
		
		comment_form( $comment_form_args ); 
	?>

	<?php if ( have_comments() ) : ?>
		
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'foodie_comment' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'foodie' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'foodie' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'foodie' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

</div><!-- #comments .comments-area -->
