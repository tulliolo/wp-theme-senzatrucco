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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'senza-trucco' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-content">
			<div class="site-branding">
				<?php if( get_header_image() != '' ) : ?> <!-- header image set -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>"  height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
				
				<?php else: ?> <!-- header image unset -->
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				
					<?php $description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .site-branding -->
			
			<?php if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'social',
						'container'       => 'div',
						'container_id'    => 'social-media',
						'container_class' => 'social-media',
						'menu_id'         => 'menu-social-top',
						'menu_class'      => 'menu social-menu',
						'depth'           => 1,
						'link_before'     => '<span class="screen-reader-text">',
						'link_after'      => '</span>',
						'fallback_cb'     => '',
					)
				);
			} ?>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="icon-bar"></span></button>
				<?php wp_nav_menu( array( 
					'theme_location' => 'primary', 
					'menu_id' 		 => 'primary-menu',
					'menu_class' 	 => 'menu nav-menu',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s
											<li id="menu-item-search" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-search">
												<button class="search-toggle" aria-controls="primary-search" aria-expanded="false"><i class="fa fa-search"></i></button>
												<div id="primary-search" aria-expanded="false">' . get_search_form( false ) . '</div>
											</li>
										</ul>') ); ?>
			</nav><!-- #site-navigation -->
		</div><!-- .header-content -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">