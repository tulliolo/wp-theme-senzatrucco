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
		<input type="search" class="search-field" placeholder="..." value="" name="s" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>