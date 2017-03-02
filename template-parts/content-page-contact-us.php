<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Senza Trucco
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Contact Us', 'senza-trucco' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		
		<div id="respond">
			<?php echo $response; ?>
			<form method="post" class="clear contact-form" action="<?php the_permalink(); ?>">
				<p class="contact-form-author"><label for="message_author"><?php _e( 'Name' ); ?> <span class="required">*</span></label> <input name="message_author" size="30" maxlength="245" aria-required="true" required="required" type="text" value="<?php echo esc_attr($_POST['message_author']); ?>" /></p>
				<p class="contact-form-email"><label for="message_email"><?php _e( 'Email' ); ?> <span class="required">*</span></label> <input name="message_email" size="30" maxlength="245" aria-required="true" required="required" type="text" value="<?php echo esc_attr($_POST['message_email']); ?>" /></p>
				<p class="contact-form-subject"><label for="message_subject"><?php _e( 'Subject', 'senza-trucco' ); ?> <span class="required">*</span></label> <input name="message_subject" size="30" maxlength="245" aria-required="true" required="required" type="text" value="<?php echo esc_attr($_POST['message_subject']); ?>" /></p>
				<p class="contact-form-message"><label for="message_text"><?php _e( 'Message', 'senza-trucco' ); ?> <span class="required">*</span></label> <textarea name="message_text" cols="45" rows="8" maxlength="65525" aria-required="true" required="required" type="text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></p>
				<p><label for="message_human"><?php _e( 'Human verification', 'senza-trucco' ); ?> <span class="required">*</span></label> <input type="text" style="width: 60px;" name="message_human" /> + 3 = 5</p>
				<input type="hidden" name="submitted" value="1">
				<p><input type="submit" class="solid-button primary-button"></p>
			</form>
		</div>
		
	</div><!-- .entry-content -->
</article><!-- #post-## -->