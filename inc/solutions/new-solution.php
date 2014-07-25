<?php
$solution = new Solutions();

$post_type = '';
if ( !isset($_GET['post_type']) )
	$post_type = 'solution';
elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
	$post_type = $_GET['post_type'];
else
	wp_die( __('Invalid post type') );

$post_type_object = get_post_type_object( $post_type );

if ( ! current_user_can( $post_type_object->cap->edit_posts ) || ! current_user_can( $post_type_object->cap->create_posts ) )
{
	echo '<h1>'.__('You do not have access to this page, please make login or change your login account', 'minka').'</h1>';
}
else 
{

	$title = $post_type_object->labels->add_new_item;
	
	$editing = true;
	
	$post = $solution->get_default_post_to_edit( $post_type, true );
	$post_ID = $post->ID;
	global $user_ID;
	
	$post_ID = isset($post_ID) ? (int) $post_ID : 0;
	$user_ID = isset($user_ID) ? (int) $user_ID : 0;
	
	$form_extra = '';
	
	$message = array();
	
	$notice = false;
	
	$form_action = 'editpost';
	$nonce_action = 'update-post_' . $post_ID;
	$form_extra .= "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($post_ID) . "' />";
	
	
	?>
	
	<div class="wrap">
	<?php //screen_icon(); ?>
	<h2 class= "new-solution"><?php
	echo esc_html( $title );
	if ( isset( $post_new_file ) && current_user_can( $post_type_object->cap->create_posts ) )
		echo ' <a href="' . esc_url( $post_new_file ) . '" class="add-new-h2">' . esc_html( $post_type_object->labels->add_new ) . '</a>';
	?></h2>
	<?php if ( $notice ) : ?>
	<div id="notice" class="error"><p><?php echo $notice ?></p></div>
	<?php endif; ?>
	<?php if ( $message ) : ?>
	<div id="message" class="updated"><p><?php echo $message; ?></p></div>
	<?php endif; ?>
	<form name="post" action="" method="post" id="post"<?php do_action('post_edit_form_tag', $post); ?>>
	<?php wp_nonce_field($nonce_action); ?>
	<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
	<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
	<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
	<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
	<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
	<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
	<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(stripslashes(wp_get_referer())); ?>" />
	<?php if ( ! empty( $active_post_lock ) ) { ?>
	<input type="hidden" id="active_post_lock" value="<?php echo esc_attr( implode( ':', $active_post_lock ) ); ?>" />
	<?php
	}
	if ( 'draft' != get_post_status( $post ) )
		wp_original_referer_field(true, 'previous');
	
	echo $form_extra;
	
	foreach ($solution->getFields() as $field)
	{
		$id = $field['slug'];
		$label = $field['title'];
		$tip = $field['tip'];
		$required_message = '';
		$input_class = '';
		$type = array_key_exists('type', $field) ? $field['type'] : '';
	?>
		<div class="solution-item">
			<label for="<?php echo $id ?>" class="solution-item-label">
				<div class="solution-item-title"><?php echo $label; ?>
					<span class="solution-item-required-asterisk">*</span>
				</div>
				<div class="solution-item-tip-text"><?php echo $tip; ?>
				</div>
			</label>
			<input type="text" id="<?php echo $id ?>" class="solution-item-input-text <?php echo $type == 'date' ? 'hasdatepicker' : ''; ?> <?php echo $input_class ?>" value="<?php echo array_key_exists($id, $_REQUEST) ? wp_strip_all_tags($_REQUEST[$id]) : ''; ?>" name="<?php echo $id ?>">
			<div class="solution-item-error-message"></div>
			<div class="solution-item-required-message"><?php echo $required_message; ?></div>
		</div>
		<?php 
	}
	?>
	
	<div class="category-group">
	<?php 
	$solution->taxonomy_checklist();
	?>
	</div>
	
	<input id="original_publish" type="hidden" value="Publish" name="original_publish">
	<input id="publish" class="button button-primary button-large" type="submit" accesskey="p" value="Publish" name="publish">
	</form>
	</div>
<?php 
}

