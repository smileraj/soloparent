/**
 * @module       ScrollTo
 * @license      MIT License
 * @version      1.0.0
 */
!function(o){o.fn.scrollTo=function(e){function n(e){if(e.preventDefault(),a.hasClass("toTop"))return o("html, body").stop().animate({scrollTop:0},s.scrollSpeed),o(a).removeClass("toTop"),!1;for(var n=0;n<r.length;n++)if(window.scrollY<r[n].offsetTop+r[n].offsetHeight){var t=r[n+1].offsetTop;return t>o(document).height()-window.innerHeight&&!a.hasClass("toTop")&&a.addClass("toTop"),void 0===r[n+2]&&a.addClass("toTop"),o("html, body").stop().animate({scrollTop:t},s.scrollSpeed,function(){void 0===r[n+2]&&a.addClass("toTop")}),!1}return!1}var t={containerID:"scrollTo",containerHoverID:"scrollTopHover",scrollSpeed:1200,easingType:"linear"},s=o.extend(t,e),l=o(window),r=this;o("body").append('<a href="#" id="'+s.containerID+'" class="'+s.containerClass+'"></a>');var a=o("#"+s.containerID);a.hide().on("click",n),l.on("scroll",function(e){window.scrollY>window.innerHeight?o(a).fadeIn():o(a).fadeOut(),window.scrollY>r[r.length-1].offsetTop-1?a.addClass("toTop"):a.removeClass("toTop"),window.scrollY===o(document).height()-window.innerHeight&&a.addClass("toTop")})}}(jQuery);
