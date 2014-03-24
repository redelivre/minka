<?php get_header(); ?>
<div class="row category-main">
	<div class="span3 archive-solution-category-sidebar">
		<?php dynamic_sidebar('solution-sidebar'); ?>
	</div>
	<div class="span8 archive-solution-category-post-list">
	<?php 
		/** @var $wp_query WP_Query **/
		global $wp_query;
		if(have_posts())
		{
			while(have_posts())
			{
				the_post();?>
				<div class="span2 category solution">
					<div class="row archive-solution-category-post-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</div>
					<div class="row archive-solution-category-post-thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
					</div>
					<div class="row archive-solution-category-post-excerpt"><?php the_excerpt();?></div>
				</div><?php
			}
		}
	?>
	</div>
</div>
<div class="row archive-solution-category-links-list">
	<?php include(locate_template('solution-footer-links.php')); ?>
</div>


<?php get_footer(); ?>