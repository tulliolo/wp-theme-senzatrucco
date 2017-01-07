<?php
/**
 * Senza Trucco Theme Customizer.
 *
 * @package Senza Trucco
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function senza_trucco_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'senza_trucco_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function senza_trucco_customize_preview_js() {
	wp_enqueue_script( 'senza_trucco_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'senza_trucco_customize_preview_js' );

/**
 * Options for Senza Trucco Theme Customizer.
 */
function senza_trucco_customizer( $wp_customize ) {
	/* Main option Settings Panel */
    $wp_customize->add_panel('senza_trucco_panel', array(
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('Senza Trucco options', 'senza-trucco'),
        'description' => __('Panel to update Senza Trucco theme options', 'senza-trucco'),
        'priority' => 10 // Mixed with top-level-section hierarchy.
    ));
	
	/**********************************
	 * Featured content configuration *
	 **********************************/
	$wp_customize->add_section( 'senza_trucco_slider' , array(
		'title'		=> __( 'Slider options', 'senza-trucco' ),
		'priority'	=> 30,
		'panel'		=> 'senza_trucco_panel'
	) );
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_enabled]', array(
		'default' 			=> 0,
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_enabled]', array(
		'label'		=> __( 'Check if you want to enable slider', 'senza-trucco' ),
		'section'	=> 'senza_trucco_slider',
		'priority'	=> 5,
		'type'      => 'checkbox',
	) );
	
	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_category]', array(
		'default' 			=> '',
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_slidecat',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_category]', array(
		'label' 		=> __('Set slider category', 'senza-trucco'),
		'section' 		=> 'senza_trucco_slider',
		'type'    		=> 'select',
		'description'	=> __('Select a category for the featured post slider', 'senza-trucco'),
		'choices'    	=> $options_categories,
	) );
	
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_randord]', array(
		'default' 			=> 0,
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_randord]', array(
		'label'		=> __( 'Check if you want slides in random order', 'senza-trucco' ),
		'section'	=> 'senza_trucco_slider',
		'type'      => 'checkbox',
	) );
	
	// Pull all the pages into an array
	global $options_pages;
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_featpage]', array(
		'default' 			=> '',
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_featpage',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_featpage]', array(
		'label' 		=> __('Set featured page', 'senza-trucco'),
		'section' 		=> 'senza_trucco_slider',
		'type'    		=> 'select',
		'description'	=> __('Select a page for the featured section', 'senza-trucco'),
		'choices'    	=> $options_pages,
	) );
	
	/******************************
	 * Color scheme configuration *
	 ******************************/
	$wp_customize->add_section( 'senza_trucco_color' , array(
		'title'		=> __( 'Color options', 'senza-trucco' ),
		'priority'	=> 30,
		'panel'		=> 'senza_trucco_panel'
	) );
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_color_primary]', array(
		'default' 			=> '#980747',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'senza-trucco[senza_trucco_color_primary]', array(
				'label'		=> __('Change theme primary color', 'senza-trucco'),
				'section' 	=> 'senza_trucco_color',
				'settings'	=> 'senza-trucco[senza_trucco_color_primary]',
				'priority'	=> 5
			)
	) );
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_color_accent]', array(
		'default' 			=> '#1FA67A',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'senza-trucco[senza_trucco_color_accent]', array(
				'label'		=> __('Change theme accent color', 'senza-trucco'),
				'section' 	=> 'senza_trucco_color',
				'settings'	=> 'senza-trucco[senza_trucco_color_accent]',
				'priority'	=> 10
			)
	) );
}
add_action( 'customize_register', 'senza_trucco_customizer' );

/**
 * Sanitize checkbox for WordPress customizer
 */
function senza_trucco_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Featured Page
 * @package Senza Trucco
 */
function senza_trucco_sanitize_featpage( $input ) {
    global $options_pages;
    if ( array_key_exists( $input, $options_pages ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Slider Category
 * @package Senza Trucco
 */
function senza_trucco_sanitize_slidecat( $input ) {
    global $options_categories;
    if ( array_key_exists( $input, $options_categories ) ) {
        return $input;
    } else {
        return '';
    }
}

function senza_trucco_customizer_css( $wp_customize ) {
	?>
	<style type="text/css">
		/** background primary **/
		div.entry-title,
		.main-navigation li:hover, .main-navigation li:focus,
		.main-navigation .current_page_item, .main-navigation .current-menu-item, .main-navigation .current_page_ancestor, .main-navigation .current-menu-ancestor,
		.main-navigation .menu-toggle .icon-bar, .main-navigation .menu-toggle .icon-bar::before, .main-navigation .menu-toggle .icon-bar::after,
		.main-navigation.toggled.disabled .menu-toggle .icon-bar, .main-navigation.toggled.disabled .menu-toggle .icon-bar::before, .main-navigation.toggled.disabled .menu-toggle .icon-bar::after,
		.main-navigation .search-toggle:hover, .main-navigation .search-toggle[aria-expanded="true"],
		.main-navigation.toggled li.menu-item-search:hover, .main-navigation.toggled li.menu-item-search:focus {
			background: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		/** color primary **/
		h1, h2, h3, h4, h5, h6 {
			color: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		/** background accent **/
		button.toggle .icon-bar, button.toggle .icon-bar::before, button.toggle .icon-bar::after,
		button.search-submit,
		.flex-control-paging li a.flex-active,
		.flex-direction-nav a {
			background: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#1FA67A' ); ?>;
		}
		
		/** color accent **/
		
		/** border-color accent **/
		button.search-submit::before {
			border-color: transparent <?php echo get_theme_mod( 'senza_trucco_color_accent', '#1FA67A' ); ?> transparent;
		}	
	</style>
	<?php
}
add_action( 'wp_head', 'senza_trucco_customizer_css' );
