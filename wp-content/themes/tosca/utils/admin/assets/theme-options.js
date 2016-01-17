jQuery.noConflict();

jQuery(document).ready(function() {

	// style some personal admin controls based on user's profile primary color (can't use wp_add_inline_style here, WP doesn't offer access to the current profile colors)
	jQuery('head').append('<style type="text/css" id="theme-options-primary-color">#options_panel .cb-enable.selected span,#options_panel .section-sliderui .ui-slider .ui-slider-range.ui-widget-header{background-color:' + jQuery('.save-options.button-primary').css('backgroundColor') + ';border-color:' + jQuery('#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu').css('backgroundColor') + '}</style>');

	jQuery('.fld').click(function() {
		var $fold = '.f_' + this.id;
		jQuery($fold).slideToggle('normal', "swing");
	});

	jQuery('.of-color').wpColorPicker();

	if ( location.hash != "" ) {
		jQuery.cookie('themeoptions_current_tab', decodeURI(location.hash), { expires: 7, path: '/' });
	}
	if (jQuery.cookie("themeoptions_current_tab") === null) {
		jQuery('.group:first').show(0);
		jQuery('#of-nav li:first').addClass('current');
	} else {
		var hooks = jQuery('#hooks').html();
		hooks = jQuery.parseJSON(hooks);
		jQuery.each(hooks, function(key, value) {
			if (jQuery.cookie("themeoptions_current_tab") == '#tab-'+ value) {
				jQuery('.group#tab-' + value).show(0);
				jQuery('#of-nav a[href="#tab-' + value + '"]').parent('li').addClass('current');
			}
		});
		if (jQuery('#of-nav li.current').length == 0) {
			jQuery('.group:first').show(0);
			jQuery('#of-nav li:first').addClass('current');
		}
	}

	jQuery('#of-nav li a').click(function(evt){
		jQuery('#of-nav li').removeClass('current');
		jQuery(this).parent().addClass('current');
		var clicked_group = jQuery(this).attr('href');
		jQuery.cookie('themeoptions_current_tab', clicked_group, { expires: 7, path: '/' });
		jQuery('.group').hide();
		jQuery(clicked_group).show();
		return false;
	});

	jQuery(window).scroll(function() {
		var top = jQuery(window).scrollTop() - jQuery('#options_panel').position().top;
		if (top > jQuery('#options_panel #info_bar').outerHeight()) {
			jQuery('#options_panel #info_bar').css('top', top).addClass('fixed');
		} else {
			jQuery('#options_panel #info_bar').css('top', '').removeClass('fixed');
		}
	});

	jQuery(window).resize(function() {
		jQuery(window).scroll();
	});

	jQuery('.of-radio-img-img').click(function(){
		jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		jQuery(this).addClass('of-radio-img-selected');
	});
	jQuery('.of-radio-img-label').hide();
	jQuery('.of-radio-img-img').show();
	jQuery('.of-radio-img-radio').hide();
	jQuery('.of-radio-tile-img').click(function(){
		jQuery(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		jQuery(this).addClass('of-radio-tile-selected');
	});
	jQuery('.of-radio-tile-label').hide();
	jQuery('.of-radio-tile-img').show();
	jQuery('.of-radio-tile-radio').hide();

	jQuery(".slide_body").hide();
	jQuery(".slide_edit_button").live( 'click', function(){
		jQuery(this).parent().toggleClass("active").next().slideToggle("fast");
		return false;
	});

	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			jQuery(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}
	
	jQuery('.of-slider-title').live('keyup', function() {
		update_slider_title(this);
	});

	jQuery('.slide_delete_button').live('click', function() {
		var message = jQuery('#message-delete-slide').html();
		if (confirm(message)) {
			var $trash = jQuery(this).parents('li');
			$trash.animate({
					opacity: 0.25,
					height: 0,
				}, 300, function() {
					jQuery(this).remove();
			});
		}
		return false;
	});

	jQuery(".slide_add_button").live('click', function(){
		var slidesContainer = jQuery(this).prev();
		var sliderId = slidesContainer.attr('id');
		var numArr = jQuery('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;
		}).get();
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) maxNum = 0;
		var newNum = maxNum + 1;
		var newSlide = jQuery('#sorter-newitem-list').html();
		newSlide = newSlide.replace(new RegExp("%1", 'g'),newNum);
		newSlide = newSlide.replace(new RegExp("%2", 'g'),sliderId);
		slidesContainer.append(newSlide);
		optionsframework_file_bindings();
		return false;
	});

	jQuery('.slider').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		jQuery('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.75,
			handle: ".slide_header",
			cancel: "a"
		});
	});

	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		jQuery('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.75,
			update: function() {
				jQuery(this).find('.position').each( function() {
					var listID = jQuery(this).parent().attr('id');
					var parentID = jQuery(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = jQuery(this).parent().parent().parent().attr('id');
					jQuery(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');
				});
			}
		});
	});

	jQuery('#of_backup_button').live('click', function() {
		var message = jQuery('#message-backup-options').html();
		if (confirm(message)) {
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');
			var nonce = jQuery('#security').val();
			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if (response==-1){ //failed
					var fail_popup = jQuery('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 1500);
				}
				else {
					var success_popup = jQuery('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
		}
		return false;
	}); 

	jQuery('#of_restore_button').live('click', function() {
		var message = jQuery('#message-backup-restore').html();
		if (confirm(message)) {
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');
			var nonce = jQuery('#security').val();
			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if (response==-1){ //failed
					var fail_popup = jQuery('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 1500);
				} else {
					var success_popup = jQuery('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
		}
		return false;
	});

	jQuery('#of_import_button').live('click', function() {
		var message = jQuery('#message-backup-import').html();
		if (confirm(message)) {
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');
			var nonce = jQuery('#security').val();
			var import_data = jQuery('#export_data').val();
			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
			jQuery.post(ajaxurl, data, function(response) {
				var fail_popup = jQuery('#of-popup-fail');
				var success_popup = jQuery('#of-popup-save');
				//check nonce
				if (response==-1) { //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 1500);
				} else {
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
		}
		return false;
	});

	jQuery('button.save-options').live('click',function() {
		var nonce = jQuery('#security').val();
		jQuery('#options_panel .spinner').addClass('is-active').fadeIn();
		var serializedReturn = jQuery('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();
		jQuery('#of_form :input[type=checkbox]').each(function() {
			if ( ! this.checked) {
				serializedReturn += '&' + this.name + '=0';
			}
		});
		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};
		jQuery.post(ajaxurl, data, function(response) {
			var success = jQuery('#of-popup-save');
			var fail = jQuery('#of-popup-fail');
			var loading = jQuery('#options_panel .spinner');
			loading.fadeOut();
			if (response==1) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
			window.setTimeout(function(){
				success.fadeOut().removeClass('is-active'); 
				fail.fadeOut();
			}, 1500);
		});
		return false; 
	});

	jQuery('button.reset-options').click(function() {
		var message = jQuery('#message-reset-warning').html();
		if (confirm(message)) {
			var nonce = jQuery('#security').val();
			jQuery('.ajax-reset-loading-img').fadeIn();
			var data = {
				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};
			jQuery.post(ajaxurl, data, function(response) {
				var success = jQuery('#of-popup-reset');
				var fail = jQuery('#of-popup-fail');
				var loading = jQuery('.ajax-reset-loading-img');
				loading.fadeOut();  
				if (response==1) {
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				} else { 
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();
					}, 1500);
				}
			});
		}
		return false;
	});

	jQuery('.smof_sliderui').each(function() {
		var obj = jQuery(this);
		var sId = "#" + obj.data('id');
		var val = parseInt(obj.data('val'));
		var min = parseInt(obj.data('min'));
		var max = parseInt(obj.data('max'));
		var step = parseInt(obj.data('step'));
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			range: "min",
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
			}
		});
	});

	jQuery(".cb-enable").click(function(){
		var parent = jQuery(this).parents('.switch-options');
		jQuery('.cb-disable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', true);
		var obj = jQuery(this);
		var $fold = '.f_' + obj.data('id');
		jQuery($fold).slideDown('normal', "swing");
	});
	jQuery(".cb-disable").click(function(){
		var parent = jQuery(this).parents('.switch-options');
		jQuery('.cb-enable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', false);
		var obj = jQuery(this);
		var $fold='.f_' + obj.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});

	function find_unique_characters(str) {
		unique=[];
		while(str.length>0){
			var char = str.charAt(0);
			var re = new RegExp(char,"g");
			if (str.match(re).length===1) unique.push(char);
			str=str.replace(re,"");
		}
		return unique.join("");
	}

	function switchGoogleFont(mainID){
		var _selected_font_name = jQuery('#' + mainID + '_family').val();
		var _selected_font_weight = jQuery('#' + mainID + '_variant').val();
		var _linkid = 'ggf_' + mainID;
		var _previewer = mainID + '_ggf_previewer';
		if (_selected_font_name) {
			if (_selected_font_name !== '') {
				jQuery('#' + _linkid).remove();
				if (_selected_font_weight) {
					_selected_font_weight = _selected_font_weight.replace("regular", "400");
					jQuery('.' + _previewer).css('font-weight', _selected_font_weight);
					_selected_font_weight = ':' + _selected_font_weight;
				} else {
					_selected_font_weight = '';
				}
				var the_font = _selected_font_name.replace(/\s+/g, '+');
				jQuery('head').append('<link rel="stylesheet" href="' + location.protocol + '//fonts.googleapis.com/css?family=' + the_font + _selected_font_weight + '" type="text/css" id="'+ _linkid +'">');
				jQuery('.' + _previewer).css('font-family', _selected_font_name);
				jQuery('.' + _previewer).fadeIn();
			} else {
				jQuery('.' + _previewer).attr('style', '').fadeOut();
			}
		}
	}

	jQuery('select.font-family').each(function(){
		switchGoogleFont(jQuery(this).data('id'));
	}).change(function(){
		// load variants and subsets for specific font
		var selectID = jQuery(this).data('id');
		var _font_name = jQuery('#' + selectID + '_family').val();
		var _font_weight = jQuery('#' + selectID + '_variant').val();
		var _font_subset = jQuery('#' + selectID + '_subset').val();
		if (_font_name) {
			var currentOption = jQuery('#' + selectID + '_family option[value="' + _font_name + '"]');
			var _font_variants = currentOption.data("variants").split(",");
			jQuery('#' + selectID + '_variant').html("");
			for (i = 0; i < _font_variants.length; ++i) {
				jQuery('#' + selectID + '_variant').append('<option value="' + _font_variants[i] + '">' + _font_variants[i] + '</option>');
			}
			if ( ! _font_weight) _font_weight = 'regular';
			jQuery('#' + selectID + '_variant option[value="' + _font_weight + '"]').prop('selected', true);
			var _font_subsets = currentOption.data("subsets").split(",");
			jQuery('#' + selectID + '_subset').html("");
			for (i = 0; i < _font_subsets.length; ++i) {
				jQuery('#' + selectID + '_subset').append('<option value="' + _font_subsets[i] + '">' + _font_subsets[i] + '</option>');
			}
			if ( ! _font_subset) _font_subset = 'latin';
			jQuery('#' + selectID + '_subset option[value="' + _font_subset + '"]').prop('selected', true);
			switchGoogleFont(jQuery(this).data('id'));
		} else {
			jQuery('.' + selectID + '_ggf_previewer').attr('style', '').fadeOut();
			jQuery('#' + selectID + '_variant').html("");
			jQuery('#' + selectID + '_subset').html("");
		}
	});
	jQuery('select.font-variants').change(function(){
		switchGoogleFont(jQuery(this).data('id'));
	});

	function optionsframework_add_file(event, selector){
		var upload = jQuery('.uploaded-file'), frame;
		var $el = jQuery(this);
		event.preventDefault();
		if (frame) {
			frame.open();
			return;
		}

		frame = wp.media({
			title: jQuery('h3', selector).text()
		});
		frame.on('select', function() {
			var attachment = frame.state().get('selection').first();
			frame.close();
			var $upload_input = selector.find('.upload');
			$upload_input.val(attachment.attributes.url);
			if ( attachment.attributes.type == 'image' ) {
				selector.find('.screenshot').empty().hide().append('<img class="of-option-image" src="' + attachment.attributes.url + '">').slideDown('fast');
				selector.find('.width').val(attachment.attributes.width);
				selector.find('.height').val(attachment.attributes.height);
				selector.find('.alt').val(attachment.attributes.alt);
			}
			selector.find('.media_upload_button').unbind();
			selector.find('.remove-image').removeClass('hide');
			selector.find('.of-background-properties').slideDown();
			if ($upload_input.hasClass('i_fld')) {
				jQuery('.f_' + $upload_input.data('id')).slideDown('normal', "swing");
			}
			optionsframework_file_bindings();
		});
		frame.open();
	}

	function optionsframework_remove_file(selector) {
		var $upload_input = selector.find('.upload');
		$upload_input.val('');
		selector.find('.remove-image').addClass('hide');
		selector.find('.of-background-properties').hide();
		selector.find('.screenshot').slideUp();
		selector.find('.remove-file').unbind();
		if ( jQuery('.section-upload .upload-notice').length > 0 ) {
			jQuery('.media_upload_button').remove();
		}
		if ($upload_input.hasClass('i_fld')) {
			jQuery('.f_' + $upload_input.data('id')).slideUp('normal', "swing");
		}
		optionsframework_file_bindings();
	}

	function optionsframework_file_bindings() {
		jQuery('.remove-image, .remove-file').on('click', function() {
			optionsframework_remove_file( jQuery(this).parents('.section-upload, .section-media, .slide_body') );
		});
		jQuery('.media_upload_button').unbind('click').click( function( event ) {
			optionsframework_add_file(event, jQuery(this).parents('.section-upload, .section-media, .slide_body'));
		});
	}
	optionsframework_file_bindings();

});

jQuery.cookie=function(key,value,options){if (arguments.length>1&&String(value)!=="[object Object]"){options=jQuery.extend({},options);if (value===null||value===undefined){options.expires=-1}if (typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days)}value=String(value);return(document.cookie=[encodeURIComponent(key),'=',options.raw?value:encodeURIComponent(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''))}options=value||{};var result,decode=options.raw?function(s){return s}:decodeURIComponent;return(result=new RegExp('(?:^|; )'+encodeURIComponent(key)+'=([^;]*)').exec(document.cookie))?decode(result[1]):null};