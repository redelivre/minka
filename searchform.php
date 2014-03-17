<?php
/**
 * The template for displaying search forms in Minka
 *
 * @package Minka
 * @since Minka 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<span aria-hidden="true" class="icon-search"></span>
		<label for="s" class="assistive-text"><?php _e( 'Search', 'minka' ); ?></label>
		<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Type your search and press enter', 'minka' ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'minka' ); ?>" />
	</form>
