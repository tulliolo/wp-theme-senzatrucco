<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Senza Trucco
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); 
		?>
		<div class="entry-meta"> 
			<?php senza_trucco_entry_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php 
		if ( has_post_thumbnail() ) : 
			the_post_thumbnail( 'senza_trucco_thumb' );
		endif;
		the_excerpt();
		senza_trucco_read_more(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->

<hr class="section-divider" />