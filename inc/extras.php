<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Senza_Trucco
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function senza_trucco_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'senza_trucco_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function senza_trucco_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'senza_trucco_pingback_header' );

if ( ! function_exists( 'senza_trucco_featured_slideshow' ) ) :
/**
 * Include slider style & scripts.
 */
function senza_trucco_slider_scripts() {
	if( ( ( is_front_page() || is_home() ) && senza_trucco_get_option( 'senza_trucco_slider_featured_content_enabled' ) ) ||
		( ( is_single() || is_page() ) && senza_trucco_get_option( 'senza_trucco_slider_post_enabled' ) ) ) {
		wp_enqueue_style( 'senza-trucco-flexslider-style', get_template_directory_uri() . '/css/flexslider.css' );
		
		wp_enqueue_script( 'senza-trucco-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'senza-trucco-jquery' ), '20151215', true );
		wp_enqueue_script( 'senza-trucco-flexslider-init', get_template_directory_uri() . '/js/flexslider-init.js', array( 'senza-trucco-jquery', 'senza-trucco-flexslider' ), '20151215', true );
	}
}	
endif;
add_action( 'wp_enqueue_scripts', 'senza_trucco_slider_scripts' );

/*************************
 * Add UI Functions here *
 *************************/
if ( ! function_exists( 'senza_trucco_fullscreen_slideshow' ) ) :
/**
 * Show a fullscreen slideshow of featured content.
 * Featured content is identified by a category and a page.
 * Featured content must be configured in slider options.
 */
function senza_trucco_fullscreen_slideshow() {
	global $post;
		
	$slideord = 'date';
	if ( senza_trucco_get_option( 'senza_trucco_slider_randord' ) == 1 ) :
		$slideord = 'rand';
	endif;

	$featpage = get_post( senza_trucco_get_option( 'senza_trucco_slider_featured_page' ) );
	$featquery = new WP_Query( array( 
		'cat' => senza_trucco_get_option( 'senza_trucco_slider_featured_category' ), 
		'nopaging' => true, 'orderby' => $slideord ) );

	if ( ( $featquery->have_posts() ) && !( is_null( $featpage ) ) ) :
		$post = $featpage;
		setup_postdata( $post );
		?>
		
		<a href="<?php the_permalink() ?>">
			<div class="flexslider">
				<ul class=slides>
					<?php
					wp_reset_postdata();
					while ( $featquery->have_posts() ) :
						$featquery->the_post();
						if ( has_post_thumbnail() ) :
							?>
							<li style="background-image: url( <?php the_post_thumbnail_url('full') ?> );">
								<?php
								$post = $featpage;
								setup_postdata( $post );
								?>
								
								<div class="flex-caption">
									<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
										<div class="entry-title"><?php the_title() ?></div>
										<div class="entry-summary">
											<?php the_excerpt(); ?>
										</div><!-- .entry-summary -->	
									</article><!-- #post-## -->
								</div><!-- .flex-caption -->
								
								<?php 
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : 
									?>
									<div class="site-branding">
										<div class="site-title"><?php bloginfo( 'name' ); ?></div>
										<div class="site-description"><?php echo $description; ?></div>
									</div><!-- .site-branding -->
									<?php 
								endif;
								?>
								
								<?php
								$featquery->reset_postdata();
								?>
								
								<div class="flex-caption">
									<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
										<div class="entry-summary">
											<?php the_excerpt(); ?>
										</div><!-- .entry-summary -->
										
										<?php the_title( '<div class="entry-title">', '</div>' );?>
									</article><!-- #post-## -->
								</div><!-- .flex-caption -->
							</li>
							<?php
						endif;
					endwhile;
					?>
				</ul><!-- .slides -->
			</div><!-- .flexslider -->
		</a>
		
		<?php
		wp_reset_postdata();
	endif;
}
endif;
 
if ( ! function_exists( 'senza_trucco_featured_slideshow' ) ) :
/**
 * Show a slideshow of featured content.
 * Featured content is identified by a category and a page.
 * Featured content must be configured in slider options.
 */
function senza_trucco_featured_slideshow( $size = 'senza_trucco_slider_thumb' ) {
	$slideord = 'date';
	if ( senza_trucco_get_option( 'senza_trucco_slider_randord' ) == 1 ) :
		$slideord = 'rand';
	endif;

	$featpage = get_post( senza_trucco_get_option( 'senza_trucco_slider_featured_page' ) );
	$featquery = new WP_Query( array( 
		'cat' => senza_trucco_get_option( 'senza_trucco_slider_featured_category' ), 
		'nopaging' => true, 'orderby' => $slideord ) );

	if ( ( $featquery->have_posts() ) && !( is_null( $featpage ) ) ) :
		global $post;
		$post = $featpage;
		setup_postdata( $post );
	?>

	<article id="featured-post-<?php the_ID(); ?>" <?php post_class( 'featured-post post-summary' ); ?>>
		<?php the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>
		<div class="flexslider">
			<ul class="slides">
		
	<?php
		while ( $featquery->have_posts() ) :
			$featquery->the_post();
			if ( has_post_thumbnail() ) :
	?>
		
				<li>
					
	<?php
				$post = $featpage;
				setup_postdata( $post );
	?>

					<div class="flex-caption">
						<?php the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>
						
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->	
					</div><!-- .flex-caption -->
						
	<?php
				$featquery->reset_postdata();
	?>

					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( $size ); ?>
					</a>
					
					<div class="flex-caption">
						<article id="featured-post-<?php the_ID(); ?>" <?php post_class( 'featured-post post-summary' ); ?>>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->
							
							<?php the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>
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
		$post = $featpage;
		setup_postdata( $post );
	?>
		
		<div class="entry-summary">
				<!--a href="<?php esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_excerpt(); ?></a-->
				<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</article><!-- #featured-post-## -->

	<?php
		wp_reset_postdata();
	endif;
}
endif;

if ( ! function_exists( 'senza_trucco_post_slideshow' ) ) :
/**
 * Shows a slideshow of the images attached to the current post.
 * 
 * @param the post id.
 */
function senza_trucco_post_slideshow( $post_id, $size = 'senza_trucco_slider_thumb' ) {
	$slideord = 'date';
	if ( senza_trucco_get_option( 'senza_trucco_slider_randord' ) == 1 ) :
		$slideord = 'rand';
	endif;

	$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => $slideord ) );

	if ( $images ) :
		
		?>
		<div class='flexslider'>
			<ul class="slides">
		<?php
		
		foreach ($images as $attachment_id => $image) :

			if ( $image->ID ) :
				?><li><?php
				echo wp_get_attachment_image( $image->ID, $size );
				?></li><?php
			endif; 
		endforeach;
		
		?>
			</ul><!-- .slides -->
		</div><!-- .flexslider -->
	<?php

	endif;
}
endif;

/*****************************
 * Add Helper Functions here *
 *****************************/
 
if ( ! function_exists( 'senza_trucco_get_option' ) ) :
/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 *
 * @package Senza Trucco
 */
function senza_trucco_get_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'senza-trucco' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
	return $options[$name];
	}

	return $default;
}
endif;