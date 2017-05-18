<?php
/**
 * mcen_s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mcen_s
 */

if ( ! function_exists( 'mcen_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mcen_s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on mcen_s, use a find and replace
	 * to change 'mcen_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mcen_s', get_template_directory() . '/languages' );

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
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'mcen_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'mcen_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'mcen_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mcen_s_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mcen_s_content_width', 640 );
}
add_action( 'after_setup_theme', 'mcen_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mcen_s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mcen_s' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mcen_s' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mcen_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mcen_s_scripts() {
	wp_enqueue_style( 'mcen_s-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mcen_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mcen_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mcen_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
* Personnalisation
*/
//CLean header
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
function clean_header(){ wp_deregister_script( 'comment-reply' ); } add_action('init','clean_header');

//Disable jpg compression
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

//Supprimer les émojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

//Empêcher l'ajout automatique de paragraphes
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

//Zone de widgets pour le footer
if (function_exists('register_sidebar')) {
 register_sidebar(array(
 'name' => 'Pied de page',
 'id' => 'pied-de-page',
 'description' => 'Widgets du pied de page',
 'before_widget' => '<div class="widget" id="%1$s">',
 'after_widget' => '</div>',
 'before_title' => '<h3>',
 'after_title' => '</h3>'
 ));
}

//Google fonts
add_action( 'wp_enqueue_scripts', 'my_google_font' );
function my_google_font() {
 wp_enqueue_style( $handle = 'my-google-font', $src = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700|Roboto+Condensed:400,700|Roboto', $deps = array(), $ver = null, $media = null );
}
	
//Taille d'image pour les articles single 
add_image_size('single', 435, 325, true ); 

//Taille d'image pour les articles de la page actualité qui ne sont pas en vedette
add_image_size('actu', 290, 220, true ); 


//Forcer la traduction des messages d'alerte des formulaires de contact
function mcen_script_caldera() {
	echo "<script> setTimeout(function(){ window.Parsley.setLocale('fr'); }, 2000);</script>";
}

add_action( 'wp_footer', 'mcen_script_caldera', 500);