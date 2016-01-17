var builder_anim_speed = 100;



jQuery(document).ready(function () { "use strict";



	jQuery('#module-builder-container').sortable({

		items: '.module-builder-row',

		handle: '.module-builder-row-toolbar .row-move',

		axis: 'y',

		tolerance: 'pointer',

		scroll: false,

		update: function () {

			refreshBuilderMetaValue();

		}

	});



	// initialy set min-height settings for cells

	refreshBuilderCellMinHeight();

	refreshBuilderModulesSortable(jQuery('#module-builder-container'));



	/* handle adding a new row */

	jQuery('#module-builder-add-row').click(function(e) {

		var $new_row = jQuery('.module-builder-new-row-template').clone().removeClass('module-builder-new-row-template'), no_of_new_cells = 2, $new_cell = jQuery('.module-builder-cell-template').clone().removeClass('module-builder-cell-template'), $new_module = jQuery('.module-builder-new-item-template').clone().removeClass('module-builder-new-item-template'), it;

		jQuery('.module-builder-cell-wrapper', $new_cell).after($new_module);

		for(it = no_of_new_cells - 1; it >= 0; it = it - 1) {

			jQuery('.module-builder-row-content', $new_row).append($new_cell.clone().css('width', (100 / no_of_new_cells) + '%'));

		}

		$new_row.css('display', 'none');

		jQuery(this).before($new_row);

		$new_row.slideDown(builder_anim_speed);

		refreshBuilderModulesSortable($new_row);

		refreshBuilderMetaValue();

		e.preventDefault();

	});



	/* handle adding a new column in a row */

	jQuery(document).on('click','.module-builder-row-toolbar .row-add-column', function (e) {

		var $parent_row = jQuery(this).parents('.module-builder-row'), current_no_cells = jQuery('.module-builder-cell', $parent_row).length;

		if (current_no_cells >= 4) { return; }

		var new_no_cells = current_no_cells + 1, $new_cell = jQuery('.module-builder-cell-template').clone().removeClass('module-builder-cell-template'), $new_module = jQuery('.module-builder-new-item-template').clone().removeClass('module-builder-new-item-template');

		jQuery('.module-builder-cell.confirm-remove', $parent_row).removeClass('confirm-remove').find('.module-builder-remove-item').remove();

		jQuery('.module-builder-cell', $parent_row).css('width', (100 / new_no_cells) + '%');

		jQuery('.module-builder-cell-wrapper', $new_cell).after($new_module);

		$new_cell.css('width', (100 / new_no_cells) + '%');

		jQuery('.module-builder-row-content', $parent_row).append($new_cell);

		jQuery('.module-builder-row-toolbar .row-remove-column', $parent_row).removeClass('toolbar-button-disabled');

		if (new_no_cells === 4) {

			jQuery(this).addClass('toolbar-button-disabled');

		}

		refreshBuilderCellMinHeight();

		refreshBuilderModulesSortable($parent_row);

		refreshBuilderMetaValue();

		e.preventDefault();

	});



	/* handle removing the last column in a row */

	jQuery(document).on('click','.module-builder-row-toolbar .row-remove-column', function (e) {

		var $parent_row = jQuery(this).parents('.module-builder-row'), current_no_cells = jQuery('.module-builder-cell', $parent_row).length;

		if (current_no_cells <= 1) { return; }

		var new_no_cells = current_no_cells - 1, $last_cell = jQuery('.module-builder-cell:last', $parent_row);



		// check if last column is empty

		if (jQuery('.module-builder-item', $last_cell).length > 0) {

			if ( ! $last_cell.hasClass('confirm-remove')) {

				$last_cell.addClass('confirm-remove').append(jQuery('.module-builder-remove-item-template').clone().removeClass('module-builder-remove-item-template'));

			}

		} else {

			$last_cell.remove();

			jQuery('.module-builder-cell', $parent_row).css('width', (100 / new_no_cells) + '%');

			jQuery('.module-builder-row-toolbar .row-add-column', $parent_row).removeClass('toolbar-button-disabled');

			if (new_no_cells === 1) {

				jQuery(this).addClass('toolbar-button-disabled');

			}

			refreshBuilderCellMinHeight();

			refreshBuilderModulesSortable($parent_row);

			refreshBuilderMetaValue();

		}

		e.preventDefault();

	});



	/* handle confirmation panel for removing the non-empty column in a row */

	jQuery(document).on('click','.module-builder-remove-item span', function (e) {

		var $parent_cell = jQuery(this).parents('.module-builder-cell');

		if (jQuery(this).hasClass('module-builder-remove-item-dismiss')) {

			$parent_cell.removeClass('confirm-remove').find('.module-builder-remove-item').remove();

		} else {

			var $parent_row = $parent_cell.parents('.module-builder-row'), $sibling_cells = jQuery('.module-builder-cell', $parent_row), new_no_cells = $sibling_cells.length - 1;

			$parent_cell.remove();

			$sibling_cells.css('width', (100 / new_no_cells) + '%');

			jQuery('.module-builder-row-toolbar .row-add-column', $parent_row).removeClass('toolbar-button-disabled');

			if (new_no_cells === 1) {

				jQuery('.module-builder-row-toolbar .row-remove-column', $parent_row).addClass('toolbar-button-disabled');

			}

			refreshBuilderCellMinHeight();

			refreshBuilderModulesSortable($parent_row);

			refreshBuilderMetaValue();

		}

		e.preventDefault();

	});



	/* handle removing a row */

	jQuery(document).on('click','.module-builder-remove-row', function (e) {

		if (jQuery('.module-builder-item', jQuery(this).parents('.module-builder-row')).length === 0 || jQuery(this).hasClass('confirmation')) {

			jQuery(this).parents('.module-builder-row').slideUp(builder_anim_speed, function() {

				jQuery(this).remove();

				refreshBuilderMetaValue();

			});

		} else {

			jQuery(this).addClass('confirmation').not('.mouseleave-handler').bind('mouseleave', function() {

				jQuery(this).removeClass('confirmation');

			}).addClass('mouseleave-handler');

		}

		e.preventDefault();

	});



	/* handle duplicating a row */

	jQuery(document).on('click','.module-builder-duplicate-row', function (e) {

		var $parent_row = jQuery(this).parents('.module-builder-row'), $row_clone = $parent_row.clone();

		jQuery('.module-builder-dropdown-wrapper ul', $parent_row).css('display', 'none').addClass('touch-hidden');

		setTimeout(function() {

			jQuery('.module-builder-dropdown-wrapper ul', $parent_row).attr('style','');

		}, 300);

		jQuery('.module-builder-cell.confirm-remove', $row_clone).removeClass('confirm-remove').find('.module-builder-remove-item').remove();

		$row_clone.css('display', 'none');

		$parent_row.after($row_clone);

		$row_clone.slideDown(builder_anim_speed);

		refreshBuilderModulesSortable($row_clone);

		refreshBuilderMetaValue();

		e.stopPropagation();

		e.preventDefault();

	});



	/* handle adding a new module */

	jQuery(document).on('click','.module-builder-new-item ul span', function (e) {

		var $parent_cell = jQuery(this).parents('.module-builder-cell');

		jQuery('.module-builder-dropdown-wrapper ul', $parent_cell).css('display', 'none').addClass('touch-hidden');

		setTimeout(function() {

			jQuery('.module-builder-dropdown-wrapper ul', $parent_cell).attr('style','');

		}, 300);

		moduleBuilderOpenPopup(jQuery(this).data('type'), jQuery(this).parents('.module-builder-cell'), false);

		e.preventDefault();

	});



	/* handle editing an existent module */

	jQuery(document).on('click','.module-builder-item .module-builder-item-edit', function (e) {

		var $module = jQuery(this).parents('.module-builder-item');

		moduleBuilderOpenPopup(jQuery('.module-value', $module).data('type'), false, $module);

		e.preventDefault();

	});



	/* handle double-click event on module, which means editing it */

	jQuery(document).on('dblclick','.module-builder-item', function (e) {

		if (jQuery(e.target).parents('.actions').length > 0) {

			return;

		}

		var $module = jQuery(this);

		moduleBuilderOpenPopup(jQuery('.module-value', $module).data('type'), false, $module);

		e.preventDefault();

	});



	/* handle tap events on modules */

	var tapped_module = false, tapped_timer = false;

	jQuery(document).on("touchstart", function(e) {

		var $module;

		if (jQuery(e.target).hasClass('module-builder-item')) {

			$module = jQuery(e.target);

		} else {

			$module = jQuery(e.target).parents('.module-builder-item');

		}

		jQuery('#module-builder-container .module-builder-item').removeClass('touch-hover');

		if ($module.length == 0) {

			tapped_module = false;

			return;

		} else {

			tapped_module = $module.addClass('touch-hover');

		}

		if ( ! tapped_timer) {

			tapped_timer = setTimeout(function() {

				tapped_timer = null;

			}, 300);

		} else {

			clearTimeout(tapped_timer);

			tapped_timer = null;

			moduleBuilderOpenPopup(jQuery('.module-value', $module).data('type'), false, $module);

		}

		e.preventDefault();

	});



	/* handle duplicating a module */

	jQuery(document).on('click','.module-builder-item .module-builder-item-duplicate', function (e) {

		var $module = jQuery(this).parents('.module-builder-item');

		var $new_module = $module.clone().css('display', 'none');

		$module.after($new_module);

		$new_module.fadeIn(builder_anim_speed);

		refreshBuilderCellMinHeight();

		refreshBuilderMetaValue();

		e.preventDefault();

	});



	/* handle removing a module */

	jQuery(document).on('click','.module-builder-item .module-builder-item-delete', function (e) {

		jQuery(this).parents('.module-builder-item').fadeOut(builder_anim_speed, function() {

			jQuery(this).remove();

			refreshBuilderCellMinHeight();

			refreshBuilderMetaValue();

		});

		e.preventDefault();

	});



	/* handle touchscreen menu dropdown issues */

	jQuery(document).on('mouseenter','.module-builder-dropdown-wrapper', function () {

		jQuery('ul', this).removeClass('touch-hidden');

	}).on('click','.module-builder-dropdown-toggle', function () {

		jQuery(this).parents('.module-builder-dropdown-wrapper').find('ul').removeClass('touch-hidden');

	});



});



/* save module layout and their properties in the 'module_builder_text' meta-field */

function refreshBuilderMetaValue() { "use strict";

	var layout = {}, no_rows = 0;

	jQuery('#module-builder-container .module-builder-row').each(function() {

		var new_row = {}, no_cells = 0;

		jQuery('.module-builder-cell', this).each(function() {

			var new_cell = {}, no_modules = 0;

			jQuery('.module-builder-item', this).each(function() {

				new_cell[no_modules] = {

					'type': jQuery('.module-value', this).data('type'),

					'data': jQuery('.module-value', this).val()

				};

				no_modules = no_modules + 1;

			});

			new_row[no_cells] = new_cell;

			no_cells = no_cells + 1;

		});

		layout[no_rows] = new_row;

		no_rows = no_rows + 1;

	});

	jQuery('#module_builder_text').val(JSON.stringify(layout));

}



/* refresh the sortable items */

function refreshBuilderModulesSortable($container) { "use strict";

	jQuery('.module-builder-cell-wrapper', $container).sortable({

		items: '.module-builder-item',

		connectWith: '#module-builder-container .module-builder-cell-wrapper',

		tolerance: 'pointer',

		change: function() {

			refreshBuilderCellMinHeight();

		},

		stop: function() {

			refreshBuilderMetaValue();

		}

	});

}



/* refresh min height properties of each row in the builder */

function refreshBuilderCellMinHeight() { "use strict";

	jQuery('#module-builder-container .module-builder-row').each(function() {

		var minHeight = 0, cellWrappers = jQuery('.module-builder-cell-wrapper', this).css('min-height', '');

		cellWrappers.each(function() {

			if (jQuery(this).outerHeight() > minHeight) {

				minHeight = jQuery(this).outerHeight();

			}

		});

		cellWrappers.each(function() {

			jQuery(this).css('min-height', minHeight);

		});

	});

}



/* close popup used for editing module values */

function moduleBuilderClosePopup() { "use strict";

	if (jQuery('.hidden-module-builder-editor').length > 0 && jQuery('.module-builder-modal .editor-placeholder').length > 0) {

		tinymce.execCommand('mceRemoveEditor', false, 'module_content_editor');

		jQuery('.hidden-module-builder-editor').append(jQuery('.module-builder-modal .editor-placeholder').contents());

	}

	jQuery('.module-builder-modal, .module-builder-modal-backdrop').remove();

}



/* handle click event for the Cancel button of the popup */

jQuery(document).on('click','#module-builder-modal .module-builder-popup-cancel-button', function(e) { "use strict";

	e.preventDefault();

	moduleBuilderClosePopup();

});



var moduleBuilderUniqueDuplicateID = 2; // unique ids for duplicated fields



/* open popup for adding new / editing exixtent module properties

   - if $container param exists then it means it is a insert operation (add new module)

   - if $module param exists then it means it is a editing operation */ 

function moduleBuilderOpenPopup(type, $container, $module) { "use strict";

	var $modal = jQuery('<div class="media-modal module-builder-modal" id="module-builder-modal"><button type="button" class="button-link media-modal-close"><span class="media-modal-icon"></span></button><div class="media-modal-content"><div class="media-frame wp-core-ui"><span class="module-builder-spinner spinner is-active"></span></div></div></div>'), $backdrop = jQuery('<div class="media-modal-backdrop module-builder-modal-backdrop" />'), moduleOptions = false;

	$modal.appendTo('body');

	$backdrop.appendTo('body');



	jQuery('#module-builder-modal .media-modal-close, .module-builder-modal-backdrop').click(function(ev) {

		ev.preventDefault();

		moduleBuilderClosePopup();

	});



	$modal.data('close-function', moduleBuilderClosePopup);

	if ($module) {

		$modal.data('current-module', $module);

		moduleOptions = JSON.parse(jQuery('.module-value', $module).val());

	} else if ($container) {

		$modal.data('current-container', $container);

	}



	// load popup content via AJAX

	jQuery.post(ajaxurl, {

		action: 'module_builder_ajax_popup',

		type: type,

		options: moduleOptions

	}, function(data) {

		if (data) {

			jQuery('#module-builder-modal .media-modal-content .media-frame').html(data);

			jQuery('.module-builder-modal .wp-color-picker-field').wpColorPicker();

			if (jQuery('.hidden-module-builder-editor').length > 0 && jQuery('.module-builder-modal .editor-placeholder').length > 0) {

				var editor_value = jQuery('.module-builder-modal textarea').val();

				jQuery('.module-builder-modal textarea').remove();

				tinymce.execCommand('mceRemoveEditor', false, 'module_content_editor');

				jQuery('.module-builder-modal .editor-placeholder').append(jQuery('.hidden-module-builder-editor').contents());

				if (getUserSetting('editor') === 'html') {

					jQuery('.module-builder-modal .editor-placeholder #wp-module_content_editor-wrap.html-active  #module_content_editor').val(editor_value);

				} else {

					tinymce.execCommand('mceAddEditor', false, 'module_content_editor');

					tinymce.get('module_content_editor').setContent(editor_value);

				}

			}

			moduleBuilderInitSubmitHandler();

			jQuery('#module-builder-modal .option-line-duplicate').sortable({

				items: ".item:not(.ui-state-disabled)",

				handle: "h3",

				placeholder: "item-placeholder",

				delay: 100,

				distance: 10,

				axis: 'y'

			});

			moduleBuilderUniqueDuplicateID = 2;

		}

	}, 'html');

}



function moduleBuilderAddFile(event, selector) { "use strict";

	var frame, $el = jQuery(this);

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

		if ( attachment.attributes.type === 'image' ) {

			selector.find('.screenshot').hide().html('<img src="' + attachment.attributes.url + '">').slideDown('fast');

			selector.find('.alt-text').val(attachment.attributes.alt);

			selector.find('.width').val(attachment.attributes.width);

			selector.find('.height').val(attachment.attributes.height);

		}

		selector.find('.remove-image').removeClass('hide');

	});

	frame.open();

}



jQuery(document).on('click','#module-builder-modal .upload-image', function(e) {

	moduleBuilderAddFile(e, jQuery(this).closest('.option-content'));

});



jQuery(document).on('click','#module-builder-modal .remove-image', function() {

	var el = jQuery(this).closest('.option-content');

	el.find('.remove-image').addClass('hide');

	el.find('.upload-file, .alt-text, .width, .height').val('');

	el.find('.screenshot img').remove();

});



jQuery(document).on('click','#module-builder-modal .module-builder-remove-template', function(e) {

	if (confirm(jQuery(this).data('confirm'))) {

		jQuery(this).parent('.item').slideUp(200, function() {

			jQuery(this).remove();

		});

	}

	e.preventDefault();

});



jQuery(document).on('click','#module-builder-modal .module-builder-duplicate-template', function(e) {

	var $el = jQuery(this).closest('.option-content'), $template_item = $el.find('.template-item'), $new_el = $template_item.clone(), $frame_content;

	$new_el.removeClass('template-item').addClass('item').hide(0);

	$new_el.find('input[name],textarea[name],select,label[for]').each(function(){

		var $this = jQuery(this), $attr;

		if ($this.is('label')) {

			$attr = $this.attr('for');

		} else {

			$attr = $this.attr('id');

		}

		var matches = $attr.match(/\[.+?\]/g);

		var old_id = matches[0];

		var new_id = '[' + moduleBuilderUniqueDuplicateID + ']';

		var new_id_attr = $attr.replace(old_id,new_id);

		if ($this.is('label')) {

			$this.attr('for', new_id_attr);

		} else {

			$this.attr('id', new_id_attr);

			$this.attr('name', new_id_attr);

		}

	});

	moduleBuilderUniqueDuplicateID = moduleBuilderUniqueDuplicateID + 1;

	$new_el.insertBefore($el.find('.duplicate-add-new')).slideDown(200);

	$frame_content = jQuery('#module-builder-modal .media-frame-content');

	$frame_content.animate({

		scrollTop: $new_el.offset().top - $frame_content.offset().top + $frame_content.scrollTop() - 12

	}, 500);

	e.preventDefault();

});



/* handle click event for insert/update button of the popup */

function moduleBuilderInitSubmitHandler() {

	jQuery('.module-builder-popup-submit-button').click(function(ev) {

		var inputValues = moduleBuilderGetInputValues(), $modal = jQuery('#module-builder-modal'), new_module_height = '1';

		if (inputValues['height'] !== undefined) {

			new_module_height = inputValues['height'];

		}

		if ($modal.data('current-container')) {

			// add new module in saved container

			var $new_module = jQuery('.module-builder-item-template').clone().removeClass('module-builder-item-template module-height-0 module-height-1 module-height-2 module-height-3 module-height-4 module-height-5 module-height-6').addClass('module-height-' + new_module_height).css('display', 'none');

			jQuery('.module-value', $new_module).val(JSON.stringify(inputValues)).attr('data-type', jQuery(this).data('module-type'));

			if (inputValues['title'] !== undefined && inputValues['title'] !== '') {

				jQuery('.module-title h4', $new_module).html(inputValues['title']);

			} else {

				jQuery('.module-title h4', $new_module).html(jQuery(this).data('module-title'));

			}

			jQuery('.module-description', $new_module).html(jQuery(this).data('module-description'));

			var $parent_cell = $modal.data('current-container');

			$parent_cell.find('.module-builder-cell-wrapper').append($new_module);

			$new_module.fadeIn(builder_anim_speed);

		} else {

			// edit existent module values

			var $edited_module = $modal.data('current-module');

			if (inputValues['title'] !== undefined && inputValues['title'] !== '') {

				jQuery('.module-title h4', $edited_module).html(inputValues['title']);

			} else {

				jQuery('.module-title h4', $edited_module).html(jQuery(this).data('module-title'));

			}

			jQuery('.module-value', $edited_module).val(JSON.stringify(inputValues));

			$edited_module.removeClass('module-height-0 module-height-1 module-height-2 module-height-3 module-height-4 module-height-5 module-height-6').addClass('module-height-' + new_module_height);

		}

		refreshBuilderCellMinHeight();

		refreshBuilderMetaValue();

		$modal.data('close-function')();

		ev.preventDefault();

	});

}



/* obtain all module properties and return a JSON string */

function moduleBuilderGetInputValues() { "use strict";

	var vals = {};

	jQuery('#module-builder-modal .media-frame-content :input[name]').each(function() {

		var $this = jQuery(this), input_name = $this.attr('name');

		if ($this.is('.alt-text, .button, input[type="hidden"]') || $this.parents('.option-line-duplicate').length > 0) {

			return;

		}

		if ($this.hasClass('upload-image')) {

			var props = {};

			props['url'] = $this.val();

			props['width'] = $this.nextAll('input[type=hidden].width').val();

			props['height'] = $this.nextAll('input[type=hidden].height').val();

			props['alt'] = $this.nextAll('.alt-text').val();

			vals[input_name] = props;

		} else if ($this.is('[type=checkbox]')) {

			vals[input_name] = $this.is(':checked');

		} else {

			if (input_name === 'module_content_editor' && jQuery('.module-builder-modal .editor-placeholder #wp-module_content_editor-wrap.tmce-active').length > 0) {

				vals[input_name] = tinyMCE.get('module_content_editor').getContent();

			} else {

				vals[input_name] = $this.val();

			}

		}

	});

	jQuery('#module-builder-modal .media-frame-content .option-line-duplicate').each(function() {

		var input_name = jQuery('.template-item', this).data('inputname'), props = {};

		jQuery.each(jQuery('.item :input[name]', this), function() {

			var $this = jQuery(this), item_input_name = $this.attr('name'), item_input_index = item_input_name.match(/\d+/)[0];

			if ($this.is('.alt-text, .button, input[type="hidden"]')) {

				return;

			}

			item_input_name = item_input_name.substr(0, item_input_name.indexOf('['));

			if (props[item_input_index] === undefined) {

				props[item_input_index] = {};

			}

			if ($this.hasClass('upload-image')) {

				var image_props = {};

				image_props['url'] = $this.val();

				image_props['width'] = $this.nextAll('input[type=hidden].width').val();

				image_props['height'] = $this.nextAll('input[type=hidden].height').val();

				image_props['alt'] = $this.nextAll('.alt-text').val();

				props[item_input_index][item_input_name] = image_props;

			} else if ($this.is('[type=checkbox]')) {

				props[item_input_index][item_input_name] = $this.is(':checked');

			} else {

				props[item_input_index][item_input_name] = $this.val();

			}

		});

		vals[input_name] = props;

	});

	return vals;

}