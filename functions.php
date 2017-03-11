<?php
/**
 * Senza Trucco functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Senza Trucco
 */

if ( ! function_exists( 'senza_trucco_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function senza_trucco_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Senza Trucco, use a find and replace
	 * to change 'senza-trucco' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'senza-trucco', get_template_directory() . '/languages' );

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
	
	/*
	 * Add image sizes for Post Thumbnails on posts and pages.
	 * You may upload full res images for thumbnails.
	 * Multiple responsive sizes for multiple purposes and aspect ratios will be preset.
	 */
	// Adds image sizes for any post & page
	// Aspect ratio is 3:2
	senza_trucco_add_image_size( 'senza_trucco_thumb', 150, 100, array( 'center', 'center' ) );
	
	// Adds image sizes for slider
	// Aspect ratio is 2:1
	senza_trucco_add_image_size( 'senza_trucco_slider_thumb', 150, 75, array( 'center', 'center' ) );
	
	// This theme uses wp_nav_menu() in one location.
	// This theme also adds a social media menu.
	register_nav_menus( array(
		'primary'	=> esc_html__( 'Primary', 'senza-trucco' ),
		'secondary'	=> esc_html__( 'Secondary', 'senza-trucco' ),
		'social'  	=> esc_html__( 'Social', 'senza-trucco' ),
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
	add_theme_support( 'custom-background', apply_filters( 'senza_trucco_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'senza_trucco_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function senza_trucco_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'senza_trucco_content_width', 1280 );
}
add_action( 'after_setup_theme', 'senza_trucco_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function senza_trucco_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'senza-trucco' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'senza-trucco' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'senza_trucco_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function senza_trucco_scripts() {
	wp_enqueue_style( 'senza-trucco-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-awesome-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'senza-trucco-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'senza-trucco-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	wp_enqueue_script( 'doubletaptogo', get_template_directory_uri() . '/js/doubletaptogo.min.js', array( 'jquery' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// include flexslider style & scripts
	wp_enqueue_style ( 'flexslider-style', get_stylesheet_directory_uri() .'/css/flexslider.css' );
	wp_enqueue_script( 'flexslider', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ) );
	wp_enqueue_script( 'flexslider-init', get_stylesheet_directory_uri() . '/js/flexslider-init.js', array( 'jquery', 'flexslider' ) );
}
add_action( 'wp_enqueue_scripts', 'senza_trucco_scripts' );

/**
 * Add custom menu items
 */
function senza_trucco_nav_menu_items($items, $args) {
	if( $args->theme_location === 'primary' )  {
		$items .= 
			'<li id="menu-item-search" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-search">
				<button class="search-toggle" aria-controls="primary-search"><i class="fa fa-search"></i></button>'
				. get_search_form( false ) .
			'</li>';

	}
	return $items;
}
add_filter('wp_nav_menu_items', 'senza_trucco_nav_menu_items', 10, 2);

/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
function senza_trucco_add_editor_styles() {
    add_editor_style( get_stylesheet_uri() );
}
add_action( 'init', 'senza_trucco_add_editor_styles' );

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
 * Setup Global variables 
 */
global $options_categories;
$options_categories = array();
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
}

global $options_pages;
$options_pages = array();
$options_pages_obj = get_pages();
foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Senza Trucco 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
/*function senza_trucco_content_image_sizes_attr($sizes, $size) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'senza_trucco_content_image_sizes_attr', 10 , 2 );*/

if ( ! function_exists( 'senza_trucco_get_attachment_image_attributes' ) ) :
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Senza Trucco 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function senza_trucco_get_attachment_image_attributes($attr, $attachment, $size) {
    //Calculate Image Sizes by type and breakpoint
    //Slider Images
    if ( $size === 'senza_trucco_slider_thumb' ) {
		if ( is_front_page() || is_home() ) {
			$attr['sizes'] = '(max-width: 3840px) 100vw, 3840px';
		} else {
			$attr['sizes'] = '(max-width: 1280px) 100vw, 1280px';
		}	
	} else if ( is_active_sidebar( 'sidebar-1' ) ) {
		$attr['sizes'] = '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, (max-width: 1440px) 38vw, 480px';
	} else {
		$attr['sizes'] = '(max-width: 768px) 100vw, (max-width: 1440) 50vw, 640px';
	}
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'senza_trucco_get_attachment_image_attributes', 10 , 3);
endif;

if ( ! function_exists( 'senza_trucco_max_srcset_image_width' ) ) :
/** 
 * Override max_srcset_image_width for Ultra HD support.
 */
function senza_trucco_max_srcset_image_width($max_width) {
    return 3840;
}
add_filter('max_srcset_image_width', 'senza_trucco_max_srcset_image_width');
endif;