function sticky(){
	var initSocialTop = parseInt($('#rhsHeader').offset().top);
	
	$( window ).on('scroll', function() {

		var siderWidth = $('.popularSection').width();

		var sidebarpos = parseInt($(window).scrollTop()),windowhght = parseInt($(window).height());

		var sidebarleft = parseInt($(".popularSection").offset().left), 

		sidebarHght=parseInt($(".popularSection").outerHeight()),

		sidebartop=parseInt($(".articleContent").offset().top),

		otherSeriesTop=parseInt($("#bottomSection").offset().top),
			
		socialTop = parseInt($('#rhsHeader').offset().top),
			
		socialHght=parseInt($("#rhsHeader").outerHeight()),
			
		socialWidth = $('#rhsHeader').width(),
			
		socialleft = parseInt($("#rhsHeader").offset().left),

		bodyhght = parseInt($("body").height());
		
		//console.log("Sidebar top is: " + sidebartop);

		if(sidebarHght > 500){
			if ((sidebarpos > (sidebarHght + sidebartop) - windowhght)) {
				if($(window).width()>991){
					$(".popularSection").css({
						"position":"fixed",
						"left":sidebarleft,
						"width": siderWidth + 'px',
						"top":-(sidebarHght-windowhght+20)
					});
				}
			}else {
				$(".popularSection").css({
					"position":"relative",
					"left":0,
					"top":0
				});
			}
		}else{
			if ((sidebarpos > (sidebarHght + sidebartop) - 50)) {
				if($(window).width()>991){
					$(".popularSection").css({
						"position":"fixed",
						"left":socialleft,
						"width": siderWidth + 'px',
						"top":-(sidebarHght-sidebarHght)
					});
				}
			}else {
				$(".popularSection").css({
					"position":"relative",
					"left":0,
					"top":0
				});
			}
		}
		
		//console.log("Scroll pos: " + sidebarpos);
		//console.log("Social pos: " + (socialTop));
		 //var isIE = /@cc_on!@/ false || !!document.documentMode;
		
		 var ua = window.navigator.userAgent;
		 var msie = ua.indexOf("MSIE ");

	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
		 {
				socialWidth= '240';
			} else {
				socialWidth = socialWidth;
			}
		
		if ((sidebarpos >= socialTop && socialTop >= initSocialTop)) {
			if($(window).width()>991){
			   
				
				$('#rhsHeader').css({
					"position":"fixed",
					"left":socialleft,
					"width": socialWidth + 'px',
					"top":0
				});
			}
		}else{
			$('#rhsHeader').css({
				"position":"relative",
				"left":0,
				"top":0
			});
		}
	});
}

$(document).ready(function(){
	$('.addIconsBtn').on('click',function(){
		$('.socialHidden').fadeIn();
	});

	$('.closeIconBtn').on('click',function(){
		$('.socialHidden').fadeOut();
	});

	sticky();  
		 
	 $('.containerwrap iframe').each(function(e){
         //$(this).parent().addClass('video-container');
         var source = $(this).attr('src');
         if(source.indexOf('youtube.com') != -1){
           $(this).wrap( "<div class='video-container'></div>" );
		   $(this).parents('.video-container').after('<div class="blackStrip articleStrip"><span>Subscribe to 101India</span><span class="subBtn"><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></span></div>');
			}
       });
});

$(window).on("resize", sticky);