jQuery(document).ready(function () {
	jQuery( ".minka_language_selector_swapper_bol" ).draggable({ axis: "x", containment: "parent" });
	jQuery('.minka_language_selector_item').droppable({
		over: function (event, ui) {
			var a = jQuery(this).children("label");
			jQuery('.minka_language_selector_swapper_bol').text(a.text());
		},
		drop: function (event, ui) {
			
			var a = jQuery(this).children("label");
			if(icl_lang != a.text() && a.text() != minka_language_swapper.default)
			{
				jQuery(location).attr('href', '/'+a.text());
			}
			else if( a.text() == minka_language_swapper.default )
			{
				var url = icl_home.substr(0, (icl_home.length - (icl_lang.length + 1 )));
				jQuery(location).attr('href', url);
			}
		}
	})
});