<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}
/**
 * smaragd-town functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package smaragd-town
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function smaragd_town_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on smaragd-town, use a find and replace
		* to change 'smaragd-town' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'smaragd-town', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'smaragd-town' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'smaragd_town_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'smaragd_town_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function smaragd_town_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'smaragd_town_content_width', 640 );
}
add_action( 'after_setup_theme', 'smaragd_town_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function smaragd_town_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'smaragd-town' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'smaragd-town' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'smaragd_town_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function smaragd_town_scripts() {
	wp_enqueue_style( 'smaragd-town-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), _S_VERSION);
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/css/swiper.css', array(), '11.2.8');
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.css', array(), '3.2.10');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.3');
	wp_enqueue_style( 'smaragd-town-style-main', get_template_directory_uri() . '/assets/css/style.min.css', array(), _S_VERSION);

	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper.js', array(), '11.2.8', true );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.min.js', array(), '1.6.0', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '5.3.3', true );
	wp_enqueue_script( 'smaragd-town-main-js', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), _S_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'smaragd_town_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Carbon init
 */
require get_template_directory() . '/inc/carbon-init.php';

/**
 * Form integration
 */
require get_template_directory() . '/inc/form-integration.php';

/**
 * Add ajax
 */
add_action( 'wp_enqueue_scripts', 'yuna_ajax_data', 99 );
function yuna_ajax_data(){

	wp_localize_script('smaragd-town-main-js', 'yuna_ajax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}

require get_template_directory() . '/inc/ajax-functions.php';

/**
 * Custom login page
 */
require get_template_directory() . '/inc/custom-login.php';

add_filter('the_generator', '__return_null');

	/**
	 * Custom colors
	 */

	function custom_tinymce_colors($init) {
		// Масив кольорів для палітри
		$custom_colors = '  
        "F9FCF5", "White",
        "F9FCF5", "Black",
        "034F43", "Dark green",
        "02B513", "Green",
        "F2682C", "Orange",
    ';

		// Додаємо кольори в налаштування TinyMCE
		$init['textcolor_map'] = "[$custom_colors]";

		// Включаємо палітру кольорів
		$init['textcolor_rows'] = 7; // Кількість рядків у палітрі

		return $init;
	}

	add_filter('tiny_mce_before_init', 'custom_tinymce_colors');



