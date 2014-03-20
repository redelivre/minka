<?php get_header(); ?>
<div class="container cf">
	<div class="row stick-video marketing">
		<div class="row">
			<iframe width="560" height="315" src="//www.youtube.com/embed/TDwB0Z9s5nE" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="row search-form">
		<?php get_search_form() ?>
	</div>
	<div class="row">
	<?php 
		$taxonomy = 'category';
		$args = array(
				'orderby' => 'id',
				'hide_empty'=> 0,
				'hierarchical' => 0,
				'parent' => 0,
				'taxonomy'=>$taxonomy
				
		);
		$terms = get_terms($taxonomy, $args);
		foreach ($terms as $term)
		{
			include(locate_template('home_category_list.php'));
		}
	?>
	</div>
</div><!-- /container -->

<div class="home-links-list">
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
</div>

<?php get_footer(); ?>