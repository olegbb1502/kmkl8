<?php
/**
 * meddical functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package meddical
 */

define('MY_THEMESLUG', 'meddical' );
define('MY_THEME_TEXTDOMAIN', 'meddical_domain' );

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
function meddical_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on meddical, use a find and replace
		* to change 'meddical' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'meddical', get_template_directory() . '/languages' );

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
			'main-menu' => esc_html__( 'Primary', 'meddical' ),
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

	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => esc_attr__( 'Primary', MY_THEME_TEXTDOMAIN ),
			'slug'  => 'primary-colors',
			'color' => get_theme_mod( MY_THEMESLUG . '_theme_color_primary' ),
		),
		array(
			'name'  => esc_attr__( 'Secondary', MY_THEME_TEXTDOMAIN ),
			'slug'  => 'secondary-colors',
			'color' => get_theme_mod( MY_THEMESLUG . '_theme_color_secondary' ),
		),
		array(
			'name'  => esc_attr__( 'Accent', MY_THEME_TEXTDOMAIN ),
			'slug'  => 'accent',
			'color' => get_theme_mod( MY_THEMESLUG . '_theme_color_accent' ),
		),
		array(
			'name'  => esc_attr__( 'Black', MY_THEME_TEXTDOMAIN ),
			'slug'  => 'black',
			'color' => get_theme_mod( MY_THEMESLUG . '_theme_color_black' ),
		),
		array(
			'name'  => esc_attr__( 'White', MY_THEME_TEXTDOMAIN ),
			'slug'  => 'white',
			'color' => get_theme_mod( MY_THEMESLUG . '_theme_color_white' ),
		),
	) );

	// add_theme_support( 'disable-custom-colors' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support('custom-logo');
}
add_action( 'after_setup_theme', 'meddical_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function meddical_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'meddical_content_width', 640 );
}
add_action( 'after_setup_theme', 'meddical_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function meddical_widgets_init() {
	// register_sidebar(
	// 	array(
	// 		'name'          => esc_html__( 'Sidebar', 'meddical' ),
	// 		'id'            => 'sidebar-1',
	// 		'description'   => esc_html__( 'Add widgets here.', 'meddical' ),
	// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
	// 		'after_widget'  => '</section>',
	// 		'before_title'  => '<h2 class="widget-title">',
	// 		'after_title'   => '</h2>',
	// 	)
	// );
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header', 'meddical' ),
			'id'            => 'header-top',
			'description'   => esc_html__( 'Add widgets here.', 'meddical' ),
			'before_widget' => '<li class="contact">',
			'after_widget'  => '</li>'
		)
	);
	// Footert widget
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 2', 'meddical' ),
			'id'            => 'footer-col-2',
			'description'   => esc_html__( 'Add widgets here.', 'meddical' ),
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="footer-strong caption">',
			'after_title'	=> '</p>'
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 3', 'meddical' ),
			'id'            => 'footer-col-3',
			'description'   => esc_html__( 'Add widgets here.', 'meddical' ),
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="footer-strong caption">',
			'after_title'	=> '</p>'
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Social links', 'meddical' ),
			'id'            => 'footer-social',
			'description'   => esc_html__( 'Add widgets here.', 'meddical' ),
			'before_widget' => '<div class="social-networks">',
			'after_widget'  => '</div>'
		)
	);
}
add_action( 'widgets_init', 'meddical_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function meddical_scripts() {
	// wp_enqueue_style( 'meddical-style', get_stylesheet_uri(), array(), _S_VERSION );
	// wp_style_add_data( 'meddical-style', 'rtl', 'replace' );
	wp_enqueue_style( 'meddical-style-app', get_template_directory_uri() . '/app.css', array(), _S_VERSION );

	wp_enqueue_script( 'meddical-navigation', get_template_directory_uri() . '/js/app.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'meddical-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script('jquery');
	
}
add_action( 'wp_enqueue_scripts', 'meddical_scripts' );

function get_attachment_url_by_slug( $slug ) {
	$args = array(
	  'post_type' => 'attachment',
	  'name' => sanitize_title($slug),
	  'posts_per_page' => 1,
	);
	$_header = get_posts( $args );
	$header = $_header ? array_pop($_header) : null;
	return $header ? wp_get_attachment_url($header->ID) : get_theme_mod( MY_THEMESLUG . '_default_image' );
}

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
 * Contacts markup.
 */
require get_template_directory() . '/inc/contacts.php';

/**
 * Doctors post type.
 */
require get_template_directory() . '/inc/doctors.php';

/**
 * Social media news post type.
 */
require get_template_directory() . '/inc/social-medias.php';

/**
 * Disease post type.
 */
require get_template_directory() . '/inc/disease.php';