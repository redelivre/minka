<?php

require_once dirname(__FILE__).'/HTMLPurifier.standalone.php';

$solution = new Solutions();

$publish = array_key_exists('publish', $_POST) && ($_POST['publish'] == 'Publish' || $_POST['publish'] == 'Publish Solution');

$post_type = '';
if ( !isset($_GET['post_type']) )
	$post_type = 'solution';
elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
	$post_type = $_GET['post_type'];
else
	wp_die( __('Invalid post type') );

$post_type_object = get_post_type_object( $post_type );

$language_code = array_key_exists('icl_post_language', $_POST) ? $_POST['icl_post_language'] : 'es';

if ( ! is_user_logged_in() )
{?>
<div class="home-entry" >
    <div class="row">
        <div class="col-lg-12 sections-description">
            <h2 class="text-center">Minka.me es una plataforma para promover y difundir la Economía Colaborativa</h2>
        </div>
    </div>
</div>
<div class="home-entry" style="background: #FFF">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center"><?php echo __('You do not have access to this page, please make login or change your login account', 'minka'); ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-lg-4 col-md-offset-4  col-lg-offset-4">
		<div class="text-center block-center">
			 <?php wp_login_form( ); ?> 
		</div>
        </div>
    </div>
</div>
<?php
}
else 
{

	$attach_id = array();
	$attach = array();
	
	$has_thumbnail = false;
	$has_thumbnail2 = false;
	
	$title = $post_type_object->labels->add_new_item;
	
	$editing = true;
	$post = null;
	if($publish && array_key_exists('post_ID', $_POST) && $_POST['post_ID'] > 0)
	{
		$post = get_post($_POST['post_ID']);
	}
	else 
	{
		$post = $solution->get_default_post_to_edit( $post_type, $publish );
	}
	
	$post_ID = $post->ID;
	
	if($publish && $post_ID == 0) wp_die('Something is wrong!!!');
	
	$user_ID = get_current_user_id();
	
	$form_extra = '';
	
	$message = array();
	
	$notice = false;
	
	$purifier = new HTMLPurifier();
	
	if($publish)
	{
		/* Save Fields and Custom Fields */
		foreach ($solution->getFields() as $key => $field)
		{
			if( (array_key_exists('required', $field) && $field['required']) && (! array_key_exists($field['slug'], $_POST) || empty($_POST[$field['slug']]) ))
			{
				$message[] = __('required field').': '.$field['title'].' '.__('is empty');
				$notice = true;
			}
			else 
			{
				
				if(array_key_exists('buildin', $field) && $field['buildin'] == true)
				{
					if(array_key_exists('type', $field) && $field['type'] == 'wp_editor')
					{
						$post->{$field['slug']} = $purifier->purify(stripslashes($_POST[$field['slug']]));
					}
					else 
					{
						$post->{$field['slug']} = wp_strip_all_tags($_POST[$field['slug']]);
					}
				}
				else 
				{
					update_post_meta($post_ID, $field['slug'], $_POST[$field['slug']]);
				}
			}
		}
		
		$post->post_name = sanitize_title($post->post_title);
		
		wp_update_post($post);
		
		/* Save Language */
		global $sitepress;
		if(is_object($sitepress))
		{
			$sitepress->set_element_language_details($post_ID, 'post_'.get_post_type($post_ID), null , $language_code, null);
		}
		
		/* Save Categories */
		
		$args = array(
			'public'   => true,
		);
		$output = 'names'; // or objects
		$operator = 'and'; // 'and' or 'or'
		$taxonomies = get_taxonomies( $args, $output, $operator );
		
		foreach ($taxonomies as $taxonomy)
		{
			if(array_key_exists('taxonomy_'.$taxonomy, $_POST))
			{
				$result = wp_set_post_terms($post_ID, $_POST['taxonomy_'.$taxonomy], $taxonomy);
				if( is_object($result) && get_class($result) == 'WP_Error' )
				{
					$message[] = __('error on set post taxonomy', 'minka').': '.$taxonomy;
					$notice = true;
				}
			}
		}
		
		/* Save Attached Content */
		
		if (!function_exists('wp_generate_attachment_metadata')){
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		
		$has_thumbnail = true;
		$has_thumbnail2 = true;
		
		if ($_FILES) {
			foreach ($_FILES as $file => $array) {
				if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK && $notice)
				{
					switch($file)
					{
						case 'thumbnail':
							$message[] = __('error on set post thumbnail image', 'minka');
							$has_thumbnail = false;
							break;
						case 'thumbnail2':
							$message[] = __('error on set post header image', 'minka');
							$has_thumbnail2 = false;
							break;
						default:
							$message[] = __('error on set post images', 'minka');
							break;
					}
						
					$notice = true;
				}
				else 
				{
					$attach_id[$file] = media_handle_upload( $file, $post_ID );
					$attach[$file] = wp_get_attachment_url($attach_id[$file]);
				}
			}
		}
		foreach ($attach_id as $key => $value)
		{
			//and if you want to set that image as Post  then use:
			if($key == 'thumbnail' && $has_thumbnail)
			{
				if( ! update_post_meta($post_ID,'_thumbnail_id',$attach_id['thumbnail']))
				{
					$message[] = __('error on set post thumbnail', 'minka');
					$notice = true;
				}
			}
			elseif($key == 'thumbnail2' && $has_thumbnail2)
			{
				if( ! update_post_meta($post_ID,'thumbnail2', $attach['thumbnail2'] ) )
				{
					$message[] = __('error on set post header image', 'minka');
					$notice = true;
				}
			}
		}
		
        /*
		var_dump($message);
		echo '<pre>';
		var_dump($_POST);
		echo '<br/>';
		var_dump($post);
		echo '<br/>';
		var_dump($attach_id);
		echo '</pre>';
		
        */
		
		if($notice == false && count($message) == 0)
		{?>
			<div class="new-solution-sucess"><?php _e('A new solution was successfully created and waiting approval, thanks'); ?>
			</div><?php
			return ;
		}
	}
	
	$form_action = 'editpost';
	$nonce_action = 'update-post_' . $post_ID;
	$form_extra .= "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($post_ID) . "' />";
	


	?>
	
<div class="home-entry" >
    <div class="row">
        <div class="col-lg-12 sections-description">
            <h2 class="text-center">Minka.me es una plataforma para promover y difundir la Economía Colaborativa</h2>
        </div>
    </div>
</div>
<div class="home-entry" style="background: #FFF">

<div class="container">
	<div class="row">
		<div class="col-md-12">
	<?php //screen_icon(); ?>
	<h2 class= "new-solution"><?php
	echo esc_html( $title );
	if ( isset( $post_new_file ) && current_user_can( $post_type_object->cap->create_posts ) )
		echo ' <a href="' . esc_url( $post_new_file ) . '" class="add-new-h2">' . esc_html( $post_type_object->labels->add_new ) . '</a>';
	?></h2>
	<?php if ( $notice ) : ?>
	<div id="notice" class="error"><p><?php echo implode( '<br/>', $message ); ?></p></div>
	<?php endif; ?>
	<?php if ( !$notice && count($message) > 0 ) : ?>
	<div id="message" class="updated"><p><?php echo implode( '<br/>', $message ); ?></p></div>
	<?php endif; ?>
	<form name="post" action="" method="post" id="post"<?php do_action('post_edit_form_tag', $post); ?> enctype="multipart/form-data" >
	<?php wp_nonce_field($nonce_action); ?>
	<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
	<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
	<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
	<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
	<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
	<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
	<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(stripslashes(wp_get_referer())); ?>" />
	<?php if ( ! empty( $active_post_lock ) )
	{?>
		<input type="hidden" id="active_post_lock" value="<?php echo esc_attr( implode( ':', $active_post_lock ) ); ?>" /><?php
	}
	if(function_exists('icl_get_current_language'))
	{?>
		<input type="hidden" id="icl_post_language" name="icl_post_language" value="<?php echo stripslashes(icl_get_current_language()); ?>" /><?php
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
		switch ($type)
		{
			case 'date':
			default:	
				?>
				<div class="solution-item">
					<label for="<?php echo $id ?>" class="solution-item-label">
							<div class="solution-item-title"><?php echo $label;
								if(array_key_exists( 'required', $field ) && $field['required'])
								{?>
									<span class="solution-item-required-asterisk">*</span><?php
								}?>
							</div>
						<div class="solution-item-tip-text"><?php echo $tip; ?>
						</div>
					</label>
					<input type="text" id="<?php echo $id ?>" class="solution-item-input-text <?php echo $type == 'date' ? 'hasdatepicker' : ''; ?> <?php echo $input_class ?>" value="<?php echo array_key_exists($id, $_REQUEST) ? wp_strip_all_tags($_REQUEST[$id]) : ''; ?>" name="<?php echo $id ?>">
					<div class="solution-item-error-message"></div>
					<div class="solution-item-required-message"><?php echo $required_message; ?></div>
				</div>
				<?php
			break;
			case 'wp_editor':
				?>
				<div class="solution-item">
					<label for="<?php echo $id ?>" class="solution-item-label">
						<div class="solution-item-title"><?php echo $label; ?>
							<span class="solution-item-required-asterisk">*</span>
						</div>
						<div class="solution-item-tip-text">
							<?php echo $tip; ?>
						</div>
					</label>
					<?php wp_editor((array_key_exists($id, $_POST) ? stripslashes($purifier->purify($_POST[$id])) : ''), $id,  array( 
				       'tinymce' => array( 
				            'content_css' => get_stylesheet_directory_uri() . '/inc/solutions/css/editor-styles.css' 
				    		)
						)
					); ?>
					<div class="solution-item-error-message"></div>
					<div class="solution-item-required-message">
						<?php echo $required_message; ?>
					</div>
				</div>
				<?php
			break;
			
		}
	}//TODO Make image a field
	?>
	<div class="images">
		<div class="images-thumbnail">  
			<label for="thumbnail" class="solution-item-label">
				<div class="solution-item-title"><?php _e('Highlight Image', 'minka'); ?>
				</div>
				<div class="solution-item-tip-text">
					<?php _e('Image showed on listing, like on home or catalog!', 'minka'); ?>
				</div>
			</label>
			<input type="file" name="thumbnail" id="thumbnail" value="<?php ?>" onchange="displayPreview(this.files, 'thumbnail');" ><?php
			if($has_thumbnail && array_key_exists('thumbnail', $attach))
			{?>
				<img src="<?php echo $attach['thumbnail']; ?>"><?php
			}?>
		</div>
		<div class="images-thumbnail2">
			<label for="thumbnail2" class="solution-item-label">
				<div class="solution-item-title"><?php _e('Header Image', 'minka'); ?>
				</div>
				<div class="solution-item-tip-text">
					<?php _e('Image showed on Header!', 'minka'); ?>
				</div>
			</label>
			<input type="file" name="thumbnail2" id="thumbnail2" value="<?php echo array_key_exists('thumbnail2', $_REQUEST) ? esc_url($_REQUEST['thumbnail2']) : ''; ?>" onchange="displayPreview(this.files, 'thumbnail2');" ><?php
			if($has_thumbnail2 && array_key_exists('thumbnail2', $attach))
			{?>
				<img src="<?php echo $attach['thumbnail2']; ?>"><?php
			}?>
		</div>
	</div>
	<div class="category-group">
	<?php 
	Solutions::taxonomy_checklist();
	?>
	</div>
	
	<input id="original_publish" type="hidden" value="Publish" name="original_publish">
	<input id="publish" class="button button-primary button-large" type="submit" accesskey="p" value="<?php _e('Publish Solution', 'minka'); ?>" name="publish">
	</form>
	</div>
</div>
</div>
</div>
<?php 
}

