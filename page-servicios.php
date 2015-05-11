<?php
/*
Template Name: Servicios
*/
get_header(); 
?>
<div class="home-entry" style="background: #FFF">
<div class="container">
	<div class="row">
		<div class="col-md-12 servicios">
		<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
		<?php endwhile; ?>
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>
