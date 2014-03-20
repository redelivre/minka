<?php
/**
 * The Header
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Minka
 * @since Minka 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
	    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
	<!--[if lt IE 7]>
	<p class="browse-happy">
	 	<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.', 'minka' ); ?>
	</p>
	<![endif]-->
	<?php $minka_front_content_bg_color = get_option('minka_front_content_bg_color'); ?>
	<div class="site-wrapper hfeed" <?php echo 'style="background-color:'.$minka_front_content_bg_color.'" ' ?> >
		<?php do_action( 'before' ); ?>
		<header id="masthead" class="site-header cf" role="banner">
		
			<div class="branding">
				<?php
				// Get the current color scheme 
				$color_scheme = get_theme_mod( 'minka_color_scheme' );
				
				// Check if there's a custom logo
				$logo = get_theme_mod( 'minka_logo' );
				$logo_uri = get_template_directory_uri() . '/images/schemes/logo-undefined.png';
				if( $logo )
				{
					$logo_uri =  $logo; 
				}
				elseif (isset($color_scheme) && $color_scheme != "")
				{
					$logo = get_template_directory_uri() . '/images/schemes/logo-' . $color_scheme . '.png';
					
					$logo_uri = $logo;
				}
				
				?>
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					 <img class="site-logo" src="<?php echo $logo_uri; ?>" alt="Logo <?php bloginfo ( 'name' ); ?>" />
				</a>
				
			</div>
			<div id='language-switch'>
				<?php
				Minka::language_selector();
				?>
			</div>
			<div id='login-form'>
				<?php
					wp_login_form();
					wp_register(); 
				?>
			</div>
			
	
			<nav role="navigation" class="site-navigation main-navigation">
				<h1 class="assistive-text"><?php _e( 'Menu', 'minka' ); ?></h1>
				<div class="clearfix"></div>
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'minka' ); ?>"><?php _e( 'Skip to content', 'minka' ); ?></a></div>
				<?php wp_nav_menu( array( 'menu' => 'main', 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->
		</header><!-- #masthead .site-header -->
	
		<section id="main" class="main cf">
		
		