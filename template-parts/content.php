<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package senzatrucco
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( has_post_thumbnail() ) :
			the_post_thumbnail( 'senzatrucco_thumb' );
		endif;
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php senzatrucco_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php
			the_excerpt();
			senzatrucco_read_more();
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
