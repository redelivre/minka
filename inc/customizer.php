<?php
/**
* minka Theme Customizer
*
* @package minka
*/

/**
 * Add postMessage support for site title and description for the Theme Customizer.
*
* @param WP_Customize_Manager $wp_customize Theme Customizer object.
*/
function minka_customize_register( $wp_customize )
{
	require_once get_template_directory() . '/inc/WP_Customize_Image_Reloaded_Control.php';
	require_once get_template_directory() . '/inc/Customize_Misc_Control.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$color = array( 'slug'=>'minka_bg_color_header', 'default' => '#6e448f', 'label' => __( 'Cor de fundo do cabeçalho', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_bg_color_footer', 'default' => '#575657', 'label' => __( 'Cor de fundo do rodapé', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_bg_color_col2', 'default' => '#d7d7d7', 'label' => __( 'Cor de fundo da coluna 2', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_font_color', 'default' => '#575657', 'label' => __( 'Cor da fonte do conteúdo', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_font_color_header', 'default' => '#f47c0c', 'label' => __( 'Cor da fonte do cabeçalho', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_font_color_titles', 'default' => '#575657', 'label' => __( 'Cor da fonte dos títulos', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	$color = array( 'slug'=>'minka_font_color_col2', 'default' => '#575657', 'label' => __( 'Cor da fonte do conteúdo da coluna 2 (sobre o formulário)', 'minka' ) );
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'capability' => 'edit_theme_options', 'transport'=>'postMessage' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));

	/*
	 *
	* Logo
	*/
	$wp_customize->add_section( 'minka_logo', array(
			'title'    => __( 'Logo', 'minka' ),
			'priority' => 30,
	) );

	// Branding: logo
	$wp_customize->add_setting( 'minka_logo', array(
			'default'     => get_template_directory_uri() . '/images/assine-ja.png',
			'capability'    => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Reloaded_Control( $wp_customize, 'minka_logo', array(
			'label'   	=> __( 'Cabeçalho', 'minka' ),
			'section'	=> 'minka_logo',
			'settings' 	=> 'minka_logo',
			'context'	=> 'minka-custom-logo'
	) ) );

	$id = get_option('page_on_front');
	$page = get_post($id);

	//$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id));

	/*
	 *
	* Page Content
	*/
	$wp_customize->add_section( 'minka_content', array(
			'title'    => __( 'Conteúdo', 'minka' ),
			'priority' => 30,
	) );

	/*$wp_customize->add_setting( 'minka_content_image', array(
	 'default'     => is_array($image_thumb) ? $image_thumb[0] : '',
			'capability'    => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Reloaded_Control( $wp_customize, 'minka_content_image', array(
			'label'   	=> __( 'Imagem', 'minka' ),
			'section'	=> 'minka_content',
			'settings' 	=> 'minka_content_image',
			'context'	=> 'minka_content_image'
	) ) );

	add_action('customize_save_minka_content_image', function()
	{
			$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
			//$post_values['minka_content_image'];

			$imgs = get_posts( array(
					'post_type'  => 'attachment',
					'meta_key'   => '_wp_attachment_context',
					'meta_value' => 'minka_content_image',
					'orderby'    => 'post_date',
					'nopaging'   => true,
			) );

			$img_id = 0;
			foreach ($imgs as $img)
			{
			if($img->guid == $post_values['minka_content_image'])
			{
			$img_id = $img->ID;
			}
			}

			set_post_thumbnail(get_option('page_on_front'), $img_id);



			});*/

	$wp_customize->add_setting( 'minka_header_text', array(
			'default'     => __("ASSINE JÁ", 'minka'),
			'capability'    => 'edit_theme_options',
			'transport'=>'postMessage'
	) );

	$wp_customize->add_control( 'minka_header_text', array(
			'label'      => __( 'Texto do Cabeçalho' ),
			'section'    => 'minka_content',
	) );

	$wp_customize->add_control(
			new Customize_Misc_Control($wp_customize, 'minka_page_edit_link',
					array(
							'section'  => 'minka_content',
							'label'    => __( 'Editar Página', 'minka' ),
							'type'     => 'link',
							'link'	   => get_edit_post_link(get_option('page_on_front'))
					)
			)
	);

	// TODO fix save bug
	/*$wp_customize->add_setting( 'minka_content_text', array(
			'default'     => apply_filters('the_editor_content', $page->post_content),
			'capability'    => 'edit_theme_options',
	) );

	$wp_customize->add_control( new Text_Editor_Custom_Control( $wp_customize, 'minka_content_text', array(
			'label'   	=> __( 'Conteudo', 'minka' ),
			'section'	=> 'minka_content',
			'settings' 	=> 'minka_content_text',
			'liveupdate' => '.page-content'
	) ) );

	add_editor_style('css/editor.css');

	add_action('customize_save_minka_content_text', function()
	{
			$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
			//$post_values['minka_content_image'];

			$id = get_option('page_on_front');
			$page = get_post($id);
			$page->post_content = $post_values['minka_content_text'];
			wp_update_post($page);

			});*/
	
	//header background image
	$wp_customize->add_section( 'minka_header', array(
			'title'    => __( 'Cabeçalho', 'minka' ),
			'priority' => 30,
	) );
	
	$wp_customize->add_setting('minka_header_image', array(
			'default' => ''
	));
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'minka_header_image_control', array(
			'label' => __('Imagem de fundo do destaque', 'minka'),
			'section' => 'minka_header',
			'settings' => 'minka_header_image'
	)));

}
add_action( 'customize_register', 'minka_customize_register' );




/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
*/
function minka_customize_preview_js() {
	wp_enqueue_script( 'minka_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );

}
add_action( 'customize_preview_init', 'minka_customize_preview_js' );

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 *
 * Used for inline custom CSS
 *
 * @since minka 1.0
*/
function minka_customize_css()
{
	?>
	<!-- Customize CSS -->
	<style type="text/css">
		.header-top {
			background-color: <?php echo get_theme_mod('minka_bg_color_header', '#6e448f'); ?>;
		}
		.page-title {
			color: <?php echo get_theme_mod('minka_font_color_titles'); ?>;
		}
		.join-meta {
			color: <?php echo get_theme_mod('minka_font_color_col2'); ?>;
		}
		.footer-area-bottom {
			background-color: <?php echo get_theme_mod('minka_bg_color_footer'); ?>;
		}
		.page-content {
			color: <?php echo get_theme_mod('minka_font_color'); ?>;
		}
		.column-2 {
			background-color: <?php echo get_theme_mod('minka_bg_color_col2'); ?>;
		}
		.site-header span {
			color: <?php echo get_theme_mod('minka_font_color_header'); ?>;
		}
		.home-stick {
			background-image: url(<?php echo get_theme_mod('minka_header_image'); ?>);
		}
	</style> 
	<!-- /Customize CSS -->
	<?php
}
add_action( 'wp_head', 'minka_customize_css' );

function minka_customize_controls_print_styles()
{
	wp_enqueue_style('minka-customizer-css', get_template_directory_uri(). '/css/customizer.css');
}
add_action('customize_controls_print_scripts', 'minka_customize_controls_print_styles');

function minka_customize_controls_print_scripts()
{
	wp_enqueue_script( 'minka_customizer_controls', get_template_directory_uri() . '/js/customizer_controls.js', array( 'jquery' ), '20140617', true );
}
//add_action('customize_controls_print_scripts', 'minka_customize_controls_print_scripts');