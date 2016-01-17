//Use this file to inject custom javascript behaviour into the foogallery edit page

//For an example usage, check out wp-content/foogallery/extensions/default-templates/js/admin-gallery-default.js



(function (FOO_VIDEO, FOOGALLERY, $, undefined) {



	var importPlaylistData,importPlaylistItems;



	FOO_VIDEO.initImport = function(){

		var loading_line = $('.upload_image_button > span');

		var loading_text = $( '#import-playlist-id' ).data('loading');

		var image_button = $('.upload_image_button > div');

		// gallery list

		importPlaylistData.prev_text = loading_line.text();



		loading_line.text( loading_text );

		image_button.removeClass('dashicons-format-gallery').addClass('spinner').css({

			"background-position"	: "center center",

			"float"					: "none",

			"visibility"			: "visible",

		});

		$( loading_line ).after( '<span class="foovideo-import-progress"><span class="foovideo-import-progress-bar" style="width: 0%;"></span></span>' );

		importPlaylistItems = [];



		wp.media.frame.close();

		$('.foovideo-results').empty();

		$('.foovideo-searchbox').val('');



		FOO_VIDEO.doImportCall();

	};



    FOO_VIDEO.closeImport = function() {

		var image_button = $('.upload_image_button > div'),

			loading_line = $('.upload_image_button > span'),

			progress_bar = $('.foovideo-import-progress');



		progress_bar.remove();

		loading_line.text( importPlaylistData.prev_text );

		image_button.removeClass('spinner').addClass('dashicons-format-gallery').css({

			"background-position"	: "",

			"float"					: "",

			"visibility"			: "",

		});

		for( var i = 0; i < importPlaylistItems.length; i++ ){

			FOOGALLERY.addAttachmentToGalleryList( importPlaylistItems[ i ] );

		}

	};



	FOO_VIDEO.doImportCall = function() {

		$.ajax({

			type: "POST",

			url: ajaxurl,

			data: importPlaylistData,

			success: function( response ) {

				if( response.success && response.data.ids.length ){

					for( var i = 0; i < response.data.ids.length; i++ ){

						importPlaylistItems.push( response.data.ids[ i ] );

					}

					if( response.data.offset ){

						$('.foovideo-import-progress-bar').css('width', response.data.percent + '%');

						importPlaylistData.offset = response.data.offset;

						FOO_VIDEO.doImportCall();

					}else{

						importPlaylistData.complete = true;

					}

				}

			},fail: function( response ) {

				alert( response );

			}, complete: function(){

				if( importPlaylistData.complete ){

					$('.foovideo-import-progress-bar').css('width', '100%');

					setTimeout( function(){FOO_VIDEO.closeImport();}, 100 );

				}

			}



		});

	};



	FOO_VIDEO.importPlaylist = function() {

		var playlist_id = $( '#import-playlist-id' ).val();

		if ( playlist_id == '' ) {

			$( '#foovideo_gallery_id' ).css( 'background-color', 'red' );

			return;

		}



		var nonce = $( '#foo_video_nonce' ).val();

		var gallery_id = $( '#foovideo_gallery_id' ).val();

		var type = $( '#import-playlist-type' ).val();

		var action = 'foo_video_gallery_import_' + type;



		importPlaylistData = {

			playlist_id: playlist_id,

			foo_video_nonce: nonce,

			gallery_id: gallery_id,

			type: type,

			action: action,

			offset: 0

		};



		FOO_VIDEO.initImport();

	};



	FOO_VIDEO.importSelection = function( selection ) {



		var nonce = $( '#foo_video_nonce' ).val();

		var action = 'foo_video_gallery_import_selection';



		importPlaylistData = {

			selection: selection,

			foo_video_nonce: nonce,

			action: action,

			offset: 0

		};



		FOO_VIDEO.initImport();

	};



	FOO_VIDEO.bindImportPlaylist = function () {

		//bind import playlist

		$( document ).on('click', '.foovideo-playlist-import', function(e) {

			e.preventDefault;

			FOO_VIDEO.importPlaylist();

		});



	};



	FOO_VIDEO.initMediaFrame = function() {

		//if we cant do anything then get out!

		if ( typeof wp == 'undefined' || typeof wp.media == 'undefined' ) {

			return;

		}



		var l10n = wp.media.view.l10n;

		wp.media.view.MediaFrame.Select = wp.media.view.MediaFrame.Select.extend ({

			browseRouter: function( routerView ) {

				"use strict";

				routerView.set({

					upload: {

						text:     l10n.uploadFilesTitle,

						priority: 20

					},

					browse: {

						text:     l10n.mediaLibraryTitle,

						priority: 40

					},

					youtube: {

						text:     "YouTube",

						priority: 50

					},

					vimeo: {

						text:     "Vimeo",

						priority: 50

					}

				});

			}

		});



		var currentMediaFrame;

		wp.media.view.Router = wp.media.view.Router.extend( {

			select : function(id){

				var view = this.get( id );

				this.deselect();

				if (view && view.$el) {

					view.$el.addClass('active');

				}



				if (id === "youtube" || id == "vimeo") {

					setTimeout( function(){

						$(".media-frame-content").html( jQuery('#video-search-' + id + '-tmpl').html() );

						$('.foovideo-searchbox').focus();

					}, 20 );

					currentMediaFrame = this;

				}

			}

		});

	};



    FOO_VIDEO._doingSearch = false;



    FOO_VIDEO.bindVideoSearch = function() {

        $( document ).on('keyup click', '.foovideo-searchbox, .foovideo-loadmore', function( e ){

            var page = 1,

                adtype = 'html',

                clicked = $(this);



            if( e.type === 'click' ){

                if( !clicked.hasClass('foovideo-loadmore') ){

                    return;

                }

                page = clicked.data('page');

                adtype = 'append';

                clicked.addClass('disabled');

            }

            var field = $( '.foovideo-searchbox:visible' ),

                spinner = $('.video-search-spinner'),

                data = {

                    foo_video_nonce: $( '#foo_video_nonce' ).val(),

                    action: 'foo_video_search',

                    type: field.data('type'),

                    q: field.val(),

                    vidpage: page

                };

            if( data.q.length < 3 ){

                return;

            }

            if( FOO_VIDEO._doingSearch ){

                FOO_VIDEO._doingSearch.abort();

            }



            spinner.css('visibility', 'visible');

            FOO_VIDEO._doingSearch = $.ajax({

                type: "POST",

                url: ajaxurl,

                data: data,

                success: function( response ) {

                    $('.foovideo-results')[adtype]( response );

                    if( clicked.hasClass('foovideo-loadmore') ){

                        clicked.remove();

                    }

                },

                complete: function(){

                    spinner.css('visibility', 'hidden');

                }

            });

        });

    };



    FOO_VIDEO.bindSearchResults = function() {

        $( document ).on('click', '.foovideo-thumbnail.attachment', function(){

            var clicked = $( this );

            if( clicked.hasClass( 'playlist') ){

                return;

            }

            if( clicked.hasClass('details') ){

                clicked.removeClass('details')

            }else{

                clicked.addClass('details')

            }

            if( $( '.foovideo-thumbnail.attachment.details').length ){

                $('.media-button-select').prop( 'disabled', false ).addClass('foovideo-import');

            }else{

                $('.media-button-select').prop( 'disabled', true ).removeClass('foovideo-import');

            }

        });

    };



    FOO_VIDEO.bindImportVideo = function() {

        $( document ).on('click', '.foovideo-import', function(){

            var videos = $('.foovideo-thumbnail.attachment.details'),

                selection = [];

            for( var v = 0; v < videos.length; v++ ){

                var video = $( videos[ v ] ).closest('.foovideo-result').find('.foovideo-import');

                selection.push( video.val() );

            }



            // send

            if( selection.length ){

                $('.media-button-select').prop( 'disabled', true );

                FOO_VIDEO.importSelection( selection );

            }

        });

    };



}(window.FOO_VIDEO = window.FOO_VIDEO || {}, window.FOOGALLERY = window.FOOGALLERY || {}, jQuery));



jQuery( function ( $ ) {

	FOO_VIDEO.bindImportPlaylist();

	FOO_VIDEO.initMediaFrame();

    FOO_VIDEO.bindVideoSearch();

    FOO_VIDEO.bindSearchResults();

    FOO_VIDEO.bindImportVideo();

});



