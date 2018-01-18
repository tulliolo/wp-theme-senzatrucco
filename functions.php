<?php
/**
 * Senza Trucco functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package senzatrucco
 */

if ( ! function_exists( 'senzatrucco_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function senzatrucco_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Senza Trucco, use a find and replace
	 * to change 'senzatrucco' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'senzatrucco', get_template_directory() . '/languages' );

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
		'primary'  => esc_html__( 'Primary',  'senzatrucco' ),
		'social'   => esc_html__( 'Social',   'senzatrucco' )
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
	add_theme_support( 'custom-background', apply_filters( 'senzatrucco_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	/*
	 * Add image sizes for Post Thumbnails on posts and pages.
	 * You may upload full res images for thumbnails.
	 * Multiple responsive sizes for multiple purposes and aspect ratios will be preset.
	 */
	// Adds image sizes for any post & page
	// Aspect ratio is 2:1
	senzatrucco_add_image_size( 'senzatrucco_thumb', 800, 400, array( 'center', 'center' ) );
	
	// Adds image sizes for slider
	// Aspect ratio is 2:1
	senzatrucco_add_image_size( 'senzatrucco_slider_thumb', 1120, 560, array( 'center', 'center' ) );
}
endif;
add_action( 'after_setup_theme', 'senzatrucco_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function senzatrucco_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'senzatrucco_content_width', 640 );
}
add_action( 'after_setup_theme', 'senzatrucco_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function senzatrucco_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'senzatrucco' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'senzatrucco' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar', 'senzatrucco' ),
		'id'            => 'footer-sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'senzatrucco' ),
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'senzatrucco_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function senzatrucco_scripts() {
	wp_enqueue_style( 'senzatrucco-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'senzatrucco-font-style', 'https://fonts.googleapis.com/css?family=Open+Sans' );
	
	wp_enqueue_style( 'senzatrucco-font-awesome-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

	wp_enqueue_script( 'senzatrucco-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js' );
	
	wp_enqueue_script( 'senzatrucco-script', get_template_directory_uri() . '/js/jquery.senzatrucco.js' );
	
	wp_enqueue_script( 'senzatrucco-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// extra styles for custom templates
	if ( is_page('landing') ) {
		wp_enqueue_style( 'senzatrucco-style-landing', get_template_directory_uri() . '/css/style-landing.css' );
	} else {
		// Runs this code when another page template is being used
	}
}
add_action( 'wp_enqueue_scripts', 'senzatrucco_scripts' );

/**
 * Enqueue scripts and styles.
 */
function senzatrucco_add_editor_styles() {
    add_editor_style( 'style.css' );
	add_editor_style( 'css/flexslider.css' );
}
add_action( 'after_setup_theme', 'senzatrucco_add_editor_styles' );

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

if ( ! function_exists( 'senzatrucco_get_attachment_image_attributes' ) ) :
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
function senzatrucco_get_attachment_image_attributes($attr, $attachment, $size) {
    //Calculate Image Sizes by type and breakpoint
    //Slider Images
	if ( $size === 'senzatrucco_slider_thumb' ) {
		$attr['sizes'] = '(max-width: 22.625em) 20em,
						  (max-width: 32.875em) 30em,
						  (max-width: 53em)     40em,
						  (max-width: 56em)     50em,
						  (max-width: 78.625em) 60em,
						  70em';
	} else if ( $size === 'senzatrucco_thumb' ) {
		$attr['sizes'] = '(max-width: 22.625em) 20em,
						  (max-width: 32.875em) 30em,
						  (max-width: 53em)     40em,
						  (max-width: 55em)     50em,
						  (max-width: 83.875em) 40em,
						  50em';
	} else {
		$attr['sizes'] = '(max-width: 70em) 100vw,
						  70em';
	}	
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'senzatrucco_get_attachment_image_attributes', 10 , 3);
endif;

if ( ! function_exists( 'senzatrucco_add_image_size' ) ) :
/*
 * Registers new responsive image sizes for post thumbnails.
 * You may upload full resolution images for thumbnails.
 * Many variants with the same aspect ratio will be generated.
 *
 * @package Senza Trucco
 */
function senzatrucco_add_image_size( $name, $width, $height, $crop ) {
	$aspect_ratio = $width / $height;
	add_image_size( $name, $width, $height, $crop );
	add_image_size( $name . '_320' ,  320, absint(  320 / $aspect_ratio ), $crop );
	add_image_size( $name . '_480' ,  480, absint(  480 / $aspect_ratio ), $crop );
	add_image_size( $name . '_640' ,  640, absint(  640 / $aspect_ratio ), $crop );
	add_image_size( $name . '_800' ,  800, absint(  800 / $aspect_ratio ), $crop );
	add_image_size( $name . '_960' ,  960, absint(  960 / $aspect_ratio ), $crop );
	add_image_size( $name . '_1120', 1120, absint( 1120 / $aspect_ratio ), $crop );
}
endif;

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
foreach ($options_pages_obj as $post) {
     $options_pages[$post->ID] = $post->post_title;
}