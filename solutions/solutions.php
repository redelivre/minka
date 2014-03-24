<?php

class Solutions
{
	function __construct()
	{
		add_action('init', array($this, 'init'));
		add_action('init', array($this, 'rewrite_rules'));
		add_action('template_redirect', array($this, 'form'));
		add_action('wp_ajax_resetpass', array($this, 'form'));
		add_action('wp_ajax_nopriv_resetpass', array($this, 'form'));
		add_filter('query_vars', array($this, 'print_variables'));
		//add_filter('archive_template', array($this, 'archiveTemplate'));
		//add_filter('single_template', array($this, 'singleTemplate'));
		add_action( 'save_post', array( $this, 'save' ) );
	}

	function init()
	{
		$this->Add_custom_Post();
	}
	
	function Add_custom_Post()
	{
		$labels = array
		(
				'name' => __('Solutions','minka'),
				'singular_name' => __('Solution','minka'),
				'add_new' => __('Add new','minka'),
				'add_new_item' => __('Add new solution','minka'),
				'edit_item' => __('Edit solution','minka'),
				'new_item' => __('New Solution','minka'),
				'view_item' => __('View Solution','minka'),
				'search_items' => __('Search Solution','minka'),
				'not_found' =>  __('Solution not found','minka'),
				'not_found_in_trash' => __('Solution not found in the trash','minka'),
				'parent_item_colon' => '',
				'menu_name' => __('Solutions','minka')
	
		);
	
		$args = array
		(
				'label' => __('Solutions','minka'),
				'labels' => $labels,
				'description' => __('Solutions','minka'),
				'public' => true,
				'publicly_queryable' => true, // public
				//'exclude_from_search' => '', // public
				'show_ui' => true, // public
				'show_in_menu' => true,
				'menu_position' => 5,
				// 'menu_icon' => '',
				'capability_type' => array('solution','solutions'),
				'map_meta_cap' => true,
				'hierarchical' => false,
				'supports' => array('title', 'editor', 'author', 'excerpt', 'trackbacks','thumbnail', 'revisions', 'comments'),
				'register_meta_box_cb' => array($this, 'minka_solution_custom_meta'), // função para chamar na edição
				'taxonomies' => array('post_tag','category'), // Taxionomias já existentes relaciondas, vamos criar e registrar na sequência
				'permalink_epmask' => 'EP_PERMALINK ',
				'has_archive' => true, // Opção de arquivamento por slug
				'rewrite' => true,
				'query_var' => true,
				'can_export' => true//, // veja abaixo
				//'show_in_nav_menus' => '', // public
				//'_builtin' => '', // Core
				//'_edit_link' => '' // Core
	
		);
	
		register_post_type("solution", $args);
	}
	
	function minka_solution_custom_meta()
	{
		add_meta_box("solution_meta", "Solution Details", array($this, 'solution_meta'), 'solution', 'side', 'default');
	}
	
	protected $_customs = array
	(
		'url' => array
		(
			'slug' => 'solution-url',
			'title' => 'URL',
			'tip' => 'web address',
			'required' => true
		),
		'created-date' => array
		(
			'slug' => 'solution-created-date',
			'title' => 'Created date',
			'tip' => 'since when is available',
			'required' => false,
			'type' => 'date',
		),
		'coverage' => array
		(
			'slug' => 'solution-coverage',
			'title' => 'Coverage',
			'tip' => 'Country/ies where available'
		),
		'country' => array
		(
			'slug' => 'solution-country',
			'title' => 'Country where it was created',
			'tip' => 'Where arises'
		),
		'facebook' => array
		(
			'slug' => 'solution-facebook',
			'title' => 'Facebook',
			'tip' => ''
		),
		'twitter' => array
		(
			'slug' => 'solution-twitter',
			'title' => 'Twitter',
			'tip' => ''
		),
		'contact' => array
		(
			'slug' => 'solution-contact',
			'title' => 'Contact',
			'tip' => 'e-mail',
			'required' => true
		),
	);
	
	function getFields()
	{
		$post = array(
			'post_title' => array(
				'slug' => 'post_title',
				'title' => 'Solution name',
				'tip' => '',
				'required' => true
			),
			'post_content' => array(
				'slug' => 'post_content',
				'title' => 'Description',
				'tip' => 'Maximum 300 characters',
				'required' => true
			),
		);
		
		return array_merge($post, $this->_customs);
	}
	
	function solution_meta()
	{
		global $post;
		
		$custom = get_post_custom($post->ID);
		if(!is_array($custom)) $custom = array();
		
		$disable_edicao = '';
		
		/*if (
				!($post->post_status == 'draft' ||
				$post->post_status == 'auto-draft' ||
				$post->post_status == 'pending')
		)
		{
			$disable_edicao = 'readonly="readonly"';
		}*/
		
		wp_nonce_field( 'solution_meta_inner_custom_box', 'solution_meta_inner_custom_box_nonce' );
		
		foreach ($this->_customs as $slug => $campo )
		{
			$dado = array_key_exists($slug, $custom) ? $custom[$slug] : '';
			
			?>
			<p>
				<label for="<?php echo $slug; ?>" class="<?php echo 'label_'.$slug; ?>"><?php echo $campo['title'] ?>:</label>
				<input <?php echo $disable_edicao ?> id="<?php echo $slug; ?>" name="<?php echo $slug; ?>" class="<?php echo $slug.(array_key_exists('type', $campo) && $campo['type'] == 'date' ? 'hasdatepicker' : '') ; ?> " value="<?php echo $dado; ?>"/>
			</p>
			<?php
			
		}
	}
	
	function taxonomy_checklist($taxonomy = 'category', $parent = 0)
	{
		/*global $posts, $wpdb;
	
		$terms = array();
		$terms_ids = array();
	
	
		$posts_ids = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key ='_mpv_inmap' ");
	
		foreach($posts_ids as $post_id)
		{
			$_terms = get_the_terms($post_id, $taxonomy);
	
			if(is_array($_terms))
			{
				foreach($_terms as $_t)
				{
					if(!in_array($_t->term_id,$terms_ids) && $_t->parent == $parent)
					{
						$terms_ids[] = $_t->term_id;
						$key = $_t->name;
						$ikey = filter_var($_t->name, FILTER_SANITIZE_NUMBER_INT);
						if(intval($ikey) > 0)
						{
							$key = substr($ikey, 2).substr($ikey, 0, 2);// TODO arrumar um jeito de definir para datas
						}
						$terms[$key] = $_t;
					}
				}
			}
		}*/
		
		$args = array(
				'orderby' => 'id',
				'hide_empty'=> 0,
				'parent' => $parent,
				'hierarchical' => 0,
				'taxonomy'=>$taxonomy
				
		);
		global $sitepress;
		$sitepress->switch_lang('es');
		$terms = get_terms($taxonomy, $args);
		//print_r($terms);
	
		if (!is_array($terms) || ( is_array($terms) && sizeof($terms) < 1 ) )
		{
			return;
		}
		/*$terms_keys = array_keys($terms);
		natcasesort($terms_keys);
		$terms_a = $terms;
		$terms = array();
		foreach ($terms_keys as $key)
		{
			$terms[] = $terms_a[$key];
		}*/
	
	
		/*if($parent == 0): ?>
			<?php $tax = get_taxonomy($taxonomy); ?>
			<li class="category-group-col"><h3><?php echo $tax->label; ?></h3>
		<?php endif;*/ ?>
			<?php if ($parent > 0): ?>
				<ul class='children'>
			<?php endif; ?>
	
			<?php foreach ($terms as $term):
				$name = $term->name;
				$input = '';
				if(strpos($name, '#input#') !== false)
				{
					$name = str_replace('#input#', '', $name);
					$value = array_key_exists($taxonomy.'_'.$term->term_id.'_input', $_REQUEST) ? $_REQUEST[$taxonomy.'_'.$term->term_id.'_input'] : ''; 
					$input = '<input type="text" class="taxonomy-category-checkbox-text" name="'.$taxonomy.'_'.$term->term_id.'_input" id="category_'.$taxonomy.'_'.$term->slug.'_input" value="'.$value.'" />';
				}
				$checked = isset($_REQUEST) && array_key_exists("category_$taxonomy", $_REQUEST) && array_search($term->slug, $_REQUEST["category_$taxonomy"]) ? 'checked="checked"' : '';				
			?>
				<li class="category-group-col">
					<?php if($parent > 0 && $input == ''): ?>
						<input type="checkbox" class="taxonomy-category-checkbox" value="<?php echo $term->term_id; ?>" name="category_<?php echo $taxonomy; ?>[]" id="category_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>" <?php echo $checked; ?> />
					<?php endif; ?>
					<label for="category_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>">
						<?php
							echo $name;
						?>
					</label>
						<?php
							echo $input; 
						?>
						<?php $this->taxonomy_checklist($taxonomy, $term->term_id); ?>
				</li>
	
			<?php endforeach; ?>
	
			<?php if ($parent > 0): ?>
				</ul>
			<?php endif;
		/*if($parent == 0): ?>
			</li>
		<?php endif; */?>
		<?php
	}
	
	const NEW_SOLUTION_PAGE = 'new-solution';
	
	function print_variables($public_query_vars) {
		$public_query_vars[] = self::NEW_SOLUTION_PAGE;
		return $public_query_vars;
	}
	
	function rewrite_rules()
	{
		add_rewrite_rule(self::NEW_SOLUTION_PAGE.'(.*)', 'index.php?'.self::NEW_SOLUTION_PAGE.'=true$matches[1]', 'top');
		flush_rewrite_rules();
	}
	
	function form()
	{
		if(get_query_var(self::NEW_SOLUTION_PAGE) == true)
		{
			wp_enqueue_script('jquery-ui-datepicker-ptbr', WP_CONTENT_URL.'/themes/minka/solutions/js/jquery.ui.datepicker-pt-BR.js', array('jquery-ui-datepicker'));
			wp_enqueue_script('date-scripts',WP_CONTENT_URL.'/themes/minka/solutions/js/date_scripts.js', array( 'jquery-ui-datepicker-ptbr'));
			get_header();
			$file_path = get_stylesheet_directory() . '/new-solution.php';
			if(file_exists($file_path))
			{
				include $file_path;
			}
			else
			{
				include dirname(__FILE__) . '/new-solution.php';;
			}
			get_footer();
			exit();
		}
	}
	
	/**
	 * Default post information to use when populating the "Write Post" form customized for sulution.
	 *
	 * @since 2.0.0
	 *
	 * @param string $post_type A post type string, defaults to 'post'.
	 * @return WP_Post Post object containing all the default post data as attributes
	 */
	function get_default_post_to_edit( $post_type = 'solution', $create_in_db = false ) {
		global $wpdb;
	
		echo '<pre>';
		var_dump($_REQUEST);
		echo '</pre>';
		$post_title = '';
		if ( !empty( $_REQUEST['post_title'] ) )
			$post_title = esc_html( stripslashes( $_REQUEST['post_title'] ));
	
		$post_content = '';
		if ( !empty( $_REQUEST['content'] ) )
			$post_content = esc_html( stripslashes( $_REQUEST['content'] ));
	
		$post_excerpt = '';
		if ( !empty( $_REQUEST['excerpt'] ) )
			$post_excerpt = esc_html( stripslashes( $_REQUEST['excerpt'] ));
	
		if ( $create_in_db ) {
			$post_id = wp_insert_post( array( 'post_title' => __( 'Auto Draft' ), 'post_type' => $post_type, 'post_status' => 'auto-draft' ) );
			$post = get_post( $post_id );
			if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) && get_option( 'default_post_format' ) )
				set_post_format( $post, get_option( 'default_post_format' ) );
		} else {
			$post = new stdClass;
			$post->ID = 0;
			$post->post_author = '';
			$post->post_date = '';
			$post->post_date_gmt = '';
			$post->post_password = '';
			$post->post_type = $post_type;
			$post->post_status = 'draft';
			$post->to_ping = '';
			$post->pinged = '';
			$post->comment_status = get_option( 'default_comment_status' );
			$post->ping_status = get_option( 'default_ping_status' );
			$post->post_pingback = get_option( 'default_pingback_flag' );
			$post->post_category = get_option( 'default_category' );
			$post->page_template = 'default';
			$post->post_parent = 0;
			$post->menu_order = 0;
			$post = new WP_Post( $post );
		}
	
		$post->post_content = apply_filters( 'default_content', $post_content, $post );
		$post->post_title   = apply_filters( 'default_title',   $post_title, $post   );
		$post->post_excerpt = apply_filters( 'default_excerpt', $post_excerpt, $post );
		$post->post_name = '';
	
		return $post;
	}
	
	/**
	 * Inclui os arquivos do tema relacionados com
	 * a listagem de pautas e retorna o template
	 * a ser usado.
	 *
	 * @param string $archiveTemplate
	 * @return string
	 */
	public function archiveTemplate($archiveTemplate)
	{
		global $post;
	
		if (get_post_type($post) == "solution" || is_post_type_archive('solution'))
		{
			if(file_exists(get_stylesheet_directory()."/archive-pauta.php"))
			{
				$archive_template = get_stylesheet_directory()."/archive-pauta.php";
			}
			else
			{
				$archiveTemplate = $this->themeFilePath('archive-pauta.php');
			}
		}
	
		return $archiveTemplate;
	}
	
	/**
	 * Inclui os arquivos do tema relacionados com
	 * a página de uma pauta e retorna o template
	 * a ser usado.
	 *
	 * @param string $singleTemplate
	 * @return string
	 */
	public function singleTemplate($singleTemplate)
	{
		global $post;
	
		if (get_post_type($post) == "pauta" || is_post_type_archive('pauta'))
		{
			if(file_exists(get_stylesheet_directory()."/single-pauta.php"))
			{
				$singleTemplate = get_stylesheet_directory()."/single-pauta.php";
			}
			else
			{
				$singleTemplate = $this->themeFilePath('single-pauta.php');
			}
		}
	
		return $singleTemplate;
	}
	
	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id )
	{
		
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		* because save_post can be triggered at other times.
		*/
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['solution_meta_inner_custom_box_nonce'] ) )
		{
			return $post_id;
		}
		
		$nonce = $_POST['solution_meta_inner_custom_box_nonce'];
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'solution_meta_inner_custom_box' ) )
		{
			return $post_id;
		}
		
		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		{
			return $post_id;
		}
	
		// Check the user's permissions.
		if ( 'solution' == $_POST['post_type'] )
		{
			if ( ! current_user_can( 'edit_solution', $post_id ) )
			{
				return $post_id;
			}
		}
		else
		{
			return $post_id;
		}
	
		/* OK, its safe for us to save the data now. */
		
		foreach ($this->_customs as $field)
		{
			// Sanitize the user input.
			$mydata = sanitize_text_field( $_POST[$field->slug] );
		
			// Update the meta field.
			update_post_meta( $post_id, $field->slug, $mydata );
		}
	}
	
}

new Solutions();

?>