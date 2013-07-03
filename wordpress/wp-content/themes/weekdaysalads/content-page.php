<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="feature-image">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-hero' ); ?></a>
		</div>
		<?php endif; ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php foodie_posted_on( 'page' ); ?>
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
	</div><!-- .entry-content -->
	
	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() )
			comments_template( '', true );
	?>

</article><!-- #post-<?php the_ID(); ?> -->
