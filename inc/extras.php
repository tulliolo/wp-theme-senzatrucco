<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Senza Trucco
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function senza_trucco_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'senza_trucco_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function senza_trucco_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'senza_trucco_pingback_header' );

/**
 * Function to display the slider content in front page.
 */
function senza_trucco_the_slider() {
	if ( is_front_page() && senza_trucco_get_option('senza_trucco_slider_enabled') == 1 ) :
		echo '<div id="featured" class="content-area">';
			echo '<div class="flexslider">';
				
				$slidecat = senza_trucco_get_option( 'senza_trucco_slider_category' );	
				if ( $slidecat ) :
					// get featpage data
					$featpage = senza_trucco_get_option( 'senza_trucco_slider_featpage' );
					$featpagelink = '';
					$featpagetitle = '';
					$featpageexcerpt = '';
					if ( $featpage != '' ) :
						global $post;
						$mypost = get_post( $featpage );
						$post = $mypost;
						setup_postdata( $post );
						$featpagelink = get_permalink();
						$featpagetitle = get_the_title();
						$featpageexcerpt = get_the_excerpt();
						wp_reset_postdata();	
					endif;
					
					// get slider data
					$slideord = 'title';
					if ( senza_trucco_get_option( 'senza_trucco_slider_randord' ) == 1 ) :
						$slideord = 'rand';
					endif;
					$query = new WP_Query( array( 'cat' => $slidecat, 'nopaging' => true, 'orderby' => $slideord ) );
					
					// the loop to feed the slider
					if ($query->have_posts()) :
						echo '<ul class="slides">';
						while ($query->have_posts()) :
							$query->the_post();
							if ( has_post_thumbnail() ) :
								echo '<li>';
									echo '<div class="flex-wrapper">';
										// add featured caption
										echo '<div class="flex-caption entry">';
											if ( $featpagetitle != '' ) echo '<div class="entry-title">'. $featpagetitle . '</div>';
											if ( $featpageexcerpt != '' ) echo '<div class="entry-excerpt">' . $featpageexcerpt .'</div>';
										echo '</div>';
										// add slide thumbnail
										echo '<a href="'. $featpagelink .'">';
											the_post_thumbnail( 'senza_trucco_slider_thumb' );
										echo '</a>';
										// add slide caption
										echo '<div class="flex-caption entry">';
											if ( get_the_excerpt() != '' ) echo '<div class="entry-excerpt">' . get_the_excerpt() .'</div>';
											if ( get_the_title() != '' ) echo '<div class="entry-title">'. get_the_title() . '</div>';
										echo '</div>';
									echo '</div>';
								echo '</li>';
							endif;
							wp_reset_postdata();
						endwhile;
						echo '</ul>';
					endif;
					wp_reset_query();
				else :
					echo __( 'Slider is not properly configured!', 'senza-trucco' );
				endif;				
			
			echo '</div>';
			echo '<div class="alt-caption entry">';
				if ( $featpageexcerpt != '' ) echo '<div class="entry-excerpt">' . $featpageexcerpt .'</div>';
			echo '</div>';
		echo '</div>';
	endif;
}

/*****************************
 * Add Helper Functions here *
 *****************************/
 
if ( ! function_exists( 'senza_trucco_get_option' ) ) :
/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 *
 * @package Senza Trucco
 */
function senza_trucco_get_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'senza-trucco' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
	return $options[$name];
	}

	return $default;
}
endif;

if ( ! function_exists( 'senza_trucco_add_image_size' ) ) :
/*
 * Helper function to register new responsive image sizes for post thumbnails.
 * You may upload full resolution images for thumbnails.
 * Many variants with the same aspect ratio will be generated.
 *
 * @package Senza Trucco
 */
function senza_trucco_add_image_size( $name, $width, $height, $crop ) {
	$aspect_ratio = $width / $height;
	add_image_size( $name, $width, $height, $crop );
	add_image_size( $name . '_xsmall', 320, absint( 320 / $aspect_ratio ), $crop );
	add_image_size( $name . '_small', 480, absint( 480 / $aspect_ratio ), $crop );
	add_image_size( $name . '_medium', 640, absint( 640 / $aspect_ratio ), $crop );
	add_image_size( $name . '_large', 800, absint( 800 / $aspect_ratio ), $crop );
	add_image_size( $name . '_xlarge', 1024, absint( 1024 / $aspect_ratio ), $crop );
	add_image_size( $name . '_hdready', 1280, absint( 1280 / $aspect_ratio ), $crop );
	add_image_size( $name . '_fullhd', 1920, absint( 1920 / $aspect_ratio ), $crop );
	add_image_size( $name . '_ultrahd', 3840, absint( 3840 / $aspect_ratio ), $crop );
}
endif;

/**
 * Helper function to convert hexdec color string to rgb(a) string 
 */
if ( ! function_exists( 'hex2rgba' ) ) :
function hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	// Return default if no color provided
	if( empty( $color ))
          return $default; 

	// Sanitize $color if "#" is provided 
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	// Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	// Convert hexadec to rgb
	$rgb =  array_map( 'hexdec', $hex );

	// Check if opacity is set(rgba or rgb)
	if( $opacity ) {
		if( abs( $opacity ) > 1 )
			$opacity = 1.0;
		$output = 'rgba(' . implode( ",", $rgb ) . ','.$opacity.')';
	} else {
		$output = 'rgb(' . implode( ",", $rgb ) . ')';
	}

	// Return rgb(a) color string
	return $output;
}
endif;