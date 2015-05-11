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
	if(isset($minka))
	{
		$cats = $minka->getCatsArray();
		$cat_num = 'home-category-num-'.(Minka::post_is_in_descendant_category($cats, get_post(), 'index') +1);
	}
	
	if(isset($post_index) && $post_index > 0 && $post_index%4 == 0)
	{
		$cat_num .= " home-cat-post-box-no-margin";
	}
	
	$cat_list = "";
	
	$cat_list_array_tmp = wp_get_post_terms(get_the_ID(), 'category', $args);
	$cat_list_array = array();
	for( $i = 0 ; $i < count($cat_list_array_tmp) && $i < 3; $i++ )
	{
		$cat_list_array[] = $cat_list_array_tmp[$i]->name;
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


<?php
$image = wp_get_attachment_url( get_post_thumbnail_id() ); 
if($image == '') { $image = "http://placehold.it/482x350"; }
?>
<div class=" col-md-4" onclick="window.location='<?php the_permalink() ?>';return false;">
	<div class="featured-article thumbnail">
		<div class="caption">
			<span class="date"><?php echo the_date(); ?></span>
			<h4><?php echo the_title();?></h4>
		</div>
		<img src="<?php echo $image ?>" alt="" class="thumb" height="295">		
	</div>
</div>
