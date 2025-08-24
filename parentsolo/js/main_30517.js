//Use Strict Mode
(function($) {

    $('.loading-wrapper').css({
        'visibility': 'visible'
    }).animate({
        opacity: '1'
    }, 600);

    //Begin - Window Load
    $(window).on("load", function() {

        //loader and Intro Animations
        $('#page-loader').delay(1000).fadeOut(400, function() {});

        // Calling functions here
        adjustViewport();
        AdjustingBannerSpacing();

    });

    //End - Use Strict mode
})(jQuery);