<?php
/**
 * Foodie Theme Options
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Register the form setting for our foodie_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, foodie_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since Foodie 1.0
 */
function foodie_theme_options_init() {
	$options = foodie_get_theme_options();
	
	register_setting(
		'foodie_options',
		'foodie_theme_options', 
		'foodie_theme_options_validate'
	);

	/** General ************************************************************/
	
	add_settings_section(
		'general',
		__( 'General', 'foodie' ),
		'__return_false',
		'theme_options'
	);

	/** Vanity Metrics */
	add_settings_field(
		'display_metrics', 
		__( 'Display Vanity Metrics', 'foodie' ),
		'foodie_settings_field_display_metrics', 
		'theme_options',
		'general'
	);
	
	/** Web Fonts */
	add_settings_field(
		'webfonts', 
		__( 'Use Webfonts', 'foodie' ),
		'foodie_settings_field_webfonts', 
		'theme_options',
		'general'
	);
		
	/** Modules **********************************************************/
	
	add_settings_section(
		'modules',
		'Modules',
		'__return_false',
		'theme_options'
	);
	
	/** Ingredients Builder */
	add_settings_field(
		'ingredients_builder', 
		__( 'Use Ingredients Builder', 'foodie' ),
		'foodie_settings_field_ingredients_builder', 
		'theme_options',
		'modules'
	);
	
	/** Custom Video Embeds */
	add_settings_field(
		'video_embeds', 
		__( 'Use Video Embeds', 'foodie' ),
		'foodie_settings_field_video_embeds', 
		'theme_options',
		'modules'
	);
	
	/** Post Ratings */
	add_settings_field(
		'ratings', 
		__( 'Allow Post Ratings', 'foodie' ),
		'foodie_settings_field_ratings', 
		'theme_options',
		'modules'
	);
	
	/**
	 * If the ingredients builder module is enabled, show a few more options.
	 */
	if ( 'on' == $options[ 'use_ingredients_builder' ] ) {
	
		/** Ingredients Builder *****************************************************/
		
		add_settings_section(
			'ingredients-builder',
			'Ingredients Builder',
			'__return_false',
			'theme_options'
		);
	
		/** Measurement System */
		add_settings_field(
			'unit_system', 
			__( 'Measurement System', 'foodie' ),
			'foodie_settings_field_unit_system', 
			'theme_options',
			'ingredients-builder'
		);
		
		/** Currency */
		add_settings_field(
			'currency', 
			__( 'Currency', 'foodie' ),
			'foodie_settings_field_currency', 
			'theme_options',
			'ingredients-builder'
		);
	}
}
add_action( 'admin_init', 'foodie_theme_options_init' );

/**
 * Change the capability required to save the 'foodie_options' options group.
 *
 * @see foodie_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see foodie_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function foodie_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_foodie_options', 'foodie_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Foodie 1.0
 */
function foodie_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'foodie' ),
		__( 'Theme Options', 'foodie' ),
		'edit_theme_options',
		'theme_options',
		'foodie_theme_options_render_page' 
	);
}
add_action( 'admin_menu', 'foodie_theme_options_add_page' );

/**
 * Returns the options array for Foodie.
 *
 * @since Foodie 1.0
 */
function foodie_get_theme_options() {
	$saved = (array) get_option( 'foodie_theme_options' );
	
	$defaults = array(
		'display_metrics'         => 'on',
		'use_webfonts'            => 'on',
		'use_ingredients_builder' => 'on',
		'use_video_embeds'        => 'on',
		'use_ratings'             => 'on',
		'unit_system'             => 'english',
		'currency'                => 'usd'
	);

	$defaults = apply_filters( 'foodie_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}

/**
 * Get a singular theme option.
 *
 * This prevents having to define the array of options
 * in a function if you only need to find one.
 *
 * @since Foodie 1.0
 */
function foodie_get_theme_option( $option ) {
	$options = foodie_get_theme_options();
	
	if ( isset( $options[ $option ] ) )
		return apply_filters( 'foodie_get_theme_option', $options[ $option ] );
	
	return false;
}

/** General ************************************************************/

/**
 * Vantiy Metrics Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_display_metrics() {
	$options = foodie_get_theme_options();
	?>
	<label for"sample-checkbox">
		<input type="checkbox" name="foodie_theme_options[display_metrics]" id="display_metrics" <?php checked( 'on', $options['display_metrics'] ); ?> />
		<?php _e( 'Twitter and Facebook metrics to the right of the copyright.', 'foodie' );  ?>
	</label>
	<?php
}

/**
 * Web Fonts Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_webfonts() {
	$options = foodie_get_theme_options();
	?>
	<label for"sample-checkbox">
		<input type="checkbox" name="foodie_theme_options[use_webfonts]" id="display_metrics" <?php checked( 'on', $options['use_webfonts'] ); ?> />
		<?php _e( 'Add even more style by loading some Google Web Fonts.', 'foodie' );  ?>
	</label>
	<?php
}

/** Modules ************************************************************/

/**
 * Use Ingredients Builder Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_ingredients_builder() {
	$options = foodie_get_theme_options();
	?>
	<label for"sample-checkbox">
		<input type="checkbox" name="foodie_theme_options[use_ingredients_builder]" id="use_ingredients_builder" <?php checked( 'on', $options['use_ingredients_builder'] ); ?> />
		<?php _e( 'Easily build and embed beautiful ingredient lists.', 'foodie' );  ?>
	</label>
	<?php
}

/**
 * Use Video Embeds Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_video_embeds() {
	$options = foodie_get_theme_options();
	?>
	<label for"sample-checkbox">
		<input type="checkbox" name="foodie_theme_options[use_video_embeds]" id="use_video_embeds" <?php checked( 'on', $options['use_video_embeds'] ); ?> />
		<?php printf( __( '<a href="%s">oEmbed</a> powered video embeds that make adding videos a one-step process.', 'foodie' ), 'http://codex.wordpress.org/Embeds' )  ?>
	</label>
	<?php
}

/**
 * Use Ratings Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_ratings() {
	$options = foodie_get_theme_options();
	?>
	<label for"sample-checkbox">
		<input type="checkbox" name="foodie_theme_options[use_ratings]" id="use_ratings" <?php checked( 'on', $options['use_ratings'] ); ?> />
		<?php printf( __( 'Make sure to download, install, and activate the <a href="%s">Post Ratings</a> plugin.', 'foodie' ), admin_url( sprintf( 'update.php?action=install-plugin&plugin=post-ratings&_wpnonce=%s', wp_create_nonce( 'install-plugin_post-ratings' ) ) ) );  ?>
	</label>
	<?php
}

/** Ingredients Builder ************************************************************

/**
 * Set Unit System Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_unit_system() {
	$options = foodie_get_theme_options();
	?>
	<label for="unit_system">
		<?php _e( 'When using the ingredient builder, use', 'foodie' );  ?> 
		<select name="foodie_theme_options[unit_system]" id="unit_system">
		<?php foreach ( foodie_unit_systems() as $system => $sys ) : ?>
			<option value="<?php echo $system; ?>" <?php selected( $system, $options['unit_system'] ); ?>><?php echo $sys[ 'label' ]; ?></option>
		<?php endforeach; ?>
		</select>
		<?php _e( 'units.', 'foodie' ); ?>
	</label>
	<?php
}

/**
 * Set Currency Settings Field
 *
 * @since Foodie 1.0
 */
function foodie_settings_field_currency() {
	$options = foodie_get_theme_options();
	?>
	<label for="currency">
		<?php _e( 'When determining the price of ingredients, display total in', 'foodie' );  ?> 
		<select name="foodie_theme_options[currency]" id="currency">
		<?php foreach ( foodie_currencies() as $currency => $cur ) : ?>
			<option value="<?php echo $currency; ?>" <?php selected( $currency, $options['currency'] ); ?>><?php printf( '%s (%s)', $cur[ 'code' ], $cur[ 'sign' ] ); ?></option>
		<?php endforeach; ?>
		</select>
	</label>
	<?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since Foodie 1.0
 */
function foodie_theme_options_render_page() {
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme = wp_get_theme();
		$name  = $theme->Name;
	} else
		$name = get_current_theme();
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'foodie' ), $name ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'foodie_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see foodie_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since Foodie 1.0
 */
function foodie_theme_options_validate( $input ) {
	$output = array();

	$output[ 'display_metrics' ] = isset( $input[ 'display_metrics' ] ) ? 'on' : 'off';
	$output[ 'use_webfonts' ] = isset( $input[ 'use_webfonts' ] ) ? 'on' : 'off';
	$output[ 'use_ingredients_builder' ] = isset( $input[ 'use_ingredients_builder' ] ) ? 'on' : 'off';
	$output[ 'use_video_embeds' ] = isset( $input[ 'use_video_embeds' ] ) ? 'on' : 'off';
	$output[ 'use_ratings' ] = isset( $input[ 'use_ratings' ] ) ? 'on' : 'off';
	
	if ( isset( $input[ 'unit_system' ] ) && array_key_exists( $input[ 'unit_system' ], foodie_unit_systems() ) )
		$output[ 'unit_system' ] = $input['unit_system'];
		
	if ( isset( $input[ 'currency' ] ) && array_key_exists( $input[ 'currency' ], foodie_currencies() ) )
		$output[ 'currency' ] = $input[ 'currency' ];
		
	return apply_filters( 'foodie_theme_options_validate', $output, $input );
}