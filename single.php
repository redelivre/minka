<?php
/**
 * The template for displaying all single posts.
 *
 * @package minka
 */

get_header();?>
<div class="home-entry" style="background: #FFF">
<div class="container">
	<div  class="blog-single-entry row col-md-12">
		<div class="blog-single-post-list col-md-9">
			<?php while ( have_posts() ) : the_post(); ?>
		
				<?php get_template_part( 'content', 'single' ); ?>
		
				<?php //minka_post_nav(); ?>
		
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( FALSE &&  comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>
		
			<?php endwhile; // end of the loop. ?>
		</div>
		<div class="blog-archives-sidebar col-md-3">
			<?php dynamic_sidebar('blog-sidebar'); ?>
		</div>

	</div>
</div>
</div>
<?php get_footer(); ?>
