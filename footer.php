<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Senza Trucco
 */

?>

		</div><!-- #content-wrapper -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="footer-wrapper" class="wrapper">
	
			<?php if ( has_nav_menu( 'secondary' ) ) {
				wp_nav_menu( 
					array( 
						'theme_location'  => 'secondary',
						'container'       => 'div',
						'container_id'    => 'secondary-navigation',
						'container_class' => 'secondary-navigation',
						'menu_id' 		  => 'secondary-menu',
						'menu_class'      => 'menu secondary-menu',
						'items_wrap'	  => '<span class="section-title">' . esc_html__( 'About', 'senza-trucco' )
											 . '&nbsp<a href="' . esc_url( home_url( '/' ) ) .'" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">'
											 . get_bloginfo( 'name', 'display' )
											 . '</a></span><ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 1,
					)
				);
			} ?>
			
			<?php if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'social',
						'container'       => 'div',
						'container_id'    => 'social-media-alt',
						'container_class' => 'social-media',
						'menu_id'         => 'social-menu-alt',
						'menu_class'      => 'menu social-menu',
						'items_wrap'	  => '<span class="section-title">' . esc_html__( 'Follow us', 'senza-trucco' ) . '</span><ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 1,
						'link_before'     => '<span class="screen-reader-text">',
						'link_after'      => '</span>',
						'fallback_cb'     => '',
					)
				);
			} ?>
			
			<div class="site-info">
				&#169; 2015&#45;<?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Senza Trucco', 'senza-trucco' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Web design by %1$s', 'senza-trucco' ), '<a href="mailto:tulliolo@yahoo.com" rel="designer">Tullio Loffredo</a>' ); ?>
			</div><!-- .site-info -->
		
		</div><!-- #footer-wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
