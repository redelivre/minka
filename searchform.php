<form role="search" method="get" class="search-form" action="/solution">
    <input type="search" class="search-field form-control " placeholder="<?php echo __('Search').' …'; ?>" value="<?php echo array_key_exists('search', $_REQUEST) ? wp_strip_all_tags($_REQUEST['search']) : '' ; ?>" name="search" title="Search for:" />
	<input type="hidden" value="<?php echo is_home() ? 'solution' : get_post_type(); ?>" name="post_type" id="post_type" />
	<input type="submit" class="search-submit" value="Search" style="<?php echo is_home() ? '' : "display: none;"; ?>" />
</form>
