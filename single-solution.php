<?php get_header(); ?>
<div class="home-entry" style="background: #FFF">
<div class="solution-entry-content container" style="background: #FFF">
	<div class="solution-category-archive-content row">	
        <div class="solution-search row center-block col-md-12">
                <div class="col-md-5 col-lg-5 search">
                    <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
                </div>
                <div class="col-lg-3 col-md-3">
                	<a href="/solution/" class="btn btn-primary see-all">Catalogo Soluciones</a>
                </div>
                <div class="col-lg-3 col-md-3">
                	<a href="/new-solution/" class="btn btn-primary btn-new-solution">Publica Nueva solución</a>
                </div>
        </div>
   </div>


	<div class="solution-single-post-list">
	<?php 
		/** @var $wp_query WP_Query **/
		global $wp_query, $post;
		if(have_posts())
		{
			while(have_posts())
			{
				the_post();
				$thumbnail_id = get_post_thumbnail_id();
				$second_image = get_post_meta(get_the_ID(), 'thumbnail2', true);
				?>
				<div class="single solution-thumbnail-region">
					<div class="solution-single-header">
						<div class="title">
                            <h2>
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
                            </h2>
						</div>
					</div><?php
					if(intval($thumbnail_id) > 0)
					{?>
						<div class="solution-thumbnail-box">
							<div class="solution-thumbnail" style="background-image: url(<?php echo $second_image != "" ? $second_image : wp_get_attachment_url( $thumbnail_id ); ?>);">
							</div>
						</div><?php
					}?>
				</div>
				<div class="solution-single-content">
					<div class="solution-single-content-col1">
						<?php $country = get_post_meta(get_the_ID(), 'solution-country', true);
						if(!empty($country))
						{?>
							<div class="solution-single-post-region">
								<h2><?php echo __('Region', 'minka'); ?></h2>
								<p><?php echo $country ?></p>
							</div><?php
						}?>
						<?php $can_use = get_post_meta(get_the_ID(), 'solution-for', true);
						if(!empty($can_use))
						{?>
						<div class="span solution-single-post-can-use">
							<h2><?php echo __('Who can use', 'minka');?></h2>
							<p><?php echo $can_use; ?></p>
						</div><?php 
						}
						$contact = get_post_meta(get_the_ID(), 'solution-contact', true);
						if(!empty($contact))
						{?>
							<div class="span solution-single-post-contact">
								<h2><?php echo __('Useful tips and facts', 'minka');?></h2>
								<p><?php echo $contact; ?></p>
							</div><?php 
						}
						$sharing = get_post_meta(get_the_ID(), 'solution-sharing', true);
						if(!empty($sharing))
						{?>
						<div class="span solution-single-post-sharing">
							<h2><?php echo __('Appreciation', 'minka');?></h2>
							<p><?php echo $sharing; ?></p>
						</div><?php 
						}
						if(has_tag())
						{?>
						<div class="solution-single-post-tags">
							<h2><?php echo __('Tags');?></h2>
							<?php the_tags('', ', '); ?>
						</div><?php 
						}?>
					</div>
					<div class="solution-single-content-col2">
						<div class="solution-single-post-content">
							<h2><?php echo __('Description', 'minka'); ?></h2>
							<p><?php the_content();?></p>
						</div><?php
						$url = get_post_meta(get_the_ID(), 'solution-url', true);
						if(!empty($url))
						{?>
							<div class="solution-single-post-url-entry">
								<div class="">
									<a class="solution-single-post-url-copy" href="<?php echo $url; ?>" target="_blank" >
                                        <?php echo $url; ?>
                                    </a>
								</div>
							</div><?php 
						}?>
					</div>
				</div>
				<!--div class="solution-single-post-rate">
					<div class="solution-single-post-rate-entry">
						<div class="solution-single-post-rate-result">
							<div class="solution-single-post-rate-result-label">
								<?php _e( 'Ease of use', 'minka' ); ?>
							</div>
							<div class="solution-single-post-rate-result-rating">
								<?php the_rating(); ?>
							</div>
						</div>
						<div class="solution-single-post-exp-result">
							<div class="solution-single-post-exp-result-label">
								<?php _e( 'Experience', 'minka' ); ?>
							</div>
							<div class="solution-single-post-exp-result-rating">
								<?php the_experience(); ?>
							</div>
						</div>
					</div>
				</div-->
				<div class="solution-single-post-exp-form-entry">
					<h3><?php _e('Share your experience', 'minka');?></h3>
					<div class="solution-single-post-exp needs-rating">
						<div class="solution-single-post-form-rate">
							<h2 class="solution-single-post-rate-title">
								Valora tu experiencia
							</h2>
							<?php the_rate_form(); ?>
						</div>
						<!--div class="solution-single-post-form-exp">
							<h2 class="solution-single-post-experience-title">
								<?php _e("Experience", "minka"); ?>
							</h2>
							<?php the_rate_formExperience(); ?>
						</div-->
					</div>
				</div>

				<div class="solution-single-post-comments">
				<?php
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>
				</div>
			<?php
			}
		}
	?>
	</div>
</div>
</div>


<?php get_footer(); ?>
