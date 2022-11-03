function socialIcons(type,socialURL,socialText,socialImage){
	switch(type){
        case 'facebook':
            url = 'http://www.facebook.com/sharer.php?u='+ socialURL;
            break;
        case 'twitter':
            url = 'http://twitter.com/share?url='+ socialURL + '&text=' + socialText;
            break;
        case 'gplus':
            url = 'https://plusone.google.com/_/+1/confirm?hl=en&url=' + socialURL;
            break;
        case 'pinterest':
            url = 'http://pinterest.com/pin/create/button/?url=' + socialURL + '&media=' + socialImage + '&description=' + socialText ;
            break;
    }
    /*Finally fire the Pop-up*/    
    window.open(url,"","left=500,top=200,height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
}

function slideToComment(){
	$('html,body').animate({ scrollTop:$('#comments').offset().top-75},1000);
}

var md = new MobileDetect(window.navigator.userAgent);

$(document).ready(function(){
	/*$('.socialShare').on('click', function(){
		//$(this).siblings('.postButton').toggle(1000);
		
		//$(this).toggleClass('active');
		
		/*if(active === false){
			$(this).addClass('active');
			active = true;
		}else if(active === true){
			$(this).removeClass('active');
			active = false;
		}

	});*/
	
	if(md.mobile() || md.tablet()){
		$('.socialShare').on('click', function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}
		});
	}else{
        $('.socialShare').on('mouseenter', function(){
            $(this).addClass('active');
        });

        $('.socialShare').on('mouseleave', function(){
            $(this).removeClass('active');
        });
	}
	
	/*$('.socialShare').on('mouseenter', function(){
		//$(this).siblings('.postButton').fadeIn(1000);
		$(this).addClass('active');
	});

	$('.socialShare').on('mouseleave', function(){
		//$(this).siblings('.postButton').fadeOut(1000);
		$(this).removeClass('active');
	});*/
});