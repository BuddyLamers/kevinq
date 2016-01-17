jQuery( document ).ready( function( $ ) {

	$('.rwmb-add-file').each( function() {
		var $this = $( this ),
			$uploads = $this.siblings('.file-input'),
			$first = $uploads.first(),
			uploadCount = $uploads.length,
			$fileList = $this.closest('.rwmb-input').find('.rwmb-uploaded'),
			fileCount = $fileList.children('li').length,
			maxFileUploads = $fileList.data('max_file_uploads');

		if ( maxFileUploads > 0 ) {
			if ( uploadCount + fileCount >= maxFileUploads  )
				$this.hide();
			if ( fileCount >= maxFileUploads )
				$uploads.hide();
		}

		$this.click( function() {
			if ( maxFileUploads <= 0 || uploadCount + fileCount < maxFileUploads ) {
				$first.clone().insertBefore( $this );
				uploadCount++;

				if ( maxFileUploads > 0 && uploadCount + fileCount >= maxFileUploads  )
					$this.hide();
			}

			return false;
		} );
	} );

	$('.rwmb-uploaded').on('click', '.rwmb-delete-file', function() {
		var $this = $( this ),
			$parent = $this.parents('li'),
			$container = $this.closest('.rwmb-uploaded'),
			data = {
				action: 'rwmb_delete_file',
				_ajax_nonce: $container.data('delete_nonce'),
				post_id: $('#post_ID').val(),
				field_id: $container.data('field_id'),
				attachment_id: $this.data('attachment_id'),
				force_delete: $container.data('force_delete')
			};

		$.post( ajaxurl, data, function( r ) {
			if ( !r.success ) {
				alert( r.data );
				return;
			}

			$parent.addClass('removed');

			// If transition events not supported
			var div = document.createElement('div');
			if ( ! ('ontransitionend' in window ) && ('onwebkittransitionend' in window ) && ! ('onotransitionend' in div || navigator.appName === 'Opera')
			) {
				$parent.remove();
				$container.trigger('update.rwmbFile');
			}

			$('.rwmb-uploaded').on('transitionend webkitTransitionEnd otransitionend', 'li.removed', function() {
				$( this ).remove();
				$container.trigger('update.rwmbFile');
			} );
		}, 'json');

		return false;
	} );

	$('.rwmb-uploaded').on('transitionend webkitTransitionEnd otransitionend', 'li.removed', function() {
		$( this ).remove();
	});

	$('body').on('update.rwmbFile', '.rwmb-uploaded', function() {
		var $fileList = $( this ),
			maxFileUploads = $fileList.data('max_file_uploads'),
			$uploader = $fileList.siblings('.new-files'),
			numFiles = $fileList.children().length;

		numFiles > 0 ? $fileList.removeClass('hidden') : $fileList.addClass('hidden');

		if ( maxFileUploads === 0 ) return false;

		numFiles >= maxFileUploads ? $uploader.addClass('hidden') : $uploader.removeClass('hidden');

		return false;
	} );
} );