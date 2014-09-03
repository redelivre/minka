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
					<div class="map clear"><?php Minka::the_user_map(); ?></div>
				</div>
				<div class="network-content" >
					<div class="network-content-text" ><?php
						 $meta = get_post_meta(get_the_ID(), '.map-top', true);
						 if($meta == '')
						 {
						 	_e('Who and where are the protagonists of the collaborative economy', 'minka');
						 }
						 else 
						 {
						 	echo $meta;
						 }?>
					</div>
					<div class="new-solution-link" onclick="window.location='/new-solution';return false;">
						<div class="new-solution-link-bol"></div>
						<div class="new-solution-link-text"><?php _e("To join the map", "minka") ?></div>
					</div> 
				</div>
			</div>
			<div class="network-page-list-entry">
				<div class="network-page-list"><?php
					wp_reset_query();
					global $wp_query;
					
					$cat_ori = get_term_by('slug', 'network', 'page_category');
					
					$cat_id = $cat_ori->term_id;
					
					if(function_exists('icl_object_id'))
					{
						$cat_id = icl_object_id($cat_id, "page_category", true, ICL_LANGUAGE_CODE);
					}
					
					$wp_query = new WP_Query(array(
						'post_type' => array( 'page' ),
						'posts_per_page' => -1,
						'order' => 'DESC',
						'orderby' => 'modified',
						'tax_query' => array(
							array(
									'taxonomy' => 'page_category',
									'field'    => 'id',
									'terms'    => $cat_id,
							),
						),
					));
					
					if(have_posts())
					{
						while (have_posts())
						{
							the_post();?>
							<div class="network-page-box" >
								<span class="network-page-title" ><h2><?php echo the_title();?></h2></span>
								<div class="network-page-box-content" >
									<div class="network-page-image">
										<div class="network-page-thumbnail" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
									</div>
									<div class="network-page-box-text" ><?php the_content(); ?></div>
								</div>
							</div><?php
						}?>
						<div class="clear"> </div>
						<?php
					} 
				?></div>
			</div>
		</article><!-- #post-## -->
	</div>
 	<div class="clear"> </div>
</div><!-- entry -->
<?php get_footer(); ?>