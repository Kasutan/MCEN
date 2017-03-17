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
 wp_enqueue_style( $handle = 'my-google-font', $src = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700|Roboto+Condensed:400,700', $deps = array(), $ver = null, $media = null );
}
	
//Gestion de l'article à la une - A déplacer dans un plugin 
    add_filter( 'rwmb_meta_boxes', 'mcen_meta_boxes' );
    function mcen_meta_boxes( $meta_boxes ) {
        $meta_boxes[] = array(
            'title'      => __( 'Article à la une', 'mcen_s' ),
            'post_types' => 'post',
            'fields'     => array(
                array(
                    'id'      => 'a_la_une',
                    'name'    => __( 'Mettre cet article à la une ?', 'mcen_s' ),
                    'type'    => 'radio',
                    'options' => array(
                        '1' => __( 'Oui', 'mcen_s' ),
                        '0' => __( 'Non', 'mcen_s' ),
                    ),
                )
               
            )
        );
        return $meta_boxes;
    }

function un_seul_article_a_la_une( $post_id) {
	$post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	$subject = 'A post has been updated';

	$message = "A post has been updated on your website:\n\n";
	$message .= $post_title . ": " . $post_url;

	
	
	//Récupérer les autres articles qui sont marqués à la une
	$args = array(
			'post_type' => 'post',
			'post__not_in'=> array(
				$post_id
			),
			'meta_query' => array(
				array(
					'key'     => 'a_la_une',
					'value'   => '1',
					'compare' => '=',
				),
			)
		);
		
		$query = new WP_Query($args);
		if($query->have_posts()):
			$message.="<br>Il y avait d'autres articles à la une, avec les identifiants suivants : ";
			while($query->have_posts()) :
				$query->the_post();
				$id=get_the_ID();
				$empty_array=array();
				apply_filters('rwmb_meta','0','a_la_une',$empty_array, $id);
				update_post_meta($id, 'a_la_une', '0');
				$message.=$id.' ';
				$message.="<br>Nouvelle valeur de a_la_une pour cet article : ".rwmb_meta( 'a_la_une', $empty_array, $id);
			endwhile;
		endif;
		wp_reset_postdata();

// Send email to admin.
	wp_mail( 'contact@kasutan.pro', $subject, $message );

}	

add_action('save_post','un_seul_article_a_la_une');

//Ajouter une colonne dans l'admin 
function affiche_si_article_a_la_une( $column, $post_id ) {
    if ($column == 'colonne_a_la_une'){
		$est_a_la_une = rwmb_meta( 'a_la_une', array(), $post_id);
		if ($est_a_la_une=='1') {
			echo 'Oui';
		} else { 
			echo 'Non';
		}
    }
}
add_action( 'manage_posts_custom_column' , 'affiche_si_article_a_la_une', 10, 2 );


function ajoute_colonne_a_la_une($columns) {
    return array_merge( $columns, 
              array('colonne_a_la_une' => 'A la une') );
}
add_filter('manage_posts_columns' , 'ajoute_colonne_a_la_une');

