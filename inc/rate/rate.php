<?php 
/*
Plugin Name: Rate
Description: Ratings: clean, lightweight and easy
Author: Scott Taylor
Version: 0.3
Author URI: http://tsunamiorigami.com
*/

class rate
{

	function __construct()
	{
		add_action('comment_post', array($this, 'save_karma'));
		// /add_action('comment_form_top', array($this, 'form_filter'));
		add_action('wp_ajax_nopriv_rate_item', array($this, 'item_callback'));
		add_action('wp_ajax_rate_item', array($this, 'item_callback'));
		add_action('wp_print_styles', array($this, 'styles'));
		add_action('wp_print_scripts', array($this, 'scripts'));
	}
	
	static function current_user() {
		global $current_user;
		if (is_user_logged_in()) {
			get_currentuserinfo();
			return $current_user->user_login;
		} else {
			return $_COOKIE['comment_author_' . COOKIEHASH];
		}
	}
	
	static function user_is_known() {
		return is_user_logged_in() || !empty($_COOKIE['comment_author_' . COOKIEHASH]);
	}
	
	static function calculate($id = 0, $is_comment = false, $is_exp = false) {
		global $wpdb;
		$url = get_permalink();
		$coerced_id = (int) $id > 0 ? $id : get_the_id();
		$previous_id = 0;
		
		if ($is_comment)
		{
			$c = $GLOBALS['comment'];	
			$rating = (int) $c->comment_karma;
			$previous_id = (int) $c->comment_ID;
		}
		elseif($is_exp)
		{
			$rating_array = $wpdb->get_results(
				$wpdb->prepare("
						SELECT SUM(meta_value) as value, count(*) as total 
							FROM $wpdb->comments as c
							inner join $wpdb->commentmeta as m on c.comment_id = m.comment_id
							WHERE c.comment_post_ID = %d AND
								m.meta_key = 'rate-experience' AND
								c.comment_approved = %d AND
								m.meta_value in (1, -1, -2)",
					$coerced_id, 1));
			if(count($rating_array) > 0)
			{
				$rating = ($rating_array[0]->value * 5) / $rating_array[0]->total;
			}
			else
			{
				$rating = 2.5;
			}
			//var_dump($rating_array);die();
		}
		else
		{
			$rating = $wpdb->get_var(
				$wpdb->prepare("SELECT AVG(comment_karma) FROM $wpdb->comments WHERE ". 
					"comment_post_ID = %d AND comment_karma > %d AND comment_approved = %d", 
					$coerced_id, 0, 1)); 		
		}
		$rating = (float) number_format($rating, 1, '.', '');
		
		if ($rating === 0.0) {
			$coerced_rating = 0.0;
		} else if (($rating * 10) % 5 !== 0) {
			$coerced_rating = round($rating * 2.0, 0) / 2.0;
		} else {
			$coerced_rating = $rating;
		}
		
		$stars = array(0,1,2,3,4,5,6);
		$classes = array('rating');
		$format = '<li class="%s"><span class="l"></span><span class="r"></span></li>';
		
		for ($i = 1; $i <= 5; $i++) {
			if ($i <= $coerced_rating) {
				$stars[$i] = sprintf($format, 'whole');
			} else if ($i - 0.5 === $coerced_rating) {
				$stars[$i] = sprintf($format, 'half');
			} else {
				$stars[$i] = sprintf($format, 'empty');		
			}
		}	
		
		$usermeta = array();	
		if (rate::user_is_known()) {
			if ($is_comment && ((int) $rating === 0 || ($c->comment_author === rate::current_user()))) {
				$classes[] = 'needs-rating';	
			}
		   	$usermeta[] = sprintf('data-id="%d"', $coerced_id);
		   	if ($previous_id > 0) {
		   		$usermeta[] = sprintf('data-comment-id="%d"', $previous_id);
		   	}
		}	
		
		$stars[0] = sprintf('<ul data-rating="%01.1f" class="%s" %s>', $rating, implode(' ', $classes), implode(' ', $usermeta));
		$stars[6] = '</ul>';
		
		return implode('', $stars);		
	}
	
	static function save_karma($id) {
		global $wpdb;
		
		if (isset($_POST['comment_karma'])) {
			$wpdb->update($wpdb->comments, 
				array('comment_karma' => (int) $_POST['comment_karma']),
				array('comment_ID' => $id)
			);
		}
	}
	
	
	static function form()
	{
		$star = '<li class="empty"><span class="l"></span><span class="r"></span></li>';
		$hide = '<input id="rate_comment_ID" type="hidden" value="0" name="rate_comment_ID">'.wp_nonce_field('rate_item', 'rate_comment_nonce', true, false);
		$form = '<ul class="rating form-rating">'.$star.$star.$star.$star.$star.'</ul>'.$hide;
		
		return $form;
	}
	
	static function formExperience()
	{
		return '
				<span class="rate-experience rate-positive"><label class="rate-experience-label"><input type="radio" class="rate-experience-input" name="rate-experience" value="1">'.__('positive', 'minka').'</label></span>
				<span class="rate-experience rate-negative"><label class="rate-experience-label"><input type="radio" class="rate-experience-input" name="rate-experience" value="-1">'.__('negative', 'minka').'</label></span>
				<span class="rate-experience rate-do-not-use"><label class="rate-experience-label"><input type="radio" class="rate-experience-input" name="rate-experience" value="-2">'.__('do not use', 'minka').'</label></span>
			';
	}
	
	static function form_filter($content) {
		the_rate::form();
	}
	
	
	static function item_callback() {
		global $wpdb;
	
		if (
			array_key_exists('rate_comment_nonce', $_POST)	&&
			wp_verify_nonce($_POST['rate_comment_nonce'], 'rate_item')
		)
		{
			
			$comment_ID = array_key_exists('comment_ID', $_POST) ? (int) $_POST['comment_ID'] : 0;
			$comment_post_ID = array_key_exists('comment_post_ID', $_POST) ? (int) $_POST['comment_post_ID'] : 0;
			$comment_karma = array_key_exists('rating', $_POST) ? (int) $_POST['rating'] : 0;
			$exp = array_key_exists('exp', $_POST) ? (int) $_POST['exp'] : 0;
			$comment_author_IP = $_SERVER['REMOTE_ADDR'];
			$comment_date = date("Y-m-d H:i:s");
			$comment_date_gmt = date("Y-m-d H:i:s");
			$user_id = get_current_user_id();
		
			if (is_user_logged_in()) {
				$user = wp_get_current_user();	
				$user->display_name = $user->user_login;
				
				$comment_author = esc_sql($user->display_name);	
				$comment_author_email = esc_sql($user->user_email);
				$comment_author_url   = esc_sql($user->user_url);		
			} elseif(array_key_exists('comment_author_' . COOKIEHASH, $_COOKIE))
			{
				$comment_author = esc_sql($_COOKIE['comment_author_' . COOKIEHASH]);	
				$comment_author_email = esc_sql($_COOKIE['comment_author_email_' . COOKIEHASH]);
				$comment_author_url   = esc_sql( $_COOKIE['comment_author_url_' . COOKIEHASH]);			
			}
			else //Anonymous rate
			{
				$comment_author = __('anonymous', 'minka');
				$comment_author_email = 'anonymous@anonymous';
				$comment_author_url = esc_sql($_SERVER['REMOTE_ADDR']);
			}
			
			if (empty($comment_author) || empty($comment_author_email)) {
				die('I don\'t know who you are!');
			}
		
			$comment_approved = 1;
			
			$commentdata = compact(
					'comment_post_ID',
					'comment_author',
					'comment_author_email',
					'comment_author_url',
					'comment_karma',
					'comment_approved',
					'comment_author_IP',
					'comment_date',
					'comment_date_gmt',
					'user_id'
			);
			if ($comment_ID > 0)
			{
				$comment = get_comment($comment_ID);
				
				if(is_user_logged_in())
				{
					if(get_current_user_id() != $comment->user_id)
					{
						die('0');
					}
				}
				else 
				{
					if($comment->comment_author_IP != $comment_author_IP)
					{
						die('0');
					}
				}
				
				if($exp != 0)
				{
					update_comment_meta($comment_ID, "rate-experience", $exp);
				}
				else 
				{
					$response = $wpdb->update($wpdb->comments, $commentdata, array('comment_ID' => $comment_ID));
				}
			} else {
				$response = $wpdb->insert($wpdb->comments, $commentdata);
				$comment_ID = $wpdb->insert_id;
				update_comment_meta($comment_ID, "rate-experience", $exp);
			}	
			
			echo $comment_ID;
		}
		else 
		{
			echo '0';
		}
		exit();
	}
	
	static function styles() {
		if (is_file(STYLESHEETPATH . '/rate.css')) {
			wp_enqueue_style('user-rate', get_bloginfo('stylesheet_directory') . '/rate.css');
		} else {
			wp_enqueue_style('rate', get_template_directory_uri() . '/inc/rate/css/rate.css');	
		}
	}
	
	static function scripts() {
		wp_enqueue_script('rate', get_template_directory_uri() . '/inc/rate/js/rate.js', array('jquery'));
	}
	
}

$global_rate = new rate();

function the_rate_form()
{
	echo rate::form();
}

function the_rate_formExperience()
{
	echo rate::formExperience();
}

function the_rating($id = 0) {
	echo rate::calculate($id);
}

function the_experience($id = 0) {
	echo rate::calculate($id, false, true);
}

function the_comment_rating() {
	$c = $GLOBALS['comment'];
	echo rate::calculate($c->comment_post_ID, true);
}

?>