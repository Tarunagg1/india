var $ = jQuery.noConflict();

function scollmenu(){
	var settings = {
		autoReinitialise: true,
		hideFocus: true,
		contentWidth: '0px'
	};
	var pane = $('.menuoptions');
	pane.jScrollPane(settings);
	var contentPane = pane.data('jsp').getContentPane();
}
    
function openMenu(){
    $('.mainContent').addClass('slideContent');
    $('.fixedPanel').addClass('slideContent');
    $('.menu').addClass('expandedMenu');
    $('.page').addClass('openMenu');
    scollmenu();
}

function closeMenu(){
    $('.mainContent').removeClass('slideContent');
    $('.fixedPanel').removeClass('slideContent');
    $('.menu').removeClass('expandedMenu');
    $('.page').removeClass('openMenu');
}

$(document).ready(function() {
    $('.menuOption6').on('click',  function(){
        if ($(this).hasClass('active')){
        //close menu
         $(this).removeClass('active');
         closeMenu();
         $('.menu-toggle').fadeOut().removeClass('active');

        }else{
        //open menu
          $(this).addClass('active');
          openMenu();
          $('.menu-toggle').fadeIn(1000).addClass('active');
        }

    });

    $('.menu-toggle').on('click',  function(){
        $('.menu-toggle').fadeOut(1000);
        if ($(this).hasClass('active')){
        //close menu
         $(this).removeClass('active');
         closeMenu();
         $('.menuOption6').fadeIn(1000).removeClass('active');
        }else{
        //open menu

          $(this).addClass('active');
          openMenu(); 
          //$('.menuOption6').fadeIn(1000).addClass('active');
        }

    });
	//scollmenu();
});

var supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

if (window.addEventListener) {
    window.addEventListener(orientationEvent, function() {
       scollmenu();
    }, false);
}
else {
    window.attachEvent("on"+orientationEvent, function() {
       scollmenu();
    });
}