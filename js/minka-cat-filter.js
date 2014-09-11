function minka_cat_search_checkbox_click()
{
	var checkValues = jQuery('input[name=taxonomy_category\\[\\]]:checked').map(function()
    {
        return jQuery(this).val();
    }).get();
	
	if(jQuery('.category-solution-category-archive-list-itens').length)
	{
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
		jQuery(".solution-category-archive-category-header").hide();
	}
	else
	{
		checkValuesStr = '';
		
		for (index = 0; index < checkValues.length; index++)
		{
			checkValuesStr += 'cat=' + checkValues[index] + '&';
		}
		
		window.location.assign(' http://' + window.location.host + '/solution?' + checkValuesStr);
	    return false;
	}
}

jQuery(document).ready(function () {
	jQuery('input[name=taxonomy_category\\[\\]]').click(function(){
		minka_cat_search_checkbox_click();
	});
});