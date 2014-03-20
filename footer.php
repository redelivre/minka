</section><!-- #main .site-main -->
		
		<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<section id="tertiary" class="sidebar-container cf row" role="complementary">
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				</div>
			</section><!-- #tertiary -->
		<?php
		else:
			if ( current_user_can( 'publish_posts' ) ): ?>
				<div class="empty-feature widget">
					<p><?php printf( __( 'To display your widgets here go to the <a href="%s">Widget Page</a> and drag them into the "Footer Widget Area".', 'minka' ), admin_url( 'widgets.php' ) ); ?></p>
				</div>
			<?php
			endif;
		endif; ?>
	
		
	</div><!-- .site-wrapper .hfeed .site -->
	
	<div class="row">
		<nav role="navigation" class="site-navigation main-navigation co">
			<div class="clearfix"></div>
			<?php wp_nav_menu( array( 'menu' => 'main', 'theme_location' => 'primary', 'container_class' => 'span9' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->
	</div>
	
	<div class="minka-credits cf span11" >
		<a href="http://wordpress.org/" title="<?php esc_attr_e( 'Proudly powered by WordPress', 'minka' ); ?>" class="icon-wordpress span11" rel="generator"><img src="<?php echo get_template_directory_uri() . '/images/icon-wordpress.png'; ?>" alt="<?php _e( 'WordPress logo', 'minka' ); ?>" /><span class="assistive-text span"><?php _e( 'Proudly powered by WordPress', 'minka' ); ?></span></a>
	</div> <!-- .minka-credits -->
	
	<?php wp_footer(); ?>
	</div> <!-- Site Container for bootstrap --> 
	</body>
</html>
