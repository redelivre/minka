<?php
/*
Template Name: Authors
*/

$usersArgs = array(
		'orderby'         => 'nicename',
		'order'           => 'ASC',
);

if(get_query_var('author_name'))
{
	$usersArgs['search'] = get_query_var('author_name');
	$usersArgs['search_columns'] = array('nicename');
}

$users_query = new WP_User_Query($usersArgs);
$users = $users_query->get_results();

get_header();

?>

<div class="authors.php">
	<div class="templeta-authors-entry">
		<div class="authors-list"><?php
			foreach ($users as $user)
			{?>
				<div class="author-box">
					<div class="author-head">
						<div class="author-image-bol" >
							<?php echo get_avatar($user->ID, 80); ?>
						</div>
						<div class="author-infos">
							<div class="author-nicename">
								<?php echo $user->user_nicename; ?>
							</div>
							<div class="author-organization">
								<?php echo get_user_meta($user->ID, 'organization', true); ?>
							</div>
							<div class="author-location">
								<?php
									$str = get_user_meta($user->ID, 'city', true).'/'.get_user_meta($user->ID, 'country', true);
									if($str != '/')
									{
										echo $str;
									}
								?>
							</div>
							<div class="author-email">
								<?php echo str_replace('@', ' at ', $user->user_email); ?>
							</div>
						</div>
					</div>
					<div class="author-content">
						<?php echo get_user_meta($user->ID, 'description', true) ?>
					</div>
					<div class="author-solutions">
						<a href="/solution<?php echo "?author_search=".$user->user_nicename; ?>" class="author-solutions-link"><?php _e('View my solutions'); ?></a>
					</div>
				</div>
			<?php
			}?>
		</div>
		<div class="network-sidebar">
			<?php dynamic_sidebar('network-sidebar'); ?>
		</div>
	</div>
</div><?php

get_footer();
?>