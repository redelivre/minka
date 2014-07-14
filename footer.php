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
		<div class="footer-area">
			<div class="footer-entry">
				<div class="footer-area">
					<?php dynamic_sidebar('footer-1'); ?>
				</div>
			</div>
		</div>
		<div class="footer-area footer-area-bottom">
			<div class="footer-entry">
				<div class="footer-bootom">
					<?php dynamic_sidebar('footer-2'); ?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
