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
	
	/*******************************************
	 * Featured content & Slider configuration *
	 *******************************************/
	$wp_customize->add_section( 'senza_trucco_slider' , array(
		'title'		=> __( 'Slider options', 'senza-trucco' ),
		'priority'	=> 30,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_featured_content_enabled]', array(
		'default' 			=> 0,
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_featured_content_enabled]', array(
		'label'			=> __( 'Enable featured content', 'senza-trucco' ),
		'description'	=> __( 'Check if you want to enable a featured posts slider in front page and in home page.', 'senza-trucco' ),
		'section'		=> 'senza_trucco_slider',
		'priority'		=> 5,
		'type'      	=> 'checkbox',
	) );
	
	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_featured_category]', array(
		'default' 			=> '',
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_slidecat',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_featured_category]', array(
		'label' 		=> __('Featured category', 'senza-trucco'),
		'description'	=> __('Select a category for the featured posts slider in front page and in home page.', 'senza-trucco'),
		'section' 		=> 'senza_trucco_slider',
		'type'    		=> 'select',
		'choices'    	=> $options_categories,
	) );
	
	// Pull all the pages into an array
	global $options_pages;
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_featured_page]', array(
		'default' 			=> '',
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_featpage',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_featured_page]', array(
		'label' 		=> __('Featured page', 'senza-trucco'),
		'description'	=> __('Select a page for the featured posts slider in front page and in home page.', 'senza-trucco'),
		'section' 		=> 'senza_trucco_slider',
		'type'    		=> 'select',
		'choices'    	=> $options_pages,
	) );
	
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_post_enabled]', array(
		'default' 			=> 0,
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_post_enabled]', array(
		'label'			=> __( 'Enable in posts', 'senza-trucco' ),
		'description'	=> __( 'Check if you want to enable the slider in single posts.', 'senza-trucco' ),
		'section'		=> 'senza_trucco_slider',
		'type'      	=> 'checkbox',
	) );
	
	$wp_customize->add_setting( 'senza-trucco[senza_trucco_slider_randord]', array(
		'default' 			=> 0,
		'type' 				=> 'option',
		'sanitize_callback' => 'senza_trucco_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'senza-trucco[senza_trucco_slider_randord]', array(
		'label'			=> __( 'Random slide order', 'senza-trucco' ),
		'description'	=> __( 'Check if you want the slides in random order.', 'senza-trucco' ),
		'section'		=> 'senza_trucco_slider',
		'type'      	=> 'checkbox',
	) );
	
	/******************************
	 * Color scheme configuration *
	 ******************************/
	$wp_customize->add_setting( 'senza_trucco_color_primary', array(
		'default' 			=> '#980747',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'senza_trucco_color_primary', array(
				'label'		=> __('Primary color', 'senza-trucco'),
				'section' 	=> 'colors',
				'settings'	=> 'senza_trucco_color_primary',
				'priority'	=> 1
			)
	) );
	$wp_customize->add_setting( 'senza_trucco_color_accent', array(
		'default' 			=> '#1FA67A',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'senza_trucco_color_accent', array(
				'label'		=> __('Accent color', 'senza-trucco'),
				'section' 	=> 'colors',
				'settings'	=> 'senza_trucco_color_accent',
				'priority'	=> 2
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
		button.primarybutton:hover, button.primarybutton:active,
		input.primarybutton:hover, input.primarybutton:active,
		.primarybutton:hover, .primarybutton:active,
		button.primarybutton.pushbutton:hover, button.primarybutton.pushbutton:focus,
		input.primarybutton.pushbutton:hover, input.primarybutton.pushbutton:focus,
		.primarybutton.pushbutton:hover, .primarybutton.pushbutton:focus,
		.flex-caption .entry-title,
		.main-navigation li:hover, .main-navigation li:focus,
		.main-navigation .current_page_item, .main-navigation .current-menu-item, .main-navigation .current_page_ancestor, .main-navigation .current-menu-ancestor,
		.main-navigation .menu-toggle .icon-bar, .main-navigation .menu-toggle .icon-bar::before, .main-navigation .menu-toggle .icon-bar::after,
		.main-navigation.toggled.toggled-out .menu-toggle .icon-bar, .main-navigation.toggled.toggled-out .menu-toggle .icon-bar::before, .main-navigation.toggled.toggled-out .menu-toggle .icon-bar::after,
		.main-navigation .search-toggle:hover, .main-navigation .search-toggle[aria-expanded="true"],
		.main-navigation.toggled li.menu-item-search,
		li.bypostauthor::before {
			background: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		.bypostauthor .comment-body  {
			background: <?php echo hex2rgba( get_theme_mod( 'senza_trucco_color_primary', '#980747' ), .12 ); ?>;
		}
		
		@media screen and (max-width: 1024px) {
			.featured-content-area {
				background: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
			}
		}
		
		/** color primary **/
		h1, h2, h3, h4, h5, h6,
		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
		.site-title, .site-title a,
		.page-title, .page-title a,
		.entry-title, .entry-title a,
		.comments-title, .comment-reply-title,
		.widget-title, .widget-title a, .widgettitle, .widgettitle a,
		button.primarybutton:not([class*="pushbutton"]):not(:hover),
		input.primarybutton:not([class*="pushbutton"]):not(:hover),
		.primarybutton:not([class*="pushbutton"]):not(:hover),
		button.primarybutton:not([class*="pushbutton"]):not(:hover) i,
		input.primarybutton:not([class*="pushbutton"]):not(:hover) i,
		.primarybutton:not([class*="pushbutton"]):not(:hover) i,
		.required {
			color: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		/** background accent **/
		button:not(.primarybutton):not([class*="toggle"]):hover, button:not(.primarybutton):not([class*="toggle"]):active,
		button:not(.primarybutton)[class*="pushbutton"], button:not(.primarybutton)[class*="pushbutton"]:focus,
		input[type="button"]:not(.primarybutton):not([class*="toggle"]):hover,	input[type="button"]:not(.primarybutton):not([class*="toggle"]):active,
		input[type="reset"]:not(.primarybutton):not([class*="toggle"]):hover, input[type="reset"]:not(.primarybutton):not([class*="toggle"]):active,
		input[type="submit"]:not(.primarybutton):not([class*="toggle"]):hover, input[type="submit"]:not(.primarybutton):not([class*="toggle"]):active,
		input:not(.primarybutton)[class*="pushbutton"], input:not(.primarybutton)[class*="pushbutton"]:focus,
		[class*="button"]:not(.primarybutton):not([class*="toggle"]):hover, [class*="button"]:not(.primarybutton):not([class*="toggle"]):active,
		[class*="pushbutton"]:not(.primarybutton), [class*="pushbutton"]:not(.primarybutton):focus,
		
		.flex-control-paging li a.flex-active,
		.flex-direction-nav a,
		
		li.comment:not(.bypostauthor)::before {
			background: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#1FA67A' ); ?>;
		}
		
		/** color accent **/	
		button:not(.primarybutton):not([class*="pushbutton"]):not(:hover),
		input[type="button"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover),
		input[type="reset"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover),
		input[type="submit"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover),
		*[class*="button"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover),
		input[type="button"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover) i,
		input[type="reset"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover) i,
		input[type="submit"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover) i,
		*[class*="button"]:not(.primarybutton):not([class*="pushbutton"]):not(:hover) i,
		.entry-meta a:hover, .entry-meta a:focus, .entry-meta a:active,
		.entry-footer a:hover, .entry-footer a:focus, .entry-footer a:active,
		.comment-metadata a:hover, .comment-metadata a:focus, .comment-metadata a:active,
		.logged-in-as a:hover, .logged-in-as a:focus, .logged-in-as a:active,
		.logged-in-as a::before,
		#wp-calendar caption,
		a, i {
			color: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#1FA67A' ); ?>;
		}
		
		/** border-color accent **/
		button.search-submit::before {
			border-color: transparent <?php echo get_theme_mod( 'senza_trucco_color_accent', '#1FA67A' ); ?> transparent;
		}	
	</style>
	<?php
}
add_action( 'wp_head', 'senza_trucco_customizer_css' );
