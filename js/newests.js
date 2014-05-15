jQuery.noConflict();
jQuery(document).ready(function() {
    jQuery('.item').css( "opacity", 0.6 );

    jQuery('.item').on('mouseenter', function(){
        jQuery(this).animate({opacity: 1, top: "+=10px"}, 600);

    });
    jQuery('.item').on('mouseleave', function(){
        jQuery(this).animate({opacity: 0.6, top: "-=10px"}, 600);

    });

    console.log(jQuery('.item')[0]);
});



