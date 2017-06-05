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
 * @package Senza_Trucco
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class('fullscreen'); ?>>
	<div id="page" class="site">
		<?php
		if ( is_front_page() && senza_trucco_get_option( 'senza_trucco_slider_featured_content_enabled' ) ) : 
			senza_trucco_fullscreen_slideshow();
		endif;
		?>
	</div><!-- #page -->
	
	<?php wp_footer(); ?>
	
</body>
</html>
