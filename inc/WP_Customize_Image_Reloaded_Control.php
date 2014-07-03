<?php
/**
 * Customize Image Reloaded Class
 *
 * Extende WP_Customize_Image_Control e permite o acesso aos uploads
 * feitos dentro do mesmo contexto
 *
 */
class WP_Customize_Image_Reloaded_Control extends WP_Customize_Image_Control
{
	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Image_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 */
	public function __construct( $manager, $id, $args = array() )
	{
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Busca as imagens de acordo com o contexto definido
	 * Não havendo contexto, são trazidas todas as imagens
	 *
	 */
	public function tab_uploaded()
	{
		$custom_logos = get_posts( array(
				'post_type'  => 'attachment',
				'meta_key'   => '_wp_attachment_context',
				'meta_value' => $this->context,
				'orderby'    => 'post_date',
				'nopaging'   => true,
		) );

		?>
	            
        <div class="uploaded-target"></div>
            
        <?php
        if ( empty( $custom_logos ) )
           	return;

        foreach ( (array) $custom_logos as $custom_logo )
        {
			$this->print_tab_image( esc_url_raw( $custom_logo->guid ) );
        }
	}
	
}
