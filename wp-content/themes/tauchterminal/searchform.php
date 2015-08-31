<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * The template for displaying search forms
 *
 * @package tauchterminal
 */
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div class="form-group">
    <label>
        <span class="screen-reader-text sr-only"><?php _ex( 'Search for:', 'label', 'tauchterminal' ); ?></span>
        <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tauchterminal' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
    </label>
    <input type="submit" class="search-submit btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button', 'tauchterminal' ); ?>">
</div><!-- .form-group -->
</form>
