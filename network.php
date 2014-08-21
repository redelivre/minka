<?php
/*
Template Name: Network
*/
get_header(); 
$highlight = array();?>

<div  class="page-network-entry">
	<div class="network-sidebar">
		<?php dynamic_sidebar('network-sidebar'); ?>
	</div>
	<div class="page-network-post-box">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<div class="network-template-bol"></div>
				<div class="network-template-page-title">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</div>
			</header><!-- .entry-header -->
			<div class="clear"></div>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<div class="network-entry">
				<div class="network-map" >
					<div class="map clear"><?php Minka::the_map(); ?></div>
				</div>
				<div class="network-content" >
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a accumsan augue. Suspendisse sit amet pharetra mi. Donec sit amet auctor nulla. Nam eleifend odio quis turpis elementum, eu scelerisque nisl iaculis. Mauris mollis nunc nec varius pretium. Duis vel venenatis lorem. Morbi vel porttitor massa. Nam iaculis velit ac pharetra convallis. Praesent sagittis ante elementum dolor semper scelerisque. Curabitur volutpat tortor urna, sit amet laoreet sapien bibendum id. Nunc fringilla, turpis eu rhoncus consectetur, enim urna consequat lectus, vitae iaculis felis felis eget risus. Duis cursus, arcu eget sagittis luctus, lacus dui pretium nibh, quis tincidunt sem eros non dui. Pellentesque imperdiet sit amet leo ac feugiat. Integer ultricies facilisis erat, non laoreet justo egestas eget. Aliquam vulputate ante in lacus congue sodales. 
				</div>
			</div>
		</article><!-- #post-## -->
	</div>
 	<div class="clear"> </div>
</div><!-- entry -->
<?php get_footer(); ?>