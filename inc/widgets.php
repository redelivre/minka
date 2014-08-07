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
		add_filter( 'widget_posts_args', array($this, 'widget_posts_args'));
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
	
	function widget_posts_args($args)
	{
		$instaces = $this->get_settings();
		$args['cat'] = $instaces[$this->number]['cat'];
		$args['post_type'] = 'solution';
		return $args;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['cat'] = (int)$new_instance['cat'];
		return $instance;		
	}
	
}

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
			echo $title;
			Minka::taxonomy_checklist();
		}
		else
		{
			parent::widget($args, $instance);
		}
	}
}

// Load the widget on widgets_init
function Minka_WP_Widget_init() {
	register_widget('WP_Widget_Categories_Posts');
	
	unregister_widget('WP_Widget_Categories');
	register_widget('Minka_WP_Widget_Categories');
}
add_action('widgets_init', 'Minka_WP_Widget_init');
