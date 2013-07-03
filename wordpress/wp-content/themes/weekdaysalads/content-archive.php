<?php
/**
 * Archived post content.
 *
 * Shown when viewing an archive (category, date, tags, etc) or search results.
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'archived' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			&mdash;<?php foodie_posted_on( 'archive' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->
