<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
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

<body <?php body_class(); ?>>
<div id="page" class="site fullscreen">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'senza-trucco' ); ?></a>
	
	<header id="masthead" class="site-header" role="banner">
		<div class="header-content">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<div class="site-branding">
					
					<?php if( get_header_image() != '' ) : ?> <!-- header image set -->
						<div class="site-logo">
							<img src="<?php header_image(); ?>"  height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/>
						</div><!-- logo container -->
					<?php else: ?> <!-- header image unset -->
						<div class="site-title"><?php bloginfo( 'name' ); ?></div>
					
						<?php $description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<div class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></div>
						<?php endif; ?>
					<?php endif; ?>
				</div><!-- .site-branding -->
			</a>
		</div><!-- .header-content -->
	</header><!-- #masthead -->	
	
	<div id="content" class="site-content">