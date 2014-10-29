<?php
/**
 * minka functions and definitions
 *
 * @package minka
 */

class Minka{

	/**
	 * Registra actions do wordpress
	 *
	 */
	public function __construct()
	{
		add_action( 'after_setup_theme', array($this, 'setup'));
		add_action( 'wp_enqueue_scripts', array($this, 'css'));
		add_action( 'wp_enqueue_scripts', array($this, 'javascript'));
		add_filter( 'nav_menu_css_class', array($this, 'nav_menu_css_class'));
		add_action( 'widgets_init', array($this, 'register_sidebars'));
		add_action( 'init', array($this, 'init'));
		add_action( 'wp_ajax_nopriv_minka_search_solutions', array($this, 'getSolutionsList_callback'));
		add_action( 'wp_ajax_minka_search_solutions', array($this, 'getSolutionsList_callback'));
		add_filter( 'comment_form_defaults', array($this, 'comment_form_defaults'));
		add_action( 'show_user_profile', array($this, 'show_user_profile'), 9 );
		add_action( 'edit_user_profile', array($this, 'show_user_profile'), 9 );
		add_action( 'personal_options_update', array($this, 'edit_user_profile_update') );
		add_action( 'edit_user_profile_update', array($this, 'edit_user_profile_update') );
		add_filter( 'mapasdevista_default_user_location', array($this, 'mapasdevista_default_user_location'), 10, 2 );
		add_filter( 'mapasdevista_load_style', array($this, 'mapasdevista_load_style') );
		add_action( 'add_meta_boxes', array($this, 'add_meta_boxes'), 10, 2 );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_filter( 'wp_list_categories', array( $this, 'wp_list_categories' ), 10, 2 );
		add_action( 'wp_head', array( $this, 'favicon') );
		
		
		global $pagenow;
		if (! empty($pagenow) && ('post-new.php' === $pagenow || 'post.php' === $pagenow ))
		{
			add_action('admin_enqueue_scripts', array( $this, 'admin_post_css'));
		}
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function setup()
	{
		require( get_template_directory() . '/inc/hacklab_post2home/hacklab_post2home.php' );
		/*
		 * Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on minka, use a find and replace
		* to change 'minka' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'minka', get_template_directory() . '/languages' );
	
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
	
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		*
		* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		//add_theme_support( 'post-thumbnails' );
	
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'minka' ),
		) );
	
		/*
		 * Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
				) );
	
		/*
		 * Enable support for Post Formats.
		* See http://codex.wordpress.org/Post_Formats
		*/
		add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
				) );
	
		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'minka_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		) ) );
	}
	
	/**
	 * Função responsável por controlar as folhas de estilo do site
	 *
	 */
	public function css()
	{
		// slideshow.css
		wp_register_style( 'minka-slideshow', get_template_directory_uri() . '/css/slideshow.css', array(), '1' );
		wp_enqueue_style( 'minka-slideshow' );
		
		// map.css
		wp_register_style( 'minka-map', get_template_directory_uri() . '/css/map.css', array(), '1' );
		wp_enqueue_style( 'minka-map' );
		
	}

	/**
	 * Controla os arquivos javascript do site
	 *
	 */
	public function javascript()
	{
		wp_enqueue_style( 'minka-style', get_stylesheet_uri(), array(), false, 'all');
		wp_enqueue_script( 'minka-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
		wp_enqueue_script( 'minka-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		// Small menu
		wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('minka-language-swapper', get_template_directory_uri() . '/js/minka-language-swapper.js', array('jquery-ui-draggable', 'jquery-ui-droppable'));
		
		$data = array();

		if(function_exists('icl_get_default_language'))
		{
			$data['default'] = icl_get_default_language();
		}
		wp_localize_script('minka-language-swapper', 'minka_language_swapper', $data);
		
		if(get_query_var(Solutions::NEW_SOLUTION_PAGE) != true)
		{
			wp_enqueue_script('minka-cat-filter', get_template_directory_uri() . '/js/minka-cat-filter.js', array('jquery'));
		}
		
		wp_enqueue_script('jquery-cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'));
		wp_enqueue_script('jquery-cycle2-carousel', get_template_directory_uri() . '/js/jquery.cycle2.carousel.min.js', array('jquery-cycle2'));
		wp_enqueue_script('jquery-cycle2-swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js', array('jquery-cycle2'));
		wp_enqueue_script('jquery-cycle2-center', get_template_directory_uri() . '/js/jquery.cycle2.center.min.js', array('jquery-cycle2'));
		wp_enqueue_script('slider-scroller', get_template_directory_uri() . '/js/slider.scroller.js', array('jquery-cycle2'));
		
	}

	public static function languageSelector()
	{
		if(function_exists('icl_get_languages'))
		{
			$languages = icl_get_languages('skip_missing=0&orderby=custom');
			if(!empty($languages))
			{
				echo '<div id="minka_language_selector" >';
				$l = array();
				$activeindex = 0;
				$i = 0;
				$activelang;
				foreach($languages as $language)
				{
					if($language['active'])
					{
						$activeindex = $i;
						$activelang = $language['language_code'];
					}
					$i++;
					
					echo '<span class="minka_language_selector_item"><label style="" >'.$language['language_code'].'</label></span>';
					$l = $language;
				}
				echo '</div>';
				$right = 0;
				if(count($languages) > 0)
				{
					switch ($activeindex)
					{
						case 0:
							$right = 76;
						break;
						case count($languages)-1:
							$right = 0;
						break;
						default: 
							$right = (76 * (($activeindex + 1) / count($languages))) - 16;
						break;
					}
				}
				echo '<div class="minka_language_selector_swapper_bol" style="right:'.$right.'px">'.$activelang.'</div>';
			}
		}
	}
	
	public static function socialList()
	{
		$post_permalink = get_home_url();
		$title = get_bloginfo('name');
		if(is_single())
		{
			$post_permalink = get_permalink();
			$title = get_the_title();
		}
		?>
			<div class="minka_social_bol minka_social_bol-right" ></div>
			<a class="share-googleplus icon-googleplus" title="<?php _e( 'Share on Google+', 'minka' ); ?>" href="https://plus.google.com/share?url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>
			<a class="share-youtube icon-youtube" title="<?php _e( 'Share on Youtube', 'minka' ); ?>" href="http://www.youtube.com=<?php echo $post_permalink; ?>&text=<?php echo $title; ?>&url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>
			<a class="share-twitter icon-twitter" title="<?php _e( 'Share on Twitter', 'minka' ); ?>" href="http://twitter.com/intent/tweet?original_referer=<?php echo $post_permalink; ?>&text=<?php echo $title; ?>&url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>		
			<a class="share-facebook icon-facebook" title="<?php _e( 'Share on Facebook', 'minka' ); ?>" href="https://www.facebook.com/sharer.php?u=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>
			<div class="minka_social_bol minka_social_bol-left" ></div>
			
		<?php
	}

	public function nav_menu_css_class($classes)
	{
		$classes[] = 'span';
		return $classes;
	}

	public function register_sidebars()
	{
		register_sidebar( array(
		'name' => __('Home Sidebar', 'minka'),
		'id' => 'sidebar-home-1',
		'before_widget' => '<div class="sidebar-home-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title' => '</h2>',
		) );
		
		register_sidebar( array(
			'name' => __('Footer Widget Area Top', 'minka'),
			'id' => 'footer-1',
			'before_widget' => '<div class="footer-top-item">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="rounded">',
			'after_title' => '</h2>',
		) );
		
		register_sidebar( array(
		'name' => __('Footer Widget Area Bottom', 'minka'),
		'id' => 'footer-2',
		'before_widget' => '<div class="footer-bottom-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title' => '</h2>',
		) );
		
		$args = array(
			'name'          => __('Solution Sidebar', 'minka'),
			'id'            => "solution-sidebar",
			'description'   => '',
			'class'         => '',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => "</li>\n",
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => "</h2>\n",
		);

		register_sidebar( $args );
		
		$args = array(
				'name'          => __('Blog Sidebar', 'minka'),
				'id'            => "blog-sidebar",
				'description'   => '',
				'class'         => '',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget'  => "</li>\n",
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => "</h2>\n",
		);
		
		register_sidebar( $args );
		
		$args = array(
				'name'          => __('Network Template Sidebar', 'minka'),
				'id'            => "network-sidebar",
				'description'   => '',
				'class'         => '',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget'  => "</li>\n",
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => "</h2>\n",
		);
		
		register_sidebar( $args );
	}
	
	public function getLoginForm()
	{
		$form = wp_login_form(array('label_log_in' => __('Iniciar', 'minka'), 'echo' => false ));
		
		$rem_ini = strpos($form, '<p class="login-remember">');
		$rem_fim = strpos($form, '</p>', $rem_ini);
		
		$rem = substr($form, $rem_ini, ($rem_fim+4) - $rem_ini);
		
		$form = substr($form, 0, $rem_ini).substr($form, $rem_fim + 4);
		
		$link = '<p class="header-register-link">'.wp_register('','', false).'</p>'.$rem.'</form>';
		
		$form = str_replace('</form>', $link, $form);
		
		$formClose = '</form>';
		
		$closeformtag = strpos($form, '>');
		
		$formOpen = substr($form, 0, $closeformtag + 1);
		$formContent = substr($form, $closeformtag + 1, strpos($form, $formClose) - ($closeformtag + 1));
		
		$formContent_a = explode('<p', $formContent);
		$formContent_a = array_reverse($formContent_a);
		
		$formContent_a2 = array('<div class="header-login-form-line-1">');
		$count = 0;
		foreach ($formContent_a as $htmltag)
		{
			if($count == 3)
			{
				$formContent_a2[] = '</div><div class="header-login-form-line-2">';
			}
			if(strlen(trim($htmltag)) > 0)
				$formContent_a2[] = '<p'.$htmltag;
			$count++;
		}
		$formContent_a2[] = '<span class="login-text">'.__("Login", 'minka').'</span></div>';
		
		$formContent2 = implode('', $formContent_a2);
		
		$form = $formOpen.$formContent2.$formClose;
		
		//echo  '<pre>'.htmlspecialchars($form).'</pre>';die();
		
		return $form;
	}
	
	public function footerThumbnailList()
	{
		global $post;
		
		$tmp_post = $post;
		//$myposts = get_posts('numberposts=-1&&category='.$listCatId[1].'&&orderby='.$categoryThumbnailList_OrderType.'&&order='.$categoryThumbnailList_Order);
		$myposts = get_posts('numberposts=-1&&category='.$listCatId[1]);
		
		$output = '<div class="footer-thumbnail-list">';
		foreach($myposts as $post) :
		setup_postdata($post);
		if ( has_post_thumbnail() ) {
			$link = get_permalink($post->ID);
			$thmb = get_the_post_thumbnail($post->ID,'thumbnail');
			$title = get_the_title();
			$output .= '<div class="categoryThumbnailList_item">';
			$output .= '<a href="' .$link . '" title="' .$title . '">' .$thmb . '</a><br/>';
			$output .= '<a href="' .$link . '" title="' .$title . '">' .$title . '</a>';
			$output .= '</div>';
		}
		endforeach;
		$output .= '</div>';
		$output .= '<div class="categoryThumbnailList_clearer"></div>';
		$post = $tmp_post;
		wp_reset_postdata();
		return ($output);
		$output = '';
	}
	
	public static function get_search_form_filter($form)
	{
		//TODO replace default form text
		return $form;
	}
	
	public static function HomeCategoryList() 
	{
		$taxonomy = 'category';
		$args = array(
				'orderby' => 'id',
				'hide_empty'=> 0,
				'hierarchical' => 0,
				'parent' => 0,
				'taxonomy'=>$taxonomy,
				'exclude'=> array(1,8,9),
				'number' => 4
		
		);
		$terms = get_terms($taxonomy, $args);
		$count = 1;
		foreach ($terms as $term)
		{
			include(locate_template('home_category_list.php'));
			$count++;
		}
	}
	
	public static function getCategoryLastChild($post)
	{
		if(is_numeric($post))
		{
			$post = get_post($post);
		}
		
		$args = array(
			'type'                     => 'solution',
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'category',
			'pad_counts'               => false 
		
		);
		$cats = get_categories($args);
		foreach ($cats as $key=>$cat)
		{
			if($cat->parent == 0)
			{
				unset($cats[$key]);
			}
		}
		return $cats;
	}
	
	public static function init()
	{
		$labels = array
		(
				'name' => __('Page Categories', 'minka'),
				'singular_name' => __('Page Category', 'minka'),
				'search_items' => __('Search for Page Category','minka'),
				'all_items' => __('All Page Categories','minka'),
				'parent_item' => __( 'Page Category parent','minka'),
				'parent_item_colon' => __( 'Page Category parent:','minka'),
				'edit_item' => __('Edit Page Caterory','minka'),
				'update_item' => __('Update Page Caterory','minka'),
				'add_new_item' => __('Add new Page Caterory','minka'),
				'add_new' => __('Add new','minka'),
				'new_item_name' => __('New Page Caterory','minka'),
				'view_item' => __('View Page Caterory','minka'),
				'not_found' =>  __('no Page Caterory founded','minka'),
				'not_found_in_trash' => __('no Page Caterory founded in trash','minka'),
				'menu_name' => __('Page Caterories','minka')
		);
		
		$args = array
		(
				'label' => __('Page Caterories','minka'),
				'labels' => $labels,
				'public' => true,
				'capabilities' => array('assign_terms' => 'edit_pages',
						'edit_terms' => 'edit_pages'),
				//'show_in_nav_menus' => true, // Public
				// 'show_ui' => '', // Public
				'hierarchical' => false,
				//'update_count_callback' => '', //Contar objetos associados
				'rewrite' => true,
				//'query_var' => '',
				//'_builtin' => '' // Core
		);
		
		register_taxonomy('page_category', array('page'), $args);
		
		//TODO move this to theme setup
		$the_slug = 'blog';
		$args=array(
			'name' => $the_slug,
			'post_type' => 'any',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$pages = get_posts($args);
		if( $pages ) // there is a /blog
		{
			$page = $pages[0];
			$page->post_type = 'page'; // have to be a page
			update_post_meta($page->ID, '_wp_page_template', 'archives.php');
		}
		else
		{
			// Create post object
			$my_post = array(
					'post_title'    => 'Blog Archive',
					'post_content'  => '',
					'post_status'   => 'publish',
					'post_author'   => 1,
					'post_type'		=> 'page',
					'post_name'		=> 'blog'
			);
				
			// Insert the post into the database
			wp_insert_post( $my_post );
			update_post_meta($page->ID, '_wp_page_template', 'archives.php');
		}
		
		//TODO move this to theme setup
		$the_slug = 'authors';
		
		$args=array(
				'name' => $the_slug,
				'post_type' => 'any',
				'post_status' => 'publish',
				'numberposts' => 1
		);
		$pages = get_posts($args);
		if( $pages ) // there is a /authors
		{
			$page = $pages[0];
			$page->post_type = 'page'; // have to be a page
			update_post_meta($page->ID, '_wp_page_template', 'authors.php');
		}
		else 
		{
			// Create post object
			$my_post = array(
					'post_title'    => 'Authors Archive',
					'post_content'  => '',
					'post_status'   => 'publish',
					'post_author'   => 1,
					'post_type'		=> 'page',
					'post_name'		=> 'authors'
			);
			
			// Insert the post into the database
			wp_insert_post( $my_post );
			update_post_meta($page->ID, '_wp_page_template', 'authors.php');
		}
		
	}
	
	public static function getSolutionsList($term = null)
	{
		$args = array(
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'		   => 'solution',
				'post_status'	   => 'publish',
				/*'tax_query' => array(
				 array(
				 		'taxonomy' => 'category',
				 		'field' => 'slug',
				 		'terms' => $term->slug
				 )
				)*/
		);
		
		if(is_object($term) AND property_exists($term, 'term_id'))
		{
			$args['cat'] = $term->term_id;
		}
		elseif(is_array($term))
		{
			$args['category__in'] = $term;
			$term = null;
		}
		
		if(array_key_exists( 'search', $_REQUEST))
		{
			$args['s'] = wp_strip_all_tags($_REQUEST['search']);
		}
		
		if(array_key_exists( 'author_search', $_REQUEST) && wp_strip_all_tags($_REQUEST['author_search']) != '')
		{
			$args['author_name'] = wp_strip_all_tags($_REQUEST['author_search']);
		}
		
		if(!isset($minka))
		{
			global $minka; 
		}
		$the_query = new WP_Query($args);
		if($the_query->have_posts())
		{
			$post_index = 0;
			while ($the_query->have_posts())
			{
				$post_index++;
				$the_query->the_post();
				include(locate_template('home_category_list_post.php'));
			}
		}
		else
		{
			$obj = get_post_type_object('solution');
			?>
			<div class="solution-category-archive-nofounded">
				<h2>
				<?php
					echo $obj->labels->not_found;
				?>
				</h2>
				<a href="/new-solution"><?php echo $obj->labels->add_new_item; ?></a>
			</div>
			<?php
		}
		wp_reset_postdata();
	}
	
	public static function getSolutionTopLevelCats($field = 'all')
	{
		$args = array(
				'type'                     => 'solution',
				'child_of'                 => 0,
				'parent'                   => 0,
				'orderby'                  => ($field == 'ids' ? 'id' : 'name'),
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 0,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false
	
		);
		$categories = get_categories($args);
		switch ($field)
		{
			case 'all':
			default:
				if(is_array($categories))
				{
					return $categories;
				}
				else
				{
					return array();
				}
				break;
			case 'ids':
				$cats = array();
				foreach($categories as $category)
				{
					$cats[] = $category->term_id;
				}
				return $cats;
				break;
			case 'name':
				$cats = array();
				foreach($categories as $category)
				{
					$cats[$category->term_id] = $category->name;
				}
				return $cats;
				break;
		}
		return array();
	}
	
	protected $_catsArray = null;
	
	public function getCatsArray()
	{
		if(is_null($this->_catsArray))
		{
			$this->_catsArray = array();
			$cats = null;
			for($i = 1; $i < 5;$i++)
			{
				$cat = get_theme_mod('minka_cat'.$i, null);
				if(is_null($cat))
				{
					if(is_null($cats))
					{
						$cats = self::getSolutionTopLevelCats('ids');
					}
					$cat = array_key_exists($i-1, $cats) ? $cats[$i - 1] : 0;
				}
				$this->_catsArray[$i] = $cat;
			}
		}
	
		return $this->_catsArray;
	}
	
	/**
	* Tests if any of a post's assigned categories are descendants of target categories
	*
	* @param int|array $cats The target categories. Integer ID or array of integer IDs
	* @param int|object $_post The post. Omit to test the current post in the Loop or main query
	* @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
	* @see get_term_by() You can get a category by name or slug, then pass ID to this function
	* @uses get_term_children() Passes $cats
	* @uses in_category() Passes $_post (can be empty)
	* @version 2.7
	* @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
	*/
	public static function post_is_in_descendant_category( $cats, $_post = null, $return = 'bool' )
	{
		$index = 0;
		$ret = false;
		switch ($return)
		{
			case 'bool':
			default:
				$ret = false;
			break;
			case 'index':
				$ret = -1;
			break;
		}
		foreach ( (array) $cats as $cat )
		{
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
				if ( $descendants && in_category( $descendants, $_post ) )
			{
				switch ($return)
				{
					case 'bool':
					default:
						$ret = true;
					break;
					case 'index':
						$ret = $index;
					break;
				}
				break;
			}
			$index++;
		}
	
		return $ret;
	}
	
	function getSolutionsList_callback()
	{
		$data = array_key_exists('data', $_POST) && is_array($_POST['data']) ? $_POST['data'] : array();
		?>
		<div id="category-all-list" style="display: block;" class="category-solution-category-archive-list-itens">
		<?php
		self::getSolutionsList($data);
		echo '</div>';
		die;
	}
	
	function comment_form_defaults($defaults)
	{
		$defaults['title_reply'] = '<div class="comment-form-bol"></div>'.$defaults['title_reply'];
		$defaults['title_reply_to'] = '<div class="comment-form-bol"></div>'.$defaults['title_reply_to'];
		return $defaults;
	}
	
	/**
	 * Display the map
	 *
	 * @since pontosdecultura 1.0
	 */
	public static function the_map()
	{
		if(function_exists('mapasdevista_view'))
		{
			mapasdevista_view();
		}
	}
	
	public static function the_user_map()
	{
		if(function_exists('mapasdevista_users_view'))
		{
			mapasdevista_users_view();
		}
	}
	
	function show_user_profile( $user )
	{?>
	
		<h3><?php _e('Extra profile information', 'minka') ?></h3>
	
		<table class="form-table">
			<tr>
				<th><label for="city"><?php _e('City', 'minka'); ?></label></th>
				<td>
					<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your City.', 'minka');?></span>
				</td>
			</tr>
			<tr>
				<th><label for="country"><?php _e('Country', 'minka'); ?></label></th>
				<td>
					<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your Country.', 'minka');?></span>
				</td>
			</tr>
			<tr>
				<th><label for="organization"><?php _e('Organization', 'minka'); ?></label></th>
				<td>
					<input type="text" name="organization" id="organization" value="<?php echo esc_attr( get_the_author_meta( 'organization', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your Organization.', 'minka');?></span>
				</td>
			</tr>
		</table><?php
	}
	
	function edit_user_profile_update( $user_id )
	{
		if ( !current_user_can( 'edit_user', $user_id ) )
		{
			return false;
		}
		if(array_key_exists('city', $_POST))
		{
			update_user_meta( $user_id, 'city', wp_strip_all_tags($_POST['city']) );
		}
		if(array_key_exists('country', $_POST))
		{
			update_user_meta( $user_id, 'country', wp_strip_all_tags($_POST['country']) );
		}
		if(array_key_exists('organization', $_POST))
		{
			update_user_meta( $user_id, 'organization', wp_strip_all_tags($_POST['organization']) );
		}
	}
	
	function mapasdevista_default_user_location($location, $user)
	{
		$city = get_user_meta($user->ID, 'city', true);
		$country = get_user_meta($user->ID, 'country', true);
		
		if(!empty($city) && !empty($country))
		{
			if($location_tmp = mapasdevista_get_coords($city.", ".$country))
			{
				$location = $location_tmp;
				update_user_meta($user->ID, '_mpv_location', $location_tmp);
			}
		}
		return $location;
	}
	
	function mapasdevista_default_post_location($location, $post)
	{
		//$city = get_post_meta($user->ID, 'city', true);
		$country = get_post_meta($user->ID, 'country', true);
		
		if(/*!empty($city) &&*/ !empty($country))
		{
			if($location_tmp = mapasdevista_get_coords(/*$city.", ".*/$country))
			{
				$location = $location_tmp;
				update_post_meta($post->ID, '_mpv_location', $location_tmp);
			}
		}
		return $location;
	}
	
	function mapasdevista_load_style($load)
	{
		return false;
	}
	
	function add_meta_boxes( $post_type, $post )
	{
		add_meta_box("network_template_meta", __("Network template content", 'minka'), array($this, 'network_template_meta'), 'page');
	}
	
	function network_template_meta()
	{
		global $post;
		
		$content = __('Who and where are the protagonists of the collaborative economy', 'minka');
		 
		if( array_key_exists('map-top', $_POST) )
		{
			$content = stripslashes($_POST['map-top']);
		}
		else
		{
			$meta = get_post_meta($post->ID, '.map-top', true);
			if($meta != "")
			{
				$content = $meta;
			}
		}
		?>
		<div class="network-template-meta-field">
			<label for="map-top" class="solution-item-label">
				<div class="network-template-meta-field-title">
					<h2>
						<?php _e('Text Before Map', 'minka'); ?>
					</h2>
				</div>
			</label>
			<?php wp_editor($content, 'map-top',  array( 
		       'tinymce' => array( 
		            'content_css' => get_stylesheet_directory_uri() . '/inc/solutions/css/editor-styles.css' 
		    		)
				)
			); ?>
		</div><?php
	}
	
	function save_post($post_id)
	{
		if(array_key_exists('map-top', $_POST))
		{
			update_post_meta($post_id, '.map-top', $_POST['map-top']); //TODO more sec
		}
	}
	
	function admin_enqueue_scripts( $hook )
	{
		if( 'post.php' == $hook )
		{
			wp_enqueue_script(
				'network_template_meta',
				get_template_directory_uri() . '/js/network_template_meta.js',
				array('jquery')
			);
		}
	}
	
	/**
	 * Controla os arquivos css da área administrativa para edição e criação de posts
	 *
	 */
	public function admin_post_css()
	{
		wp_enqueue_style( 'minka-admin', get_template_directory_uri().'/css/admin-post.css');
	}
	
	public function wp_list_categories($output, $args)
	{
		if(is_home() || get_post_type() == 'solution' || is_404())
		{
			$output = str_replace('" title=', '?post_type=solution" title=', $output);
		}
		return $output;
	}
	
	function favicon() {
		printf( "<link rel=\"shortcut icon\" href=\"%s\" />\n", get_theme_mod('minka_favicon') );
	}
	
}

global $minka;
$minka = new Minka();

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Solution Post type
 */
require_once get_template_directory() . '/inc/solutions/solutions.php';

/**
 * categories-images plugin
 */
if (!function_exists('z_taxonomy_image_url'))
{
	require_once get_template_directory() . '/inc/categories-images/categories-images.php';
}

/**
 * Rate Plugin
 */
if(!function_exists('the_rating'))
{
	require_once get_template_directory() . '/inc/rate/rate.php' ;
}

/**
 * widgets
 *  
*/
require_once get_template_directory() . '/inc/widgets.php';

if(function_exists('icl_get_languages'))
{
	require_once get_template_directory() . '/inc/LinkTranslationWidget.php';
}
