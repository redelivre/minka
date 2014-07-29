<?php
	get_header();
	$term = get_category(get_query_var('cat'));
?>
<div class="solution-category-archive-entry">
	<div class="solution-category-archive-content">
		<div class="solution-category-archive-content-entry">
			<div class="solution-single-sidebar">
			<?php
				dynamic_sidebar('solution-sidebar'); 
			?>
			</div>
			<div class="solution-category-archive-category-list">
				<div id="category-<?php echo $term->slug; ?>" class="solution-category-archive-category-list-view solution-category-archive-category-num-<?php echo $count; ?>">
					<div class="solution-category-archive-category-header">
						<?php
						if(get_query_var('cat') != '' && !array_key_exists( 'search', $_REQUEST))
						{
							echo __("Result for category", 'minka'); ?>&nbsp;<span class=""><?php echo $term->name; ?></span><?php 
						}
						elseif(array_key_exists( 'search', $_REQUEST))
						{
							echo __("Result for", 'minka'); ?>&nbsp;<span class=""><?php echo $_REQUEST['search']; ?></span><?php
						}
					?>
					</div>
					<div class="clear"></div>
					<div id="category-<?php echo $term->slug; ?>-list" style="display: block;" class="category-solution-category-archive-list-itens">
						<?php
						$args = array(
								'posts_per_page'   => -1,
								'orderby'          => 'post_date',
								'order'            => 'DESC',
								'post_type'		   => 'solution',
								/*'tax_query' => array(
										array(
												'taxonomy' => 'category',
												'field' => 'slug',
												'terms' => $term->slug
										)
								)*/
						);

						if(is_object($term) AND property_exists($term, 'term_id'))
						{
							$args['cat'] = $term->term_id;
						}

						if(array_key_exists( 'search', $_REQUEST))
						{
							$args['s'] = $_REQUEST['search'];
						}
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
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>