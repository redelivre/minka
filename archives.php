<?php
/*
Template Name: Archives
*/
get_header(); ?>

<div id="container">
	<div id="content" role="main">
		
		
	<div class="blog-archive-tags><?php
		if ( function_exists('wp_tag_cloud') )
		{?>
			<ul>
				<li><?php wp_tag_cloud('smallest=8&largest=22'); ?></li>
			</ul><?php
		}?>
	</div>
	</div><!-- #content -->
</div><!-- #container -->

<div class="span3 archive-solution-category-sidebar">
	<?php dynamic_sidebar('blog-sidebar'); ?>
</div>
<?php get_footer(); ?>