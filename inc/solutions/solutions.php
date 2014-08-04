<?php

class Solutions
{
	function __construct()
	{
		$this->_customs = array(
			'url' => array
			(
					'slug' => 'solution-url',
					'title' => __('URL', 'minka'),
					'tip' => __('web site address', 'minka'),
					'required' => true
			),
			'for' => array
			(
					'slug' => 'solution-for',
					'title' => __('for serving?', 'minka'),
					'tip' => __('for serving', 'minka'),
					'required' => true
			),
			'coverage' => array(
					'slug' => 'solution-coverage',
					'title' => __ ( 'to whom it is addressed', 'minka' ),
					'tip' => __ ( 'coverage', 'minka' ) 
			),
			'sharing' => array (
					'slug' => 'solution-sharing',
					'title' => __ ( 'for sharing', 'minka' ),
					'tip' => __ ( 'sharing', 'minka' ) 
			),
			'country' => array (
					'slug' => 'solution-country',
					'title' => __ ( 'available to countries', 'minka' ),
					'tip' => __ ( 'country', 'minka' )
			),
			'contact' => array (
					'slug' => 'solution-contact',
					'title' => __ ( 'Contact', 'minka' ),
					'tip' => __ ( 'e-mail', 'minka' ),
					'required' => true 
			) 
		);
		
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
	
	protected $_customs = array();
	
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
				'required' => true,
				'type' => 'wp_editor'
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
		
		foreach ($this->_customs as $key => $campo )
		{
			$slug = $campo['slug'];
			$dado = array_key_exists($slug, $custom) ? array_pop($custom[$slug]) : '';
			
			
			?>
			<p>
				<label for="<?php echo $slug; ?>" class="<?php echo 'label_'.$slug; ?>"><?php echo $campo['title'] ?>:</label>
				<input <?php echo $disable_edicao ?> id="<?php echo $slug; ?>"
					name="<?php echo $slug; ?>"
					class="<?php echo $slug.(array_key_exists('type', $campo) && $campo['type'] == 'date' ? 'hasdatepicker' : '') ; ?> "
					value="<?php echo $dado; ?>" />
			</p>
			<?php
			
		}
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
			//wp_enqueue_script('jquery-ui-datepicker-ptbr', WP_CONTENT_URL.'/themes/minka/solutions/js/jquery.ui.datepicker-pt-BR.js', array('jquery-ui-datepicker'));
			//wp_enqueue_script('date-scripts',WP_CONTENT_URL.'/themes/minka/solutions/js/date_scripts.js', array( 'jquery-ui-datepicker-ptbr'));
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
	 * a listagem de solutions e retorna o template
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
			if(file_exists(get_stylesheet_directory()."/archive-solution.php"))
			{
				$archive_template = get_stylesheet_directory()."/archive-solution.php";
			}
			else
			{
				$archiveTemplate = $this->themeFilePath('archive-solution.php');
			}
		}
	
		return $archiveTemplate;
	}
	
	/**
	 * Inclui os arquivos do tema relacionados com
	 * a página de uma solution e retorna o template
	 * a ser usado.
	 *
	 * @param string $singleTemplate
	 * @return string
	 */
	public function singleTemplate($singleTemplate)
	{
		global $post;
	
		if (get_post_type($post) == "solution" || is_post_type_archive('solution'))
		{
			if(file_exists(get_stylesheet_directory()."/single-solution.php"))
			{
				$singleTemplate = get_stylesheet_directory()."/single-solution.php";
			}
			else
			{
				$singleTemplate = $this->themeFilePath('single-solution.php');
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
			if(array_key_exists($field['slug'], $_POST))
			{
				// Sanitize the user input.
				$mydata = sanitize_text_field( $_POST[$field['slug']] );
			
				// Update the meta field.
				update_post_meta( $post_id, $field['slug'], $mydata );
			}
		}
	}
	
}

$Solution_global = new Solutions();

?>