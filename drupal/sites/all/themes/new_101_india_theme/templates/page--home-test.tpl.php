<?php
/**
 * @file
 * Adaptivetheme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * Adaptivetheme supplied variables:
 * - $site_logo: Themed logo - linked to front with alt attribute.
 * - $site_name: Site name linked to the homepage.
 * - $site_name_unlinked: Site name without any link.
 * - $hide_site_name: Toggles the visibility of the site name.
 * - $visibility: Holds the class .element-invisible or is empty.
 * - $primary_navigation: Themed Main menu.
 * - $secondary_navigation: Themed Secondary/user menu.
 * - $primary_local_tasks: Split local tasks - primary.
 * - $secondary_local_tasks: Split local tasks - secondary.
 * - $tag: Prints the wrapper element for the main content.
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 * - *_attributes: attributes for various site elements, usually holds id, class
 *   or role attributes.
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Core Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * Adaptivetheme Regions:
 * - $page['leaderboard']: full width at the very top of the page
 * - $page['menu_bar']: menu blocks placed here will be styled horizontal
 * - $page['secondary_content']: full width just above the main columns
 * - $page['content_aside']: like a main content bottom region
 * - $page['tertiary_content']: full width just above the footer
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see adaptivetheme_preprocess_page()
 * @see adaptivetheme_process_page()
 
 
 Use <div class="loader"></div> for loader
 
 */

/*if(isset($_SESSION['loaded_series'])){
    unset($_SESSION['loaded_series']);
}*/
global $base_url;

//Mobile detect code starts
$deviceType = '';
include_once DRUPAL_ROOT . '/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends
/* require_once DRUPAL_ROOT . '/vzaar-src/Vzaar.php';
Vzaar::$token = 'SJxSbf84NUl6cJsKjCHMCMcnhF9Qvw3XpmOpD4v268';
Vzaar::$secret = 'Abbasali';*/
                                
$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$whatsNewView = get_views_data('home_page_featured', 'hp_whats_new');
$whatsNewRes = $whatsNewView->result[0];

//echo '<pre style="display: none">';print_r($whatsNewRes);echo '</pre>';

$whatsHotView = get_views_data('home_page_featured', 'hp_whats_hot');
$whatsHotRes = $whatsHotView->result[0];

$getSeriesView = get_views_data('get_all_series_data_block', 'all_series');
$allSeriesData = $getSeriesView->result;

$seriesStories = array();
$recentContentArr = array();
$allNidArr = array();
$finalHPArr = array();

foreach($allSeriesData as $skey=>$seriesData){
    $stories = $seriesData->_field_data['nid']['entity']->field_series_stories['und'];
    foreach($stories as $tkey=>$snid){
        $seriesStories[$seriesData->nid][] = $snid['nid'];
    }
}

$getHPSeededView = get_views_data('get_all_series_data_block', 'hp_seeded');
$hpSeededCont = $getHPSeededView->result;

if(!empty($hpSeededCont)){
    foreach($hpSeededCont as $dkey=>$seed){
        $allNidArr[] = $seed->nid;
        $finalHPArr[] = $seed;
    }
}

//echo '<pre style="display: none;">';print_r($allNidArr);echo '</pre>';
//echo '<pre style="display: none;">';print_r($finalHPArr);echo '</pre>';

$hpSeededContCount = count($hpSeededCont);

if($hpSeededContCount < 12){
    $recentContView = get_views_data('recent_content', 'block');
    $recentContentArr = $recentContView->result;
    
    foreach($recentContentArr as $rckey=>$rcVal){
        if($rcVal->node_type == 'series' && !in_array($rcVal->nid, $allNidArr)){
            $finalHPArr[] = $rcVal;
            
            $sStories = $rcVal->_field_data['nid']['entity']->field_series_stories['und'];
            $storiesArr = array();
            $allNidArr[] = $rcVal->nid;
            foreach($sStories as $tkey=>$ssnid){
                $allNidArr[] = $ssnid['nid'];
                $storiesArr[] = $ssnid['nid'];
            }
            
            $latestStory = max($storiesArr);
            
            $nodeView = get_views_data('get_all_series_data_block', 'node_by_nid', array(0 => array('name' => 'nid', 'value' => array($latestStory))));

            if(isset($nodeView->result[0]) && !empty($nodeView->result[0])){
                $finalHPArr[] = $nodeView->result[0];
            }
        }else if($rcVal->node_type != 'series' && !in_array($rcVal->nid, $allNidArr)){
            foreach($seriesStories as $snkey=>$ssCont){
                if(in_array($rcVal->nid, $ssCont) && !in_array($rcVal->nid, $allNidArr) && !in_array($snkey, $allNidArr)){
                    $allNidArr[] = $snkey;
                    
                    $serNodeView = get_views_data('get_all_series_data_block', 'node_by_nid', array(0 => array('name' => 'nid', 'value' => array($snkey))));

                    if(isset($serNodeView->result[0]) && !empty($serNodeView->result[0])){
                        $finalHPArr[] = $serNodeView->result[0];
                    }
                    
                    $latestStory = max($ssCont);
                    
                    $nodeView = get_views_data('get_all_series_data_block', 'node_by_nid', array(0 => array('name' => 'nid', 'value' => array($latestStory))));

                    if(isset($nodeView->result[0]) && !empty($nodeView->result[0])){
                        $finalHPArr[] = $nodeView->result[0];
                        
                        foreach($ssCont as $snid){
                            $allNidArr[] = $snid;
                        }
                    }
                    
                    break;
                }
            }
            
            if(!in_array($rcVal->nid, $allNidArr)){
                $finalHPArr[] = $rcVal;
                $allNidArr[] = $rcVal->nid;
            }
        }
    }

//echo '<pre style="display: none;">';print_r($finalHPArr);echo '</pre>';
}
?>
<?php
    //drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular.min.js', array('type' => 'file', 'group' => JS_THEME, 'weight' => 20));

    drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular-sanitize.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));

    drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/hp-angular.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));
?>



<div class="page homePg">
    <div class="logoWrap colLhs">
        <?php if ($site_logo):
            print $site_logo;
        endif; ?>
        <?php /*<div class="logoTxt">Stories for<br/>a New India</div>*/ ?>
        <div class="logoTxt">Storytellers of a new generation</div>
    </div>
    
    <div class="containerwrap">
        <div class="menuWrap">
            <?php if($page['header']){
                print render($page['header']);
            }?>
        </div>
        
        <div class="contentWrap contentSlide" ng-app="myapp">
            
            <!-- !Messages -->
            <?php print $messages; ?>

            <!-- !Navigation -->
            <?php if ($primary_navigation): print $primary_navigation; endif; ?>
            <?php if ($secondary_navigation): print $secondary_navigation; endif; ?>

            <!-- !Breadcrumbs -->
            <?php //if ($breadcrumb): print $breadcrumb; endif; ?>

            <?php if ($primary_local_tasks || $secondary_local_tasks || $action_links): ?>
                <div id="tasks">

                    <?php if ($primary_local_tasks): ?>
                        <ul class="tabs primary clearfix"><?php print render($primary_local_tasks); ?></ul>
                    <?php endif; ?>

                    <?php if ($secondary_local_tasks): ?>
                        <ul class="tabs secondary clearfix"><?php print render($secondary_local_tasks); ?></ul>
                    <?php endif; ?>

                    <?php if ($action_links = render($action_links)): ?>
                        <ul class="action-links clearfix"><?php print $action_links; ?></ul>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <!-- !Main Content -->
            <?php if ($page['content']): ?>

                <?php if(drupal_is_front_page()){
                    unset($page['content']['system_main']['default_message']);
                } ?>

                <?php print render($page['content']); ?>
            <?php endif; ?>
            
            <?php /******* What's New & What's Hot Section STARTS *******/ ?>
            <div class="whatsNewWrap">
                <ul>
                <?php if(!empty($whatsNewRes)){
                    $whatsNewNode = $whatsNewRes->_field_data['nid']['entity']; 
                    $whatsNewTitle = $whatsNewNode->title;
                
                    if(strlen($whatsNewTitle) > 108){
                        $whatsNewTitle = substr($whatsNewTitle, 0, strpos($whatsNewTitle, ' ', 105));
                        $whatsNewTitle .= '...';
                    }else{
                        $whatsNewTitle = $whatsNewTitle;
                    }
                                
                    $whatsNewSummary = field_get_items('node', $whatsNewNode, 'body');

                    if(!empty($whatsNewSummary[0]['summary'])){
                        if(strlen($whatsNewSummary[0]['summary']) > 160){
                            $pos = strpos($whatsNewSummary[0]['summary'], ' ', 155);
                            $whatsNewSummary = substr($whatsNewSummary[0]['summary'], 0, $pos);
                            $whatsNewSummary .= '...';
                        }else{
                            $whatsNewSummary = $whatsNewSummary[0]['summary'];
                        }
                    }else{
                        if(strlen($whatsNewSummary[0]['value']) > 160){
                            $pos = strpos(strip_tags($whatsNewSummary[0]['value']), ' ', 155);
                            $whatsNewSummary = substr(strip_tags($whatsNewSummary[0]['value']), 0, $pos);
                            $whatsNewSummary .= '...';
                        }else{
                            $whatsNewSummary = strip_tags($whatsNewSummary[0]['value']);
                        }
                    }
                
                    $whatsNewDate = date('j M, Y', $whatsNewRes->publication_date_published_at);
                
                    $whatsNewImg = '';
                    $whatsNewAlt = '';
                    $whatsNewTtl = '';

                    $whatsNewThbImg = field_get_items('node', $whatsNewNode, 'field_thumb_image');

                    if(empty($whatsNewThbImg)){
                        $whatsNewThbImg = field_get_items('node', $whatsNewNode, 'field_cover_image');
                    }

                    $whatsNewImg = image_style_url('hp_whats_section', $whatsNewThbImg[0]['uri']);

                    if(!empty($whatsNewThbImg[0]['alt'])){
                        $whatsNewAlt = $whatsNewThbImg[0]['alt'];
                    }else{
                        $whatsNewAlt = $whatsNewNode->title;
                    }

                    if(!empty($whatsNewThbImg[0]['title'])){
                        $whatsNewTtl = $whatsNewThbImg[0]['title'];
                    }else{
                        $whatsNewTtl = $whatsNewNode->title;
                    }
                
                    if($whatsNewNode->type == 'videos'){
                        $whatsNewContentIcon = $image_url . 'video-play-icon.png';
                        //$whatsNewContentText = '<span>' . '</span>';
                        $whatsClass = ' class="play"';
                        
                        $videoDuration = field_get_items('node', $whatsNewNode, 'field_vzaar_video_duration');
                        
                        $vidTimeStamp = '';
                                
                        if(!empty($videoDuration[0]['value'])){

                            $vidTimeStamp = $videoDuration[0]['value'];

                            //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                        }else{
                            $vidTimeStampSecs = $whatsNewRes->field_field_brightcove_video[0]['rendered']['#video']->length;

                            $min = ($vidTimeStampSecs/1000/60) << 0;
                            $sec = round(($vidTimeStampSecs/1000) % 60);
                            $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

                            //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                        }

                        $whatsNewContentText = '<span>' . $vidTimeStamp . '</span>';
                    }else{
                        $whatsNewContentIcon = $image_url . 'read-icon.png';
                        $whatsNewContentText = '';
                        $whatsClass = '';
                    }
                
                    $whatsNewPath = url('node/' . $whatsNewNode->nid, array('absolute' => true));
                ?>
                    <li>
                        <div class="whatsNew">
                            <div class="titleTxt">WHAT’S NEW</div>
                            <div class="dataContainer">
                                <div class="imageContent">
                                    <a class="detailLink" href="<?php echo $whatsNewPath; ?>">
                                        <img class="imgpost" src="<?php echo $whatsNewImg; ?>" alt="<?php echo $whatsNewAlt; ?>" title="<?php echo $whatsNewTtl; ?>" />
                                    </a>
                                    <div class="iconWrap">
                                        <a href="<?php echo $whatsNewPath; ?>"><img<?php echo $whatsClass; ?> src="<?php echo $whatsNewContentIcon; ?>" alt="icon" /><?php echo $whatsNewContentText; ?></a>
                                    </div>
                                </div>
                                <a href="<?php echo $whatsNewPath; ?>">
                                    <div class="summary">
                                        <h2><?php echo $whatsNewTitle; ?></h2>
                                        <div class="metaDate"><span><?php echo $whatsNewDate; ?></span></div>
                                        <p><?php echo $whatsNewSummary; ?></p>
                                    </div>
                                </a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
                <?php if(!empty($whatsHotRes)){
                    $whatsHotNode = $whatsHotRes->_field_data['nid']['entity']; 
                    $whatsHotTitle = $whatsHotNode->title;
                
                    if(strlen($whatsHotTitle) > 108){
                        $whatsHotTitle = substr($whatsHotTitle, 0, strpos($whatsHotTitle, ' ', 105));
                        $whatsHotTitle .= '...';
                    }else{
                        $whatsHotTitle = $whatsHotTitle;
                    }
                                
                    $whatsHotSummary = field_get_items('node', $whatsHotNode, 'body');

                    if(!empty($whatsHotSummary[0]['summary'])){
                        if(strlen($whatsHotSummary[0]['summary']) > 160){
                            $whatsHotSummary = substr($whatsHotSummary[0]['summary'], 0, strpos($whatsHotSummary[0]['summary'], ' ', 155));
                            $whatsHotSummary .= '...';
                        }else{
                            $whatsHotSummary = $whatsHotSummary[0]['summary'];
                        }
                    }else{
                        if(strlen($whatsHotSummary[0]['value']) > 160){
                            $pos = strpos(strip_tags($whatsHotSummary[0]['value']), ' ', 155);
                            $whatsHotSummary = substr(strip_tags($whatsHotSummary[0]['value']), 0, $pos);
                            $whatsHotSummary .= '...';
                        }else{
                            $whatsHotSummary = strip_tags($whatsHotSummary[0]['value']);
                        }
                    }
                
                    $whatsHotDate = date('j M, Y', $whatsHotRes->publication_date_published_at);
                    //echo "<pre display:none;>".$whatsHotNode->publication_date_published_at."<pre>";
                
                    $whatsHotImg = '';
                    $whatsHotAlt = '';
                    $whatsHotTtl = '';

                    $whatsHotThbImg = field_get_items('node', $whatsHotNode, 'field_thumb_image');

                    if(empty($whatsHotThbImg)){
                        $whatsHotThbImg = field_get_items('node', $whatsHotNode, 'field_cover_image');
                    }

                    $whatsHotImg = image_style_url('hp_whats_section', $whatsHotThbImg[0]['uri']);

                    if(!empty($whatsHotThbImg[0]['alt'])){
                        $whatsHotAlt = $whatsHotThbImg[0]['alt'];
                    }else{
                        $whatsHotAlt = $whatsHotNode->title;
                    }

                    if(!empty($whatsHotThbImg[0]['title'])){
                        $whatsHotTtl = $whatsHotThbImg[0]['title'];
                    }else{
                        $whatsHotTtl = $whatsHotNode->title;
                    }
                
                    if($whatsHotNode->type == 'videos'){
                        $whatsHotContentIcon = $image_url . 'video-play-icon.png';
                        //$whatsNewContentText = '<span>' . '</span>';
                        $whatsClass = ' class="play"';
                        
                        $videoDuration = field_get_items('node', $whatsHotNode, 'field_vzaar_video_duration');
                        
                        $vidTimeStamphot = '';
                                
                        if(!empty($videoDuration[0]['value'])){
                            $vidTimeStamphot = $videoDuration[0]['value'];

                            //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                        }else{
                            $vidTimeStampSecs = $whatsHotRes->field_field_brightcove_video[0]['rendered']['#video']->length;

                            $min = ($vidTimeStampSecs/1000/60) << 0;
                            $sec = round(($vidTimeStampSecs/1000) % 60);
                            $vidTimeStamphot = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

                            //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                        }

                        $whatsHotContentText = '<span>' . $vidTimeStamphot . '</span>';
                    }else{
                        $whatsHotContentIcon = $image_url . 'read-icon.png';
                        $whatsHotContentText = '';
                        $whatsClass = '';
                    }
                
                    $whatsHotPath = url('node/' . $whatsHotNode->nid, array('absolute' => true));
                ?>
                    <li>
                        <div class="whatsHot">
                            <div class="titleTxt">WHAT’S HOT</div>
                            <div class="dataContainer">
                                <div class="imageContent">
                                    <a class="detailLink" href="<?php echo $whatsHotPath; ?>">
                                        <img class="imgpost" src="<?php echo $whatsHotImg; ?>" alt="<?php echo $whatsHotAlt; ?>" title="<?php echo $whatsHotTtl; ?>" />
                                    </a>
                                    <div class="iconWrap">
                                        <a href="<?php echo $whatsHotPath; ?>"><img<?php echo $whatsClass; ?> src="<?php echo $whatsHotContentIcon; ?>" alt="icon" /><?php echo $whatsHotContentText; ?></a>
                                    </div>
                                </div>
                                <a href="<?php echo $whatsHotPath; ?>">
                                    <div class="summary">
                                        <h2><?php echo $whatsHotTitle; ?></h2>
                                        <div class="metaDate"><span><?php echo $whatsHotDate; ?></span></div>
                                        <p><?php echo $whatsHotSummary; ?></p>
                                    </div>
                                </a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
                </ul>
            </div>
            <?php /******* What's New & What's Hot Section ENDS *******/ ?>
            
        <?php /******* Home page data masonary *******/ ?>            
        
        <?php
            $scrollDistance='';
            $scrollDistance=($deviceType=='computer' ? 0 : 1);
        ?>
            
        <div class="listContent">
            <div class="masonryContent">
            <?php $totalCont = 0;
            if(!empty($finalHPArr)){
                foreach($finalHPArr as $rckey=>$recent){
                    if($totalCont < 12){
                        //echo '<pre style="display: none;">';print_r($recent);echo '</pre>';
                        $recentNode = $recent->_field_data['nid']['entity'];

                        $contentTypeName = $recent->field_field_article_category[0]['rendered']['#markup'];

                        $textClass = '';

                        if(strstr($contentTypeName,'101')){
                            if($contentTypeName == "101 Travel"){
                                $typeLink = $base_url.'/travel-food';
                                $typeName = 'Travel & Food';
                                $linkClass = 'travelFood';
                            }else if($contentTypeName == "101 Janta"){
                                $typeLink = $base_url.'/people';
                                $typeName = 'People';
                                $linkClass = 'people';
                            }else{
                                $typeLink = $base_url.'/'.strtolower(str_replace('101 ','',$contentTypeName));
                                $typeLink = str_replace(array(' & ', ' amp; ', ' &amp; ', ' Amp; '), array('-', '-', '-', '-'), $typeLink);
                                $typeName = str_replace('101 ','',$contentTypeName);
                                $textClass = str_replace('101 ','',$contentTypeName);
                                $textClass = explode('&', $textClass);
                                foreach($textClass as $tk=>$cat){
                                    if($tk == 0){
                                        $textClass[$tk] = strtolower($cat);
                                    }else{
                                        $textClass[$tk] = ucfirst($cat);
                                    }        
                                }
                                $textClass = implode('', $textClass);
                                $linkClass = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' '), array('', '', '', '', ''), $textClass);
                            }
                        }else{
                            $typeLink = $base_url.'/'.strtolower($contentTypeName);
                            $typeLink = str_replace(array(' & ', ' amp; ', ' &amp; ', ' Amp; '), array('-', '-', '-', '-'), $typeLink);
                            $typeName = $contentTypeName;
                            $textClass = explode(' ', $contentTypeName);
                            foreach($textClass as $tk=>$cat){
                                if($tk == 0){
                                    $textClass[$tk] = strtolower($cat);
                                }else{
                                    $textClass[$tk] = ucfirst($cat);
                                }        
                            }
                            $textClass = implode('', $textClass);
                            $linkClass = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' '), array('', '', '', '',''), $textClass);
                        }

                        $recentTitle = trim($recent->node_title);
                        $pos = 0;

                        if(strlen(trim($recentTitle)) > 90){
                            $pos = strpos($recentTitle, ' ', 86);
                            if($pos){
                                $recentTitle = substr(trim($recentTitle), 0, $pos);
                                $recentTitle .= '...';
                            }
                        }else{
                            $recentTitle = $recentTitle;
                            $pos = strpos($recentTitle, ' ', 86);
                        }

                        $recentSummary = field_get_items('node', $recentNode, 'body');

                        if(!empty($recentSummary[0]['summary'])){
                            if(strlen($recentSummary[0]['summary']) > 160){
                                $recentSummary = substr($recentSummary[0]['summary'], 0, strpos($recentSummary[0]['summary'], ' ', 155));
                                $recentSummary .= '...';
                            }else{
                                $recentSummary = $recentSummary[0]['summary'];
                            }
                        }else{
                            if(strlen($recentSummary[0]['value']) > 160){
                                $pos = strpos(strip_tags($recentSummary[0]['value']), ' ', 155);
                                $recentSummary = substr(strip_tags($recentSummary[0]['value']), 0, $pos);
                                $recentSummary .= '...';
                            }else{
                                $recentSummary = strip_tags($recentSummary[0]['value']);
                            }
                        }

                        $recentDate = date('j M, Y', $recent->publication_date_published_at);

                        $recentImg = '';
                        $recentAlt = '';
                        $recentTtl = '';

                        $recentThbImg = field_get_items('node', $recentNode, 'field_thumb_image');

                        if(empty($recentThbImg)){
                            $recentThbImg = field_get_items('node', $recentNode, 'field_cover_image');
                        }

                        $recentImg = image_style_url('hp_whats_section', $recentThbImg[0]['uri']);

                        if(!empty($recentThbImg[0]['alt'])){
                            $recentAlt = $recentThbImg[0]['alt'];
                        }else{
                            $recentAlt = $recentNode->title;
                        }

                        if(!empty($recentThbImg[0]['title'])){
                            $recentTtl = $recentThbImg[0]['title'];
                        }else{
                            $recentTtl = $recentNode->title;
                        }

                        if($recentNode->type == 'videos'){
                            $recentContentIcon = $image_url . 'video-play-icon.png';
                            //$whatsNewContentText = '<span>' . '</span>';
                            $recentClass = ' class="play"';

                            $videoDuration = field_get_items('node', $recentNode, 'field_vzaar_video_duration');

                            $vidTimeStamphot = '';

                            if(!empty($videoDuration[0]['value'])){
                                $vidTimeStamphot = $videoDuration[0]['value'];

                                //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                            }else{
                                $vidTimeStampSecs = $recentRes->field_field_brightcove_video[0]['rendered']['#video']->length;

                                $min = ($vidTimeStampSecs/1000/60) << 0;
                                $sec = round(($vidTimeStampSecs/1000) % 60);
                                $vidTimeStamphot = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

                                //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                            }

                            $recentContentText = '<span>' . $vidTimeStamphot . '</span>';
                        }else{
                            $recentContentIcon = $image_url . 'read-icon.png';
                            $recentContentText = '';
                            $recentClass = '';
                        }

                        $recentPath = url('node/' . $recentNode->nid, array('absolute' => true));
                ?>
                    <div class="masonry-brick item <?php echo $linkClass; ?>">
                        <div class="dataContainer">
                            <div class="metaDate"><span><?php echo $recentDate; ?></span></div>
                            <div class="imageContent">
                                <div class="categoryVal">
                                    <a href="<?php echo $typeLink; ?>" ><?php echo $typeName; ?></a>
                                </div>
                                <a class="detailLink" href="<?php echo $recentPath; ?>">
                                    <img src="<?php echo $recentImg; ?>" alt="<?php echo $recentAlt; ?>" title="<?php echo $recentTtl; ?>" />
                                </a>
                                <div class="iconWrap" >
                                    <a href="<?php echo $recentPath; ?>">  
                                        <img<?php echo $recentClass; ?> src="<?php echo $recentContentIcon; ?>" /><?php echo $recentContentText; ?>
                                    </a>    
                                </div>
                            </div>
                            <div class="summary">
                                <h2><a href="<?php echo $recentPath; ?>" ><?php echo $recentTitle; ?></a></h2>
                                <p><?php echo $recentSummary; ?></p>
                                <div class="mobileDate"><span><?php echo $recentDate; ?></span></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php }else{
                        break;
                    }
                    $totalCont++;
                }
            }?>
            </div>
        </div>
        
        <div class="listContent" ng-app="myapp" >
            <div ng-controller="MyController"  ng-Cloak>
                <div class="masonryContent" ng-init="myData.autoLoad()" infinite-scroll="myData.autoLoad()" infinite-scroll-distance="<?php echo $scrollDistance; ?>" infinite-scroll-disabled="check"  infinite-scroll-immediate-check="true">
                    <div class="masonry-brick item {{ x.linkClass }}"  ng-repeat="x in Data track by $index">
                        <div class="dataContainer">
                            <div class="metaDate"><span>{{(x.publication_date_published_at*1000) | date:'MMM dd, yyyy'}}</span></div>
                            <div class="imageContent">
                                <div class="categoryVal">
                                    <a href="{{x.url}}" >{{ x.typeName }}</a>
                                </div>
                                <a class="detailLink" href="{{x.path}}" ng-bind-html="x.thumb_image" ></a>
                                <div class="iconWrap" >
                                    <a href="{{x.path}}" >  
                                        <img class="play" ng-if="x.type=='videos'" ng-src="{{x.contentIcon}}" alt="icon" />
                                        <img ng-if="x.type!='videos'" ng-src="{{x.contentIcon}}" alt="icon" />
                                        <div ng-bind-html="x.contentText"></div>
                                    </a>    
                                    <!-- <span>{{x.post_date | date:'hh:mm'}}</span> -->
                                </div>
                            </div>
                            <div class="summary">
                                <h2><a href="{{x.path}}" >{{x.title}}</a></h2>
                                <p ng-bind-html="x.description"></p>
                                <div class="mobileDate"><span>{{(x.publication_date_published_at*1000) | date:'MMM dd, yyyy'}}</span></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div ng-if="busy" style="visibility: visible;" class="loader-new" id="views_infinite_scroll-ajax-loader"></div>
                <div ng-if="!busy" style="visibility: hidden;" class="loader-new" id="views_infinite_scroll-ajax-loader"></div>
                <div class="loader" id="loadMore" ng-click="myData.doClick();" ></div>
            </div>
        </div>

        <?php /******* Home page data masonary Ends *******/ ?>                             
        </div>
        <div class="clear"></div>

    </div>
    <div class="test"></div>
    <div class="colRhs">
        <!-- empty column -->
    </div>
    <div class="clear"></div>
</div>

<!-- !Footer -->
<?php  if ($page['footer']):
    print render($page['footer']);
endif; ?>