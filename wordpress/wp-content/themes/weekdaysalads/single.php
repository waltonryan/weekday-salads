<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Foodie
 * @since Foodie 1.0
 */

get_header(); ?>

		<div id="primary" class="site-content">
		
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
			
			<?php get_footer( 'copyright' ); ?>
			
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>