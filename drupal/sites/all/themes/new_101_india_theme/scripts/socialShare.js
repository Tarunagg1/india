function socialIcons(type,socialURL,socialText,socialImage,socialDescription){
	switch(type){
        case 'facebook':
            url = 'http://www.facebook.com/sharer.php?u='+ socialURL;
            break;
        case 'twitter':
            url = 'http://twitter.com/share?url='+ socialURL + '&text=' + socialText + ' via @101india';
            break;
        case 'gplus':
            url = 'https://plusone.google.com/_/+1/confirm?hl=en&url=' + socialURL;
            break;
        case 'pinterest':
            url = 'http://pinterest.com/pin/create/button/?url=' + socialURL + '&media=' + socialImage + '&description=' + socialText ;
            break;
		case 'reddit':
            url = 'http://www.reddit.com/submit?url=' + socialURL + '&title=' + socialText;
            break;
		case 'delicious':
            url = 'https://delicious.com/post?url=' + socialURL;
            break;
		case 'linkedin':
            url = 'https://www.linkedin.com/shareArticle?mini=true&url=' + socialURL;
            //url = 'https://www.linkedin.com/cws/share?url=' + socialURL;
            break;
		case 'tumblr':
            url = 'http://www.tumblr.com/share/link?url='+ socialURL +'&name='+ socialText +'&description='+ socialDescription;
            break;
		case 'buffer':
            url = 'http://bufferapp.com/add?text='+ socialText +'&url='+ socialURL;
            break;
		case 'digg':
            url = 'http://digg.com/submit?url='+ socialURL +'&title='+ socialText;
            break;
		case 'instapaper':
            url = 'http://www.instapaper.com/api/authenticate';
            //url = 'http://www.instapaper.com/api/add?username=prathamesh.tambe@experiencecommerce.com&password=9969419758&url='+ socialURL +'&title=&selection=&redirect=close';
            //url = 'http://www.instapaper.com/api/add?url='+ socialURL;
            break;
    }
    /*Finally fire the Pop-up*/    
    window.open(url,"","left=500,top=200,height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
}

function scrollComment(className){
    $('html, body').animate({
        scrollTop: $("."+className).offset().top
    }, 2000);
}

/*	
	var OAuth = require('oauth').OAuth;
	//var consumerKey    = 'chill';
	//var consumerSecret = 'duck';
	
	var consumerKey    = '0eefdbe7570845048c23f4cbf7760686';
	var consumerSecret = '620f8a3840d141cda4880a0071e10bae';

	var oa = new OAuth(
		null,
		'https://www.instapaper.com/api/1/oauth/access_token',
		consumerKey,
		consumerSecret,
		'1.0',
		null,
		'HMAC-SHA1'
	);

	var x_auth_params = {
		'x_auth_mode': 'client_auth',
		'x_auth_password': 'yourpass',
		'x_auth_username': 'yourusername@whatever.com'
	};
	
	oa.getOAuthAccessToken(null, null, null, x_auth_params, function (err, token, tokenSecret, results) {
	
		// CAN HAZ TOKENS!
		console.log(token);
		console.log(tokenSecret);
	
		// ZOMG DATA!!!
		oa.get("https://www.instapaper.com/api/1/bookmarks/list", token, tokenSecret,  function (err, data, response) {
	
			console.log(data);
	
		});
	
	});
*/

	function insta(){
		url = "https://www.instapaper.com/api/1.1/oauth/access_token";
		$.ajax({
			type: 'GET',
			url: url,
			dataType: 'jsonp',
			statusCode: {
				200: function( data ) {
					alert("yay");
				},	
				201: function( data ) {
			
				}
			},
			error: function(status) {
				alert("oh noes");
			}
		});
	}


function slideToComment(){
	$('html,body').animate({ scrollTop:$('#comments').offset().top-75},1000);
}

/*var md = new MobileDetect(window.navigator.userAgent);

$(document).ready(function(){
	
	if(md.mobile() || md.tablet()){
		$('.socialShare').on('click', function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}
		});
	}else{
		$('.socialShare').hover(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}
		});
	}
});*/