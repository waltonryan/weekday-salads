<?php
/**
 * Gallery post content. 
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
			$gallery = get_children( array(
				'post_type'      => 'attachment',
				'posts_per_page' => -1,
				'post_parent'    => $post->ID,
			) );
			
			if ( $gallery ) :
		?>
		<div class="feature-image flexslider">
			<ul class="slides">
				<?php foreach ( $gallery as $item_id => $gallery_item ) : ?>
					<li><?php echo wp_get_attachment_image( $item_id, 'post-hero' ); ?></li>
				<?php endforeach; ?>
			</ul>			
		</div>
		<?php endif; ?>
						
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			<?php foodie_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'foodie' ) ); ?>
	</div><!-- .entry-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->
