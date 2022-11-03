<?php
/**
 * @file
 * Adaptivetheme implementation to display a node.
 *
 * Adaptivetheme variables:
 * AT Core sets special time and date variables for use in templates:
 * - $submitted: Submission information created from $name and $date during
 *   adaptivetheme_preprocess_node(), uses the $publication_date variable.
 * - $datetime: datetime stamp formatted correctly to ISO8601.
 * - $publication_date: publication date, formatted with time element and
 *   pubdate attribute.
 * - $datetime_updated: datetime stamp formatted correctly to ISO8601.
 * - $last_update: last updated date/time, formatted with time element and
 *   pubdate attribute.
 * - $custom_date_and_time: date time string used in $last_update.
 * - $header_attributes: attributes such as classes to apply to the header element.
 * - $footer_attributes: attributes such as classes to apply to the footer element.
 * - $links_attributes: attributes such as classes to apply to the nav element.
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 * @see adaptivetheme_preprocess_node()
 * @see adaptivetheme_process_node()
 */

/**
 * Hide Content and Print it Separately
 *
 * Use the hide() function to hide fields and other content, you can render it
 * later using the render() function. Install the Devel module and use
 * <?php dsm($content); ?> to find variable names to hide() or render().
 */
hide($content['comments']);
hide($content['links']);

//echo '<pre style="display: none">';print_r($body);echo '</pre>';

global $base_url;
$url = $base_url.$node_url;

//to get vzaar video details
/*require_once DRUPAL_ROOT . '/vzaar-src/Vzaar.php';
Vzaar::$token = 'SJxSbf84NUl6cJsKjCHMCMcnhF9Qvw3XpmOpD4v268';
Vzaar::$secret = 'Abbasali';*/

//Mobile detect code starts
$deviceType = '';
include_once DRUPAL_ROOT . '/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends

$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$soundEmbed = $content['field_soundcloud_embed'][0]['#markup'];

$taxonomyIdArr = array();

if(isset($content['field_tags']['#items']) && !empty($content['field_tags']['#items'])){
	foreach($content['field_tags']['#items'] as $tKey=>$term){
		$taxonomyIdArr[] = $term['tid'];
	}
}

$currPath = drupal_get_path_alias();
$currPathArr = explode('/', $currPath);
$currCategoryLink = str_replace('101-', '', $currPathArr[0]);

$currCategoryArr = explode('-', $currCategoryLink);

$currCategoryName = '';

if(count($currCategoryArr) > 1){
    $currCategoryName = ucwords(implode(' & ', $currCategoryArr));
}else{
    $currCategoryName = ucwords($currCategoryLink);
}

$currCategoryActualLink = $currPathArr[0];
$currCat1 = '';
$currCat2 = '';

if(strstr($currCategoryActualLink, '101-')){
    if(strstr($currCategoryActualLink, 'janta')){
        $currCat1 = drupal_get_normal_path($currCategoryActualLink);
        $currCat2 = drupal_get_normal_path('people');
    }else{
        $currCat1 = drupal_get_normal_path($currCategoryActualLink);
        $currCat2 = drupal_get_normal_path(str_replace('101-', '', $currCategoryActualLink));
    }
}else{
    if(strstr($currCategoryActualLink, 'people')){
        $currCat1 = drupal_get_normal_path($currCategoryActualLink);
        $currCat2 = drupal_get_normal_path('101-janta');
    }else{
        $currCat1 = drupal_get_normal_path($currCategoryActualLink);
        $currCat2 = drupal_get_normal_path('101-'.$currCategoryActualLink);
    }
}

$currCat1 = explode('/', $currCat1);
$currCat2 = explode('/', $currCat2);

$currCategoryTidArr = array($currCat1[2], $currCat2[2]);

$mostPopView = get_views_data('most_popular', 'block', array(0 => array('name' => 'field_article_category_tid', 'value' => $currCategoryTidArr)), array($node->nid));
$mostPopResArr = $mostPopView->result;

$mostPopResArrSorted = array();

foreach($mostPopResArr as $kPop => $popular){
    $pageViewCount = 0;
    
    if(isset($popular->google_analytics_counter_storage_pageview_total) && !empty($popular->google_analytics_counter_storage_pageview_total)){
        $pageViewCount = $popular->google_analytics_counter_storage_pageview_total;
    }else{
        $pageViewCount = $kPop;
    }
    //$mostPopResArrSorted[$popular->node_counter_totalcount] = $popular; // keeping array key as total view for sorting by most views
    $mostPopResArrSorted[$pageViewCount] = $popular; // keeping array key as total view for sorting by most views
}

krsort($mostPopResArrSorted); // sorting array based on key(total views) in descinding order | most viewed first

//echo '<pre style="display:none">';print_r($mostPopResArrSorted);echo '</pre>';
//echo '<pre style="display:none">';print_r(render($mostPopResArr[0]->field_field_thumb_image));echo '</pre>';

/*
 * call the prev next function defined in custom_next_prev module
 * It takes 2 parameters
 * 1st is node id of the currently view node
 * 2nd is an array which needs a key as not_in or in for excluding a contenttype or showing only particular contenttype respectively
*/
$srView = get_views_data('series_related', 'block', array(0 => array('name' => 'field_series_stories_nid', 'value' => array($node->nid))), array($node->nid));

// series next - prev starts here
$nidArr = array();
// get all the nid of the related series
foreach($srView->result as $id=>$relatedArt){
	$nidArr[$id] = $relatedArt->nid;
}
// sort it in asc order
sort($nidArr);

$prevId = "";
$nextId = "";

// get the min and max id
foreach($nidArr as $id=>$nodeId){
	if($node->nid > $nodeId){
		$prevId = $nodeId;
	}
	if($node->nid < $nodeId){
		$nextId = $nodeId;
		break;
	}
}
// series next - prev ends here


$similarArticleType = field_get_items('node', $node, 'field_article_category');
$similarArticleTypeObj = taxonomy_term_load($similarArticleType[0]['tid']);
$next_prev = custom_prev_next_node($prevId, $nextId, $similarArticleTypeObj->tid, $node->nid, array('not_in' => array('page', 'series')));

$nextLink = '';
$prevLink = '';

if(isset($next_prev['next']['link']) && !empty($next_prev['next']['link'])){
	$nextLink = $next_prev['next']['link'];
}

if(isset($next_prev['prev']['link']) && !empty($next_prev['prev']['link'])){
	$prevLink = $next_prev['prev']['link'];
}

if((count($nidArr) >0) && ($prevId=="")){
	$prevLink = "";
}
if((count($nidArr) >0) && ($nextId=="")){
	$nextLink = "";
}

$twitterShare = str_replace('#', '%23', $title);

if(strlen($twitterShare) > 125){
	$pos = strpos(htmlentities($twitterShare), ' ', 125);
	if($pos != FALSE){
		$twitterShare = substr(htmlentities($twitterShare), 0, $pos) . '...';
	}
}

$twitterShare = addslashes(strip_tags($twitterShare));

/*$statistics = statistics_get($node->nid);
$totalViews = $statistics['totalcount'];*/
$statistics = google_analytics_counter_display('node/' . $node->nid);
$totalViews = strip_tags($statistics);
$totalViewsStr = '';

if($totalViews > 999999999){
	$totalViews = round($totalViews/1000000000, 1);
	$totalViewsStr = $totalViews . 'B';
}else if($totalViews > 999999){
	$totalViews = round($totalViews/1000000, 1);
	$totalViewsStr = $totalViews . 'M';
}else if($totalViews > 999){
	$totalViews = round($totalViews/1000, 1);
	$totalViewsStr = $totalViews . 'K';
}else{
	$totalViewsStr = $totalViews;
}

$bannerImageUri = "";
$bannerAlt = "";
$bannerTtl = "";

if(isset($content['field_cover_image'])){
    $bannerImageUri = $content['field_cover_image'][0]['#item']['uri'];
    if(!empty($content['field_cover_image'][0]['#item']['alt'])){
        $bannerAlt = $content['field_cover_image'][0]['#item']['alt'];
    }else{
        $bannerAlt = $title;
    }
    
    if(!empty($content['field_cover_image'][0]['#item']['title'])){
        $bannerTtl = $content['field_cover_image'][0]['#item']['title'];
    }else{
        $bannerTtl = $title;
    }
}else{
    $bannerImageUri = $content['field_thumb_image'][0]['#item']['uri'];
    if(!empty($content['field_thumb_image'][0]['#item']['alt'])){
        $bannerAlt = $content['field_thumb_image'][0]['#item']['alt'];
    }else{
        $bannerAlt = $title;
    }
    
    if(!empty($content['field_thumb_image'][0]['#item']['title'])){
        $bannerTtl = $content['field_thumb_image'][0]['#item']['title'];
    }else{
        $bannerTtl = $title;
    }
}

$bannerImage = image_style_url('big_image', $bannerImageUri);

$similarStoriesRes = array();

if(!empty($taxonomyIdArr)){
    $similarStories = get_views_data('related_stories', 'block', array(0 => array('name' => 'field_tags_tid', 'value' => $taxonomyIdArr), 1 => array('name' => 'nid', 'value' => array($node->nid))));

    $similarCount = count($similarStories->result);
}

if($similarCount > 0){
    $similarStoriesRes = $similarStories->result;
}

//echo '<pre style="display:none">Original Result: ';print_r($similarStoriesRes);echo '</pre>';

shuffle($similarStoriesRes); // to randomize the result

//echo '<pre style="display:none">Twitter: ';print_r($node->nid);echo '</pre>';

$breadcrumb = drupal_get_breadcrumb();

$breadcrumbHTML = theme('breadcrumb', array('breadcrumb' => $breadcrumb));

//echo '<pre style="display:none">Twitter: ';print_r($breadcrumbHTML);echo '</pre>';

drupal_add_js("$(document).ready(function() {
        $('.addIconsBtn').on('click',function(){
            $('.socialHidden').fadeIn();
        });

        $('.closeIconBtn').on('click',function(){
            $('.socialHidden').fadeOut();
        });
    });", array('type' => 'inline', 'group' => JS_THEME, 'weight' => 100));
?>

<div class="pageBanner article">
    <img class="bannerImg" src="<?php echo $bannerImage; ?>" alt="<?php echo $bannerAlt; ?>" title="<?php echo $bannerTtl; ?>">
    
    <div class="articleContent">
        <div class="lhsContent">
            <?php /*<div class="breadCrumbs">
                <ul>
                    <li><a href="/">Home</a><span> &gt;&gt; </span></li>
                    <li><a href="/<?php echo $currCategoryLink; ?>"><?php echo $currCategoryName; ?></a><span> &gt;&gt; </span></li>
                    <li><span><?php echo $title; ?></span></li>
                </ul>
            </div>*/ ?>
            <?php print $breadcrumbHTML; ?>
            <div class="articleSummary">
                <h1><?php echo $title;?></h1>
                <?php /* ?><div class="metaDate"><?php echo date('F j, Y',$content['body']['#object']->published_at);?></div><?php */ ?>
                <div class="podcastContainer">
                    <?php print_r($soundEmbed); ?>
                </div>
                <?php print $body[0]['value']; ?>
            </div>
        </div>
        <div class="rhsContent">
            <div class="socialContent">
                <div class="socialIconsContainer">
                    <div class="socialVisible">
                        <ul>
                            <li><a href="javascript:;" onClick="socialIcons('facebook','<?php echo $url;?>');"><img src="<?php echo $image_url; ?>fb-101.png" alt="Facebook" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('twitter','<?php echo $url;?>','<?php echo $twitterShare;?>');"><img src="<?php echo $image_url; ?>twitter-101.png" alt="Twitter" /></a></li>
                            <!-- <li><a href="javascript:;" onClick="socialIcons('gplus','<?php echo $url;?>');"><img src="<?php echo $image_url; ?>gplus-101.png" alt="Google Plus" /></a></li> -->
                            <?php if($deviceType=='phone'){ ?>	
								<li><a href='whatsapp://send?text="<?php echo urlencode($title);?>" - <?php echo $url;?>' data-action='share/whatsapp/share'>
								<img src="<?php echo $image_url; ?>whatsapp-101.png" alt="WhatsApp" /></a></li>
							<?php	}else{ ?>				
									<li><a href="mailto:?subject=Share%20From%20101%20India&body=<?php echo $title." - ".$url;?>"><img src="<?php echo $image_url; ?>message-icon-101.png" alt="Message Icon" /></a></li>
							<?php	}	?>
                            <li><a class="addIconsBtn" href="javascript:;"><i class="mdi-content-add-circle"></i></a></li>
                        </ul>
                    </div>
                    <div class="socialHidden" style="display: none;">
                        <div class="shareTxt">
                            <span class="share">SHARE</span>
                            <a class="closeIconBtn" href="javascript:;"><i class="mdi-navigation-cancel"></i></a>
                            <div class="clear"></div>
                        </div>
                        <ul>
                            <li><a href="javascript:;" onClick="socialIcons('reddit','<?php echo $url;?>','<?php echo $title;?>');"><img src="<?php echo $image_url; ?>reddit-social-101.png" alt="Reddit" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('pinterest','<?php echo $url;?>','<?php echo $title;?>','<?php echo $bannerImage; ?>');"><img src="<?php echo $image_url; ?>pinterst-social-101.png" alt="pinterest" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('tumblr','<?php echo $url;?>','<?php echo $title;?>','','<?php echo $body[0]['summary']; ?>');"><img src="<?php echo $image_url; ?>tumblr-social-101.png" alt="Tumblr" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('delicious','<?php echo $url;?>');"><img src="<?php echo $image_url; ?>delicious-social-101.png" alt="Delicious" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('digg','<?php echo $url;?>','<?php echo $title;?>');"><img src="<?php echo $image_url; ?>digg-social-101.png" alt="Digg Social" /></a></li>
                            <?php /*<li><a href="javascript:;" onClick="socialIcons();"><img src="<?php echo $image_url; ?>top-odkazy-social-101.png" /></a></li>*/ ?>
                    <?php /*        <li><a href="javascript:;" onClick="socialIcons('instapaper','<?php echo $url;?>');"><img src="<?php echo $image_url; ?>i-social-101.png" /></a></li>
                     */ ?>       
							<?php /*<li><a href="javascript:;" onClick="insta();"><img src="<?php echo $image_url; ?>i-social-101.png" /></a></li>*/ ?>
                            <li><a href="javascript:;" onClick="socialIcons('linkedin','<?php echo $url;?>');"><img src="<?php echo $image_url; ?>linkedIn-101.png" alt="LinkedIn" /></a></li>
							<?php if($deviceType!='computer'){ ?>	
									<li><a href="mailto:?subject=Share%20From%20101%20India&body=<?php echo $title." - ".$url;?>"><img src="<?php echo $image_url; ?>message-inner-101.png" alt="Message" /></a></li>
							<?php	}	?>
                            <?php /*<li><a href="javascript:;" onClick="socialIcons();"><img src="<?php echo $image_url; ?>notes-101.png" /></a></li>*/ ?>
                        </ul>
                    </div>
                </div>
                <?php /*<div class="viewCount"><?php echo $totalViewsStr;?> <?php echo ($totalViews==0 || $totalViews > 1)?'Views':'View'; ?></div>*/ ?>
                <h2 class="popTitle">Most Popular</h2>
                <div class="clear"></div>
            </div>
            <div class="popularSection sidebar">
                <?php if(!empty($mostPopResArrSorted)){
                $mostPopCounter = 0; ?>
                <div class="popularContent">
                    <ul>
                    <?php foreach($mostPopResArrSorted as $kMos=>$mosPop){
                        if($mostPopCounter < 8){
                            $mosPopNode = $mosPop->_field_data['nid']['entity'];
									
                            $mosPopTitle = html_entity_decode($mosPopNode->title, ENT_NOQUOTES, 'UTF-8');
                            
                            if(strlen($mosPopTitle) > 70){
                                $pos = strpos($mosPopTitle, ' ', 65);
                        
                                if(!$pos){
                                    $pos = strpos($mosPopTitle, ' ', 45);
                                }
                                
                                $mosPopTitle = substr($mosPopTitle, 0, $pos);
                                $mosPopTitle .= '...';
                            }else{
                                $mosPopTitle = $mosPopTitle;
                            }
                            
                            $mosPopImg = '';
                            $mosPopAlt = '';
                            $mosPopTtl = '';

                            $mosPopThbImg = field_get_items('node', $mosPopNode, 'field_thumb_image');
                            $mosPopImg = image_style_url('most_popular', $mosPopThbImg[0]['uri']);

                            if(!empty($mosPopThbImg[0]['alt'])){
                                $mosPopAlt = $mosPopThbImg[0]['alt'];
                            }else{
                                $mosPopAlt = $mosPopThbImg->title;
                            }

                            if(!empty($mosPopThbImg[0]['title'])){
                                $mosPopTtl = $mosPopThbImg[0]['title'];
                            }else{
                                $mosPopTtl = $mosPopThbImg->title;
                            }
                            
                            if($mosPopNode->type == 'videos'){
                                $mosPopvidDur = field_get_items('node', $mosPopNode, 'field_vzaar_video_duration');
                                $mosPopClass = 'play';
                                
                                $vidTimeStamp = '';
                                
                                /*if(!empty($mosPop->field_data_field_embed_video_field_embed_video_video_url)){
                                    $ytVidUrl = strpos($mosPop->field_data_field_embed_video_field_embed_video_video_url, '?v=');
                                    $ytVidId = substr($mosPop->field_data_field_embed_video_field_embed_video_video_url, $ytVidUrl + 3);
                                    $ytDataUrl = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id='.$ytVidId.'&key=AIzaSyAiwWY-OB3DvxUm9WZAoT6MUHSyg8Le2MY';
                                    
                                    $ch = curl_init($ytDataUrl);

                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                    $youtubeData = curl_exec($ch);

                                    curl_close($ch);

                                    $youtubeDataArr = json_decode($youtubeData, 1);
                                    $ytReturnedTime = $youtubeDataArr['items'][0]['contentDetails']['duration'];
                                    
                                    $timeArr = explode('M', $ytReturnedTime);
                                    $min = explode('PT', $timeArr[0]);
                                    $min = (strlen($min[1]) == 1)?'0'.$min[1]:$min[0];
                                    
                                    $sec = explode('S', $timeArr[1]);
                                    $sec = (strlen($sec[0]) == 1)?'0'.$sec[0]:$sec[0];
                                    
                                    $vidTimeStamp = $min . ':' . $sec;
                                    
                                    //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                                }*/
                                if(!empty($mosPopvidDur[0]['value'])){
                                    $vidTimeStamp = $mosPopvidDur[0]['value'];
                                    //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                                }
                                else{
                                    $vidTimeStampSecs = $mosPop->field_field_brightcove_video[0]['rendered']['#video']->length;
                                    
                                    $min = ($vidTimeStampSecs/1000/60) << 0;
                                    $sec = round(($vidTimeStampSecs/1000) % 60);
                                    $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
                                    
                                    //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                                }                                
                                
                                $mosPopTimeStamp = '<span class="playTime">' . $vidTimeStamp . '</span>';
                            }else{
                                $mosPopClass = 'read';
                                $mosPopTimeStamp = '';
                            }
                            
                            $mosPopPath = url('node/' . $mosPopNode->nid, array('absolute' => true));
                            
                            $mosPopDate = date('M j, Y', $mosPopNode->created);
                        ?>
                        <li class="popularItems">
                            <div class="dataContainer">
                                <div class="imageContent">
                                    <a class="detailLink" href="<?php echo $mosPopPath; ?>">
                                        <img class="imgpost" src="<?php echo $mosPopImg; ?>" alt="<?php echo $mosPopAlt; ?>" title="<?php echo $mosPopTtl; ?>">
                                    </a>
                                    <a href="<?php echo $mosPopPath; ?>">
                                        <span class="<?php echo $mosPopClass; ?>"></span>
                                        <?php print $mosPopTimeStamp; ?>
                                    </a>
                                </div>
                                <div class="summary">
                                    <h2><a href="<?php echo $mosPopPath; ?>"><?php echo $mosPopTitle; ?></a></h2>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </li>
                        <?php }else{
                            break;
                        }
                            $mostPopCounter++;
                        } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="commentBox">
        <h2>Comments</h2>
        <div id="comments"><div class="fb-comments" data-href="<?php echo $url;?>" data-width="100%" data-numposts="4" data-colorscheme="light"></div></div>
    </div>
    
    <?php if($similarCount > 0){
        $similarCounter = 0; ?>
    <div class="relatedVideosSection">
        <div class="queueTitle"><h2>You May Also Like</h2></div>
        <ul>
        <?php foreach($similarStoriesRes as $kSim=>$similarStories){
            if($similarCounter < 5){
                if($similarStories->nid == $node->nid){
                    continue;
                }else{
                    $similarCounter++;
                }
                $similarNode = $similarStories->_field_data['nid']['entity'];
									
                $similarTitle = html_entity_decode($similarNode->title, ENT_NOQUOTES, 'UTF-8');
                
                if(strlen($similarTitle) > 70){
                    $pos = strpos($similarTitle, ' ', 65);
                        
                    if(!$pos){
                        $pos = strpos($similarTitle, ' ', 45);
                    }
                    
                    $similarTitle = substr($similarTitle, 0, $pos);
                    $similarTitle .= '...';
                }else{
                    $similarTitle = $similarTitle;
                }

                $similarDate = date('M j, Y', $similarNode->created);

                $similarImg = '';
                $similarAlt = '';
                $similarTtl = '';

                $similarThbImg = field_get_items('node', $similarNode, 'field_thumb_image');

                $similarImg = image_style_url('must_watch', $similarThbImg[0]['uri']);

                if(!empty($similarThbImg[0]['alt'])){
                    $similarAlt = $similarThbImg[0]['alt'];
                }else{
                    $similarAlt = $similarNode->title;
                }

                if(!empty($similarThbImg[0]['title'])){
                    $similarTtl = $similarThbImg[0]['title'];
                }else{
                    $similarTtl = $similarNode->title;
                }
                
                if($similarNode->type == 'videos'){
                    $mosPopvidDur = field_get_items('node', $similarNode, 'field_vzaar_video_duration');
                    $similarContentClass = 'play';
                    
                    $vidTimeStamp = '';
                                
                    /*if(!empty($similarStories->field_data_field_embed_video_field_embed_video_video_url)){
                        $ytVidUrl = strpos($similarStories->field_data_field_embed_video_field_embed_video_video_url, '?v=');
                        $ytVidId = substr($similarStories->field_data_field_embed_video_field_embed_video_video_url, $ytVidUrl + 3);
                        $ytDataUrl = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id='.$ytVidId.'&key=AIzaSyAiwWY-OB3DvxUm9WZAoT6MUHSyg8Le2MY';

                        $ch = curl_init($ytDataUrl);

                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        $youtubeData = curl_exec($ch);

                        curl_close($ch);

                        $youtubeDataArr = json_decode($youtubeData, 1);
                        $ytReturnedTime = $youtubeDataArr['items'][0]['contentDetails']['duration'];

                        $timeArr = explode('M', $ytReturnedTime);
                        $min = explode('PT', $timeArr[0]);
                        $min = (strlen($min[1]) == 1)?'0'.$min[1]:$min[0];

                        $sec = explode('S', $timeArr[1]);
                        $sec = (strlen($sec[0]) == 1)?'0'.$sec[0]:$sec[0];

                        $vidTimeStamp = $min . ':' . $sec;

                        //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                    }
                       else if(!empty($similarStories->_field_data['nid']['entity']->field_vzaar_video_url['und'][0]['value'])){
                           # code...
                                $parts = explode("/", $similarStories->_field_data['nid']['entity']->field_vzaar_video_url['und'][0]['value']);
                                $videodetail=Vzaar::getVideoDetails($parts[3], true);
                                $vidTimeStampSecs=$videodetail->duration*1000;
                                $min = ((int)$vidTimeStampSecs/1000/60) << 0;
                                $sec = round(((int)$vidTimeStampSecs/1000) % 60);
                                $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
                       }*/
                    if(!empty($mosPopvidDur[0]['value'])){
                            $vidTimeStamp = $mosPopvidDur[0]['value'];
                            //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                        }
                    else{
                        $vidTimeStampSecs = $similarStories->field_field_brightcove_video[0]['rendered']['#video']->length;

                        $min = ($vidTimeStampSecs/1000/60) << 0;
                        $sec = round(($vidTimeStampSecs/1000) % 60);
                        $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

                        //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                    }                                

                    $similarTimeStamp = '<span class="playTime">' . $vidTimeStamp . '</span>';
                }else{
                    $similarContentClass = 'read';
                    $similarTimeStamp = '';
                }

                $similarPath = url('node/' . $similarNode->nid, array('absolute' => true));
        ?>
            <li>
                <div class="relatedContent">
                    <a href="<?php echo $similarPath; ?>">
                        <div class="videoQueue">
                            <img src="<?php echo $similarImg; ?>" alt="<?php echo $similarAlt; ?>" title="<?php echo $similarTtl; ?>">
                            <span class="<?php echo $similarContentClass; ?>"></span>
                            <?php print $similarTimeStamp; ?>
                        </div>
                        <div class="queueDesc">
                            <h2><?php echo $similarTitle; ?></h2>
                        </div>
                        <div class="clear"></div>
                    </a>
                </div>
            </li>
        <?php }
        } ?>
       </ul>
    </div>
    <?php } ?>
    
    <?php if(!empty($srView->result)){ ?>
    <div class="relatedVideosSection">
        <div class="queueTitle"><h2>FROM THE SAME SERIES</h2></div>
        <ul>
        <?php foreach($srView->result as $kSer=>$seriesStories){
            $seriesNode = $seriesStories->_field_data['nid']['entity'];
    
            if($seriesStories->nid == $node->nid){
                continue;
            }
									
            $seriesTitle = html_entity_decode($seriesNode->title, ENT_NOQUOTES, 'UTF-8');
                        
            if(strlen($seriesTitle) > 70){
                $pos = strpos($seriesTitle, ' ', 65);
                        
                if(!$pos){
                    $pos = strpos($seriesTitle, ' ', 45);
                }
                
                $seriesTitle = substr($seriesTitle, 0, $pos);
                $seriesTitle .= '...';
            }else{
                $seriesTitle = $seriesTitle;
            }

            $seriesDate = date('M j, Y', $seriesNode->created);

            $seriesImg = '';
            $seriesAlt = '';
            $seriesTtl = '';

            $seriesThbImg = field_get_items('node', $seriesNode, 'field_thumb_image');

            $seriesImg = image_style_url('must_watch', $seriesThbImg[0]['uri']);

            if(!empty($seriesThbImg[0]['alt'])){
                $seriesAlt = $seriesThbImg[0]['alt'];
            }else{
                $seriesAlt = $seriesNode->title;
            }

            if(!empty($seriesThbImg[0]['title'])){
                $seriesTtl = $seriesThbImg[0]['title'];
            }else{
                $seriesTtl = $seriesNode->title;
            }

            if($seriesNode->type == 'videos'){
                $mosPopvidDur = field_get_items('node', $seriesNode, 'field_vzaar_video_duration');
                $seriesContentClass = 'play';
                
                $vidTimeStamp = '';
                                
                /*if(!empty($seriesStories->field_data_field_embed_video_field_embed_video_video_url)){
                    $ytVidUrl = strpos($seriesStories->field_data_field_embed_video_field_embed_video_video_url, '?v=');
                    $ytVidId = substr($seriesStories->field_data_field_embed_video_field_embed_video_video_url, $ytVidUrl + 3);
                    $ytDataUrl = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id='.$ytVidId.'&key=AIzaSyAiwWY-OB3DvxUm9WZAoT6MUHSyg8Le2MY';

                    $ch = curl_init($ytDataUrl);

                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    $youtubeData = curl_exec($ch);

                    curl_close($ch);

                    $youtubeDataArr = json_decode($youtubeData, 1);
                    $ytReturnedTime = $youtubeDataArr['items'][0]['contentDetails']['duration'];

                    $timeArr = explode('M', $ytReturnedTime);
                    $min = explode('PT', $timeArr[0]);
                    $min = (strlen($min[1]) == 1)?'0'.$min[1]:$min[0];

                    $sec = explode('S', $timeArr[1]);
                    $sec = (strlen($sec[0]) == 1)?'0'.$sec[0]:$sec[0];

                    $vidTimeStamp = $min . ':' . $sec;

                    //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                }
                   else if(!empty($seriesStories->_field_data['nid']['entity']->field_vzaar_video_url['und'][0]['value'])){
                           # code...
                                $parts = explode("/", $seriesStories->_field_data['nid']['entity']->field_vzaar_video_url['und'][0]['value']);
                                $videodetail=Vzaar::getVideoDetails($parts[3], true);
                                $vidTimeStampSecs=$videodetail->duration*1000;
                                $min = ((int)$vidTimeStampSecs/1000/60) << 0;
                                $sec = round(((int)$vidTimeStampSecs/1000) % 60);
                                $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
                       }*/
                if(!empty($mosPopvidDur[0]['value'])){
                        $vidTimeStamp = $mosPopvidDur[0]['value'];
                        //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                    }
                else{
                    $vidTimeStampSecs = $seriesStories->field_field_brightcove_video[0]['rendered']['#video']->length;

                    $min = ($vidTimeStampSecs/1000/60) << 0;
                    $sec = round(($vidTimeStampSecs/1000) % 60);
                    $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

                    //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
                }                                

                $seriesTimeStamp = '<span class="playTime">' . $vidTimeStamp . '</span>';
            }else{
                $seriesContentClass = 'read';
                $seriesTimeStamp = '';
            }

            $seriesPath = url('node/' . $seriesNode->nid, array('absolute' => true));
        ?>
            <li>
                <div class="relatedContent">
                    <a href="<?php echo $seriesPath; ?>">
                        <div class="videoQueue">
                            <img src="<?php echo $seriesImg; ?>" alt="<?php echo $seriesAlt; ?>" title="<?php echo $seriesTtl; ?>">
                            <span class="<?php echo $seriesContentClass; ?>"></span>
                            <?php print $seriesTimeStamp; ?>
                        </div>
                        <div class="queueDesc">
                            <h2><?php echo $seriesTitle; ?></h2>
                        </div>
                        <div class="clear"></div>
                    </a>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>
<?php if($deviceType=='phone'){ ?>	
<div class="socialftr">
		<ul>
			<li><a href='whatsapp://send?text="<?php echo urlencode($title);?>" - <?php echo $pageURL;?>' data-action='share/whatsapp/share'>
				<img src="<?php echo $image_url; ?>wht_ftr.jpg" /></a></li>
			<li><a href="javascript:;" onClick="socialIcons('facebook','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>fb_ftr.jpg" /></a></li>
			<li><a href="javascript:;" onClick="socialIcons('twitter','<?php echo $pageURL;?>','<?php echo $twitterShare;?>');"><img src="<?php echo $image_url; ?>tw_ftr.jpg" /></a></li>
			<li><a href="javascript:;" onClick="socialIcons('gplus','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>gp_ftr.jpg" /></a></li>
		</ul>
	</div>
<script>
$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 50) {
        $('.socialftr').fadeIn();
    } else {
        $('.socialftr').fadeOut();
    }

});
</script>
<?php	} ?>