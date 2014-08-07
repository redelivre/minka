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
			'default'     => get_template_directory_uri() . '/images/logo.png',
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

	/*$wp_customize->add_setting( 'minka_header_text', array(
			'default'     => __("ASSINE JÁ", 'minka'),
			'capability'    => 'edit_theme_options',
			'transport'=>'postMessage'
	) );

	$wp_customize->add_control( 'minka_header_text', array(
			'label'      => __( 'Texto do Cabeçalho' ),
			'section'    => 'minka_content',
	) );*/
	
	$wp_customize->add_setting( 'minka_footer_text_top', array(
			'default'     => __("Redes Amigas de MINKA", 'minka'),
			'capability'    => 'edit_theme_options',
			'transport'=>'postMessage'
	) );
	
	$wp_customize->add_control( 'minka_footer_text_top', array(
			'label'      => __( 'Footer Title' ),
			'section'    => 'minka_content',
	) );
	
	$wp_customize->add_setting( 'minka_footer_text', array(
			'default'     => __("Minka - Banco de las redes. Todos los derechos reservados, copyright 2014", 'minka'),
			'capability'    => 'edit_theme_options',
			'transport'=>'postMessage'
	) );
	
	$wp_customize->add_control( 'minka_footer_text', array(
			'label'      => __( 'Footer Text' ),
			'section'    => 'minka_content',
	) );
	
	$wp_customize->add_setting( 'minka_home_video_url', array(
			'default'     => __("http://youtu.be/TDwB0Z9s5nE", 'minka'),
			'capability'    => 'edit_theme_options',
			//'transport'=>'postMessage'
	) );
	
	$wp_customize->add_control( 'minka_home_video_url', array(
			'label'      => __( 'Home Video URL (copy only the video url)', 'minka' ),
			'section'    => 'minka_content',
	) );

	//header background image
	$wp_customize->add_section( 'minka_header', array(
			'title'    => __( 'Cabeçalho', 'minka' ),
			'priority' => 30,
	) );
	
	$wp_customize->add_setting('minka_header_image', array(
			'default' => get_template_directory_uri() . '/images/rede-home.png'
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
	$langs = 3;
	if(function_exists('icl_get_languages'))
	{
		$langs_count = count(icl_get_languages('skip_missing=0'));
		if($langs_count > 0)
		{
			$langs = $langs_count;
		}
	}
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
			background-image: url(<?php echo get_theme_mod('minka_header_image', get_template_directory_uri() . '/images/rede-home.png'); ?>);
		}
		.minka_language_selector_item {
			width: <?php echo 100 / $langs; ?>%;
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