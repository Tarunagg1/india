<?php
/**
 * @file
 * Adaptivetheme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Adaptivetheme Variables:
 * - $html_attributes: structure attributes, includes the lang and dir attributes
 *   by default, use $vars['html_attributes_array'] to add attributes in preprcess
 * - $polyfills: prints IE conditional polyfill scripts enabled via theme
 *   settings.
 * - $skip_link_target: prints an ID for the skip navigation target, set in
 *   theme settings.
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 *
 * Available Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * Notes:
 * - Skip link "nocontent" class is for exluding the element from inclusion in
 *   a Google Custom Search index - http://www.google.com/cse
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 * @see adaptivetheme_preprocess_html()
 * @see adaptivetheme_process_html()
 */
/* To get the node ids of all the content in
    the Basic Page content type(Static Pages
    like About Us, Contact Us etc) */

if(!$logged_in){
   if(!isset($_SESSION['start_session'])){
       drupal_session_start();

       $_SESSION['start_session'] = 'Session started';
   }
}

$base_url = 'https://www.101india.com';	
	
$nidsStaticPagesArr = get_static_node_html_tpl();

$currNid = arg(1); // Get the node id of currently viewed page
$currPage = arg(0);

$staticPageClass = ''; // To add a class for static pages

if(in_array($currNid, $nidsStaticPagesArr) && ($currPage != 'user')){
    $staticPageClass = ' staticPage';
}else{
    $staticPageClass = '';
}

//echo '<pre style="display: none">';print_r($nidsStaticPagesArr);print_r($currNid);print_r($currPage);echo '</pre>';
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9"<?php print $html_attributes; ?>><![endif]-->
<!--[if gt IE 8]><!--><html<?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->
<head>
<?php print $head; ?>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php /* head title for the homepage is reset somewhere that couldn't be found, hence overriding it */ ?>
<title><?php $is_front ? print "101India - Unique Stories From India" : print $head_title; ?></title>
<?php print $styles; ?>
<?php print $scripts; ?>
<?php print $polyfills; ?>

<!--[if lt IE 9]> <script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '485063075030172');
fbq('track', "PageView");
fbq('track', 'ViewContent');

</script>
<noscript><img alt="" height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=485063075030172&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


    <!--OneSignal Implementation BY Mahbubeh Pardis 30th March 2016-->

<link rel="manifest" href="https://www.101india.com/manifest.json">
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
<script>
    var OneSignal = OneSignal || [];
    OneSignal.LOGGING = true;
	var notify;

	OneSignal.push(function() {
        // If we're on an unsupported browser, do nothing
        if (!OneSignal.isPushNotificationsSupported()) {
            return;
        }
        OneSignal.isPushNotificationsEnabled(function (isEnabled) {
            if (isEnabled) {
                document.getElementById("onesignal-bell-container").style.display = "none";
				document.getElementById("onesignal-bell-container").style.visibility = "hidden";
            } else {
                //nothing to do
            }
        });
    });



    OneSignal.push(["init", {
      appId: "bcfda9a7-06af-49b4-85fa-b077b4e15515",
      autoRegister: true,
	  notifyButton: {
		enable: true ,
		size: 'small',
		position: 'bottom-right'
       },
	  showCredit: false,  // Hide the OneSignal logo
safari_web_id: 'web.onesignal.auto.66c7fbb6-f0f6-47ab-9f8e-1bd725d1f3d2',
persistNotification: false // Automatically dismiss the notification after ~20 seconds in Chrome Deskop v47+

    }]);

	OneSignal.push(["getUserId", function(userId) {
    console.log("OneSignal User ID:", userId);
    // (Output) OneSignal User ID: 270a35cd-4dda-4b3f-b04e-41d7463a2316
}]);
$(document).ready(function(){
	if (navigator.userAgent.indexOf('Mac OS X') != -1) {
  $("body").addClass("mac");
	} else {
	  $("body").addClass("pc");
	}
});
</script>



<!--End: OneSignal Implementation BY Mahbubeh Pardis 30th March 2016-->

<!-- Google Tag Manager -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-54469768-1', 'auto');
    ga('require','displayfeatures');
    ga('require', 'linkid');
    ga('send', 'pageview');

</script>
<!-- End Google Tag Manager -->
<script type="text/javascript">
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}
$(document).ready(function(){
    $('#email_id_mobile').keypress(function(e){
      if(e.keyCode==13){
          submitSubscriptionmobile();
      }else{
          $('#errorMessage').hide();
      }
    });
	$('#close_pop').click(function(){
		//console.log('close pop');
		setCookie("youtube_sub_pop", "close_youtube_sub_pop", 1);
		
		$( ".popContainer" ).animate({
			top: "-100%"
		  }, 900, function() {
			// Animation complete.
			$("#subscribe_pop").hide();
			$("#youtube_subscribe").hide();
			$('.overlay').hide();
			/*setTimeout(function() {
				$('.overlay').hide();
			}, 3000);*/
			
		  });
	});
	var closepopsummer=getCookie("youtube_sub_pop");
	
    if(closepopsummer =="close_youtube_sub_pop"){
		
          $("#subscribe_pop").hide();
		 // $('.overlay').hide();
    }
    $('#email_id_mobile').on("focus", function(){
        $('#errorMessage').hide();
    });
	
	if(closepopsummer != "close_youtube_sub_pop" ){
	   $.ajax({
		   type:'POST',
		   url:'<?php echo $base_url;?>/getMinutes',
		   success:function(data){
				   data = jQuery.parseJSON(data);
				   console.log('data',data);
				   var seconds = 0;
				   if(data.seconds!=""){
						   seconds = data.seconds;
				   }
				   countdown(seconds);
				   
		   }
	   });
	}
});

function countdown(seconds)
{
   var element, endTime, hours, mins, msLeft, time;

   function updateTimer()
   {
       msLeft = endTime - 1;
	   //console.log('msLeft',msLeft);
       if ( msLeft < 1 ) {
           //console.log('show popup here');
		   /*$(".overlay").show();*/
       console.log('vikee');
		   $('#subscribe_pop').hide();
		   $("#youtube_subscribe").fadeIn();
		   $( ".popContainer" ).animate({
			top: "6em"
		  }, 2000, function() {
			// Animation complete.
			//var ytContainer = 'dynamic_yt_sub';
			//gapi.ytsubscribe.go(ytContainer);
		  });
		   $.ajax({
			   type:'POST',
			   url:'<?php echo $base_url;?>/destroyEndsession',
			   success:function(data){
					   //data = jQuery.parseJSON(data);
					   //console.log('data',data);
					  /* var seconds = 0;
					   if(data.seconds!=""){
							   seconds = data.seconds;
					   }*/
					   //countdown(seconds);
					   
			   }
		   });
           //scrollToPopCont();
       } else {
           endTime = msLeft;
           setTimeout( updateTimer, 1000 );
       }
   }
   endTime = seconds;
   //console.log('endTime',endTime);
   updateTimer();
}

function submitSubscriptionmobile(){
    $("#thankYouText_mobile").hide();
    $("#errorMessage").hide();

    var email = $('#email_id_mobile').val();
    if(validateEmail(email)){

        $(".subscribeBtn").hide();
        $(".loader").fadeIn();

        $.ajax({
                type:'POST',
                url: Drupal.settings.basePath + 'submit-subscriptions',
                data:'email='+email,
                success:function(data){

                    if($.trim(data)=="Failure"){
                        $(".errMsg").show();
                        $(".errMsg").html("Invalid e-mail address");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else if($.trim(data)=="Already Exist"){
                        $(".errMsg").show();
                        $(".errMsg").html("This e-mail id is already registered with us.");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else if($.trim(data)=="Database error occured"){
                        $(".errMsg").show();
                        $(".errMsg").html("Database error occured");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else{
						$('#subscribe_pop').hide();
                        $('#email_id_mobile').val("");
                        $("#subForm").fadeOut();
                        $("#thankYouText_mobile").show();
						$( ".popContainer" ).animate({
								top: "6em"
							  }, 900, function() {
								// Animation complete.
							  });
                        $("#email_id_mobile").hide();
                        $(".loader").hide();
                        setTimeout(function() {
                            
							$( ".popContainer" ).animate({
								top: "-100%"
							  }, 900, function() {
								// Animation complete.
								$('#thankYouText_mobile').hide();
								$(".errMsg").hide();
								$('.overlay').hide();
								/*setTimeout(function() {
									$('.overlay').hide();
								}, 3000);*/
								
							  });
							
                        }, 9000);
                    }

                }
        });
    }else{
        $(".errMsg").show();
        $(".errMsg").html("Invalid e-mail address");
    }
}

function validateEmail(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}

</script>


</head>
<body class="<?php print $classes . $staticPageClass; ?>"<?php print $attributes; ?>>
<div class="overlay" style="display:none">
<!--<div style="position: absolute; width:100%; height:100%;" onclick="location.href='/horror'"></div>
<div class="popContainer">
	<div class="popup" >
		<div align="right" style="top:20px; position:relative; left:10px;"><a href="javascript:;" id="close_pop"><img src="https://www.101india.com/sites/all/themes/new_101_india_theme/images/close_popup_black.png" border="0"></a></div>
		<div class="">
			<a href="/horror"><img src="https://www.101india.com/sites/all/themes/new_101_india_theme/images/horroranimation4.gif" border="0" width="400"></a>
		</div>
	</div>
</div>
-->
<div class="popContainer">
	<div class="popup" >
		<a class="close" href="javascript:;" id="close_pop"></a>
			
		<!--<div class="popCont" id="youtube_subscribe">
			<h2>Love our stories? <span class="smaller">Follow us on Youtube</span></h2>
			<table>
				<tr>
					<td>
			<div href="javascript:;" class="popSubs">
			
								<div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div>
			</div>
			</td>
				</tr>
			</table>
			<span class="mobYt">Sign in to subscribe</span> 

		</div>-->
		<div class="popCont" style="display:none;" id="subscribe_pop">
			<h3>Don't miss a single story. Subscribe now.</h3>
			<div class="subscribeInfo"> 
				<input type="text" id="email_id_mobile" placeholder="Enter your Email ID" maxlength="100">
				<div class="loader" style="display:none;"></div> 
				<a href="javascript:;" onclick="submitSubscriptionmobile()" class="subscribeBtn">Subscribe</a>
				<div class="clear"></div>
				<span class="errMsg" id="errorMessage">Error</span> 
			</div>
			<div class="clear"></div>
		</div>
		<div style="display:none;" class="thankYouText" id="thankYouText_mobile">
			Thank you for subscribing. You were successfully added to the newsletter recipients.
		</div>
	</div>
</div>

</div>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MC69DH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MC69DH');</script>
<!-- End Google Tag Manager -->

  <div id="skip-link" class="nocontent">
    <a href="<?php print $skip_link_target; ?>" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

  <?php /******** Script for active menu on detail pages STARTS ********/
    $argArr = arg();
    if($argArr[0] == 'node' && count($argArr) == 2){
        $pathAlias = drupal_get_path_alias();
        $pathAliasArr = explode('/', $pathAlias);
        $currCat = str_replace('101-', '', $pathAliasArr[0]);
        $currCat = str_replace('-', '', $currCat);

        if($currCat == 'janta'){
            $currCat = 'people';
        }

        //echo '<pre style="display: none">';print_r($currCat);echo '</pre>';

        echo '<script type="text/javascript">
                $(document).ready(function(){
                    //$("#slide-out li").each(function(e){
                    $(".side-nav.deskMenu li").each(function(e){
                        var currClass = $(this).attr("class");
                        if(currClass.toLowerCase().indexOf("'.$currCat.'") != -1){
                            $(this).find(".menuLink").addClass("active");
                        }
                    });
                });
            </script>
        ';
    }
  /******** Script for active menu on detail pages ENDS ********/ ?>
    
  <script type="text/javascript">
      $(window).load(function(){
          $('ul.tabs').off();
      });
  </script>
	
  <!-- Facebook -->
  <script src="//connect.facebook.net/en_US/all.js"></script>
  <div id="fb-root"></div>
  <script>
	FB.init({
		appId : '381395515353450',
		status : true, // check login status
		cookie : false, // enable cookies to allow the server to access the session
		xfbml : true, // parse XFBML
		//channelURL : '', // channel.html file
		oauth : true // enable OAuth 2.0
	});
	/*if (navigator.appName == 'Microsoft Internet Explorer') {
		FB.UIServer.setLoadedNode = function (a, b){FB.UIServer._loadedNodes[a.id] = b; } // IE hack to correct FB bug
	}*/
  </script>
  <!-- gplus js -->
  <script type="text/javascript" src="//apis.google.com/js/plusone.js"></script>
  <!-- twiiter js -->
  <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
  <!-- youtube subscribe button js -->
  <script src="//apis.google.com/js/platform.js"></script>

</body>
</html>
