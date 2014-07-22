<?php get_header(); ?>
<div class="solution-entry-content">
	<div class="solution-single-sidebar">
		<?php dynamic_sidebar('solution-sidebar'); ?>
	</div>
	<div class="solution-single-post-list">
	<?php 
		/** @var $wp_query WP_Query **/
		global $wp_query, $post;
		if(have_posts())
		{
			while(have_posts())
			{
				the_post();?>
				<div class="single solution-thumbnail-region">
					<div class="solution-single-header">
						<div class="solution-single-post-title">
						<?php
							$cats_name = '';
							foreach (Minka::getCategoryLastChild(get_post()) as $cat)
							{
								$cats_name .= $cat->name.", ";
								break;
							}
							$cats_name = substr($cats_name, 0, -2);
							echo get_the_title()." / ".$cats_name;
						?>
						</div>
						<div class="solution-single-link-catalog" onclick="window.location='<?php echo get_post_type_archive_link( 'solution' ); ?>';return false;">
							<?php _e('View the Catalog', 'minka') ?>
						</div>
					</div><br/>
					<div class="solution-single-post-thumbnail"><?php the_post_thumbnail(); ?></div>
				</div>
				<div class="solution-single-content">
					<div class="solution-single-post-region">
						<h2><?php echo __('Region', 'minka'); ?></h2>
						<p><?php echo get_post_meta(get_the_ID(), 'solution-country', true); ?></p>
					</div>
					<div class="solution-single-post-content">
						<h2><?php echo __('description', 'minka'); ?></h2>
						<p><?php echo get_the_content();?></p>
					</div>
					<div class="span solution-single-post-can-use">
						<h2><?php echo __('Who can use', 'minka');?></h2>
						<p><?php echo get_post_meta(get_the_ID(), 'solution-for', true); ?></p>
					</div>
					<div class="span solution-single-post-contact">
						<h2><?php echo __('Useful tips and facts', 'minka');?></h2>
						<p><?php echo get_post_meta(get_the_ID(), 'solution-contact', true); ?></p>
					</div>
					<div class="span solution-single-post-sharing">
						<h2><?php echo __('Appreciation', 'minka');?></h2>
						<p><?php echo get_post_meta(get_the_ID(), 'solution-sharing', true); ?></p>
					</div>
					<div class="solution-single-post-tags">
						<h2><?php echo __('Tags');?></h2>
						<?php the_tags('', ', '); ?>
					</div>
					<div class="solution-single-post-url">
						<a href="<?php echo get_post_meta(get_the_ID(), 'solution-url', true); ?>" target="_blank" ><?php _e('view web site', 'minka')?></a>
					</div>
				</div>
				<div class="solution-single-post-exp needs-rating">
					<?php rate_form_filter(); ?>
				</div>
				<div class="solution-single-post-comments">
					<?php get_comments(); ?>
				</div>
				<div class="solution-single-post-comment-form">
					<?php comment_form(); ?>
				</div>
			<?php
			}
		}
	?>
	</div>
</div>


<?php get_footer(); ?>