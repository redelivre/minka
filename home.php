<?php get_header(); ?>

<div class="home-entry">
	<div class="home-stick stick-video marketing">
		<div class="home-stick-entry">
		<?php 
			//<iframe width="560" height="315" src="//www.youtube.com/embed/TDwB0Z9s5nE" frameborder="0" allowfullscreen></iframe>
			$video = wp_oembed_get('http://youtu.be/TDwB0Z9s5nE', array('height' => '400', 'width' => '1000'));
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
	</div>
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
