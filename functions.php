<?php
/**
 * Farm to Plate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Farm_to_Plate
 */


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'farm_to_plate_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function farm_to_plate_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Farm to Plate, use a find and replace
		 * to change 'farm-to-plate' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'farm-to-plate', get_template_directory() . '/languages' );

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

		//Add custom crop with a uniqe name 'menu-home'
		// menu item image on home page - 398px width, 360px height, hard crop
		add_image_size( 'menu-home', 398, 360, true );


		

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'farm-to-plate' ),
				'footer' => esc_html__( 'Footer Menu Location', 'farm-to-plate' ),
				'social' => esc_html__( 'Social Menu Location', 'farm-to-plate' ),
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
				'farm_to_plate_custom_background_args',
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
				'height'      => 120,
				'width'       => 120,
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'farm_to_plate_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function farm_to_plate_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'farm_to_plate_content_width', 640 );
}
add_action( 'after_setup_theme', 'farm_to_plate_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function farm_to_plate_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'farm-to-plate' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'farm-to-plate' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'farm_to_plate_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function farm_to_plate_scripts() {
	wp_enqueue_style( 'farm-to-plate-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'farm-to-plate-style', 'rtl', 'replace' );

	wp_enqueue_script( 'farm-to-plate-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// add a google font ( always set version number to 'null' for google font )
	wp_enqueue_style( 'fwd-googlefonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap', array(), null );
	// font-family: 'Lato', sans-serif;

	// font awesome
	wp_enqueue_script( 'farm-iconmonster', 'https://kit.fontawesome.com/4ff771d579.js');


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'farm_to_plate_scripts' );






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
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
* Custom Post Types & Taxonomies
*/
require get_template_directory() . '/inc/cpt-taxonomy.php';



// add custom image size into the drop down menu
function create_custom_image_size($sizes){
	$custom_sizes = array(
	'menu-home' => 'Menu Home'
	);
	return array_merge( $sizes, $custom_sizes );
}
add_filter('image_size_names_choose', 'create_custom_image_size');



if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Image Settings',
		'menu_title'	=> 'Image Settings',
		'menu_slug' 	=> 'Image-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

// Adding Google Maps ACF
// Code via: https://www.advancedcustomfields.com/resources/google-map/

function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyBR6zFQixHl8iMZjIyT6bkznTH0CahK0lM';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

wp_enqueue_script( 'google-map', get_template_directory_uri() . '/js/google-map.js', array('jquery', 'google-server'), _S_VERSION, true );
wp_enqueue_script( 'google-server', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBR6zFQixHl8iMZjIyT6bkznTH0CahK0lM', array(), _S_VERSION, true );
