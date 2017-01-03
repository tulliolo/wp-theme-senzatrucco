(function($) {
    $(window).load(function() {
		$('.flexslider').removeData("flexslider");
        $('.flexslider').flexslider({
	        animation: 'fade',
		    controlsContainer: '.flex-container',
			prevText: '',
			nextText: '',
	    });
    });
})(jQuery)