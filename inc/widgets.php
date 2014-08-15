<?php

class WP_Widget_Categories_Posts extends WP_Widget_Recent_Posts
{
	function __construct()
	{
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "Most recent Posts of a category.", 'minka') );
		WP_Widget::__construct('category-posts', __('Recent Posts of Category', 'minka'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}
	
	function form($instance)
	{
		parent::form($instance);
		$cat_args = array('orderby' => 'name', 'show_count' => 1, 'hierarchical' => 1);
		$cat_args['show_option_none'] = __('Select Category');
		$cat_args['name'] = $this->get_field_name('cat');
		$cat_args['id'] = $this->get_field_id('cat');
		$cat_args['selected'] = array_key_exists('cat', $instance) && isset($instance['cat']) ? $instance['cat'] : -1;
		wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
	}
	
	function widget($args, $instance)
	{
		global $WP_Widget_Categories_Posts;
		$WP_Widget_Categories_Posts = $this;
		parent::widget($args, $instance);
		$WP_Widget_Categories_Posts = false;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['cat'] = (int)$new_instance['cat'];
		return $instance;		
	}
	
}

function WP_Widget_Categories_Posts_widget_posts_args($args)
{
	global $WP_Widget_Categories_Posts;
	if(is_object($WP_Widget_Categories_Posts) && get_class($WP_Widget_Categories_Posts) == 'WP_Widget_Categories_Posts')
	{
		$instaces = $WP_Widget_Categories_Posts->get_settings();
		$args['cat'] = $instaces[$WP_Widget_Categories_Posts->number]['cat'];
		$args['post_type'] = 'solution';
	}
	return $args;
}
add_filter( 'widget_posts_args', 'WP_Widget_Categories_Posts_widget_posts_args');

class Minka_WP_Widget_Categories extends WP_Widget_Categories
{
	function form( $instance )
	{
		$checkbox = isset( $instance['checkbox'] ) ? (bool) $instance['checkbox'] : false;
		
		parent::form($instance);
		?>
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('checkbox'); ?>" name="<?php echo $this->get_field_name('checkbox'); ?>"<?php checked( $checkbox ); ?> />
		<label for="<?php echo $this->get_field_id('checkbox'); ?>"><?php _e( 'Display as checkbox', 'minka' ); ?></label><br /></p>
		<?php
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['checkbox'] = !empty($new_instance['checkbox']) ? 1 : 0;
		return $instance;
	}
	
	function widget( $args, $instance )
	{
		extract( $args );
		$ch = ! empty( $instance['checkbox'] ) ? '1' : '0';
		if($ch)
		{
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base);
			if ( $title )
				echo $before_title . $title . $after_title;
			Minka::taxonomy_checklist();
			/*?>
			<div class="minka-widget-categories-button"><?php _e('search', 'minka'); ?></div> 
			<?php*/
		}
		else
		{
			parent::widget($args, $instance);
		}
	}
}

class WP_Widget_Recent_Posts_Image extends WP_Widget_Recent_Posts
{
	function __construct()
	{
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "Your site&#8217;s most recent Posts.") );
		WP_Widget::__construct('recent-posts', __('Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
		add_action('wp_enqueue_scripts', array($this, 'css'));
	}
	
	public function css()
	{
		wp_register_style( 'widget-recent-posts', get_template_directory_uri() . '/css/widget-recent-posts.css', array(), '1' );
		wp_enqueue_style( 'widget-recent-posts' );
	}
	
	function form($instance)
	{
		$show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
		
		parent::form($instance);?>
		<p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display post image?' ); ?></label></p><?php
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['show_image'] = isset( $new_instance['show_image'] ) ? (bool) $new_instance['show_image'] : false;
		return $instance;
	}
	
	function widget($args, $instance)
	{
		$cache = wp_cache_get('widget_recent_posts', 'widget');
	
		if ( !is_array($cache) )
			$cache = array();
	
		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;
	
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
	
		ob_start();
		extract($args);
	
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
		if ( ! $number )
			$number = 10;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_image = isset( $instance['show_image'] ) ? $instance['show_image'] : false;
		
		if($show_image)
		{
			$before_title = '<div class="recent-posts-title-bol"></div>'.$before_title;
		}
	
		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
		?>
		<div class="<?php echo $show_image ? 'recent-posts-with-image' : ''; ?>" onclick="window.location = '<?php the_permalink(); ?>'">
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul>
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<li>
					<div class="recent-posts-entry-image-box"><?php
						if($show_image)
						{?>
							<div class="recent-posts-entry-image" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)">
							</div><?php
						}?>
					</div>
					<div class="recent-posts-entry-title-box">
						<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
					<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php echo $after_widget;?>
		</div><?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}
	
}

// Load the widget on widgets_init
function Minka_WP_Widget_init() {
	register_widget('WP_Widget_Categories_Posts');
	
	unregister_widget('WP_Widget_Categories');
	register_widget('Minka_WP_Widget_Categories');
	
	unregister_widget('WP_Widget_Recent_Posts');
	register_widget('WP_Widget_Recent_Posts_Image');
	
}
add_action('widgets_init', 'Minka_WP_Widget_init');
