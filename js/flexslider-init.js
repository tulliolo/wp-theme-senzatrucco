(function($) {
    $(window).on('load', function() {
		$('.flexslider').removeData("flexslider");
        $('.flexslider').flexslider({
	        animation: 'fade',
		    controlsContainer: '.flex-container',
			controlNav: false,
			prevText: '',
			nextText: '',
	    });
    });
})(jQuery)