<?php
/**
 * This block is for Custom Menu for the site
 * 
 * @file
 * Adativetheme implementation to display a block.
 *
 * The block template in Adaptivetheme is a little different to most other themes.
 * Instead of hard coding its markup Adaptivetheme generates most of it in
 * adaptivetheme_process_block(), conditionally printing outer and inner wrappers.
 *
 * This allows the core theme to have just one template instead of five.
 *
 * You can override this in your sub-theme with a normal block suggestion and use
 * a standard block template if you prefer, or use your own themeName_process_block()
 * function to control the markup. For example a typical navigation tempate might look
 * like this:
 *
 * @code
 * <nav id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
 *   <div class="block-inner clearfix">
 *     <?php print render($title_prefix); ?>
 *     <?php if ($block->subject): ?>
 *       <h2<?php print $title_attributes; ?>><?php print $block->subject; ?></h2>
 *     <?php endif; ?>
 *     <?php print render($title_suffix); ?>
 *     <div<?php print $content_attributes; ?>>
 *       <?php print $content ?>
 *     </div>
 *   </div>
 * </nav>
 * @endcode
 *
 * Adativetheme supplied variables:
 * - $outer_prefix: Holds a conditional element such as nav, section or div and
 *                  includes the block id, classes and attributes.
 * - $outer_suffix: Closing element.
 * - $inner_prefix: Inner div with .block-inner and .clearfix classes.
 * - $inner_suffix: Closing div.
 * - $title: Holds the block->subject.
 * - $content_processed: Pre-wrapped in div and attributes, but for some
 *   blocks these are stripped away, e.g. menu bar and main content.
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.  
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 * @see adaptivetheme_preprocess_block()
 * @see adaptivetheme_process_block()
 */
 global $user;
 global $base_url;

$currentPath = drupal_get_path_alias();
$currentPath = explode('/', $currentPath);
$currentPath = $currentPath[0];
//echo '<pre style="display: none;">' . $currentPath . '</pre>';

 $theme_url = drupal_get_path('theme', 'new_101_india_theme');
 $image_url = $base_url . '/' . $theme_url . '/images/';

 $vocabulary = taxonomy_vocabulary_machine_name_load('article_categories');
 $terms = entity_load('taxonomy_term', FALSE, array('vid' => $vocabulary->vid));
 $termsList = array();
 $i = 0;

 foreach($terms as $tKey=>$term){
     if(!strstr($term->name, '101')){
         $termsList[$i]['name'] = $term->name;
         $termsList[$i]['link'] = drupal_get_path_alias('taxonomy/term/' . $term->tid);
         $i++;
     }
 }
 
 $fid = theme_get_setting('mobile_logo');
 $mobilelogo_url = file_create_url(file_load($fid)->uri);

 $overlay_fid = theme_get_setting('mobile_overlay_logo');
 $mobilelogo_overlay_url = file_create_url(file_load($overlay_fid)->uri);
 
 $mobilebg = theme_get_setting('mobilebg');
 
 $mobilebg_over = theme_get_setting('mobilebg_over');
 
?>
<header>
	<!--<div class="overlay" style="display:none;" id="youtube_subscribe">
      	<div class="popContainer">
        	<div class="popup">
            	<a class="close" href="javascript:;"></a>
            	<div class="popCont" >
            		<h2>Love our stories? Follow us on Youtube</h2>
                	<div href="javascript:;" class="popSubs"><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></div>
                </div>
                <div style="display:none;" class="thankYouText">
                	Thanks
                </div>
            </div>
        </div>
    </div>
	<div class="overlay" id="subscribe_pop" style="display:none;">
      	<div class="popContainer" >
        	<div class="popup" >
            	<a class="close" href="javascript:;"></a>
            	<div class="popCont">
            		<h3>Subscribe to our newsletter</h3>
            		<div class="subscribeInfo"> 
                        <input type="text" id="email_id" placeholder="Enter your email id" maxlength="100">
                        <div class="loader" style="display:none;"></div> 
                        <a href="javascript:;" onclick="submitSubscription()" class="subscribeBtn">Subscribe</a>
                        <div class="clear"></div>
                        <span class="errMsg" id="errorMessage">Error</span> 
                	</div>
                    <div class="clear"></div>
                </div>
                <div style="display:none;" class="thankYouText">
                	Thanks
                </div>
            </div>
        </div>
    </div>-->
	
	
	
	
    <div class="headerwrap">
        <!--Subscribe-->
    <?php    
        if(time() >= $_SESSION['user_subscribe_expire']){
    unset($_SESSION["user_subscribed"]);
}

global $base_url;
if(!isset($_SESSION["user_subscribed"])){
    drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/main-header.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));
} ?>

       <!-- <div class="extraDetails">
            <div class="subscribeInfo">
                <input type="text" id="email_id" placeholder="Enter your email id" value="" maxlength="100">
                <a href="javascript:;" onClick="submitSubscription()">Subscribe</a>
                <span class="loader" style="display:none;"></span>
                <div class="messages error" id="errorMessage" style="display:none;"></div>
                <div class="thankYou messages status" style="display:none;"></div>
                    
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>-->
        
        <div class="extraDetails">
        <?php if(!isset($_SESSION["user_subscribed"])){ ?>
            <div class="subscribeInfo">
                <span class="errMsg" id="errorMessage"></span>
                <input type="text" id="email_id" placeholder="Enter your Email ID" value="" maxlength="100">
                <div class="loader" style="display:none;"></div>
                <a href="javascript:;" onClick="submitSubscription()" class="subscribeBtn">Subscribe</a>
                <div class="clear"></div>
            </div>
        <?php } ?>
        <ul class="socialIcons">
            <li>
                <a href="https://www.facebook.com/101India" target="_blank"><img alt="Facebook" title="Facebook" src="<?php echo $image_url;?>fb-circle.png"></a>
            </li>
            <li>
                <a href="https://twitter.com/101India" target="_blank"><img alt="Twitter" title="Twitter" src="<?php echo $image_url;?>tw-circle.png"></a>
            </li>
<!--             <li>
                <a href="https://plus.google.com/+101India/posts" target="_blank"><img alt="Google+" title="Google+" src="<?php echo $image_url;?>gplus-circle.png"></a>
            </li> -->
            <li>
                <a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"><img alt="Youtube" title="Youtube" src="<?php echo $image_url;?>youtube-circle.png"></a>
            </li>
            <li>
                <a href="https://www.instagram.com/101india/" target="_blank"><img alt="Instagram" title="Instagram" src="<?php echo $image_url;?>insta-circle.png"></a>
            </li>
            <li>
                <a href="https://www.linkedin.com/company/101india/" target="_blank"><img alt="LinkedIn" title="LinkedIn" src="<?php echo $image_url;?>linkedin.png"></a>
            </li>
            <li>
                <a href="https://t.me/One_O_One_India" target="_blank"><img alt="Telegram" title="Telegram" src="<?php echo $image_url;?>Telegram.png"></a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/rss-feed.xml" target="_blank"><img alt="RSS Feed" title="RSS Feed" src="<?php echo $image_url;?>rss-circle.png"></a>
            </li>
        </ul>
        <ul class="staticMenu">
            <li><a href="<?php echo $base_url; ?>/about-us" class="<?php echo ($currentPath == 'about-us'?'active':''); ?>">ABOUT US</a></li>
            <li><a href="<?php echo $base_url; ?>/contact-us" class="<?php echo ($currentPath == 'contact-us'?'active':''); ?>">CONTACT US</a></li>
            <li><a href="<?php echo $base_url; ?>/terms-and-conditions" class="<?php echo ($currentPath == 'terms-and-conditions'?'active':''); ?>">TERMS</a></li>
            <li><a href="<?php echo $base_url; ?>/privacy-policy" class="<?php echo ($currentPath == 'privacy-policy'?'active':''); ?>">PRIVACY</a></li>
        </ul>
        <div class="clear"></div>
            
        <?php if(!isset($_SESSION["user_subscribed"])){ ?>
            <div class="thankYouText" style="display:none;">Thank you for subscribing,You were successfully added to the newsletter recipients.</div>
        <?php } ?>
          
      </div>
        <!-- header -->
        <nav>
            <div class="menuList">
                <?php /*<ul id="slide-out" class="side-nav">
                    <li class="menuItems funny">
                        <a class="menuLink menuLink1 waves-effect" href="javascript:;">FUNNY</a>
                    </li>
                    <li class="menuItems loveSex">
                        <a class="menuLink menuLink2 waves-effect" href="javascript:;">LOVE & SEX</a>
                    </li>
                    <li class="menuItems people">
                        <a class="menuLink menuLink3 waves-effect" href="javascript:;">PEOPLE</a>
                    </li>
                    <li class="menuItems travelFood">
                        <a class="menuLink menuLink4 waves-effect" href="javascript:;">TRAVEL & FOOD</a>
                    </li>
                    <li class="menuItems fiction">
                        <a class="menuLink menuLink5 waves-effect" href="javascript:;">FICTION</a>
                    </li>
                    <li class="menuItems music">
                        <a class="menuLink menuLink6 waves-effect" href="javascript:;">MUSIC</a>
                    </li>
                    <li class="menuItems brief">
                        <a class="menuLink menuLink7 waves-effect" href="javascript:;">THE BRIEF</a>
                    </li>
                    <li class="menuItems other">
                        <a class="menuLink menuLink8 waves-effect" href="javascript:;" data-activates="dropdown1">OTHER</a>
                        <?php /*<!-- Dropdown Structure -->
                        <ul id="dropdown1" class="dropdown-content">
                            <li><a href="javascript:;" class="waves-effect">CONTACT</a></li>
                            <li><a href="javascript:;" class="waves-effect">TERMS</a></li>
                            <li><a href="javascript:;" class="waves-effect">PRIVACY</a></li>
                            <li><a href="javascript:;" class="waves-effect">NEWSLETTER</a></li>
                        </ul>*//* ?>
                    </li>
                    <li class="menuItems about">
                        <ul class="collapsible" data-collapsible="accordion">
                            <li>
                              <div class="collapsible-header">
                                <a class="menuLink menuLink9 waves-effect" href="javascript:;">ABOUT</a></div>
                              <div class="collapsible-body">
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="waves-effect">CONTACT</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="waves-effect">TERMS</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="waves-effect">PRIVACY</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="waves-effect">NEWSLETTER</a>
                                    </li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                    </li>
                </ul> */ ?>
                <?php print $content; ?>
                
                <ul class="mobMenu">
                	<li class="toLeft">
                    	<ul>
                        	<li class="menuItems home"><a href="/" title="" class="menuLink waves-effect<?php echo ($currentPath == 'node'?' active':''); ?>">Home</a></li>
                            <li class="menuItems videos"><a href="/videos" title="" class="menuLink waves-effect<?php echo ($currentPath == 'videos'?' active':''); ?>">Videos</a></li>
                            <li class="menuItems funny"><a href="/funny" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'funny')?' active':''); ?>">Funny</a></li>
                            <li class="menuItems loveSex"><a href="/love-sex" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'love-sex')?' active':''); ?>">Love &amp; Sex</a></li>
                            <li class="menuItems people"><a href="/people" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'people') || strstr($currentPath, 'janta')?' active':''); ?>">People</a></li>
                            <li class="menuItems travelFood"><a href="/travel-food" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'travel-food')?' active':''); ?>">Travel &amp; Food</a></li>
                            <li class="menuItems fiction"><a href="/fiction" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'fiction')?' active':''); ?>">Fiction</a></li>
                            <li class="menuItems music"><a href="/music" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'music')?' active':''); ?>">Music</a></li>
                            <li class="menuItems sports"><a href="/sports" class="menuLink waves-effect<?php echo (strstr($currentPath, 'sports')?' active':''); ?>">Sports</a></li>
                            <li class="menuItems artsCulture"><a href="/arts-culture" class="menuLink waves-effect<?php echo (strstr($currentPath, 'arts-culture')?' active':''); ?>">Arts &amp; Culture</a></li>
                            <li class="menuItems specials"><a href="/specials" class="menuLink waves-effect<?php echo (strstr($currentPath, 'specials')?' active':''); ?>">Specials</a></li>
                            <?php /*<li class="menuItems others">
                                <a href="javascript:;" title="" class="menuLink waves-effect">Others</a>
                                <ul id="dropdown1" class="dropdown-content">
                                    <li><a href="/arts-culture" class="waves-effect artsCulture">Arts &amp; Culture</a></li>
                                    <li><a href="/specials" class="waves-effect specials">Specials</a></li>
                                </ul>
                            </li>
                            <li class="menuItems about">
                                <ul class="collapsible active" data-collapsible="accordion">
                                    <li class="active">
                                        <div class="collapsible-header active">
                                            <a class="menuLink waves-effect" href="javascript:;">OTHERS</a>
                                        </div>
                                        <div class="collapsible-body" style="display: block;">
                                            <ul>
                                                <li class="waves-effect artsCulture"><a href="/arts-culture" class="waves-effect artsCulture<?php echo (strstr($currentPath, 'arts-culture')?' active':''); ?>">Arts &amp; Culture</a></li>
                                                <li class="waves-effect specials"><a href="/specials" class="waves-effect specials<?php echo (strstr($currentPath, 'specials')?' active':''); ?>">Specials</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>*/ ?>
                        </ul>
                    </li>
					<script type="text/javascript">
						function showSubscribepop(){
							$('.overlay').show();
							$('#subscribe_pop').show();
							 $( ".popContainer" ).animate({
								top: "6em"
							  }, 900, function() {
								// Animation complete.
								
							  });
						}
					</script>
                    <li class="toLeft">
                    	<ul>
                              <li class="menuItems footerLink"><a class="menuLink waves-effect<?php echo (strstr($currentPath, 'about-us')?' active':''); ?>" href="<?php echo $base_url; ?>/about-us">ABOUT US</a></li>
                              <li class="menuItems footerLink"><a class="menuLink waves-effect<?php echo (strstr($currentPath, 'contact-us')?' active':''); ?>" href="<?php echo $base_url; ?>/contact-us">CONTACT US</a></li>
                              <li class="menuItems footerLink"><a class="menuLink waves-effect<?php echo (strstr($currentPath, 'terms-and-conditions')?' active':''); ?>" href="<?php echo $base_url; ?>/terms-and-conditions">TERMS</a></li>
                              <li class="menuItems footerLink"><a class="menuLink waves-effect<?php echo (strstr($currentPath, 'privacy-policy')?' active':''); ?>" href="<?php echo $base_url; ?>/privacy-policy">PRIVACY</a></li>
							  <?php /*<li class="menuItems footerLink"><a class="menuLink waves-effect" href="javascript:;" onclick="return showSubscribepop();">SUBSCRIBE</a></li>
                              <li class="menuItems footerLink"><a class="menuLink waves-effect" href="javascript:;">NEWSLETTER</a></li>
                              <li class="menuItems footerLink"><span class="menuLink waves-effect">&copy; 101 INDIA DIGITAL PVT.LTD</span></li>
                              <li class="menuItems footerLink"><span class="menuLink waves-effect">ALL RIGHTS RESERVED</span></li>*/ ?>
                        </ul>
                    </li>
                    
                    
                </ul>
            </div>
        </nav>

        <div class="socialIconWrap">
            <ul>
                <li>
                    <div class="searchArea">
                        <a class="icons searchIcon" href="javascript:;" title="Search">
                            <i class="mdi-action-search search" alt="Search"></i>
                            <i class="mdi-navigation-close searchCross" style="display:none"></i>
                        </a>
                        <div class="searchInput">
                            <input placeholder="SEARCH" name="user_id" id="userId" type="text" class="txtBox">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</header>
<div class="mobileViewHeader101" style="background-color:<?php echo $mobilebg; ?>">
<div id="header101">
<div id="toggle101"><span></span></div>
<div id="mobilemenu101">
	<div class="bgylw" style="background-color:<?php echo $mobilebg_over; ?>">
		<span id="title" style="padding-top:20px;">
			<?php if ( $logo = theme_get_setting('logo') ) :
$front_page = variable_get('site_frontpage', '/'); ?>
<a href="/" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $mobilelogo_overlay_url; ?>" alt="<?php print t('Home'); ?>" width="50" /></a>
<?php endif; ?>
		</span>
		<div class="searchInput">
			<input placeholder="SEARCH" name="user_id" id="userId" type="text" class="txtBox">
		</div>
	</div>
  <ul class="mobMenu101">
<!--<li class="videos"><a href="/videos" title="" class="menuLink waves-effect<?php echo ($currentPath == 'videos'?' active':''); ?>">Videos</a></li>-->
    <li class="series"><a href="/series" title="" class="menuLink waves-effect<?php echo ($currentPath == 'series'?' active':''); ?>">Series</a></li>
	<li class="funny"><a href="/funny" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'funny')?' active':''); ?>">Funny</a></li>
	<li class="loveSex"><a href="/love-sex" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'love-sex')?' active':''); ?>">Love &amp; Sex</a></li>
	<li class="people"><a href="/people" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'people') || strstr($currentPath, 'janta')?' active':''); ?>">People</a></li>
	<li class="travelFood"><a href="/travel-food" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'travel-food')?' active':''); ?>">Travel &amp; Food</a></li>
	<li class="fiction"><a href="/fiction" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'fiction')?' active':''); ?>">Fiction</a></li>
	<li class="music"><a href="/music" title="" class="menuLink waves-effect<?php echo (strstr($currentPath, 'music')?' active':''); ?>">Music</a></li>
	<li class="sports"><a href="/sports" class="menuLink waves-effect<?php echo (strstr($currentPath, 'sports')?' active':''); ?>">Sports</a></li>
	<li class="artsCulture"><a href="/arts-culture" class="menuLink waves-effect<?php echo (strstr($currentPath, 'arts-culture')?' active':''); ?>">Arts &amp; Culture</a></li>
	<li class="horror"><a href="/horror" class="menuLink waves-effect<?php echo (strstr($currentPath, 'specials')?' active':''); ?>">Horror</a></li>
	<li class="specials"><a href="/partnerships" class="menuLink waves-effect<?php echo (strstr($currentPath, 'partnerships')?' active':''); ?>">Partnerships</a></li>
	<li class="about-us"><a class="menuLink waves-effect<?php echo (strstr($currentPath, 'about-us')?' active':''); ?>" href="<?php echo $base_url; ?>/about-us">ABOUT US</a></li>
	<li class="contact-us" align="left">
		<a class="menuLink waves-effect<?php echo (strstr($currentPath, 'contact-us')?' active':''); ?>" href="<?php echo $base_url; ?>/contact-us">CONTACT US</a>
	</li>
	<li class="terms-and-conditions" align="left">
		<a class="menuLink waves-effect<?php echo (strstr($currentPath, 'terms-and-conditions')?' active':''); ?>"  href="<?php echo $base_url; ?>/terms-and-conditions">TERMS</a>
	  </li>
	<li class="privacy-policy" align="left">
		<a class="menuLink waves-effect<?php echo (strstr($currentPath, 'privacy-policy')?' active':''); ?>" href="<?php echo $base_url; ?>/privacy-policy">PRIVACY</a>
	</li>
  </ul>
  <div class="mobilesocialfix" align="center">
	  <a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"><img src="<?php echo $image_url;?>yt_mobile.png" width="23"></a>&nbsp;&nbsp;
	  <a href="https://www.facebook.com/101India" target="_blank"><img src="<?php echo $image_url;?>fb_mobile.png" width="23"></a>&nbsp;&nbsp;
	  <a href="https://twitter.com/101India" target="_blank"><img src="<?php echo $image_url;?>tw_mobile.png" width="23"></a>&nbsp;&nbsp;
	  <a href="http://i.instagram.com/101india/" target="_blank"><img src="<?php echo $image_url;?>insta_mobile.png" width="23"></a>
  </div>
</div>
</div>
<div class="mobileSiteLogo"><a href="/"><img src="<?php echo $mobilelogo_url; ?>" alt="Site Logo"></a></div>
    <!-- <div class="mobileSiteLogo"><a href="/"><img src="<?php $base_url; ?>/sites/default/files/mobile-logo-epic.png" alt="Site Logo"></a></div> -->
	<?php if(!isset($_SESSION["user_subscribed"])){ ?>
	<div class="subscribeInfo"> <a href="javascript:;" onclick="return showSubscribepop();" class="subscribeBtn">Subscribe</a></div>
	<?php } ?>
    <div class="searchArea">
        <a class="icons searchIcon" href="javascript:;">
            <img src="<?php echo $image_url; ?>mobile-search-v2.png" class="search" alt="Search Icon" />
            <i class="mdi-navigation-close searchCross" style="display:none"></i>
        </a>
        <div class="searchInput">
            <input placeholder="SEARCH" name="user_id" id="userId" type="text" class="txtBox">
        </div>
    </div>
</div>
<script>
$("#toggle101").click(function() {
	$(this).toggleClass("open");
	$("#mobilemenu101").toggleClass("opened");
});
</script>