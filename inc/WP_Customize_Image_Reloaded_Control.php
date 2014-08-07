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
	
	public function render_content()
	{
		parent::render_content();
		?>
		<div class="customize-control-default-image" style="display:none;" >
			<div class="library" >
				<div class="library-content" data-customize-tab="uploaded">
					<a id="customize-control-<?php echo $this->id; ?>-default-image" class="thumbnail" data-customize-image-value="<?php echo $this->setting->default; ?>" href="#">
					</a>
				</div>
			</div>
		</div>
		<div class="actions">
			<a class="default" href="#" onclick="jQuery('#customize-control-<?php echo $this->id; ?>-default-image').click()" ?><?php _e('Default image'); ?></a>
		</div>
		<?php
	}
	
}
