(function( $ ) {
	'use strict';

	$(function() {
		if( $('.table-of-contents-widget-container').get(0)) {
			var $tocContainer = $('.table-of-contents-widget-container');
			var contentWrapperSelector = $tocContainer.data('selector');
			var sticky = $tocContainer.data('sticky');
			var offsetTop = $tocContainer.data('offset_top');
			var viewPortOffsetTop = $tocContainer.data('viewport_offset_top');

			var $contentWrapper = $(contentWrapperSelector);

			var $headings = $contentWrapper.find(":header");
			if($headings.length > 0) {

				var $tocWidget = $tocContainer.parents('.widget_table-of-contents-widget');

				var textToHash = function (str) {
					str = str.replace(/^\s+|\s+$/g, ''); // trim
					str = str.toLowerCase();
					str = str.replace('.', '-') // replace a dot by a dash 
						.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
						.replace(/\s+/g, '-') // collapse whitespace and replace by a dash
						.replace(/-+/g, '-') // collapse dashes
						.replace( /\//g, '' ); // collapse all forward-slashes
					return str;
				}

				//TOC html
				var $ul = $("<ul>");
				$headings.each(function( index ) {
					var $heading = $(this);
					if (!$heading.is('[id]')) {
						var headingHash = textToHash($heading.text());
						$heading.attr('id', 'htoc-'+headingHash);
					}
					var $tocItem = $heading.clone();
					var $li = $("<li>").append($tocItem);
					$ul.append($li);
					var anchor = $tocItem.attr('id');
					$tocItem.wrap('<li><a href="#'+anchor+'"></a></li>');
				});
				$tocContainer.append($ul);
				$tocWidget.show();

				if($('body').hasClass('admin-bar')) {
					viewPortOffsetTop = viewPortOffsetTop + 32;
				}

				//TOC set active
				$.fn.isInViewport = function(viewPortOffsetTop) {
					var elementTop = $(this).offset().top;
					var elementBottom = elementTop + $(this).outerHeight();
					var viewportTop = $(window).scrollTop() + viewPortOffsetTop;
					var viewportBottom = viewportTop + $(window).height() - viewPortOffsetTop;
					//console.log($(this).text(), elementTop, elementBottom, viewportTop, viewportBottom);
					return elementBottom > viewportTop && elementTop < viewportBottom;
				};
				function setTocActive($contentWrapper, $tocContainer, viewPortOffsetTop) {
					var $headings = $contentWrapper.find(":header");
					var $visibleHeading = null
					$headings.each(function( index ) {
						var $heading = $(this);
						var isVisible = $heading.isInViewport(viewPortOffsetTop);
						if(isVisible) {
							//set first visible element as active
							$visibleHeading = $heading;
							return false;
						}
					});

					if($visibleHeading) {
						var anchor = $visibleHeading.attr('id');
						$tocContainer.find('a').removeClass('active');
						$tocContainer.find('a[href="#'+anchor+'"]').addClass('active');
					}
				}

				//TOC sticky
				function initStickyPosition($tocWidget, offsetTop) {
					var containerRect = $tocWidget.get(0).getBoundingClientRect();
					$tocWidget.data('offsetTop', offsetTop);
					$tocWidget.data('offsetTopPage', containerRect.top + window.scrollY);
					$tocWidget.data('width', $tocWidget.outerWidth());
				}
				function mimicStickyPosition($tocWidget) {
					var offsetTopPage = $tocWidget.data('offsetTopPage');
					var offsetTop = $tocWidget.data('offsetTop');
					var widgetWidth = $tocWidget.data('width');
					if (offsetTopPage - offsetTop <= window.scrollY) {
					// If so, position the element at the top of the container
						$tocWidget.css({'position': 'fixed', 'top': offsetTop + 'px', 'z-index': 9999, 'width': widgetWidth});
					}
					else {
						$tocWidget.css({'position': 'relative', 'top': 'auto', 'z-index': 1, 'width': 'auto'});
					}
				}

				initStickyPosition($tocWidget, offsetTop);
				$(window).on('resize', function() {
					if(sticky) {
						initStickyPosition($tocWidget, offsetTop);
					}
				});

				$(window).on('scroll', function() {
					setTocActive($contentWrapper, $tocContainer, viewPortOffsetTop);
					if(sticky) {
						mimicStickyPosition($tocWidget);
					}
				});

			}
		}
	});

})( jQuery );
