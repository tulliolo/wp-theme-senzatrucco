<?php
/**
 * Template part for displaying featured content in header.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Senza Trucco
 */
 
?>

<?php
$featpost = get_post( senza_trucco_get_option( 'senza_trucco_slider_featpage' ) );
$featquery = new WP_Query( array( 
	'cat' => senza_trucco_get_option( 'senza_trucco_slider_category' ), 
	'nopaging' => true, 'orderby' => $slideord ) );

if ( ( $featquery->have_posts() ) && !( is_null( $featpost ) ) ) :
	// get slider options
	$slideord = 'title';
	if ( senza_trucco_get_option( 'senza_trucco_slider_randord' ) == 1 ) :
		$slideord = 'rand';
	endif;
	
	global $post;
	$post = $featpost;
	setup_postdata( $post );
?>

<article id="featured-post-<?php the_ID(); ?>" <?php post_class( 'featured-post post-summary' ); ?>>
	<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	<div class="flexslider">
		<ul class="slides">
	
<?php
	while ( $featquery->have_posts() ) :
		$featquery->the_post();
		if ( has_post_thumbnail() ) :
?>
	
			<li>
				
<?php
			$post = $featpost;
			setup_postdata( $post );
?>

				<div class="flex-caption">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->	
				</div><!-- .flex-caption -->
					
<?php
			$featquery->reset_postdata();
?>

				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'senza_trucco_slider_thumb' ); ?>
				</a>
				
				<div class="flex-caption">
					<article id="featured-post-<?php the_ID(); ?>" <?php post_class( 'featured-post post-summary' ); ?>>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
						
						<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					</article><!-- #featured-post-## -->
				</div><!-- .flex-caption -->
			</li>
			
<?php
		endif;
	endwhile;
	wp_reset_query();
?>

		</ul>
	</div><!-- .flexslider -->

<?php
	$post = $featpost;
	setup_postdata( $post );
?>
	
	<div class="entry-summary">
			<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #featured-post-## -->

<?php
	wp_reset_postdata();
endif;
?>