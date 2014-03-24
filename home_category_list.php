<div id="category-<?php echo $term->slug; ?>" class="category-toggle-list-view">
	<h1><?php echo $term->name;?></h1>
	<p><?php echo $term->description;?></p>
	<div id="category-<?php echo $term->slug; ?>-list" style="display: block;" class="category-home-list">
		<?php
		$args = array(
				'posts_per_page'   => 3,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'category'		   => $term->slug,
				'post_type'		   => 'solution',
				/*'tax_query' => array(
						array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => $term->slug
						)
				)*/
		);
		$the_query = new WP_Query($args);
		if($the_query->have_posts())
		{
			while ($the_query->have_posts())
			{
				$the_query->the_post();
				include(locate_template('home_category_list_post.php'));
			}
		}
		wp_reset_postdata();
		?>
	</div>
	<div class="category-home-list-archive-link">
		<a class="category-home-list-archive-link" href="<?php echo get_category_link($term->term_id); ?>"><span class="category-home-list-archive-link-label">ver más</span></a> 
	</div>
</div>