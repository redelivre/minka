<?php

	$post_terms = wp_get_object_terms( get_the_ID(), 'category', array( 'fields' => 'ids' ) );
	
	$term_ids = implode(',', $post_terms);
	
	$args = array(
		'orderby'            => 'name',
		'order'              => 'ASC',
		'hide_empty'         => 1,
		'child_of'           => ($term != false && property_exists($term, 'term_id') ? $term->term_id : 0),
		'exclude'            => '',
		'include'            => $term_ids,
		'hierarchical'       => 1,
		'number'             => 3,
		'pad_counts'         => false,
		'taxonomy'           => 'category',
	);
	
	$imgError = "this.onerror=null;this.src='".get_template_directory_uri()."/images/home-noimage.png';";
	
	$cat_num = '';
	if(isset($Solution_global))
	{
		$cats = $Solution_global->getCatsArray();
		$cat_num = 'home-category-num-'.(Solutions::post_is_in_descendant_category($cats, get_post(), 'index') +1);
	}
	
	if(isset($post_index) && $post_index > 0 && $post_index%3 == 0)
	{
		$cat_num .= " home-cat-post-box-no-margin";
	}
	
	$cat_list = "";
	
	$cat_list_array_tmp = get_categories($args);
	$cat_list_array = array();
	foreach ($cat_list_array_tmp as $cat_list_item)
	{
		$cat_list_array[] = $cat_list_item->name;
	}
	switch (count($cat_list_array))
	{
		case 2:
			$cat_list_array[] = '&nbsp;';
		break;
		case 1:
			$cat_list_array = array('&nbsp;', $cat_list_array[0], '&nbsp;');
		break;
		case 0:
			$cat_list_array = array('&nbsp;', '&nbsp;', '&nbsp;');
		break;
	}
	
	$cat_list = '<span>'.implode('</span><br/><span>', $cat_list_array).'</span><br/>';
?>

<div class="home-cat-post-box <?php echo $cat_num; ?>" onclick="window.location='<?php the_permalink() ?>';return false;">
	<span class="home-cat-post-cat" ><?php echo $cat_list; ?></span>
	<span class="home-cat-post-title" ><h2><?php echo the_title();?></h2></span>
	<span class="home-cat-post-thumbnail" ><?php echo the_post_thumbnail('post-thumbnail', array('onerror' => $imgError));?></span>
	<span class="home-cat-post-content" ><?php echo the_excerpt();?></span>
</div>