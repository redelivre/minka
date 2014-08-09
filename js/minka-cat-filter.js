function minka_cat_search_checkbox_click()
{
	var checkValues = jQuery('input[name=category_category\\[\\]]:checked').map(function()
    {
        return jQuery(this).val();
    }).get();
	
	jQuery.ajax({
		type   : 'post',
		url    : 'http://' + window.location.host + '/wp-admin/admin-ajax.php',
		data   : {
			action: 'minka_search_solutions',
			data: checkValues
		},
		success: function(response) {
			jQuery('.category-solution-category-archive-list-itens').replaceWith(response);
		}
	});
}

jQuery(document).ready(function () {
	jQuery('input[name=category_category\\[\\]]').click(function(){
		minka_cat_search_checkbox_click();
	});
});