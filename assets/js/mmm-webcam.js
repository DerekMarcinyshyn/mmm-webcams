/*
    MMM Webcams
    @author     Derek Marcinyshyn <derek@marcinyshyn.com>
    @since      October 21, 2012
    */
jQuery.noConflict();

jQuery(document).ready( function () {
    // Open webcam image into lightbox
    jQuery("a.fancybox").fancybox({
        openEffect      : 'elastic',
        closeEffect     : 'elastic'
    });

    // Animation
    TweenMax.to( jQuery("h3.webcams"), 0, {css: { alpha: 0, marginLeft:600 } } );
    TweenMax.to( jQuery("h3.webcams"), 0.7, {css: { alpha: 1, marginLeft:0 }, ease: Bounce.easeOut } );
    TweenMax.to( jQuery(".mmm-webcam"), 0, {css: { marginTop:"-600px", rotation:181, alpha:0 } } );
    TweenMax.to( jQuery(".mmm-webcam"), 0.4, {css: { marginTop:"0", rotation:0, alpha:1 }, delay: 0.7, ease: Sine.easeOut } );
});