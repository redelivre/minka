<?php
get_header(); 
$highlight = array();
?>

<div class="home-entry" style="background: #FFF">
<div class="blog-archive-entry container  " style="padding-top:115px !important">
	<div class="row">
        <a class="semana-anterior btn btn-primary post-new pull-right" href="/?p=521">Accede a la información de la Semana de la Economía Colaborativa de 2014</a>
    </div>
    <div clasS="row">
            <div class="col-md-9">


	<div class="row">
		<div class="col-lg-12">
			<?php
		 	$count = 1;
			$featured = new WP_Query( array( 

                'category_name' => 'semana-2',
                'posts_per_page' => 5, 
                'ignore_sticky_posts' => 1, 
                'meta_value' => 1 ) 
            );
			if ( $featured->have_posts() ) : 
			?>
			<div id="carousel-featured" class="carousel slide" data-ride="carousel">				
				<ol class="carousel-indicators">
					<li data-target="#carousel-featured" data-slide-to="0" class=""></li>
					<li data-target="#carousel-featured" data-slide-to="1"></li>
					<li data-target="#carousel-featured" data-slide-to="2"></li>
					<li data-target="#carousel-featured" data-slide-to="3"></li>
					<li data-target="#carousel-featured" data-slide-to="4"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
				 		<?php
						while ( $featured->have_posts() ) : $featured->the_post();
						$highlight[] = get_the_ID();
						?>
						    <div class="item <?php if($count == 1){ echo "active"; } ?>">
						    	<div class="row">
						    		<?php if ( has_post_thumbnail() ) : ?>
								    	<div class="col-sm-3 text-center">
						                  <img class="img-responsive" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id()); ?>" style="">
						                </div>
						                <div class="col-sm-9">
						            <?php else: ?>
						            	<div class="col-sm-12">
					            	<?php endif; ?>
					            		<div class="entry-meta">
						        			<?php $category = get_the_category(); ?>
											<a href="<?php echo get_category_link( $category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a>
										</div>
					        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo substr(the_title($before = '', $after = '', FALSE), 0, 60).'...'; ?></a></h2>
					        			<div class="entry-summary">
						        			<?php the_excerpt(); ?>
					        			</div>
					                </div>
						      </div>
						    </div>
						<?php 
						$count++;
						endwhile;
						wp_reset_postdata();
					?>
				</div>						
			</div>
		<?php endif; ?>
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-12">                
            <?php
            wp_reset_postdata();
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			global $wp_query;
            $args = array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 4,
				'paged' => $paged,
				'order' => 'DESC',
                'category_name' => 'semana-2',
				'orderby' => 'modified',
				'post__not_in' => $highlight
            );
            $the_query = new WP_Query($args);
            if(have_posts())
			{
	            while ($the_query->have_posts()) {
	                $the_query->the_post();
					$image = wp_get_attachment_url( get_post_thumbnail_id() ); 
					if($image == '') { $image = "http://placehold.it/482x325"; }
					?>
					<div class="proxy-post col-md-4" onclick="window.location='<?php the_permalink() ?>';return false;">
						<div class="featured-article thumbnail">
							<div class="caption">
								<span class="date"><?php echo the_date(); ?></span>
								<h4><?php echo the_title();?></h4>
							</div>
							<img src="<?php echo $image ?>" alt="" class="thumb" height="235">		
						</div>
					</div>
					<?php
	            }
        	}
            wp_reset_postdata();
            ?>                     
        </div>	
        <div class="blog-archive-post-paginate">
		<?php 
		$big = 999999999; // need an unlikely integer
		$term = false;
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
		?>
		</div>		
	</div>
	<!--div class="row">
		<div class="blog-archive-tags col-lg-12"><?php
			if ( function_exists('wp_tag_cloud') )
			{?>
				<div class="blog-archive-tags-entry">
					<?php wp_tag_cloud('smallest=16&largest=28'); ?>
				</div><?php
			}?>
		</div>
	</div-->

            </div>
            <div class="col-md-3 semana-sidebar">
                <?php dynamic_sidebar('semana-sidebar'); ?>
            </div>

        </div>
    </div>
    </div>
<?php get_footer(); ?>
