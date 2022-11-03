var $ = jQuery.noConflict();

$(document).ready(function(){
    //mobileMenu();
    searchIcon();
    accordionSlide();
    //menuDropDown();
    menuMouseEvent();
    slideHeaderOnScroll();
    
    $('.search').on('click', function(){
        $('.txtBox').focus();
    });
    
    $('.searchCross').on('click', function(){
        $('.txtBox').blur();
        $('.txtBox').val('');
    });
    
    $(".searchIcon").on( "click", function() {
    if($(window).width() < 992){
    $('.search').toggleClass('hide');
    $('.searchCross').toggleClass('show');
    $('.mobileViewHeader').toggleClass('zindexOverlap');
    $('.searchArea').toggleClass('activeMobile');
    $(".searchArea input, .searchInput").toggleClass('widthInput');    
    }
    else
    {  
    $('.search').toggleClass('hide');
    $('.searchCross').toggleClass('show');
    $(".searchArea input, .searchInput").toggleClass('widthInput');        
    }
        
    var $body = $(document.body);
	if ('ontouchstart' in window) {
	  $body.on('touchstart', '.waves-effect', Effect.show);
	  $body.on('touchend', '.waves-effect', Effect.hide);
	  $body.on('touchcancel', '.waves-effect', Effect.hide);
	} else {
	  $body.on('mousedown', '.waves-effect', Effect.show);
	  $body.on('mouseup', '.waves-effect', Effect.hide);
	  $body.on('mouseleave', '.waves-effect', Effect.hide);
	}
});
    
    $('#hamburger').on("click", function(){
		$(this).toggleClass('menuOpen');
		if($(this).hasClass('menuOpen')){
			slideHeaderOnScroll('open');
			$( ".mobMenu" ).animate({
				top: "42px"
			  }, 300, function() {
				// Animation complete.
			});
		}else{
			slideHeaderOnScroll();
			$( ".mobMenu" ).animate({
				top: "-560px"
			  }, 300, function() {
				// Animation complete.
			});
		}
	});
    
    $(document).on("mouseup touchend", function (e){
        var container1 = $(".mobMenu"),
            container2 = $(".mobileViewHeader");

        if (!container1.is(e.target) // if the target of the click isn't the container...
            && container1.has(e.target).length === 0
            && !container2.is(e.target) // if the target of the click isn't the container...
            && container2.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('#hamburger').removeClass('menuOpen');
            slideHeaderOnScroll();
			container1.animate({
				top: "-560px"
			  }, 300, function() {
				// Animation complete.
			});
        }
    });
    
    $('.txtBox').keypress(function(e) {
        if(e.which == 13) {
            var searchText = $(this).val();
            searchText = encodeURIComponent(searchText);
            //searchText = searchText.replace(" ", "-");
            if(searchText != null && searchText != '' && searchText != undefined){
                var hostname = window.location.hostname;
                window.location.href = 'http://'+hostname+'/search/site/'+searchText+'';
            }
        }
    });

    
    /*$('body').on("click", function(){        
        if($('.search').hasClass('hide')){
            $('.search').toggleClass('hide');
            $('.searchCross').toggleClass('show');
            $(".searchArea input").fadeToggle('slow');
        }
    });*/

    if (is_touch_device()) {
      $('#slide-out').css({ overflow: 'auto'})
    }

    var child = jQuery('.page-search-site .masonryContent').children();
    var newArray = [];
    jQuery(child).each (function (index, value) {
        var nid = value.classList[3];
        jQuery(newArray).each (function (ind, val) {
            if(nid == val) {
                jQuery('div.'+nid).eq(1).remove();
                
            }
        });
    newArray[index] = jQuery.makeArray(nid);
    });

    var ua = navigator.userAgent.toLowerCase();

    if (ua.indexOf('macintosh') >= 0) {
        $('body').addClass('ios')
        if (ua.indexOf('version/') >= 0) {
            $('body').addClass('ios-safari');
        }
    }

});

$(window).on("scroll", function(){
	if($('#hamburger').hasClass('menuOpen')){
		$('#hamburger').removeClass('menuOpen');
		//slideHeaderOnScroll();
		$( ".mobMenu" ).animate({
			top: "-560px"
		  }, 300, function() {
			// Animation complete.
		});
	}
});
    
$(window).resize(function(){
    searchIcon();
});

function is_touch_device() {
  try {
  document.createEvent("TouchEvent");
  return true;
  } catch (e) {
  return false;
  }

}

function mobileMenu(){
        $('.button-collapse').sideNav({
        menuWidth: 220, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: false // Closes side-nav on <a> clicks, useful for Angular/Meteor
      });
      
    }

function searchIcon(){
    if(($(window).width() < 992) && ($(".searchArea input, .searchInput").hasClass('widthInput'))){
    $('.mobileViewHeader').addClass('zindexOverlap');
    $('.searchArea').addClass('activeMobile');   
    }else{
		$('.searchArea').removeClass('activeMobile'); 
	}
   
}



function accordionSlide(){
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
}

function menuDropDown(){
    $('.others').dropdown({
          inDuration: 300,
          outDuration: 225,
          constrain_width: true, // Does not change width of dropdown to that of the activator
          hover: true, // Activate on click
          alignment: 'left', // Aligns dropdown to left or right edge (works with constrain_width)
          gutter: 0, // Spacing from edge
          belowOrigin: true // Displays dropdown below the button
        }
      );
}

function menuMouseEvent(){
    $('.others').on('mouseenter', function(){
        $('#dropdown1').show('fast');
    });
    
    $('.others').on('mouseleave', function(){
        $('#dropdown1').hide('fast');
    });
}

function slideHeaderOnScroll(menuState){
	var deviceAgent = navigator.userAgent.toLowerCase();
    var agentID = deviceAgent.match(/(iphone|ipod|ipad)/),
	header = $('.mobileViewHeader'),
    threshold = 0,
    lastScroll = 0,
    headerHeight = header.height() + 30;
	
	if(menuState == 'open'){
		threshold = 0;
		$('.mobMenu').css('position', 'fixed');
	}

	$(window).on('scroll', function (e) {
		
		var newScroll = $(window).scrollTop(),
			diff = newScroll-lastScroll;		
			if(menuState == 'open'){
				threshold = 0;
				$('.mobMenu').css('position', 'fixed');
			}else{
				$('.mobMenu').css('position', 'absolute');
				threshold = (threshold+diff>headerHeight) ? headerHeight : threshold+diff;
				threshold = (threshold < 0) ? 0 : threshold;
			}
			if (agentID) {
				header.css('top', '0');
			}else{
				header.css('top', (-threshold)+'px');
			}
			lastScroll = newScroll;	
	});
}