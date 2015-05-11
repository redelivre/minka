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
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/inc/slideshow/theme/supersized.shutter.css" type="text/css" media="screen" />

<?php wp_head(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?4" type="text/css" media="screen" />

		
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/slideshow/js/jquery.easing.min.js"></script>
		
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/slideshow/js/supersized.3.2.7.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/slideshow/theme/supersized.shutter.js"></script>
	
		
		<script type="text/javascript">
			
			jQuery(function($){
				$.supersized({
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	1,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   3000,		// Length between transitions
					transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	1000,		// Speed of transition
					new_window				:	0,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   1,			// Vertically center background
					horizontal_center       :   1,			// Horizontally center background
					fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   0,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width
															   
					// Components							
					slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
					thumb_links				:	0,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
					slides 					:  	[			// Slideshow Images
<?php if(is_front_page()) {?>
														{image : '<?php bloginfo('template_url'); ?>/images/header/1_home.jpg', title : '', thumb : '', url : ''},
														{image : '<?php bloginfo('template_url'); ?>/images/header/2_blog.jpg', title : '', thumb : '', url : ''},
														{image : '<?php bloginfo('template_url'); ?>/images/header/3_catalogo.jpg', title : '', thumb : '', url : ''},
														{image : '<?php bloginfo('template_url'); ?>/images/header/4_servicios.jpg', title : '', thumb : '', url : ''},
														{image : '<?php bloginfo('template_url'); ?>/images/header/5_contacto.jpg', title : '', thumb : '', url : ''},
														{image : '<?php bloginfo('template_url'); ?>/images/header/6_red.jpg', title : '', thumb : '', url : ''}
<?php } else { ?>
														{image : '<?php bloginfo('template_url'); ?>/images/header/<?php echo get_slider(get_the_ID());?>.jpg', title : '', thumb : '', url : ''}
<?php } ?>

                    
												],
												
					progress_bar			:	0,			// Timer for each slide							
					mouse_scrub				:	0
					
				});
		    });
		    
		</script>
	

</head>

<body <?php body_class(); ?>>
<!--nav class="navbar navbar-default minka-navbar<?php if(is_front_page()) {echo '-home';} ?>" role="navigation"-->
<nav class="navbar navbar-default minka-navbar-home " role="navigation">


    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php bloginfo('url')?>">
            <?php
            $logo = get_theme_mod( 'minka_logo', get_template_directory_uri() . '/images/logo.png' );
            $logo_uri = get_template_directory_uri() . '/images/logo.png';
            if( $logo )
            {
                $logo_uri =  $logo;
            }
            ?>
            <img style="z-index:100" height="150px" width="150px" alt="" src="<?php echo $logo_uri; ?>"/>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <?php wp_nav_menu( array( 'menu' => 'main',
            'theme_location' => 'primary', 'container' => false,
            'menu_class' => 'minka-header-menu nav navbar-nav' ) ); ?>       
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php
                    if(!is_user_logged_in()) { ?>
                        <?php echo do_shortcode('[ultimate_ajax_login template=popmodal]'); ?>
                    <?php
                    //  echo Minka::getLoginForm();
                    } else { ?>
                        <button id="register" class="btn btn-primary header-login-welcome btn-header">
                        <?php echo __('Welcome', 'minka').' <strong>'.wp_get_current_user()->display_name.'</strong>';?>
                        </button>
                    <?php } ?>
                </li>
                <!--li>
                    <div class="btn-group btn-toggle language-switch-v1"> 
                        <button class="btn btn-default switch ">PT</button>
                        <button class="btn btn-primary switch active">ES</button>
                    </div>                    
                </li-->
            </ul>

        </div>
    </div>  

</nav>

    <ul id="supersized" ></ul>
<header class="marquee container">   
</header>


<?php if(!is_front_page() && get_the_ID() != 518 && get_the_ID() != 521 && get_the_ID() != 131) {?>

<!--header class="marquee header-bottom header-<?php echo get_the_ID() ;?>">   
    <div class="container">
        <!--div class="col-md-8 col-md-offset-2">
            <div class="brand-name">
                <span clas="intro-span">
                <?php
                    echo text_slider(get_the_ID())

                ?>        
                </span>    
            </div>     
        </div-->
    </div>
</header-->



<?php } ?>

<!--- <div id="content" class="site-content container"> -->
