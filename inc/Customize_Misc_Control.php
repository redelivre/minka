<?php

/**
 * From: http://coreymckrill.com/blog/2014/01/09/adding-arbitrary-html-to-a-wordpress-theme-customizer-section/
 */

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'ThemeName_Customize_Misc_Control' ) ) :
class Customize_Misc_Control extends WP_Customize_Control
{
	public $settings = 'blogname';
	public $description = '';
	public $link = '';


	public function render_content()
	{
		switch ( $this->type )
		{
			default:
			case 'text' :
				echo '<p class="description">' . $this->description . '</p>';
			break;

			case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
			break;

			case 'line' :
				echo '<hr />';
			break;
			case 'link':
				echo '<a href="'.esc_html( $this->link ).'" class="customize-control-link">' . esc_html( $this->label ) . '</a>';
			break;
		}
	}
}
endif;
?>