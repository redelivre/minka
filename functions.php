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
		add_action('after_setup_theme', array($this, 'setup'));
		add_action('wp_enqueue_scripts', array($this, 'css'));
		add_action('wp_enqueue_scripts', array($this, 'javascript'));
		add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'));
		add_action('widgets_init', array($this, 'register_sidebars'));
		add_action('init', array($this, 'init'));
		add_action('wp_ajax_nopriv_minka_search_solutions', array($this, 'getSolutionsList_callback'));
		add_action('wp_ajax_minka_search_solutions', array($this, 'getSolutionsList_callback'));
		
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
		wp_enqueue_script('minka-language-swapper', get_template_directory_uri() . '/js/minka-language-swapper.js', array('jquery-ui-draggable'));
		
		$data = array();

		if(function_exists('icl_get_default_language'))
		{
			$data['default'] = icl_get_default_language();
		}
		wp_localize_script('minka-language-swapper', 'minka_language_swapper', $data);
		
		wp_enqueue_script('minka-cat-filter', get_template_directory_uri() . '/js/minka-cat-filter.js', array('jquery'));
		
		wp_enqueue_script('jquery-cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'));
		wp_enqueue_script('jquery-cycle2-carousel', get_template_directory_uri() . '/js/jquery.cycle2.carousel.min.js', array('jquery-cycle2'));
		wp_enqueue_script('jquery-cycle2-swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js', array('jquery-cycle2'));
		wp_enqueue_script('jquery-cycle2-center', get_template_directory_uri() . '/js/jquery.cycle2.center.min', array('jquery-cycle2'));
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
		$post_permalink = get_permalink(); ?>
			<div class="minka_social_bol minka_social_bol-right" ></div>
			<a class="share-googleplus icon-googleplus" title="<?php _e( 'Share on Google+', 'minka' ); ?>" href="https://plus.google.com/share?url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>
			<a class="share-youtube icon-youtube" title="<?php _e( 'Share on Youtube', 'minka' ); ?>" href="http://www.youtube.com=<?php echo $post_permalink; ?>&text=<?php the_title() ?>&url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>
			<a class="share-twitter icon-twitter" title="<?php _e( 'Share on Twitter', 'minka' ); ?>" href="http://twitter.com/intent/tweet?original_referer=<?php echo $post_permalink; ?>&text=<?php echo get_the_title(); ?>&url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"></a>		
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
			'name'          => 'Solution Sidebar',
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
				'name'          => 'Blog Sidebar',
				'id'            => "blog-sidebar",
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
	
	static function taxonomy_checklist($taxonomy = 'category', $parent = 0)
	{
		$args = array(
				'orderby' => 'id',
				'hide_empty'=> 0,
				'parent' => $parent,
				'hierarchical' => 0,
				'taxonomy'=>$taxonomy
	
		);
		$terms = get_terms($taxonomy, $args);
		//print_r($terms);
	
		if (!is_array($terms) || ( is_array($terms) && sizeof($terms) < 1 ) )
		{
			return;
		}
		if ($parent > 0)
			{?>
				<ul class='children'><?php
		}
		$index = 1;
		foreach ($terms as $term)
		{
			$name = $term->name;
			$input = '';
			if(strpos($name, '#input#') !== false)
			{
				$name = str_replace('#input#', '', $name);
				$value = array_key_exists($taxonomy.'_'.$term->term_id.'_input', $_REQUEST) ? $_REQUEST[$taxonomy.'_'.$term->term_id.'_input'] : ''; 
				$input = '<input type="text" class="taxonomy-category-checkbox-text" name="'.$taxonomy.'_'.$term->term_id.'_input" id="category_'.$taxonomy.'_'.$term->slug.'_input" value="'.$value.'" />';
			}
			$checked = isset($_REQUEST) && array_key_exists("category_$taxonomy", $_REQUEST) && array_search($term->term_id, $_REQUEST["category_$taxonomy"]) !== false ? 'checked="checked"' : '';				
			?>
			<li class="category-group-col <?php echo $parent == 0 ? 'category-group-col-'.$index : ''; ?>"><?php
				if($parent > 0 && $input == '')
				{?>
					<input type="checkbox" class="taxonomy-category-checkbox" value="<?php echo $term->term_id; ?>" name="category_<?php echo $taxonomy; ?>[]" id="category_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>"
					<?php echo $checked; ?> /><?php
				}?>
				<label for="category_<?php echo $taxonomy; ?>_<?php echo $term->slug; ?>"><?php
					echo $name;?>
				</label><?php
				echo $input; 
				self::taxonomy_checklist($taxonomy, $term->term_id); ?>
			</li>
			<?php
			$index++;
		}
		if ($parent > 0)
		{?>
			</ul><?php
		}
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
	}
	
	public static function getSolutionsList($term = null)
	{
		$args = array(
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'		   => 'solution',
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
