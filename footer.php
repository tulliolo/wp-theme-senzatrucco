<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package senzatrucco
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?>
			<aside class="footer-widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
			</aside><!-- .footer-widget-area -->
		<?php } ?>
	
		<div class="site-info">
			&#169; 2015&#45;<?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Senza Trucco', 'senzatrucco' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Web design by %1$s', 'senzatrucco' ), '<a href="mailto:tulliolo@yahoo.com" rel="designer">Tullio Loffredo</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
