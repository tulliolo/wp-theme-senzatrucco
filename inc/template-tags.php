<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Senza Trucco
 */

 if ( ! function_exists( 'senza_trucco_comment' ) ) :
/**
 * Prints HTML for the current comment.
 */
function senza_trucco_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( '('.__( 'Edit', 'senza-trucco' ).')', '<span class="edit-link">', '</span>' ); ?>
			</div>

	<?php else : 
		$extra_class = 
			( 0 == $args['avatar_size'] ) || !get_avatar( $comment, $args['avatar_size'] ) ? 'no-avatar' : ''; 
	?>
 
		<li id="comment-<?php comment_ID() ?>" <?php comment_class( $extra_class ); ?>>
			<article id="div-comment-<?php comment_ID() ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'senza-trucco' ), sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->
					
					<div class="comment-metadata">
						<span class="posted-on">
							<i class="fa fa-clock-o"></i>
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'senza-trucco' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
						</span>
						<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?>
					</div><!-- .comment-metadata -->
					
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting"><?php _e( 'Your comment is awaiting moderation.', 'senza-trucco' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->
				
				<div class="clear"></div>
		 
				<div class="comment-content">	
					<?php comment_text() ?>
				</div><!-- .comment-content -->
		 
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					) ) );
				?>
			
				<div class="clear"></div>
			</article><!-- .comment-body -->
	<?php 
	endif; // if pingback
}
endif;

if ( ! function_exists( 'senza_trucco_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function senza_trucco_posted_on() {
	// Show only on posts.
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		'<i class="fa fa-calendar"></i>%1$s',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	
	$byline = sprintf(
		'<i class="fa fa-user"></i>%1$s',
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'senza_trucco_cat_links' ) ) :
/**
 * Prints HTML with meta information for the categories.
 */
function senza_trucco_cat_links() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'senza-trucco' ) );
	if ( $categories_list && senza_trucco_categorized_blog() ) {
		printf( '<span class="cat-links"><i class="fa fa-folder-open-o"></i>' . esc_html__( '%1$s', 'senza-trucco' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'senza_trucco_tags_links' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function senza_trucco_tags_links() {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'senza-trucco' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><i class="fa fa-tags"></i>' . esc_html__( '%1$s', 'senza-trucco' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'senza_trucco_comments_link' ) ) :
/**
 * Prints HTML with meta information for the comments.
 */
function senza_trucco_comments_link() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="fa fa-comment-o"></i>';
		/* translators: %s: post title */
		comments_popup_link( 
			sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'senza-trucco' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ),
			__( '1 Comment', 'senza-trucco' ),
			__( '% Comments', 'senza-trucco' ));
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'senza_trucco_edit_link' ) ) :
/**
 * Prints HTML with meta information for the comments.
 */
function senza_trucco_edit_link() {
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'senza-trucco' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link"><i class="fa fa-pencil-square-o"></i>',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'senza_trucco_read_more' ) ) :
/**
 * Prints HTML with meta information for the comments.
 */
function senza_trucco_read_more() {
	printf ( '<p class="read-more"><a class="primary-button" href="%1$s">' . esc_html__( 'Read more', 'senza-trucco' ) . '<i class="fa fa-chevron-right"></i></a></p>', get_the_permalink() );
}
endif;

if ( ! function_exists( 'senza_trucco_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function senza_trucco_entry_meta() {
	// Hide category text for pages.
	if ( 'post' === get_post_type() ) {
		senza_trucco_posted_on();
		if ( ! is_single() ) {
			senza_trucco_cat_links();
		}
	}
	if ( ! is_single() ) {
		senza_trucco_comments_link();
		senza_trucco_edit_link();
	}
}
endif;


if ( ! function_exists( 'senza_trucco_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function senza_trucco_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		senza_trucco_cat_links();
		senza_trucco_tags_links();
	}
	senza_trucco_comments_link();
	senza_trucco_edit_link();
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function senza_trucco_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'senza_trucco_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'senza_trucco_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so senza_trucco_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so senza_trucco_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in senza_trucco_categorized_blog.
 */
function senza_trucco_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'senza_trucco_categories' );
}
add_action( 'edit_category', 'senza_trucco_category_transient_flusher' );
add_action( 'save_post',     'senza_trucco_category_transient_flusher' );
