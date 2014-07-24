"use strict";

/*globals $, jQuery, window, document */

(function ($) {
	var nratings, fratings;
	
	function doHover(e) {
		$(this).prevAll().andSelf()[(e.type === 'mouseenter' ? 'add' : 'remove') + 'Class']('rover');
	}
	
	function doSuccess(data) {
		//console.log(data);
		jQuery('#rate_comment_ID').val(data);
	}
	
	function doError(e) {
		//console.log(e);
	}
	
	function setUI(elem) {
		elem.prevAll().andSelf().addClass('whole').removeClass('empty half rover');
		elem.nextAll().addClass('empty').removeClass('whole half rover');	
	}
	
	function doFormRating() {
		var elem = $(this), indx, ctx, field;
		
		setUI(elem);	
		
		ctx = elem.parent();
		indx = ctx.find('li').index(this) + 1;
		
		if (!$('#comment_karma').length) {
			field = $('<input />').attr({
				name : 'comment_karma',
				id   : 'comment_karma',
				value: indx,
				type : 'hidden'
			});
			ctx.after(field);
		} else {
			$('#comment_karma').val(indx);
		}
	}
	
	function doRating() {
		var elem = $(this), indx, ctx;
		
		setUI(elem);		
		
		ctx = elem.parent();
		indx = ctx.find('li').index(this) + 1;

		$.ajax({
			type   : 'post',
			url    : 'http://' + window.location.host + '/wp-admin/admin-ajax.php',
			data   : {
				action: 'rate_item',
				rating: indx,
				'comment_post_ID' : jQuery('#comment_post_ID').val(),
				'comment_ID' : jQuery('#rate_comment_ID').val(),
				'rate_comment_nonce' : jQuery('#rate_comment_nonce').val()
			},
			success: doSuccess,
			error  : doError
		});	
	
		return false;
	}
	
	function doRatingExp() {
		$.ajax({
			type   : 'post',
			url    : 'http://' + window.location.host + '/wp-admin/admin-ajax.php',
			data   : {
				'action': 'rate_item',
				'exp': jQuery('input[name="rate-experience"]').val(),
				'comment_post_ID' : jQuery('#comment_post_ID').val(),
				'comment_ID' : jQuery('#rate_comment_ID').val(),
				'rate_comment_nonce' : jQuery('#rate_comment_nonce').val()
			},
			success: doSuccess,
			error  : doError
		});	
	
		return false;
	}
	
	$(document).ready(function () {
		nratings = $('.needs-rating li');
		fratings = $('.form-rating li');
		jQuery('input[name="rate-experience"]').change(doRatingExp);
		fratings.bind('mouseenter mouseleave', doHover).click(doFormRating);
		nratings.bind('mouseenter mouseleave', doHover).click(doRating);
	});
}(jQuery));