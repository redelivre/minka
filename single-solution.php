<?php get_header(); ?>
<div class="row single-main">
	<div class="span3 solution-single-sidebar">
		<?php dynamic_sidebar('solution-sidebar'); ?>
	</div>
	<div class="span9 solution-single-post-list">
	<?php 
		/** @var $wp_query WP_Query **/
		global $wp_query, $post;
		if(have_posts())
		{
			while(have_posts())
			{
				the_post();?>
				<div class="row span9 single solution-thumbnail-region">
					<div class="row solution-single-post-title">
						<?php the_title(); ?>
					</div>
					<div class="span3 solution-single-post-thumbnail"><?php the_post_thumbnail(); ?></div>
					<div class="span5 solution-single-post-region"><?php echo __('Region', 'minka').': '.get_post_meta($post->post_ID, 'solution-coverage', true); ?></div>
					<div class="span solution-single-post-excerpt"><?php echo __('description', 'minka').': '.get_the_content();?></div>
				</div>
				<div class="row span9 single solution-middle-region">
					<div class="span solution-single-post-can-use"><?php echo __('Who can use', 'minka').': '.get_post_meta($post->post_ID, 'solution-coverage', true); ?></div>
				</div><?php
			}
		}
	?>
	</div>
</div>
<div class="row solution-single-links-list">
	<?php include(locate_template('solution-footer-links.php')); ?>
</div>


<?php get_footer(); ?>