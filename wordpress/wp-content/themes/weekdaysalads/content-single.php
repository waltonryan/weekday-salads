<?php
/**
 * @package Foodie
 * @since Foodie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( 'video' == get_post_format() ) : ?>
		<div class="feature-image">	
			<?php foodie_the_video(); ?>
		</div>
		<?php
			elseif ( 'gallery' == get_post_format() ) :
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
		<?php endif; elseif ( has_post_thumbnail() ) : ?>
		<div class="feature-image">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-hero' ); ?></a>
		</div>
		<?php endif; ?>
		
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php foodie_posted_on(); ?>
			<?php edit_post_link( __( 'Edit', 'foodie' ), '<span class="sep"> | </span> <span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		
		<?php 
			wp_link_pages( array( 
				'before' => '<div class="page-links"><h3 class="section"><span>' . __( 'Pages', 'foodie' ) .'</span><small>', 
				'after' => '</small></h3></div>'
			) ); 
		?>
		
		<?php the_tags(); /** fair enough */ ?> 
	</div><!-- .entry-content -->
	
	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() )
			comments_template( '', true );
	?>
	
	<?php foodie_content_nav( 'nav-below' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->