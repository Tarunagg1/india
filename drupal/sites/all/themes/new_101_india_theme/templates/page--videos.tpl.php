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
 */

global $base_url;

$image_url_path = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$argArr = arg();
$bgClass = '';

$coverImage = '';
$coverImageAlt = '';
$coverImageTtl = '';

$terms = taxonomy_get_term_by_name('Video Page Cover Image');
 $tid = key($terms);
 $imagevideo = taxonomy_term_load($tid);
 $image_url = $imagevideo->field_all_videos_cover_image['und'][0]['uri'];
 $coverImageAlt = $imagevideo->field_all_videos_cover_image['und'][0]['alt'];
 $coverImageTtl = $imagevideo->field_all_videos_cover_image['und'][0]['title'];
 $name = "Videos";

if(isset($imagevideo) && !empty($imagevideo)){
$coverImage = image_style_url('home_page_category_image', $image_url);
if(!empty($imagevideo->field_all_videos_cover_image['und'][0]['alt'])){
        $coverImageAlt = $imagevideo->field_all_videos_cover_image['und'][0]['alt'];
    }else{
        $coverImageAlt = $name;
    }
    
    if(!empty($imagevideo->field_all_videos_cover_image['und'][0]['title'])){
        $coverImageTtl = $imagevideo->field_all_videos_cover_image['und'][0]['title'];
    }else{
        $coverImageTtl = $name;
    }  
}else{
    $coverImage = $image_url . 'video-cover.jpg';
    $coverImageAlt = $name;
    $coverImageTtl = $name;
    $name = "Videos";
}

if($argArr[0] == 'node' && count($argArr) > 1){
    $currNode = node_load($argArr[1]);
    
    if($currNode->type == 'page'){
        $bgClass = 'homePg';
    }else if($currNode->type == 'blogs'){
        $bgClass = 'homePg';
    }else if($currNode->type == 'listicles'){
        $bgClass = 'homePg';
    }else if($currNode->type == 'series'){
        $bgClass = 'seriesLanding';
    }else if($currNode->type == 'photo_essay'){
        $bgClass = 'homePg';
    }else if($currNode->type == 'videos'){
        $bgClass = 'seriesVideo';
    }
    else if($currNode->type == 'prodcast'){
        $bgClass = 'podcast';
    }
}else if($argArr[0] == 'taxonomy'){
    $bgClass = 'category';
}

$breadcrumb = drupal_get_breadcrumb();

$breadcrumbHTML = theme('breadcrumb', array('breadcrumb' => $breadcrumb));

if(isset($_GET['page']) && !empty($_GET['page'])){
    $pageNo = (int)$_GET['page'] - 1;
}else{
    $pageNo = 0;
}

$videoView = get_views_data('videos_listing', 'block', array(), array(), $pageNo);
$videoArr = $videoView->render('block');

?>

<div class="page <?php echo $bgClass; ?>">
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
        
        <!--all videos code start-->


        <div class="pageBanner series categoryList" >
            <div class="bannerImg videos">
                <img class="bannerImg" src="<?php echo $coverImage; ?>" alt="<?php echo $coverImageAlt; ?>" title="<?php echo $coverImageTtl; ?>">
            </div>
            <div class="dataContainer">
                <div class="summary">
                    <h1><?php print $name; ?></h1>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        
        <div class="listContent">
            <?php print $breadcrumbHTML; ?>
            <div class="pagerContainer">
                <?php print theme('pager'); ?>
            </div>  
            
            <?php print $videoArr; ?>
            
            <div class="pagerContainer">
                <?php print theme('pager'); ?>
            </div>    
        </div>
					
        <!--all videos code end-->        

    </div>
    <div class="colRhs">
        <!-- empty column -->
    </div>
    <div class="clear"></div>
</div>

<!-- !Footer -->
<?php  if ($page['footer']):
    print render($page['footer']);
endif; ?>