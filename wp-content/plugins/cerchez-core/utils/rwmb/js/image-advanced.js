/* determine if screen can handle touch events */
if ( ! (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0))) {
	jQuery('html').addClass('no-touch');
}

jQuery( function( $ ) {

	var frame, template = $('#tmpl-rwmb-image-advanced').html();

	$('body').on('click', '.rwmb-image-advanced-upload', function( e ) {
		e.preventDefault();

		var $uploadButton = $( this ),
			$imageList = $uploadButton.siblings('.rwmb-images'),
			maxFileUploads = $imageList.data('max_file_uploads'),
			msg = maxFileUploads > 1 ? rwmbFile.maxFileUploadsPlural : rwmbFile.maxFileUploadsSingle;

		msg = msg.replace('%d', maxFileUploads );

		if ( !frame ) {
			frame = wp.media( {
				className: 'media-frame rwmb-media-frame',
				multiple : true,
				title    : rwmbImageAdvanced.frameTitle,
				library  : {
					type: 'image'
				}
			} );
		}

		frame.open();
		frame.off('select');
		frame.on('select', function() {
			var selection = frame.state().get('selection').toJSON(),
				uploaded = $imageList.children().length,
				ids;

			if ( maxFileUploads > 0 && ( uploaded + selection.length ) > maxFileUploads ) {
				if ( uploaded < maxFileUploads )
					selection = selection.slice( 0, maxFileUploads - uploaded );
				alert( msg );
			}

			selection = _.filter( selection, function( attachment ) {
				return $imageList.children('li#item_' + attachment.id ).length == 0;
			} );
			ids = _.pluck( selection, 'id');

			if( ids.length > 0 ) {
				var data = {
					action			: 'rwmb_attach_media',
					post_id			: $('#post_ID').val(),
					field_id			: $imageList.data('field_id'),
					attachment_ids	: ids,
					_ajax_nonce  	: $uploadButton.data('attach_media_nonce')
				};

				$.post( ajaxurl, data, function( r ) {
					if( r.success ) {
						$imageList
							.append( _.template( template, { attachments: selection }, {
								evaluate:    /<#([\s\S]+?)#>/g,
								interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
								escape:      /\{\{([^\}]+?)\}\}(?!\})/g
							} ) )
							.trigger('update.rwmbFile');
					}
				}, 'json');
			}
		} );
	} )
} );