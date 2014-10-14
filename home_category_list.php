<div id="category-<?php echo $term->slug; ?>" class="home-category-list-view home-category-num-<?php echo $count; ?>">
	<div class="home-category-header">
		<div class="home-category-image"><img alt="" src="<?php echo z_taxonomy_image_url($term->term_id,null,true); ?>"/></div>
		<div class="home-category-header-text">
			<h2 class="home-category-name"><?php echo $term->name;?></h2>
			<span class="home-category-description"><?php echo $term->description;?></span>
		</div>
	</div>

	<div class="category-home-list-archive-link" onclick="window.location='<?php echo get_category_link($term->term_id).'?post_type=solution'; ?>';return false;">
		<span class="category-home-list-archive-link-button">&nbsp;</span>
		<span class="category-home-list-archive-link-text" ><?php echo __('View All', 'minka'); ?></span>
		 
	</div>
	<div class="clear"></div>
	<div id="category-<?php echo $term->slug; ?>-list" style="display: block;" class="category-home-list-itens">
		<?php
		$args = array(
				'posts_per_page'   => 3,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'cat'		   => $term->term_id,
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
</div>
<div class="clear"></div>