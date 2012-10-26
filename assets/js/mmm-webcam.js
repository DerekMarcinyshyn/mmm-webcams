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
});