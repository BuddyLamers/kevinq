var cerchez_new_line_pattern = /\n/g;
(function() {
	if (typeof CERCHEZ_CORE_PLUGIN_BUTTON_MENU === "undefined") return;
	tinymce.create('tinymce.plugins.cerchez_core_shortcodes_plugin', {
		init : function(ed, url) {
			var menu_items = [];
			this.addMenuItem(CERCHEZ_CORE_PLUGIN_BUTTON_MENU, menu_items);
			ed.addButton("cerchez_core_shortcodes_button", {
				tooltip: tinymce.activeEditor.getLang('cerchezcore.buttonTitle'),
				type: 'menubutton',
				menu: menu_items,
				icon: 'cerchez_core'
			});
		},
		addMenuItem : function(options, items) {
			var btn;
			for (btn in options) {
				if (options[btn]['type'] == 'parent') {
					var menu_items = [];
					var curent_title = options[btn]['title'];
					this.addMenuItem(options[btn]['childs'], menu_items);
					items.push({
						text: curent_title,
						menu: menu_items
					});
				} else if (options[btn]['type'] == 'addInsert') {
					items.push({
						text: options[btn]['title'],
						value: [options[btn]['before'], options[btn]['after']],
						onclick: function() {
							var values = this.value();
							if (typeof values[0] == "undefined") values[0] = '';
							if (typeof values[1] == "undefined") values[1] = '';
							tinymce.activeEditor.insertContent(values[0] + tinymce.activeEditor.selection.getContent() + values[1]);
						}
					});
				} else if (options[btn]['type'] == 'addPopup') {
					items.push({
						text: options[btn]['title'],
						value: [btn, options[btn]['title']],
						onclick: function() {
							var values = this.value();
							cerchez_core_plugin_popup(values[0], values[1]);
						}
					});
				}
			}
		},

	});

	tinymce.PluginManager.add('cerchez_core_shortcodes_plugin', tinymce.plugins.cerchez_core_shortcodes_plugin);

})();

function cerchez_core_plugin_popup_close() {
	jQuery('.cerchez-core-shortcodes-modal, .cerchez-core-shortcodes-modal-backdrop').remove();
}

jQuery(document).on('click','#cerchez-core-shortcodes-modal .cerchez-core-popup-cancel-button', function(ev) {
	ev.preventDefault();
	cerchez_core_plugin_popup_close();
});

var cerchezUniqueDuplicateID = 2;

function cerchez_core_plugin_popup(id, title) {
	var $modal = jQuery('<div class="media-modal cerchez-core-shortcodes-modal" id="cerchez-core-shortcodes-modal"><button type="button" class="button-link media-modal-close"><span class="media-modal-icon"></span></button><div class="media-modal-content"><div class="media-frame wp-core-ui"></div></div></div>');
	var $backdrop = jQuery('<div class="media-modal-backdrop cerchez-core-shortcodes-modal-backdrop" />');
	$modal.appendTo('body');
	$backdrop.appendTo('body');

	jQuery('#cerchez-core-shortcodes-modal .media-modal-close, .cerchez-core-shortcodes-modal-backdrop').click(function(ev) {
		ev.preventDefault();
		cerchez_core_plugin_popup_close();
	});

	$modal.data('close-function', cerchez_core_plugin_popup_close);

	jQuery.post( ajaxurl, {
		action: 'cerchez_core_popup',
		id: id,
		title: title
	}, function(data) {
		if (data) {
			jQuery('#cerchez-core-shortcodes-modal .media-modal-content .media-frame').html(data);
			cerchez_core_init_code_generator();
			jQuery('#cerchez-core-shortcodes-modal .option-line-duplicate').sortable({
				items: ".item:not(.ui-state-disabled)",
				handle: "h3",
				placeholder: "item-placeholder",
				delay: 100,
				distance: 10,
				axis: 'y'
			});
			cerchezUniqueDuplicateID = 2;
		}
	}, 'html');
}

function cerchez_add_file(event, selector) {
	var upload = jQuery(".uploaded-file"), frame;
	var $el = jQuery(this);
	event.preventDefault();
	if ( frame ) {
		frame.open();
		return;
	}

	frame = wp.media({
		title: $el.data('choose'),
		button: {
			text: $el.data('update'),
			close: false
		}
	});
	frame.on('select', function() {
		var attachment = frame.state().get('selection').first();
		frame.close();
		selector.find('.upload-file').val(attachment.attributes.url);
		if ( attachment.attributes.type == 'image' ) {
			selector.find('.screenshot').hide().html('<img src="' + attachment.attributes.url + '">').slideDown('fast');
			selector.find('.alt-text').val(attachment.attributes.alt);
			selector.find('.width').val(attachment.attributes.width);
			selector.find('.height').val(attachment.attributes.height);
		}
		selector.find('.remove-image').removeClass('hide');
	});
	frame.open();
}

jQuery(document).on('click','#cerchez-core-shortcodes-modal .upload-image', function(ev) {
	cerchez_add_file(ev, jQuery(this).closest('.option-content'));
});

jQuery(document).on('click','#cerchez-core-shortcodes-modal .remove-image', function() {
	el = jQuery(this).closest('.option-content');
	el.find('.remove-image').addClass('hide');
	el.find('.upload-file, .alt-text, .width, .height').val('');
	el.find('.screenshot img').remove();
});

jQuery(document).on('click','#cerchez-core-shortcodes-modal .cerchez-core-remove-template', function(e) {
	e.preventDefault();
	if (confirm(jQuery(this).data('confirm'))) {
		jQuery(this).parent('.item').slideUp(200, function() {
			jQuery(this).remove();
		});
	}
});

jQuery(document).on('click','#cerchez-core-shortcodes-modal .cerchez-core-duplicate-template', function(e) {
	e.preventDefault();
	$el = jQuery(this).closest('.option-content');
	$template_item = $el.find('.template-item');
	var $new_el = $template_item.clone();
	$new_el.removeClass('template-item').addClass('item').hide(0);
	$new_el.find('input[name],textarea[name],select,label[for]').each(function(){
		$this = jQuery(this);
		if ($this.is('label')) {
			$attr = $this.attr('for');
		} else {
			$attr = $this.attr('id');
		}
		var matches = $attr.match(/\[.+?\]/g);
		var old_id = matches[0];
		var new_id = '[' + cerchezUniqueDuplicateID + ']';
		var new_id_attr = $attr.replace(old_id,new_id);
		if ($this.is('label')) {
			$this.attr('for', new_id_attr);
		} else {
			$this.attr('id', new_id_attr);
			$this.attr('name', new_id_attr);
		}
	})
	cerchezUniqueDuplicateID++;
	$new_el.insertBefore($el.find('.duplicate-add-new')).slideDown(200);
	$frame_content = jQuery('#cerchez-core-shortcodes-modal .media-frame-content');
	$frame_content.animate({
		scrollTop: $new_el.offset().top - $frame_content.offset().top + $frame_content.scrollTop() - 12
	}, 500);
});

function cerchez_core_init_code_generator() {
	jQuery('.cerchez-core-popup-submit-button').click(function(ev) {
		var id = jQuery(this).data('shortcode-id');
		if (typeof(window['cerchez_core_shortcode_generator_' + id]) == 'function') {
			var code = window['cerchez_core_shortcode_generator_' + id]();
			if (typeof(code) != 'undefined' && typeof(code['before']) != 'undefined' && typeof(code['after']) != 'undefined')
				window.tinymce.activeEditor.insertContent(code.before + window.tinymce.activeEditor.selection.getContent() + code.after);
		} else {
			alert('Sorry, an unexpected error has occurred. Please try to reinstall the shortcodes plugin.');
		}
		jQuery('#cerchez-core-shortcodes-modal').data('close-function')();
		ev.preventDefault();
	});
}

function cerchez_core_attr_esc(str) {
	if (typeof str === "undefined") return '';
	return str.replace(/"/g,'\\"');
}