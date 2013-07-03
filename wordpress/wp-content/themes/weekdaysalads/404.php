<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Foodie
 * @since Foodie 1.0
 */

get_header(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'foodie' ); ?></h1>
		<div class="taxonomy-description"><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'foodie' ); ?></div>
	</header>

	<div id="primary" class="site-content full-width">
	
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
			
				<div class="entry-content">
					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'foodie' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .entry-content -->
				
			</article><!-- #post-0 -->

		</div><!-- #content -->
		
		<?php get_footer( 'copyright' ); ?>
		
	</div><!-- #primary .site-content -->
	
<?php get_footer(); ?>