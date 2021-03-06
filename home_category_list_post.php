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
	

	$term_list = wp_get_post_terms(get_the_ID(), 'category', array("fields" =>"slugs"));
	$term_slugs = implode(' ', $term_list);
?>

<!--div class="solution-wrapper"-->
    <div class="item2 thumbnail all home-cat-post-box <?php echo $term_slugs; ?> <?php echo $cat_num; ?> col-md-3 col-sm-12" onclick="window.location='<?php the_permalink() ?>';return false;">
        <!--<span class="home-cat-post-cat" ><?php echo $cat_list; ?></span>-->
        <span class="home-cat-post-thumbnail" ><span class="home-cat-post-thumbnail-img" style="background-image: url(<?php 

    if ( has_post_thumbnail(get_the_ID()) ) {
        echo wp_get_attachment_url( get_post_thumbnail_id() ); 
    } else {
        echo get_template_directory_uri() . '/images/thumbnail_default.png';
    }

    ?>)" ></span></span>
        <span class="home-cat-post-title" ><h2><?php echo the_title();?></h2></span>
        <span class="home-cat-post-content" ><?php echo the_excerpt();?></span>
    </div>
<!--/div-->
