<?php
/**
 * The template for displaying the landing page
 *
 * This is the template that displays a landing page with a fullscreen slider.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package senzatrucco
 */

get_header('landing');
?>

<div class="content-area">
	<?php
	if ( is_front_page() && senzatrucco_get_option( 'senzatrucco_slider_featured_content_enabled' ) ) : 
		senzatrucco_fullscreen_slideshow();
	endif;
	?>
</div>

<?php
get_footer('landing');