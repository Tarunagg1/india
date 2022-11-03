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

$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$argArr = arg();

$searchTerm = (isset($argArr[1]) && !empty($argArr[1]))?$argArr[1]:'';
$sort_criteria = (isset($argArr[2]) && !empty($argArr[2]))?$argArr[2]:'';
$content_type = (isset($argArr[3]) && !empty($argArr[3]))?$argArr[3]:'';
$date_from = (isset($argArr[4]) && !empty($argArr[4]))?$argArr[4]:'';
$date_to = (isset($argArr[5]) && !empty($argArr[5]))?$argArr[5]:'';

//echo '<pre style="display: none">';print_r($searchTerm, $sort_criteria);echo '</pre>';
//echo '<pre style="display: none">search term is: ' . $searchTerm . '      sort criteria: ' . $sort_criteria . '</pre>';

drupal_add_css(drupal_get_path('theme', 'new_101_india_theme') . '/css/jquery-ui.css');
drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/jquery-ui.min.js');

drupal_add_css('.ui-datepicker select.ui-datepicker-month{
    height:auto;
    color:#000;
    padding:0;
    display:inline-block
}', array('type' => 'inline')
);

drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/search-page.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));
?>

<div class="page">
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
        
        <div class="contentWrap contentSlide">
            
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

                <?php //print render($page['content']); ?>
            <?php endif; ?>
            
            <div class="pageBanner searchResult">
                <div class="searchBox">
                    <input type="text" name="search" id="search" placeholder="Search" value="<?php echo str_replace('-', ' ', $searchTerm); ?>" onfocus="javascript:$('#searcErr').hide();">
                    <p class="errMsg" id="searcErr" style="display: none">Please enter text to search</p>
                </div>
                <div class="contentSortWrap">
                    <div class="searchContentType">
                        <ul>
                            <li>Content by:</li>
                            <li>
                                <input name="group1" type="radio" id="videos" value="videos" class="with-gap" <?php echo ($content_type == 'videos')?'checked':''; ?> />
                                <label for="videos">videos</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="listicle" value="listicles" class="with-gap" <?php echo ($content_type == 'listicles')?'checked':''; ?> />
                                <label for="listicle">listicle</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="photo_essay" value="photo_essay" class="with-gap" <?php echo ($content_type == 'photo_essay')?'checked':''; ?> />
                                <label for="photo_essay">photo essay</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="podcast" value="podcast" class="with-gap" <?php echo ($content_type == 'podcast')?'checked':''; ?> />
                                <label for="podcast">podcast</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="series" value="series" class="with-gap" <?php echo ($content_type == 'series')?'checked':''; ?> />
                                <label for="series">series</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="blog" value="blogs" class="with-gap" <?php echo ($content_type == 'blogs')?'checked':''; ?> />
                                <label for="blog">blog</label>
                            </li>
                            <li>
                                <input name="group1" type="radio" id="all" value="all" class="with-gap" <?php echo (empty($content_type) || $content_type == 'all')?'checked':''; ?> />
                                <label for="all">all</label>
                            </li>
                        </ul>
                    </div>
                    <div class="searchRelevanceType">
                        <ul>
                            <li>Sort by:</li>
                            <li>
                                <div class="selectBox">
                                <select class="browser-default" id="sort_criteria">
                                    <option value="most-recent" <?php echo (empty($sort_criteria) || $sort_criteria == 'most-recent')?'selected':''; ?>>Most Recent</option>
                                    <option value="most-viewed" <?php echo ($sort_criteria == 'most-viewed')?'selected':''; ?>>Most Viewed</option>
                                    <option value="relevance" <?php echo ($sort_criteria == 'relevance')?'selected':''; ?>>Relevance</option>
                                </select><div class="pink-arrow">&#9660;</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="datePick">
                    <ul>
                        <li>Date range:</li>
                        <li>
                            <input type="text" id="from" name="from" placeholder="From:" value="<?php echo (!empty($date_from) && $date_from != 'null')?$date_from:''; ?>" readonly></li>
                        <li>
                            <input type="text" id="to" name="to" placeholder="To:" value="<?php echo (!empty($date_to) && $date_to != 'null')?$date_to:''; ?>" readonly>
                        </li>
                        <li><a class="searchBtn" href="javascript:;" onclick="javascript:searchResult();">Search</a></li>
                    </ul>
                </div>
            </div>
            
            <?php /******* Search Results STARTS *******/ ?>
                <?php
                    if(!empty($sort_criteria)){
                        $viewDisplay = str_replace('-', '_', $sort_criteria);
                    }else{
                        $viewDisplay = 'most_recent';
                    }
                    
                    $searchView = views_get_view($viewDisplay);
                    $searchView->set_display($viewDisplay);

                    if(!empty($searchTerm)){
                        $search_term = $searchView->get_item($viewDisplay, 'filter', 'keys');
                        $search_term['value'] = str_replace('-', ' ', $searchTerm);
                        $searchView->set_item($viewDisplay, 'filter', 'keys', $search_term);
                    }

                    if(!empty($content_type) && $content_type != 'all'){
                        $content = $searchView->get_item($viewDisplay, 'filter', 'type');
                        $content['value'] = array(str_replace('podcast', 'prodcast', $content_type));
                        $searchView->set_item($viewDisplay, 'filter', 'type', $content);
                    }

                    $dateRangeArr = array();

                    if(!empty($date_from) && $date_from != 'null'){
                        $dateRangeArr['min'] = $date_from;
                    }

                    if(!empty($date_to) && $date_to != 'null'){
                        $dateRangeArr['max'] = $date_to;
                    }

                    $operator = '';

                    if(!empty($date_from) || !empty($date_to)){
                        if(!empty($dateRangeArr['min']) && !empty($dateRangeArr['max'])){
                            if($dateRangeArr['min'] == $dateRangeArr['max']){
                                $operator = '=';
                                $dateRangeArr['value'] = $dateRangeArr['min'];
                            }else{
                                $operator = 'between';
                            }
                        }else if(empty($dateRangeArr['min']) && !empty($dateRangeArr['max'])){
                            $operator = '<=';
                            $dateRangeArr['value'] = $dateRangeArr['max'];
                        }else if(empty($dateRangeArr['max']) && !empty($dateRangeArr['min'])){
                            $operator = '>=';
                            $dateRangeArr['value'] = $dateRangeArr['min'];
                        }
                    }else{
                        $operator = '<=';
                        $dateRangeArr['value'] = date('d-m-Y', strtotime('+1 day'));
                    }

                    if(!empty($dateRangeArr) && !empty($operator)){
                        $filter_date = $searchView->get_item($viewDisplay, 'filter', 'created');
                        $filter_date['operator'] = $operator;
                        $filter_date['value'] = $dateRangeArr;
                        $searchView->set_item($viewDisplay, 'filter', 'created', $filter_date);
                    }
            
                    $searchResult = get_search_view_result($searchView);

                   /*echo '<pre style="display: none">';
                    print_r($searchView);
                    echo '</pre>';*/
                    print $searchResult->render($viewDisplay);
                ?>
            <?php /******* Search Results ENDS *******/ ?>
            
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