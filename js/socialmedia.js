/**
 * File socialmedia.js.
 *
 * Handles social media menu for small screens
 */
( function() {
	var social, social_alt,
		maxSize = 1024;

	social = document.getElementById( 'social-media' );
	social_alt = document.getElementById( 'social-media-alt' );
	/*if ( ( ! social ) || ( ! social-alt) ) {
		return;
	}*/
	
	// set initial state based on window size
	if ( window.innerWidth > maxSize ) {
		social_alt.className += ' hidden';
	} else {
		social.className += ' hidden';
	}
	
	// Handle resize events
	window.addEventListener( 'resize', windowResizeListener, false );
	function windowResizeListener( e ) {
		if ( ( window.innerWidth > maxSize ) && ( -1 !== social.className.indexOf( 'hidden' ) ) ) {
			social.className = social.className.replace( ' hidden', '' );
			social_alt.className += ' hidden';
		} else if ( ( window.innerWidth <= maxSize ) && ( -1 === social.className.indexOf( 'hidden' ) ) ) {
			social.className += ' hidden';
			social_alt.className = social_alt.className.replace( ' hidden', '' );
		}
	}
} )();