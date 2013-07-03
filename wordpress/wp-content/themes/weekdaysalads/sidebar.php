<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Foodie
 * @since Foodie 1.0
 */
?>
		<div id="secondary" class="widget-area" role="complementary">
		
			<?php do_action( 'before_sidebar' ); ?>
			
			<?php if ( ! dynamic_sidebar( 'foodie-sidebar-1' ) ) : ?>

				<?php
					$args = array(
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => "</aside>",
						'before_title'  => '<h1 class="widget-title">',
						'after_title'   => '</h1>',
					);
					
					the_widget( 'WP_Widget_Pages', array(), $args );
							
					the_widget( 'Foodie_CTA_Box_Widget', array(
						'title'    => __( 'Call to Action Widget', 'foodie' ),
						'subtitle' => __( 'Click to add your own boxes', 'foodie' ),
						'url'      => admin_url( 'widgets.php' ),
						'icon'     => get_template_directory_uri() . '/images/icons/hd.png'
					) );
					
					the_widget( 'WP_Widget_Archives', array(), $args );
				?>
				
			<?php endif; // end sidebar widget area ?>
			
		</div><!-- #secondary .widget-area -->
