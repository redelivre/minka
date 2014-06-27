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
<div class="row home-links-list">
	<?php include(locate_template('solution-footer-links.php')); ?>
</div>
<?php get_footer(); ?>
