<?php

include('solutions/solutions.php');

class Minka{
	
	/**
	* Registra actions do wordpress
	*
	*/
	public function __construct(){
		
		add_action('wp_enqueue_scripts', array($this, 'css'));		
		add_action('wp_enqueue_scripts', array($this, 'javascript'));
		add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'));
	}
	
	/**
	* Função responsável por controlar as folhas de estilo do site
	*
	*/
	public function css(){
		$path = get_template_directory_uri() . '/css';
		wp_register_style('bootstrap-responsive', $path . '/bootstrap-responsive.min.css');
		wp_register_style('bootstrap', $path . '/bootstrap.min.css');		
		wp_register_style('geral', get_stylesheet_directory_uri() . '/style.css', array('bootstrap'));
		
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('bootstrap-responsive');
		wp_enqueue_style('geral');		
	}
	
	/**
	* Controla os arquivos javascript do site
	*
	*/
	public function javascript(){
		$path = get_template_directory_uri() . '/js';
		wp_register_script('bootstrap', $path . '/bootstrap.min.js');
		wp_register_script('minka_language_selector', $path . '/language_selector.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('minka_language_selector');
	}
	
	public static function language_selector()
	{
		if(function_exists('icl_get_languages'))
		{
	    	$languages = icl_get_languages('skip_missing=0&orderby=code');
		    if(!empty($languages))
		    {
		    	echo '<div id="minka_language_selector" onclick="minka_language_selector_swapper();">';
		    	$l = array();
		        foreach($languages as $language)
		        {
		        	if(count($l) == 0)
		        	{
		        		$l = $language;
		        		$f = $l['url'];
		        		continue;
		        	}
		            /*if(!$l['active']) echo '<a href="'.$l['url'].'">';
		            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
		            if(!$l['active']) echo '</a>';*/
		        	echo '<a href="'.$language['url'].'"><span '.($l['active'] ? '' : 'style="display:none"').'>'.$l['translated_name'].'</span></a>';
		        	$l = $language;
	        	}
	        	if(count($l) > 0) echo '<a href="'.$f.'"><span '.($l['active'] ? '' : 'style="display:none"').'>'.$l['translated_name'].'</span></a>';
	        	echo '</div>';
	    	}
		}
	}
	
	public function nav_menu_css_class($classes)
	{
		$classes[] = 'span';
		return $classes;
	}
	
}

$minka = new Minka();

?>