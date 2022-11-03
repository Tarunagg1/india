<?php
global $base_url; //for base url accesiable everywhere
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
?><!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9"<?php print $html_attributes; ?>><![endif]-->
<!--[if gt IE 8]><!--><html<?php print $html_attributes . $rdf_namespaces; ?> itemscope="" itemtype="http://schema.org/WebPage"><!--<![endif]-->
<head>

<?php if(drupal_is_front_page()){ ?>
	<title>101 India | Home</title>
<?php }else{ ?>
	<title><?php print $head_title; ?></title>
<?php } ?>

<?php print $head; ?>
<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable = no">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<?php print $styles; ?>
<?php print $scripts; ?>
<?php print $polyfills; ?>

<!--[if lt IE 9]> <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

<!-- Facebook Conversion Code for Facebook 101 India -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6019776961726', {'value':'0.00','currency':'INR'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6019776961726&amp;cd[value]=0.00&amp;cd[currency]=INR&amp;noscript=1" /></noscript>





</head>
<body class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div id="skip-link" class="nocontent">
    <a href="<?php print $skip_link_target; ?>" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  
  <!-- Facebook -->
  <script src="https://connect.facebook.net/en_US/all.js"></script>
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
	if (navigator.appName == 'Microsoft Internet Explorer') {
		FB.UIServer.setLoadedNode = function (a, b){FB.UIServer._loadedNodes[a.id] = b; } // IE hack to correct FB bug
	}
  </script>
  <!-- gplus js -->
  <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
  <!-- twiiter js -->
  <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  
  <script type="text/javascript">
  	$('body').fitVids();
  </script>
  
    <!-- Google Tag Manager -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54469768-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
<!-- End Google Tag Manager -->
    
</body>
</html>
