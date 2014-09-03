function show_network_template_meta()
{
	if(jQuery('#network_template_meta').length)
	{
		if (jQuery('#page_template').val() == 'network.php')
		{
			jQuery('#network_template_meta').show();
		}
		else
		{
			jQuery('#network_template_meta').hide();
		}
	}
}

jQuery(document).ready(function()
{
	if(jQuery('#page_template').length)
	{
		show_network_template_meta();
		jQuery('#page_template').change(function () {
		   show_network_template_meta();
		});
	}

});