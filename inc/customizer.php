<?php
/**
 * Senza Trucco Theme Customizer
 *
 * @package Senza_Trucco
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
		'label'			=> __( 'Featured content', 'senza-trucco' ),
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
		'default' 			=> '#0060A0',
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
 * Applies color customizations
 */
function senza_trucco_customizer_css( $wp_customize ) {
	?>
	<style type="text/css">
		/** background primary **/
		.main-navigation li:hover,
		.main-navigation li.focus,
		.main-navigation li.menu-item-search:hover  .search-toggle,
		.main-navigation li.menu-item-search.focus  .search-toggle,
		.main-navigation li.menu-item-search .search-toggle[aria-expanded="true"],
		.main-navigation .current_page_item, 
		.main-navigation .current-menu-item, 
		.main-navigation .current_page_ancestor, 
		.main-navigation .current-menu-ancestor,
		
		.menu-toggle .icon-bar,
		.menu-toggle .icon-bar::before,
		.menu-toggle .icon-bar::after,
		
		.content-area.featured > .hentry,
		
		.flex-caption .entry-title,
		
		.bypostauthor .comment-reply-link,

		.button.primary,
		.button.primary.flat.enclosed:hover,
		.button.primary.flat.enclosed:active {
			background: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		/** foreground primary **/
		.entry-title, .entry-title a,
		
		.bypostauthor .comment-meta i,
		.bypostauthor .vcard a,
		.bypostauthor .comment-metadata a:hover,
		.bypostauthor .comment-metadata a:focus,
		.bypostauthor .comment-metadata a:active,

		.button.primary.flat {
			color: <?php echo get_theme_mod( 'senza_trucco_color_primary', '#980747' ); ?>;
		}
		
		/* background accent */
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],

		.button,
		.button.flat.enclosed:hover,
		.button.flat.enclosed:active {
			background: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#0060A0' ); ?>;
		}

		/* foreground accent */
		.button.flat,

		a,
		a.inverted:hover,
		a.inverted:focus,
		a.inverted:active,

		.widget ul a:hover,
		.widget ul a:focus,
		.widget ul a:active,
		.widget li::before,
		.widget_pages li::before,
		.widget_archive li::before,
		.widget_categories li::before,
		.widget_recent_entries li::before,
		.widget_recent_comments li::before,

		.entry-meta i,
		.entry-footer i,
		.entry-meta a:hover,
		.entry-meta a:focus,
		.entry-meta a:active,
		.entry-footer a:hover,
		.entry-footer a:focus,
		.entry-footer a:active,

		.comment-metadata i,
		.comment-metadata a:hover,
		.comment-metadata a:focus,
		.comment-metadata a:active {
			color: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#0060A0' ); ?>;
		}
		
		/* misc accent */
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="range"]:focus,
		input[type="date"]:focus,
		input[type="month"]:focus,
		input[type="week"]:focus,
		input[type="time"]:focus,
		input[type="datetime"]:focus,
		input[type="datetime-local"]:focus,
		input[type="color"]:focus,
		textarea:focus,

		button.search-submit {
			border-color: <?php echo get_theme_mod( 'senza_trucco_color_accent', '#0060A0' ); ?>;
		}

		button.search-submit::before {
			border-color: transparent <?php echo get_theme_mod( 'senza_trucco_color_accent', '#0060A0' ); ?> transparent;
		}
		
		/* reset */
		.button.flat {
			background: none;
		}
		
		@media screen and ( min-width: 55em ) {
			.content-area.featured > .hentry {
				background: none;
			}
		}
	</style>
	<?php
}
add_action( 'wp_head', 'senza_trucco_customizer_css' );

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