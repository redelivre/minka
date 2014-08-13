<?php
/*
Template Name: Archives
*/
get_header(); 
$highlight = array();?>

<div  class="blog-archive-entry"><?php
	//if ( !$current_page = get_query_var('paged') )
	{
		//if( get_theme_mod('minka_display_slider') == 1 )
		{
			wp_reset_query();
			$feature = new WP_Query( array( 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'meta_key' => '_home', 'meta_value' => 1 ) );
			if ( $feature->have_posts() ) : ?>

			<div class="cycle-slideshow highlights" >
						<ul class="slides">
			        	<div class="cycle-pager"></div>
			        	<div class="cycle-prev"></div>
   					 	<div class="cycle-next"></div>
				        <?php while ( $feature->have_posts() ) : $feature->the_post();
				        	$highlight[] = get_the_ID();
				        ?>
					        <li class="cycles-slide">
						        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						        	<div class="media slide cf">
						    			<?php if ( has_post_thumbnail() ) : ?>
							    			<div class="entry-image">
							    			<?php the_post_thumbnail( 'slider' ); ?>
							    			</div>
						    			<?php endif; ?>
						        		<div class="bd">
						        			<div class="entry-meta">
							        			<?php $category = get_the_category(); ?>
												<a href="<?php echo get_category_link( $category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a>
											</div>
						        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo substr(the_title($before = '', $after = '', FALSE), 0, 60).'...'; ?></a></h2>
						        			<div class="entry-summary">
							        			<?php the_excerpt(); ?>
						        			</div>
						        		</div>
						        	</div><!-- /slide -->
						        </article><!-- /article -->
					        </li>
			        	<?php endwhile; ?>
						
			        	</ul><!-- .swiper-wrapper -->
			</div><!-- .swiper-container -->
			<?php
			wp_reset_postdata();
			
			else : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ): ?>
					<div class="empty-feature">
		                <p><?php printf( __( 'To display your featured posts here go to the <a href="%s">Post Edit Page</a> and check the "Feature" box. You can select how many posts you want, but use it wisely.', 'guarani' ), admin_url('edit.php') ); ?></p>
					</div>
				<?php
				endif;
			endif; // have_posts()
		}?>
	 	<div class="clear"> </div><?php
	}?>
	<div class="blog-archive-post-list-entry">
		<div class="blog-archive-post-list"><?php
			wp_reset_query();
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			global $wp_query;
			
			$wp_query = new WP_Query(array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 4,
				'paged' => $paged,
				'order' => 'DESC',
				'orderby' => 'modified',
				'post__not_in' => $highlight
			));
			
			if(have_posts())
			{
				while (have_posts())
				{
					the_post();?>
					<div class="blog-archive-post-box">
						<div class="blog-archive-post-thumbnail" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)">
							<span class="blog-archive-post-title" ><h2><?php echo the_title();?></h2></span>
						</div>
					</div><?php
				}?>
				<div class="clear"> </div>
				<div class="blog-archive-post-paginate">
				<?php 
					$big = 999999999; // need an unlikely integer
					
					echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages
					) );
				?>
				</div>
				<?php
			} 
		?></div>
		<div class="archives-sidebar">
			<?php dynamic_sidebar('blog-sidebar'); ?>
		</div>
	</div>
	<div class="clear"> </div>
	<div class="blog-archive-tags"><?php
		if ( function_exists('wp_tag_cloud') )
		{?>
			<div class="blog-archive-tags-entry">
				<?php wp_tag_cloud('smallest=16&largest=28'); ?>
			</div><?php
		}?>
	</div>
</div><!-- entry -->
<?php get_footer(); ?>