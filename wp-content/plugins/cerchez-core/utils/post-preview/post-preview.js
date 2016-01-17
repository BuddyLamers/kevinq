

jQuery(document).ready(function () { "use strict";



	var $tabsHolder = (jQuery('#wp-content-wrap .wp-editor-tabs').length > 0) ? jQuery('#wp-content-wrap .wp-editor-tabs') : jQuery('#wp-content-wrap .wp-editor-tools');

	if ($tabsHolder.length == 0) return;

	var check_new_tabs = (jQuery('#content-html').prop("tagName").toLowerCase() == 'button');

	if (check_new_tabs) {

		var $preview_tab = jQuery('<button type="button" id="content-preview" class="wp-switch-editor switch-preview" onclick="switchEditors.switchto(this);">' + cerchez_post_preview.previewNormal + '</button>');

	} else {

		var $preview_tab = jQuery('<a id="content-preview" class="wp-switch-editor switch-preview" onclick="switchEditors.switchto(this);">' + cerchez_post_preview.previewNormal + '</a>');

	}

	if ( ! jQuery('#cerchez-quick-preview.postbox').hasClass('hide-if-js')) $preview_tab.addClass('enabled');

	if (check_new_tabs) {

		$tabsHolder.append($preview_tab);

	} else {

		$tabsHolder.prepend($preview_tab);

	}



	jQuery(document).on('click', '.metabox-prefs #cerchez-quick-preview-hide',function (e) {

		if (jQuery(this).is(':checked')) {

			$preview_tab.addClass('enabled');

		} else {

			$preview_tab.removeClass('enabled');

			jQuery('#content-tmce', $tabsHolder).triggerHandler('click');

		}

	});



	jQuery('#content-tmce, #content-html', $tabsHolder).on('click', function(e) {

		if (jQuery('#wp-content-wrap').hasClass('preview-active')) {

			jQuery('#wp-content-wrap').removeClass("preview-active");

		} else {

			return;

		}

		if (jQuery('#cerchez-quick-preview.postbox').hasClass('hide-if-js')) return;



		var editor_mode = (jQuery(this).is(jQuery('#content-html'))) ? 'text' : 'visual';

		switch (editor_mode) {

			case 'visual':

				ed = tinyMCE.get('content');

				if (typeof ed == 'undefined' || ed == null) {

					ed = new tinymce.Editor('content', tinyMCEPreInit.mceInit['content']);

					ed.render();

				}

				if (typeof ed != 'undefined' && ed != null) {

					ed.show();

				}

				jQuery('#wp-content-wrap').addClass("tmce-active");

				break;

			case 'text':

				jQuery('#wp-content-wrap').addClass("html-active");

				break;

		}

	});



	var cerchez_preview_link = null;

	var cerchez_preview_scroll_position = 0;



	var ajax_params = {

		'action': 'cerchez_content_preview',

		'post_ID': jQuery('#post_ID').val(),

		'post_status': 'auto-draft',

		'post_format': ''

	};

	

	jQuery.post(ajaxurl, ajax_params, function(response) {

		cerchez_preview_link = response;

	});



	jQuery('#wp-content-editor-container').append('<div id="cerchez-content-preview"><span class="spinner"></span></div>');



	$preview_tab.on('click', function() {

		if (jQuery('#wp-content-wrap').hasClass('preview-active')) return;



		QTags.closeAllTags('content');

		setUserSetting('editor', 'tinymce');

		var ed = tinyMCE.get('content');

		if (typeof ed != 'undefined' && ed != null) ed.hide();



		if (jQuery('#cerchez-content-preview iframe').length > 0) {

			cerchez_preview_scroll_position = jQuery('#cerchez-content-preview iframe').contents().scrollTop();

		}

		jQuery('#cerchez-content-preview iframe').remove();

		var editor_height = jQuery('#wp-content-editor-container textarea#content').height() + jQuery('#wp-content-editor-container #ed_toolbar').height() + jQuery('#wp-content-wrap #post-status-info').height() + 40;

		jQuery('#cerchez-content-preview').append('<iframe width="100%" style="height:' + editor_height + 'px;min-height:300px;"></iframe>');

		jQuery('#wp-content-wrap').removeClass("html-active tmce-active").addClass("preview-active");



		var ajax_active = jQuery.active;

		if ( typeof autosave == 'function' ) {

			autosave();

		}

		if ( typeof wp != 'undefined' && wp.autosave && wp.autosave.server ) {

			wp.autosave.server.triggerSave();

		}



		var intervalID = window.setInterval(function() {

			if (jQuery.active > ajax_active) return;

			clearInterval(intervalID);



			jQuery('#cerchez-content-preview .spinner').removeClass('hide-spinner');

			jQuery('#cerchez-content-preview iframe').attr("src", cerchez_preview_link).load(function() {

				var $contents = jQuery(this).contents();

				$contents.find('#wpadminbar').remove();

				$contents.find('html').addClass('post-preview');

				$contents.find('html, html body').each(function() {

					jQuery(this).get(0).style.setProperty("margin-top", "0px", "important");

				});

				if (cerchez_post_preview.hiddenElements) {

					$contents.find(cerchez_post_preview.hiddenElements).remove();

				}

				$contents.find('html, body').scrollTop(cerchez_preview_scroll_position);

				jQuery('#cerchez-content-preview .spinner').addClass('hide-spinner');

				jQuery(this).addClass('loaded');

			});

		}, 300);

	});

});