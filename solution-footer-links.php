<?php
$cat = get_term_by('slug', 'home-links', 'link_category');
$args = array(
		'orderby'          => 'name',
		'order'            => 'ASC',
		'limit'            => 6,
		'category'         => $cat->term_id,
		//'exclude_category' => ' ',
		//'category_name'    => ' ',
		'hide_invisible'   => 1,
		'show_updated'     => 0,
		'echo'             => 1,
		'categorize'       => 0,
		'title_li'         => '',
		'title_before'     => '',
		'title_after'      => '',
		/*'category_orderby' => 'name',
			'category_order'   => 'ASC',
'class'            => 'home-links-link',
'category_before'  => '<li id=%id class=%class>',
'category_after'   => '</li>'*/
);
wp_list_bookmarks($args);
?>
