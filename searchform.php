<form role="search" method="get" class="search-form" action="">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="search-field" placeholder="<?php echo __('Search').' …'; ?>" value="" name="search" title="Search for:" />
	</label>
	<input type="hidden" value="<?php echo get_post_type(); ?>" name="post_type" id="post_type" />
	<input type="submit" class="search-submit" value="Search" />
</form>