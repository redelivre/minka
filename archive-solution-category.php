<?php
	get_header();
	$term = false;
	if(get_query_var('cat') != '')
	{
		$term = get_category(get_query_var('cat'));
	}
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
				<div id="category-<?php echo $term != false ? $term->slug : 'all'; ?>" class="solution-category-archive-category-list-view">
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
					<div id="category-<?php echo $term != false ? $term->slug : 'all'; ?>-list" style="display: block;" class="category-solution-category-archive-list-itens">
						<?php
						Minka::getSolutionsList($term);
						?>
					</div>
				</div>
				<div class="clear"></div>			
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>