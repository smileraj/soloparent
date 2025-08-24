var isIEBrows =navigator.appVersion.indexOf("MSIE") != -1 || navigator.appVersion.indexOf('Trident/') > 0;
var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

/**
 * @function      Include
 * @description   Includes an external scripts to the page
 * @param         {string} scriptUrl
 */
function include(scriptUrl) {
    document.write('<script src="' + scriptUrl + '"></script>');
}


/**
 * @module       Smoothscroll
 * @description  Enables smooth scrolling on the page
 */
;
(function ($) {
    if ($("html").hasClass("smoothscroll")) {
        include('parentsolo/js/js/smoothscroll.min.js');
    }
})(jQuery);


/**
 * @module       RD Parallax 3
 * @description  Enables RD Parallax 3 Plugin
 */
;
(function ($) {
    var o = $('.rd-parallax');
    if (o.length) {
        include('parentsolo/js/js/jquery.rd-parallax.min.js');

        $(document).ready(function () {
            $.RDParallax();
        });
    }
})(jQuery);