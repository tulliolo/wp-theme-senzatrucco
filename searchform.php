<?php
/**
 * Custom search form for this theme
 *
 * @package Senza_Trucco
 */
 ?>
 
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'senza-trucco' ) ?></span>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search…', 'placeholder', 'senza-trucco' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label', 'senza-trucco' ) ?>" />
    </label>
    <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form>