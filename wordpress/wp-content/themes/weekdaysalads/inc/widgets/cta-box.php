<?php
/**
 * Makes a custom Widget for displaying Aside, Link, Status, and Quote Posts available with Twenty Eleven
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
class Foodie_CTA_Box_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Foodie_CTA_Box_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_twentyeleven_ephemera', 
			'description' => __( 'Use this widget to list your recent Aside, Status, Quote, and Link posts', 'foodie' ) 
		);
		
		$this->WP_Widget( 'widget_foodie_cta_box', __( 'Foodie Call to Action Box', 'foodie' ), $widget_ops );
		$this->alt_option_name = 'widget_foodie_cta';
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		ob_start();
		extract( $args, EXTR_SKIP );

		$title      = apply_filters( 'widget_title', $instance['title'] );
		$subtitle   = isset( $instance[ 'subtitle' ] ) ? esc_attr( $instance[ 'subtitle' ] ) : '';
		$url        = isset( $instance[ 'url' ] ) ? esc_url( $instance[ 'url' ] ) : '#';
		$icon       = isset( $instance[ 'icon' ] ) ? esc_url( $instance[ 'icon' ] ) : '';
		$background = isset( $instance[ 'background' ] ) ? esc_attr( $instance[ 'background' ] ) : '#76ad21';
		
		echo $before_widget;
?>
			
			<div class="cta-box" style="background-color: <?php echo $background; ?>">
				<a href="<?php echo $url; ?>" style="background: url('<?php echo $icon; ?>') no-repeat center center;">
					<span class="title"><?php echo $title; ?>
					<span class="subtitle"><?php echo $subtitle; ?></span>
				</a>
			</div>

<?php
			echo $after_widget;
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'subtitle' ] = strip_tags( $new_instance[ 'subtitle' ] );
		$instance[ 'url' ] = strip_tags( $new_instance[ 'url' ] );
		$instance[ 'icon' ] = strip_tags( $new_instance[ 'icon' ] );
		$instance[ 'background' ] = strip_tags( $new_instance[ 'background' ] );
		
		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title      = isset( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : 'Video Recipes';
		$subtitle   = isset( $instance[ 'subtitle'] ) ? esc_attr( $instance[ 'subtitle' ] ) : 'Easy to follow guides.';
		$url        = isset( $instance[ 'url' ] ) ? esc_url( $instance[ 'url' ] ) : 'http://';
		$icon       = isset( $instance[ 'icon' ] ) ? esc_url( $instance[ 'icon' ] ) : get_template_directory_uri() . '/images/icons/hd.png';
		$background = isset( $instance[ 'background' ] ) ? esc_attr( $instance[ 'background' ] ) : '#76ad21';
?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$( '#<?php echo $this->get_field_id( 'background' ); ?>' ).on( 'focus', function() {
						$( '.cta-color-picker[rel="<?php echo $this->get_field_id( 'background' ); ?>"]' ).toggle();
					}).focusout(function() {
						$( '.cta-color-picker[rel="<?php echo $this->get_field_id( 'background' ); ?>"]' ).toggle();
					});
					
					$( '.cta-color-picker' ).each(function(){
						var $this = $( this ),
							id    = $this.attr('rel');
 
						$this.farbtastic( '#' + id );
					});
				});
			</script>
			
			<style>
				.farbtastic {
					margin: 0 auto;
				}
			</style>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'foodie' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php _e( 'Subtitle:', 'foodie' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'Link To:', 'foodie' ); ?></label>
				<input class="widefat code" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon URL:', 'foodie' ); ?></label>
				<input class="widefat code" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'background' ) ); ?>"><?php _e( 'Background Color:', 'foodie' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'background' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background' ) ); ?>" type="text" value="<?php echo esc_attr( $background ); ?>" style="border:0" />
				<div class="cta-color-picker" rel="<?php echo $this->get_field_id( 'background' ); ?>" style="display: none;"></div>
			</p>
		<?php
	}
}

function foodie_load_color_picker_script() {
	wp_enqueue_script( 'farbtastic' );
}
add_action( 'admin_print_scripts-widgets.php', 'foodie_load_color_picker_script');

function foodie_load_color_picker_style() {
	wp_enqueue_style( 'farbtastic' );	
}
add_action( 'admin_print_styles-widgets.php', 'foodie_load_color_picker_style');