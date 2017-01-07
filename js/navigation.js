/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, menuButton, searchButton, menu, search, searchForm, links, subMenus, i, len,
		maxSize = 1024,
		pfx = ["webkit", "moz", "ms", "o", ""];

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}
	
	menuButton = container.getElementsByClassName( 'menu-toggle' )[0];
	if ( 'undefined' === typeof menuButton ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle menuButton if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		menuButton.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}
	
	// search form
	searchButton = container.getElementsByClassName( 'search-toggle' )[0];
	search = document.getElementById( 'primary-search' );
	searchForm = search.getElementsByClassName( 'search-form' )[0];
	
	/**
	 * Register event listeners
	 */
	// Register window listeners
	window.addEventListener( 'resize', windowResizeListener, false );
	// Register prefixed menu event listeners
	registerPrefixedEvent( menu, 'AnimationEnd', menuAnimationListener );
	// Register menuButton event listeners
	menuButton.addEventListener( 'click', menuButtonClickListener, false );
	// Register searchButton event listeners
	searchButton.addEventListener( 'click', searchButtonClickListener, false );
	// Register searchForm event listeners
	searchForm.addEventListener( 'submit', searchButtonClickListener, false );
	
	/**
	 * Handle events
	 */
	// Handle window events
	function windowResizeListener( e ) {
		if ( ( window.innerWidth > maxSize ) && ( -1 !== container.className.indexOf( 'toggled' ) ) ) {
			container.className = container.className.replace( ' toggled', '' );
			menuButton.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else if ( ( window.innerWidth <= maxSize ) && ( -1 !== search.className.indexOf( 'toggled' ) ) ) {
			search.className = search.className.replace( ' toggled', '' );
			search.setAttribute( 'aria-expanded', 'false' );
			searchButton.setAttribute( 'aria-expanded', 'false' );
		}	
	}	
	// Handle menu events
	function menuAnimationListener( e ) {
		if ( -1 !== container.className.indexOf( ' enabled' ) ) {
			container.className = container.className.replace( ' enabled', '' );	
		} else if ( -1 !== container.className.indexOf( ' disabled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			container.className = container.className.replace( ' disabled', '' );
		}
	}
	// Handle menuButton events
	function menuButtonClickListener( e ) {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', ' toggled disabled' );
			menuButton.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled enabled';
			menuButton.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	}	
	
	// Handle searchButton events
	function searchButtonClickListener( e ) {
		if ( -1 !== search.className.indexOf( 'toggled' ) ) {
			search.className = search.className.replace(' toggled', '');
			search.setAttribute( 'aria-expanded', 'false' );
			searchButton.setAttribute( 'aria-expanded', 'false' );
		} else {
			search.className += ' toggled';
			search.setAttribute( 'aria-expanded', 'true' );
			searchButton.setAttribute( 'aria-expanded', 'true' );
		}
	}	

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}
	
	/**
	 * Register prefixed event handlers
	 */
	function registerPrefixedEvent( element, type, callback ) {
		for (var i = 0; i < pfx.length; i++) {
			if ( ! pfx[i] ) type = type.toLowerCase();
			element.addEventListener( pfx[i] + type, callback, false );
		}
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();
