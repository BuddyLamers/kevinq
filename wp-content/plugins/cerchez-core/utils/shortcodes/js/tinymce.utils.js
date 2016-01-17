var cerchez_new_line_pattern = /\n/g;
(function() {
	if (typeof CERCHEZ_CORE_PLUGIN_BUTTON_MENU === "undefined") return;
	tinymce.create('tinymce.plugins.cerchez_core_shortcodes_plugin', {
		createControl : function(id, cm) {
			if ( id == 'cerchez_core_shortcodes_button' ) {
				var this_ = this;
				btn = cm.createMenuButton("cerchez_core_shortcodes_button", {
					title: tinyMCE.activeEditor.getLang('cerchezcore.buttonTitle'),
					icons: false
				});
				btn.onRenderMenu.add(function (c, b) {
					function add_items(arr, node) {
						var k;
						for(k in arr) {
							if(arr[k]['type'] == 'parent') {
								var newnode=node.addMenu( {title: arr[k]['title']} );
								add_items(arr[k]['childs'], newnode);
							} else if(arr[k]['type'] == 'addPopup') {
								this_.addPopup( node, arr[k]['title'], k );
							} else if(arr[k]['type'] == 'addInsert') {
								this_.addInsert( node, arr[k]['title'], arr[k]['before'], arr[k]['after'] );
							} else if(arr[k]['type'] == 'separator') {
								node.addSeparator();
							}
						}
					}
					add_items(CERCHEZ_CORE_PLUGIN_BUTTON_MENU, b);
				});
				return btn;
			}
		},

		addPopup: function ( b, title, id ) {
			b.add({
				title: title,
				onclick: function () {
					cerchez_core_plugin_popup(id, title);
				}
			});
		},

		addInsert: function ( b, title, code_start, code_end) {
			b.add({
				title: title,
				onclick: function () {
					cerchez_core_plugin_insert(title, code_start, code_end);
				}
			})
		}
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
	var $modal = jQuery('<div class="media-modal cerchez-core-shortcodes-modal" id="cerchez-core-shortcodes-modal"><a class="media-modal-close" href="#"><span class="media-modal-icon"></span></a><div class="media-modal-content"><div class="media-frame wp-core-ui"></div></div></div>');
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

function cerchez_core_plugin_insert(title, code_start, code_end) {
	if (typeof code_start == "undefined") code_start = '';
	if (typeof code_end == "undefined") code_end = '';
	tinyMCE.activeEditor.selection.setContent(code_start + tinyMCE.activeEditor.selection.getContent() + code_end);
}

function cerchez_core_init_code_generator() {
	jQuery('.cerchez-core-popup-submit-button').click(function(ev) {
		var id = jQuery(this).data('shortcode-id');
		if (typeof(window['cerchez_core_shortcode_generator_' + id]) == 'function') {
			var code = window['cerchez_core_shortcode_generator_' + id]();
			if (typeof(code) != 'undefined' && typeof(code['before']) != 'undefined' && typeof(code['after']) != 'undefined')
				window.tinyMCE.activeEditor.selection.setContent(code.before + window.tinyMCE.activeEditor.selection.getContent() + code.after);
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