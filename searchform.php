<?php
/**
 * The template for displaying search forms in Senza Trucco
 *
 * @package Senza Trucco
 */
?>
<form role="search" method="get" class="clear search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
		<input type="search" class="search-field" placeholder="..." value="" name="s" size="27" />
	</label>
	<button type="submit" class="search-submit"><?php echo esc_attr_x( 'Search', 'submit button' ) ?></button>
</form>