<?php get_header(); ?>

<div class="home-entry"><?php
	if( get_theme_mod('minka_home_video_enabled', true) )
	{?>
		<div class="home-stick stick-video marketing">
			<div class="home-stick-entry">
			<?php 
				$video = wp_oembed_get(get_theme_mod('minka_home_video_url', 'http://youtu.be/TDwB0Z9s5nE'), array('height' => '563', 'width' => '1000'));
	
				if($video !== false)
				{
					echo $video;
				}
				else 
				{
					_e('Invalid Media URL', 'minka');
				}
			?>
			</div>
		</div>
		<div class="home-search-form search-form">
			<div class="home-search-form-entry">
				<?php get_search_form() ?>
			</div>
		</div><?php
	}?>
	<div class="home-content">
		<div class="home-content-entry">
			<div class="home-category-list">
			<?php 
				Minka::HomeCategoryList();
			?>
			</div>
			<div class="home-sidebar">
			<?php
				dynamic_sidebar('sidebar-home-1'); 
			?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
