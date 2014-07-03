/**
 * 
 */

jQuery(document).ready(function () {
  		tinymce.editors['assineja_content_text'].onKeyUp.add(function(ed, l) {
  			var content = ed.getContent();
			jQuery('#customize-preview').find("iframe").contents().find('.page-content').html(content);
			jQuery('#assineja_content_text').html(content);
		});
});


