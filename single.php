<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package senzatrucco
 */

get_header(); 

if ( is_single() && senzatrucco_get_option( 'senzatrucco_slider_post_enabled' ) == 1 ) :
	global $post;
	$post_id = $post->ID;
	?><aside id="post-<?php $post_id; ?>-slideshow" class="content-area slideshow" role="complementary"><?php
		senzatrucco_post_slideshow( $post_id );
	?></aside><!-- #post-##-slideshow --><?php
endif;
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content-single', get_post_format() );

		the_post_navigation();

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
