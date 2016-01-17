/* enable CSS features that have JavaScript */

jQuery('html').removeClass('no-js');



/* determine if screen can handle touch events */

if ( ! (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0))) {

	jQuery('html').addClass('no-touch');

}



/* simple way of determining if user is using a mouse */

var screenHasMouse = false;

function themeMouseMove() {

	screenHasMouse = true;

}

function themeTouchStart() {

	jQuery(window).off("mousemove");

	screenHasMouse = false;

	setTimeout(function() {

		jQuery(window).on("mousemove", themeMouseMove);

	}, 250);

}

if ( ! /(iPad|iPhone|iPod)/g.test(navigator.userAgent) ) {

	jQuery(window).on("touchstart", themeTouchStart).on("mousemove", themeMouseMove);

	if (window.navigator.msPointerEnabled) {

		document.addEventListener("MSPointerDown", themeTouchStart, false);

	}

}



jQuery(document).ready(function () { "use strict";



	var belowHeaderLimit = jQuery('body:not(.has-sticky-header) #header').outerHeight() + jQuery('#featured-media').outerHeight() + jQuery('#border-top').height();

	jQuery(window).on("resize", function() {



		var currentContentMargin = parseInt(jQuery('.has-sticky-header #featured-media, .has-sticky-header .no-featured-media + #content').css('margin-top'));

		if (currentContentMargin < jQuery('#header').outerHeight()) {

			jQuery('.has-sticky-header #featured-media, .has-sticky-header .no-featured-media + #content').css('marginTop', jQuery('#header').outerHeight());

		}



		var featuredMediaContainer = jQuery('#featured-media');

		if (jQuery('body').hasClass('featured-header-full')) {

			featuredMediaContainer.css('height', jQuery(window).height() - jQuery('#header').outerHeight() - jQuery('#border-bottom').height() - jQuery('#wpadminbar').outerHeight());

		}

		centerFeaturedImage(featuredMediaContainer);

		centerFeaturedVideo(featuredMediaContainer);



		centerModuleVideos();



		belowHeaderLimit = jQuery('body:not(.has-sticky-header)').outerHeight() + featuredMediaContainer.outerHeight() + jQuery('#border-top').height();

	}).resize();



	var $goToTopLink = jQuery('#go-to-top-link').on('click', function(e){

		jQuery('html, body').animate({ scrollTop: 0 }, { duration: 300, easing: "swing" });

		e.preventDefault();

		return false;

	});



	jQuery(window).scroll(function() {

		$goToTopLink.toggleClass("active", jQuery(window).scrollTop() > belowHeaderLimit);

	});



	/* create mobile menu navigation */

	var $select = jQuery('<select />');

	var mobile_menu_items = '';

	jQuery('#header .menu-wrapper li').each(function () {

		var el = jQuery(this), link = el.find("> a"), indentNo, indentText;

		if (el.parents('#tosca-menu-cart').length == 0) {

			mobile_menu_items += '<option data-href="' + link.prop("href") + '"'+ ("_blank" == link.prop("target") ? ' data-target="_blank"' : "") + '>';

			indentText = '';

			for (indentNo = 0; indentNo < el.parents('ul').length - 1; indentNo++) {

				indentText += '&mdash;';

			}

			if (indentText) { indentText += ' '; }

			mobile_menu_items += indentText;

			mobile_menu_items += link.text() + '</option>';

		}

	});

	if (mobile_menu_items) {

		$select.append(mobile_menu_items).change(function () {

			var url = jQuery(this).find("option:selected").data("href");

			if ( ! url || url =="#") { return; }

			if (jQuery(this).find("option:selected").data("target")) {

				window.open(url, "_blank");

			} else {

				window.location.href = url;

			}

		});

		var $select_wrapper = jQuery('<div id="mobile-menu" />').html($select);

		jQuery($select_wrapper).append('<em class="icon-menu" />');

		jQuery('#header #logo').after($select_wrapper);

		var currentMenu = jQuery('#menu li').index(jQuery('#menu li.current-menu-item'));

		if (currentMenu !== -1) {

			$select.find(':eq(' + currentMenu + ')').attr('selected', true);

		}

	}



	/* handle both mouse hover and touch events for traditional menu (live events used for the cart submenu) */

	jQuery(document).on({

		mouseenter: function () {

			if (screenHasMouse) {

				jQuery(this).addClass("hover");

			}

		},

		mouseleave: function () {

			if (screenHasMouse) {

				jQuery(this).removeClass("hover");

			}

		}

	}, '#header li');

	if ( ! jQuery('html').hasClass('no-touch')) {

		jQuery('#header ul li.menu-item-has-children > a, #header ul li.page_item_has_children > a, #header ul li.menu-item-language > a').on('click', function (e) {

			if ( ! screenHasMouse && ! window.navigator.msPointerEnabled ) {

				var $parent = jQuery(this).parent();

				if ( ! $parent.parents('.hover').length) {

					jQuery('#header ul li.menu-item-has-children, #header ul li.page_item_has_children, #header ul li.menu-item-language').not($parent).removeClass('hover');

				}

				$parent.toggleClass("hover");

				e.preventDefault();

			}

		});



		/* toggle visibile dropdowns if touched outside the menu area */

		jQuery(document).click(function(e){

			if (jQuery(e.target).parents('#header ul').length > 0) { return; }

			jQuery('#header ul li.menu-item-has-children, #header ul li.page_item_has_children, #header ul li.menu-item-language').removeClass('hover');

		});

	}



	/* add functionality to accordion widgets */

	jQuery(document).on('click', '.accordion .accordion-title', function (e) {

		var $li = jQuery(this).parent('li'), $ul = $li.parent('.accordion');

		// check if only one accordion can be opened at a time

		if ($ul.hasClass('only-one-visible')) {

			jQuery('li',$ul).not($li).removeClass('active');

		}

		$li.toggleClass('active');

		if ($li.hasClass('active')) { jQuery($li).intoViewport(); }

		e.preventDefault();

	});



	if (window.location.hash.indexOf("#comment") >= 0 || window.location.hash.indexOf("#review") >= 0) {

		setTimeout(function(){

			jQuery(window.location.hash).intoViewport();

		}, 500);

	}



	/* handle directional thumbnail overlays */

	var s = document.createElement('p').style, supportForTransitions = 'transition' in s || 'WebkitTransition' in s || 'MozTransition' in s || 'msTransition' in s || 'OTransition' in s, transitionSpeed = 200, transitionProp = 'all ' + transitionSpeed + 'ms ease';

	jQuery(document).delegate('.thumb.directional', 'mouseenter mouseleave', function( event ) {

		if (jQuery(window).width() < 768) { return; }

		var $el = jQuery(this), $hoverElem = $el.find('.info'), w = $el.width(), h = $el.height(), x = ( event.pageX - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ), y = ( event.pageY - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ), direction = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4, fromStyle, toStyle, slideFromTop = { left : '0px', top : '-100%' }, slideFromBottom = { left : '0px', top : '100%' }, slideFromLeft = { left : '-100%', top : '0px' }, slideFromRight = { left : '100%', top : '0px' }, slideTop = { top : '0px' }, slideLeft = { left : '0px' };

		switch( direction ) {

			case 0: // from top

				fromStyle = slideFromTop;

				toStyle = slideTop;

				break;

			case 1: // from right

				fromStyle = slideFromRight;

				toStyle = slideLeft;

				break;

			case 2: // from bottom

				fromStyle = slideFromBottom;

				toStyle = slideTop;

				break;

			case 3: // from left

				fromStyle = slideFromLeft;

				toStyle = slideLeft;

				break;

		}

		if ( event.type === 'mouseenter' ) {

			$hoverElem.hide().css(fromStyle).show(0, function() {

				var $elem = jQuery( this );

				if ( supportForTransitions ) {

					$elem.css( 'transition', transitionProp );

				}

				jQuery.fn.applyStyle = supportForTransitions ? jQuery.fn.css : jQuery.fn.animate;

				$elem.stop().applyStyle( toStyle, jQuery.extend( true, [], { duration : transitionSpeed + 'ms' } ) );

			});

		} else {

			if ( supportForTransitions ) {

				$hoverElem.css( 'transition', transitionProp);

			}

			jQuery.fn.applyStyle = supportForTransitions ? jQuery.fn.css : jQuery.fn.animate;

			$hoverElem.stop().applyStyle( fromStyle, jQuery.extend( true, [], { duration : transitionSpeed + 'ms' } ) );

		}

	});



	jQuery('.tabs a').on('click', function (e) {

		var $parent = jQuery(this).parent();

		e.preventDefault();

		if ($parent.hasClass('active')) return;

		$parent.siblings('li').each(function() {

			jQuery(this).removeClass('active');

			jQuery(jQuery(this).find('a').attr('href')).hide();

		});

		$parent.addClass('active');

		var hash = $parent.find('a').attr('href');

		jQuery(hash).show();

	});



	// elements that are initially into view shouldn't be animated

	if (jQuery('body').hasClass('animate-elems-in-view')) {

		jQuery('.gallery figure.gallery-item').addClass('animate-in-view');

		var $animatedElements = jQuery('.animate-in-view');

		if ($animatedElements.length > 0) {

			$animatedElements.filter(function() {

				return verge.inY(this, -50);

			}).each(function() {

				jQuery(this).removeClass('animate-in-view');

			});

			// elements that are out of view will be animated on scroll or resize

			var didScrollOrResize = false, inViewportTimer = false;

			jQuery(window).bind('scroll resize', function() {

				if ( ! didScrollOrResize) {

					inViewportTimer = setInterval(function() {

						if ( didScrollOrResize ) {

							didScrollOrResize = false;

							clearTimeout(inViewportTimer);

							isInPageViewport();

						}

					}, 150);

				}

				didScrollOrResize = true;

			});

			isInPageViewport();

		}

	}



	var $video_iframe = jQuery("#featured-media .featured-video iframe, .module-type-video iframe");

	$video_iframe.each(function() {

		var $iframe = jQuery(this);

		if ($iframe.hasClass("vimeo") && $iframe.hasClass("mute")) {

			if (typeof $f !== "undefined") {

				var player = $f(this);

				player.addEvent('ready', function(player_id) {

					player = $f(player_id);

					player.api('setVolume', 0);

				});

			}

		}

		$iframe.load(function() {

			jQuery(window).resize();

			jQuery(this).parent().addClass('loaded');

		});

	});



	jQuery.event.trigger({

		type: "cerchezWidgetUpdate",

		target: document

	});



	jQuery('body').removeClass('hide-background');

	setTimeout(function()  {

		jQuery('#featured-media .loader').remove();

	}, 1000);

});



jQuery(window).unload(function () { });



function isInPageViewport() {

	jQuery('.animate-in-view:not(.animated)').filter(function() {

		return verge.inY(this,50);

	}).each(function() {

		jQuery(this).addClass('animated');

	});

}



function centerFeaturedImage($container) {

	var $img = jQuery('.featured-image', $container);

	if ( ! $img) { return; }

	var container_width = $container.width(), container_height = $container.height(), container_aspect_ratio = container_height / container_width, img_width = $img.attr('width'), img_height = $img.attr('height'), img_aspect_ratio = img_height / img_width, final_top = 'auto', final_left = 'auto', final_bottom = 'auto', final_right = 'auto', final_width, final_height, align_image = 'center center';



	if ($img.data('image-align')) {

		align_image = $img.data('image-align');

	}



	if (container_aspect_ratio > img_aspect_ratio) {

		final_width = container_height / img_aspect_ratio;

		final_height = container_height;

	} else {

		final_width = container_width;

		final_height = container_width * img_aspect_ratio;

	}

	if (align_image === 'left top' || align_image === 'center top' || align_image === 'right top') {

		final_top = 0;

	}

	if (align_image === 'left center' || align_image === 'right center' || align_image === 'center center') {

		final_top = (container_height - final_height) / 2;

	}

	if (align_image === 'left top' || align_image === 'left center' || align_image === 'left bottom') {

		final_left = 0;

	}

	if (align_image === 'center top' || align_image === 'center center' || align_image === 'center bottom') {

		final_left = (container_width - final_width) / 2;

	}

	if (align_image === 'right top' || align_image === 'right center' || align_image === 'right bottom') {

		final_right = 0;

	}

	if (align_image === 'left bottom' || align_image === 'center bottom' || align_image === 'right bottom') {

		final_bottom = 0;

	}



	$img.css({ top: final_top, left: final_left, right: final_right, bottom: final_bottom, width: final_width, height: final_height });

}



function centerFeaturedVideo($container) {

	var $video_container = jQuery('.featured-video', $container);

	if ( ! $video_container) { return; }

	var bottomExcludeHeight = 0;

	if (jQuery('iframe', $video_container).hasClass('youtube') || jQuery('iframe', $video_container).hasClass('vimeo')) {

		bottomExcludeHeight = 60;

	}

	var container_width = $container.width(), container_height = $container.height() + bottomExcludeHeight, container_aspect_ratio = container_height / container_width, video_aspect_ratio = 9/16, final_top = 'auto', final_left = 'auto', final_bottom = 'auto', final_right = 'auto', final_width, final_height, align_video = 'center center';



	if ($video_container.data('image-align')) {

		align_video = $video_container.data('image-align');

	}



	if (container_aspect_ratio > video_aspect_ratio) {

		final_width = container_height / video_aspect_ratio;

		final_height = container_height;

	} else {

		final_width = container_width;

		final_height = container_width * video_aspect_ratio;

	}

	if (align_video === 'left top' || align_video === 'center top' || align_video === 'right top') {

		final_top = 0;

	}

	if (align_video === 'left center' || align_video === 'right center' || align_video === 'center center') {

		final_top = (container_height - final_height) / 2;

	}

	if (align_video === 'left top' || align_video === 'left center' || align_video === 'left bottom') {

		final_left = 0;

	}

	if (align_video === 'center top' || align_video === 'center center' || align_video === 'center bottom') {

		final_left = (container_width - final_width) / 2;

	}

	if (align_video === 'right top' || align_video === 'right center' || align_video === 'right bottom') {

		final_right = 0;

	}

	if (align_video === 'left bottom' || align_video === 'center bottom' || align_video === 'right bottom') {

		final_bottom = 0;

	}



	jQuery('iframe,video', $video_container).css({ top: final_top, left: final_left, right: final_right, bottom: final_bottom, width: final_width, height: final_height });

}



var $video_modules;

function centerModuleVideos() {

	if ( ! $video_modules) {

		$video_modules = jQuery('.module-type-video');

	}

	$video_modules.each(function() {

		var bottomExcludeHeight = 0, $this = jQuery(this), $iframe = jQuery('iframe', this);

		if ($iframe.hasClass('vimeo')) {

			bottomExcludeHeight = 60;

		}

		if ($iframe.hasClass('youtube')) {

			bottomExcludeHeight = 40;

		}

		var container_width = $this.width(), container_height = $this.outerHeight() + bottomExcludeHeight, container_aspect_ratio = container_height / container_width, video_aspect_ratio = 9/16, final_top = 'auto', final_left = 'auto', final_bottom = 'auto', final_right = 'auto', final_width, final_height, align_video = 'center center';



		if ($this.data('image-align')) {

			align_video = $this.data('image-align');

		}



		if (container_aspect_ratio > video_aspect_ratio) {

			final_width = container_height / video_aspect_ratio;

			final_height = container_height;

		} else {

			final_width = container_width;

			final_height = container_width * video_aspect_ratio;

		}

		if (align_video === 'left top' || align_video === 'center top' || align_video === 'right top') {

			final_top = 0;

		}

		if (align_video === 'left center' || align_video === 'right center' || align_video === 'center center') {

			final_top = (container_height - final_height) / 2;

		}

		if (align_video === 'left top' || align_video === 'left center' || align_video === 'left bottom') {

			final_left = 0;

		}

		if (align_video === 'center top' || align_video === 'center center' || align_video === 'center bottom') {

			final_left = (container_width - final_width) / 2;

		}

		if (align_video === 'right top' || align_video === 'right center' || align_video === 'right bottom') {

			final_right = 0;

		}

		if (align_video === 'left bottom' || align_video === 'center bottom' || align_video === 'right bottom') {

			final_bottom = 0;

		}



		jQuery('iframe,video', this).css({ top: final_top, left: final_left, right: final_right, bottom: final_bottom, width: final_width, height: final_height });

	});

}



var featured_youtube_player, featured_youtube_player_timer;

function onYouTubePlayerAPIReady() { // called automatically by YouTube API

	jQuery('#featured-media .featured-video iframe.youtube.mute, .module-type-video iframe.youtube.mute').each(function () {

		featured_youtube_player = new YT.Player(jQuery(this).attr('id'), {

			events: {

				'onReady': function() {

					featured_youtube_player.mute();

				}

			}

		});

	});

}



/* scroll element into view */

(function(a){jQuery.fn.intoViewport=function(options){options=a.extend({duration:300,easing:"swing"},options||{});return this.each(function(){function scrTo(dest){a("html,body").stop().animate({scrollTop:dest},options);}var scr=a(document).scrollTop()||a(window).scrollTop(),wheight=a(window).height()-a('#wpadminbar').height(),top=a(this).offset().top-a('#wpadminbar').height()-a('.has-sticky-header #header').height(),eheight=a(this).outerHeight();if(scr>top){scrTo(top);}else if(scr!=top&&top+eheight>scr+wheight){scrTo(top+Math.min(eheight-wheight,0));}});};})(jQuery);



/* verge 1.9.1 */

!function(a,b,c){"undefined"!=typeof module&&module.exports?module.exports=c():a[b]=c()}(this,"verge",function(){function a(){return{width:k(),height:l()}}function b(a,b){var c={};return b=+b||0,c.width=(c.right=a.right+b)-(c.left=a.left-b),c.height=(c.bottom=a.bottom+b)-(c.top=a.top-b),c}function c(a,c){return a=a&&!a.nodeType?a[0]:a,a&&1===a.nodeType?b(a.getBoundingClientRect(),c):!1}function d(b){b=null==b?a():1===b.nodeType?c(b):b;var d=b.height,e=b.width;return d="function"==typeof d?d.call(b):d,e="function"==typeof e?e.call(b):e,e/d}var e={},f="undefined"!=typeof window&&window,g="undefined"!=typeof document&&document,h=g&&g.documentElement,i=f.matchMedia||f.msMatchMedia,j=i?function(a){return!!i.call(f,a).matches}:function(){return!1},k=e.viewportW=function(){var a=h.clientWidth,b=f.innerWidth;return b>a?b:a},l=e.viewportH=function(){var a=h.clientHeight,b=f.innerHeight;return b>a?b:a};return e.mq=j,e.matchMedia=i?function(){return i.apply(f,arguments)}:function(){return{}},e.viewport=a,e.scrollX=function(){return f.pageXOffset||h.scrollLeft},e.scrollY=function(){return f.pageYOffset||h.scrollTop},e.rectangle=c,e.aspect=d,e.inX=function(a,b){var d=c(a,b);return!!d&&d.right>=0&&d.left<=k()},e.inY=function(a,b){var d=c(a,b);return!!d&&d.bottom>=0&&d.top<=l()},e.inViewport=function(a,b){var d=c(a,b);return!!d&&d.bottom>=0&&d.right>=0&&d.top<=l()&&d.left<=k()},e});