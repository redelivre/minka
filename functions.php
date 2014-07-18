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
		
		/**
		 * Set the content width based on the theme's design and stylesheet.
		 */
		
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
		$path = get_template_directory_uri() . '/css';
	}

	/**
	 * Controla os arquivos javascript do site
	 *
	 */
	public function javascript()
	{
		wp_enqueue_style( 'minka-style', get_stylesheet_uri() );
		wp_enqueue_script( 'minka-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
		wp_enqueue_script( 'minka-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
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
				foreach($languages as $language)
				{
					if($language['active'])
					{
						$activeindex = $i;
					}
					$i++;
					
					if(count($l) == 0)
					{
						$l = $language;
						$f = $l['url'];
						continue;
					}
					/*if(!$l['active']) echo '<a href="'.$l['url'].'">';
					 echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
					if(!$l['active']) echo '</a>';*/
					echo '<a href="'.$language['url'].'"><span '.($l['active'] ? '' : 'style="display:none"').'>'.$l['translated_name'].'</span></a>';
					$l = $language;
				}
				if(count($l) > 0) echo '<a href="'.$f.'"><span '.($l['active'] ? '' : 'style="display:none"').'>'.$l['translated_name'].'</span></a>';
				echo '</div>';
				$right = 0;
				if(count($languages) > 0)
				{
					switch ($activeindex)
					{
						case 0:
							$right = 108;
						break;
						case count($languages)-1:
							$right = 0;
						break;
						default: 
							$right = (108 * (($activeindex + 1) / count($languages))) - 16;
						break;
					}
				}
					
				echo '<div class="minka_language_selector_swapper_bol" style="right:'.$right.'px"></div>';
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
				'exclude'=> 4,
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
	
}

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
 * widgets
 *  
*/
require_once get_template_directory() . '/inc/widgets.php';