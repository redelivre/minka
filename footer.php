<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package minka
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-area footer-area-top">
			<div class="footer-area-top-title">
				<div class="footer-area-top-title-text">
					<?php echo get_theme_mod('minka_footer_text_top', __("Redes Amigas de MINKA", 'minka')); ?>
				</div>
			</div>
			<div class="footer-entry footer-entry-top">
				<div class="footer-top">
					<?php dynamic_sidebar('footer-1'); ?>
				</div>
			</div>
		</div>
		<div class="footer-area footer-area-bottom">
			<div class="footer-entry footer-entry-bottom">
				<div class="footer-bootom">
					<?php dynamic_sidebar('footer-2'); ?>
				</div>
				<div class="footer-bottom-text">
					<?php echo get_theme_mod('minka_footer_text', __("Minka - Banco de las redes. Todos los derechos reservados, copyright 2014", 'minka')); ?>
				</div>
			</div>
		</div>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
