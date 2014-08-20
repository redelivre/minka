<?php
/**
 * The template for displaying all single posts.
 *
 * @package minka
 */

get_header();?>

<div  class="blog-single-entry">
	<div class="archives-sidebar">
		<?php dynamic_sidebar('blog-sidebar'); ?>
	</div>
	<div  class="blog-single-post">
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part( 'content', 'single' ); ?>
	
			<?php //minka_post_nav(); ?>
	
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>
	
		<?php endwhile; // end of the loop. ?>
	</div>

</div>

<?php get_footer(); ?>