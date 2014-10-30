<?php get_header(); ?>
<div class="solution-entry-content">
	<div class="solution-single-sidebar">
		<?php dynamic_sidebar('solution-sidebar'); ?>
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
						<div class="solution-single-post-title">
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
						</div>
						<div class="solution-single-link-catalog" onclick="window.location='<?php echo get_post_type_archive_link( 'solution' ); ?>';return false;">
							<?php _e('View the Catalog', 'minka') ?>
						</div>
					</div><br/><?php
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
								<div class="solution-single-post-url-copy">
									<?php echo $url; ?>
								</div>
								<div class="solution-single-post-url">
									<a href="<?php echo $url; ?>" target="_blank" ><?php _e('view web site', 'minka')?></a>
								</div>
							</div><?php 
						}?>
					</div>
				</div>
				<div class="solution-single-post-rate">
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
				</div>
				<div class="solution-single-post-exp-form-entry">
					<h3><?php _e('Share your experience', 'minka');?></h3>
					<div class="solution-single-post-exp needs-rating">
						<div class="solution-single-post-form-rate">
							<h2 class="solution-single-post-rate-title">
								<?php _e("Usability", "minka"); ?>
							</h2>
							<?php the_rate_form(); ?>
						</div>
						<div class="solution-single-post-form-exp">
							<h2 class="solution-single-post-experience-title">
								<?php _e("Experience", "minka"); ?>
							</h2>
							<?php the_rate_formExperience(); ?>
						</div>
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


<?php get_footer(); ?>