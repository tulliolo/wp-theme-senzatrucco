(function (window, $) {
	
	var $breakpoint = 55; // ems
	
	/**
	 * Handles toggling the navigation menu for small screens and enables TAB key
	 * navigation support for dropdown menus.
	 */
	$(function() {
		
		var $menuToggle    = $('.menu-toggle'),
			$menuContainer = $menuToggle.parent(),
			$menu          = $menuContainer.find('.menu').first(),
			
			$searchToggle  = $menu.find('.search-toggle').first(),
			$search        = $menu.find('#primary-search').first();
		
		// Hides menu toggle button if menu is empty
		if ( $menu.length === 0 ) {
			$menuToggle.hide();
			return;
		}
		
		/**
		 * Toggles menu on click events
		 */
		$menuToggle.click(function(event) {
			if ($menuContainer.hasClass('toggled')) {
				$menuContainer.removeClass('switch-on');
				$menuContainer.addClass('switch-off');
			} else {
				$menuContainer.removeClass('switch-off');
				$menuContainer.addClass('toggled switch-on');
			}
			
			$menu.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(event) {
				if ($menuContainer.hasClass('switch-off')) {
					$menuContainer.removeClass('switch-off toggled');
					$menuToggle.attr('aria-expanded', false);
					$menu.attr('aria-expanded', false);
				} else {
					$menuContainer.removeClass('switch-on');
					$menuToggle.attr('aria-expanded', true);
					$menu.attr('aria-expanded', true);
				}
			});
		});
		
		/**
		 * Toggles search form on click events
		 */
		$searchToggle.click(function(event) {
			$searchStatus = $searchToggle.attr('aria-expanded') == 'true',
			
			$searchToggle.attr('aria-expanded', ! $searchStatus);
			$search.attr('aria-expanded', ! $searchStatus);
		}); 
		
		/**
		 * Toggles `focus` class when a menu link is focused or blurred.
		 */
		$menu.find('a').on('focus blur', function(event) {
			$(this).parents('li').toggleClass('focus');
		});

		/**
		 * Toggles `focus` class to allow submenu access on touch devices.
		 */
		$('.menu-item-has-children > a, .page_item_has_children > a').on('touchstart', function(event){
			
			var $menuItem = $(this).parent();

			if (! $menuItem.hasClass('focus')) {
				event.preventDefault();
				
				$menuItem.parent().children().removeClass('focus');
				$menuItem.addClass('focus');
			} else {
				$menuItem.removeClass('focus');
			}
		});
		
		/**
		 * Handles resize events
		 */
		$(window).resize(function() {
			var $currWidth = window.innerWidth
					|| document.documentElement.clientWidth
					|| document.body.clientWidth,
				$breakWidth = $breakpoint * parseFloat($('html').css('font-size')); 
				
					
			/*$(".size-test").remove();
			$("body").prepend("<div class='size-test'>"+$currWidth+" - "+$breakWidth+"</div>");*/
			
			if ($currWidth < $breakWidth) {
				$searchToggle.attr('aria-expanded', false);
				$search.attr('aria-expanded', false);
			}			
			else {
				$menuContainer.removeClass('switch-on switch-off toggled');
				$menuToggle.attr('aria-expanded', false);
				$menu.attr('aria-expanded', false);
			}	
		});
	});	

	/**
	 * Handles buttons.
	 */
	$(function() {
		
		/**
		 * Adds a ripple effect on click events
		 */
		$('.ripple').click(function(event) {
			
			var size    = $(this).height(),
				posX	= event.pageX - $(this).offset().left - size/2,
				posY	= event.pageY - $(this).offset().top  - size/2,
				$ripple = $('<div class="pebble" />').appendTo($(this));
			
			$ripple.css({
				width : size+'px',
				height: size+'px',
				top   : posY+'px',
				left  : posX+'px',
				background: $(this).data("ripple-color")
			}).addClass('animate');
				
			$ripple.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(event) {
				$ripple.remove();
			});
		});
	});
	
	/**
	 * Handles Layout.
	 */
	$(function() {
		
		/**
		 * adjust content and footer position   
		 */
		var adjustFooter = function() {
			var posY = $('.site-footer').innerHeight() + ( 1.5 * parseFloat($('html').css('font-size')));
			$('.site-content').css({ 'padding-bottom': posY+'px' });
		};
		
		adjustFooter();
		$(window).resize(function() {
			adjustFooter();
		});
	});
})(window, jQuery);	