<?php
/**
 * Foodie functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, foodie_setup(), sets up the theme by registering support
 * for various features in WordPress, such as a custom background and a navigation menu.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Foodie 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 580; /* pixels */

if ( ! function_exists( 'foodie_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Foodie 1.0
 */
function foodie_setup() {
	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates.
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options.
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );
		
	/**
	 * Custom widgets for this theme.
	 */
	require( get_template_directory() . '/inc/widgets/cta-box.php' );
	
	/**
	 * Load custom modules based on theme options.
	 */
	
	/** Are we using the builder? */
	if ( 'on' == foodie_get_theme_option( 'use_ingredients_builder' ) ) {
		require( get_template_directory() . '/inc/modules/ingredients/ingredients.php' );
		require( get_template_directory() . '/inc/modules/ingredients/shortcodes.php' );
		
		if ( is_admin() )
			require( get_template_directory() . '/inc/modules/ingredients/metabox.php' );
	}

	/** Are we using video embeds? */
	if ( 'on' == foodie_get_theme_option( 'use_video_embeds' ) ) {
		require( get_template_directory() . '/inc/modules/videos/videos.php' );
		
		if ( is_admin() )
			require( get_template_directory() . '/inc/modules/videos/metabox.php' );
	}
	
	/** Are we using ratings? */
	if ( 'on' == foodie_get_theme_option( 'use_ratings' ) && class_exists( 'PostRatings' ) ) {
		require( get_template_directory() . '/inc/modules/ratings/ratings.php' );
	}
		
	/**
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'foodie', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 96, 96, true );
	add_image_size( 'post-hero', 700, 350, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'footer' => __( 'Footer Menu', 'foodie' ),
	) );
	
	/**
	 * Enable support for custom backgrounds
	 */
	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', array(
			'default-color' => 'edf0f2',
			'default-image' => get_template_directory_uri() . '/images/pattern-food.png'
		) );
	} else {
		add_custom_background();
	}
	
	/**
	 * Enable support for custom editor styles.
	 */
	add_editor_style();

	/**
	 * Add support for a few post formats.
	 */
	add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
	
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '196374',
		'width'                  => 940,
		'height'                 => 220,
		'flex-height'            => true,
		'wp-head-callback'       => 'foodie_header_style',
		'admin-head-callback'    => 'foodie_admin_header_style',
		'admin-preview-callback' => 'foodie_admin_header_image',
	);

	$args = apply_filters( 'foodie_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
	
	/**
	 * Custom header
	 */
	require( get_template_directory() . '/inc/custom-header.php' );
}
endif;
add_action( 'after_setup_theme', 'foodie_setup' );

/**
 * Register widgetized area and load our custom widget.
 *
 * Rename from sidebar-1 to prevent the loading of default widgets.
 * A custom set of widgets is chosen by the theme.
 *
 * @since Foodie 1.0
 */
function foodie_widgets_init() {
	register_widget( 'Foodie_CTA_Box_Widget' );
	
	register_sidebar( array(
		'name' => __( 'Sidebar', 'foodie' ),
		'id' => 'foodie-sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'foodie_widgets_init' );

/**
 * Enqueue scripts and styles
 *
 * @since Foodie 1.0
 */
function foodie_scripts() {
	global $post;

	/** Only load web fonts if enabled */
	if ( 'on' == foodie_get_theme_option( 'use_webfonts' ) )
		wp_enqueue_style( 'webfonts', 'http://fonts.googleapis.com/css?family=Arvo|Tienne:400,700|Patua+One|Droid+Sans|Cantarell:700|Oldenburg' );
		
	/** Default style.css required by WP */
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	/** Remove custom post ratings styles */
	wp_dequeue_style( 'post-ratings' );
	
	/** jQuery Flexslider */
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.js', array( 'jquery' ) );
	
	/** Basic jQuery ehanhancements */
	wp_enqueue_script( 'foodie', get_template_directory_uri() . '/js/foodie.js', array( 'jquery' ), '20120522' );
	
	/** Keyboard navigation for galleries */
	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'foodie_scripts', 11 );

/**
 * Enqueue comment reply script
 *
 * @since Foodie 1.0
 */
function foodie_enqueue_comment_reply_script() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		
		/** Textarea Autogrow */
		wp_enqueue_script( 'autogrow', get_template_directory_uri() . '/js/autogrowtextarea.js', array( 'jquery', 'foodie' ) );
	}
}
add_action( 'comment_form_before', 'foodie_enqueue_comment_reply_script' );

/**
 * Show the styleselect button in the second row of the editor
 *
 * @since Foodie 1.0
 */
function foodie_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
	
    return $buttons;
}
add_filter( 'mce_buttons_2', 'foodie_mce_buttons_2' );

/**
 * Add a few items to the styleselect box in TinyMCE
 *
 * @since Foodie 1.0
 */
function foodie_mce_before_init( $settings ) {
    $style_formats = array(
    	array(
    		'title' => 'Instructions List',
    		'selector' => 'ol',
    		'classes' => 'instructions'
    	),
		array(
    		'title' => 'Section Title',
    		'block' => 'h3',
    		'classes' => 'section'
    	)
    );

    $settings[ 'style_formats' ] = json_encode( $style_formats );

    return $settings;
}
add_filter( 'tiny_mce_before_init', 'foodie_mce_before_init' );