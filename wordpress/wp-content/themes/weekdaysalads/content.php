<?php
/**
 * Standard post content. 
 *
 * Although posts can be set as a video or gallery, currently they all
 * use the same templates. However, a child theme can define content-video.php or
 * content-gallery.php to create more customized templates for the formats.
 *
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
		<?php elseif ( has_post_thumbnail() ) : ?>
		<div class="feature-image">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-hero' ); ?></a>
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
