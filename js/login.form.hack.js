jQuery(document).ready(function (){
	var i = 5;
	jQuery('#loginform').find('input').each(function () {
		jQuery(this).attr('tabindex', i);
		i--;
	});
});