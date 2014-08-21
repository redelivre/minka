<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package minka
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'minka' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-top">
			<div class="header-top-entry">
				<span data-title="<?php _e("click and drag the buttom to change language", "minka"); ?>" class="tolltip" >
					<span id='language-switch' class="language-switch">
						<?php
						Minka::languageSelector();
						?>
					</span>
				</span>
				<div class="header-social-list">
					<?php
					Minka::socialList();
					?>
				</div>
				<div id='login-form' class="header-login-form">
					<?php
					if(!is_user_logged_in())
					{
						?>
						<span class="login-text"><?php _e('Login', 'minka'); ?></span>
						<?php
						echo Minka::getLoginForm();
					}
					else 
					{
					?>
						<span class="header-login-welcome"><?php echo __('Bem Vindo', 'minka').' <strong>'.wp_get_current_user()->display_name.'</strong>';?></span>
					<?php
					} 
					?>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="header-bottom-entry">
				
				<div class="header-logo">
					
					<?php
					$logo = get_theme_mod( 'minka_logo', get_template_directory_uri() . '/images/logo.png' );
					$logo_uri = get_template_directory_uri() . '/images/logo.png';
					if( $logo )
					{
						$logo_uri =  $logo;
					}
					?>
					<a href="/"><img alt="" src="<?php echo $logo_uri; ?>"/></a>
				</div>
				<div class="header-navigation-menu">
					<nav role="navigation" class="site-navigation main-navigation co">
						<h1 class="assistive-text">Menu</h1> 
						<div class="clearfix"></div>
						<?php wp_nav_menu( array( 'menu' => 'main', 'theme_location' => 'primary', 'container_class' => 'minka-header-menu' ) ); ?>
					</nav><!-- .site-navigation .main-navigation -->
					<div class="clear"></div>
					<div class="header-search-form">
						<?php get_search_form() ?>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
