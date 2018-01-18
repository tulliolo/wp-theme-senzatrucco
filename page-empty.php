<?php
/**
 * The template for displaying an empty page
 *
 * This is the template that displays an empty page with a slider.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package senzatrucco
 */

get_header();
?>

<div id="primary" class="content-area slideshow featured">
	<?php
	if ( is_front_page() && senzatrucco_get_option( 'senzatrucco_slider_featured_content_enabled' ) ) : 
		senzatrucco_featured_slideshow();
	endif;
	?>
</div><!-- #primary -->

<?php
get_footer();
