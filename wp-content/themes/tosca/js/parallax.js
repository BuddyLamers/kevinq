jQuery(document).ready(function () { "use strict";

	// disable parallax effect for mobile devices (for performance reasons)
	if (jQuery(window).width() < 768) {
		return;
	}

	var parallaxParticles = [],
		$window = jQuery(window),
		currentScrollTop = 0,
		vendorPrefix = (function() {
			var prefixes = /^(Moz|Webkit|Khtml|O|ms)(?=[A-Z])/,
				style = jQuery('script')[0].style,
				prefix = '',
				prop;

			for (prop in style) {
				if (prefixes.test(prop)) {
					prefix = prop.match(prefixes)[0];
					break;
				}
			}

			if ('WebkitOpacity' in style) { prefix = 'Webkit'; }
			if ('KhtmlOpacity' in style) { prefix = 'Khtml'; }

			return function(property) {
				return prefix + (prefix.length > 0 ? property.charAt(0).toUpperCase() + property.slice(1) : property);
			};
		}()),

		prefixedTransform = vendorPrefix('transform'),

		setParallaxPosition = function($elem, top) {
			$elem[0].style[prefixedTransform] = 'translateY(' + top + 'px)';
		},

		requestAnimFrame = (
			window.requestAnimationFrame       ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame    ||
			window.oRequestAnimationFrame      ||
			window.msRequestAnimationFrame     ||
			function(callback) {
				setTimeout(callback, 15); // default: 1000 / 60
			}
		),

		parallaxTicking = false,

		parallaxUpdate = function() {
			repositionParallaxElements();
			parallaxTicking = false;
		},

		parallaxRequestTick = function() {
			if ( ! parallaxTicking) {
				requestAnimFrame(parallaxUpdate);
				parallaxTicking = true;
			}
		};

	jQuery('[data-parallax-ratio], #featured-media[class="caption-centered"] .featured-caption, #featured-media[class="caption-special"] .featured-caption').each(function() {
		var $parent = jQuery(this), $this = jQuery('.featured-image, .featured-video, .cerchez-slider-full-height, .text .inner', $parent), parentTop = 0, parentHeight = 0;

		if ( $parent.hasClass('parallaxed')) {
			return; // ignore already processed element
		} else {
			$parent.addClass('parallaxed');
		}

		parentTop = $parent.offset().top, // .position()
		parentHeight = $parent.outerHeight();

		if ($this.length > 0) {
			parallaxParticles.push({
				element: $this,
				elementTop: $this.position().top,
				elementHeight: $this.outerHeight(),
				parent: $parent,
				parentTop: parentTop,
				parentHeight: parentHeight,
				parallaxRatio: $this.parents('[data-parallax-ratio]').data('parallax-ratio')
			});
		}
	});

	$window.bind('resize.parallax', function() {
		for (var i = parallaxParticles.length - 1; i >= 0; i--) {
			parallaxParticles[i].elementTop = parallaxParticles[i].element.position().top;
			parallaxParticles[i].elementHeight = parallaxParticles[i].element.outerHeight();
			if (parallaxParticles[i].parent.length > 0) {
				parallaxParticles[i].parentTop = parallaxParticles[i].parent.offset().top; // .position()
				parallaxParticles[i].parentHeight = parallaxParticles[i].parent.outerHeight();
			}
		}
		repositionParallaxElements();
	}).bind('scroll.parallax', parallaxRequestTick);

	function repositionParallaxElements() {
		if (currentScrollTop == $window.scrollTop()) return;

		currentScrollTop = $window.scrollTop();
		for (var i = parallaxParticles.length - 1; i >= 0; i--) {
			var newPositionTop = currentScrollTop * - (parallaxParticles[i].parallaxRatio - 1);

			setParallaxPosition(parallaxParticles[i].element, newPositionTop);
		}
	}

});
