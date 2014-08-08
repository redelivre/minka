<?php

	$post_terms = wp_get_object_terms( get_the_ID(), 'category', array( 'fields' => 'ids' ) );
	
	$term_ids = implode(',', $post_terms);
	
	$args = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'style'              => 'none',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => ($term != false && property_exists($term, 'term_id') ? $term->term_id : 0),
		'feed'               => '',
		'feed_type'          => '',
		'feed_image'         => '',
		'exclude'            => '',
		'exclude_tree'       => '',
		'include'            => $term_ids,
		'hierarchical'       => 1,
		'title_li'           => '',
		'show_option_none'   => false,
		'number'             => 3,
		'echo'               => 1,
		'depth'              => 0,
		'current_category'   => 0,
		'pad_counts'         => 0,
		'taxonomy'           => 'category',
		'walker'             => null
	);

	$imgError = "this.onerror=null;this.src='".get_template_directory_uri()."/images/home-noimage.png';";
	
	$cat_num = '';
	if(isset($Solution_global))
	{
		$cats = $Solution_global->getCatsArray();
		$cat_num = 'home-category-num-'.(Solutions::post_is_in_descendant_category($cats, get_post(), 'index') +1);
	}
?>

<div class="home-cat-post-box <?php echo $cat_num; ?>" onclick="window.location='<?php the_permalink() ?>';return false;">
	<span class="home-cat-post-cat" ><?php wp_list_categories($args); ?></span>
	<span class="home-cat-post-title" ><h2><?php echo the_title();?></h2></span>
	<span class="home-cat-post-thumbnail" ><?php echo the_post_thumbnail('post-thumbnail', array('onerror' => $imgError));?></span>
	<span class="home-cat-post-content" ><?php echo the_excerpt();?></span>
</div>