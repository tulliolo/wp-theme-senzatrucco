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
 * @package Senza_Trucco
 */

get_header();
?>

<div id="primary" class="content-area slideshow featured">
	<?php
	if ( is_front_page() && senza_trucco_get_option( 'senza_trucco_slider_featured_content_enabled' ) ) : 
		senza_trucco_featured_slideshow();
	endif;
	?>
</div><!-- #primary -->

<?php
get_footer();
