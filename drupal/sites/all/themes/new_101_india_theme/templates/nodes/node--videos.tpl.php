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
 
/* //to get vzaar video details
require_once '/mnt/vol1/101india.com/vzaar-src/Vzaar.php';
Vzaar::$token = 'SJxSbf84NUl6cJsKjCHMCMcnhF9Qvw3XpmOpD4v268';
Vzaar::$secret = 'Abbasali';*/

//echo '<pre style="display: none">Node obj is: ';print_r($node);echo '</pre>';

//Mobile detect code starts
$deviceType = '';
include_once DRUPAL_ROOT . '/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends

	hide($content['comments']);
	hide($content['links']);
	
	global $base_url;

    $image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

	$pageURL = $base_url.$node_url;
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
	
	$pageImage = '';
	$imageAlt = '';
	$imageTitle = '';
	
	if(isset($content['field_cover_image']['#items']) && !empty($content['field_cover_image']['#items'])){
		$image = field_get_items('node', $node, 'field_cover_image');
		
		$pageImage = image_style_url('hp_series', $image[0]['uri']);
		
		if(!empty($image[0]['alt'])){
			$imageAlt = $image[0]['alt'];
		}else{
			$imageAlt = $title;
		}
		  
		if(!empty($image[0]['title'])){
			$imageTitle = $image[0]['title'];
		}else{
			$imageTitle = $title;
		}
	}else{
		$image = field_get_items('node', $node, 'field_thumb_image');
		
		$pageImage = image_style_url('hp_series', $image[0]['uri']);
		
		if(!empty($image[0]['alt'])){
			$imageAlt = $image[0]['alt'];
		}else{
			$imageAlt = $title;
		}
		  
		if(!empty($image[0]['title'])){
			$imageTitle = $image[0]['title'];
		}else{
			$imageTitle = $title;
		}
	}
	
$taxonomyIdArr = array();

if(isset($content['field_tags']['#items']) && !empty($content['field_tags']['#items'])){
	foreach($content['field_tags']['#items'] as $tKey=>$term){
		$taxonomyIdArr[] = $term['tid'];
	}
}

if(!empty($taxonomyIdArr)){
    
    $similarStories = get_views_data('related_stories', 'block', array(0 => array('name' => 'field_tags_tid', 'value' => $taxonomyIdArr), 1 => array('name' => 'type_1', 'value' => array('videos')), 2 => array('name' => 'nid', 'value' => array($node->nid))));

    $similarCount = count($similarStories->result);
    
}



if($similarCount > 0){
    $similarStoriesRes = $similarStories->result;
    $vzaarOverlaydata= $similarStories->result;
}
//echo '<pre style="display:none">Original Result1: '; print_r($similarStoriesRes); echo '</pre>';

//Video Overlay next video start

$nodeidoverlayarray = array();
$overcounter = 0;
//echo '<pre style="display: none;">';print_r($nodeidoverlayarray);echo '</pre>';
foreach($vzaarOverlaydata as $overlaykey=>$overlayarray){
    if($node->nid == $overlayarray->nid){
        continue;
    } else {
        if($overcounter < 8){
            $nodeidoverlayarray[$overlayarray->nid] = $overlayarray;
        } else {
            break;
        }
        $overcounter++;
    }
}
if(!empty($nodeidoverlayarray)){
$counterless = 0;
//$nextvidnid = '';
$overlayniddata = array_keys($nodeidoverlayarray);

/*foreach($overlayniddata as $overlaynidkey=>$overlaynids){
echo '<pre style="display: none;">current';print_r($node->nid);echo '</pre>';
//print_r($overlaynids);
    if($overlaynids < $node->nid){
        $nextvidnid = $overlaynids;
//        echo '<pre style="display: none;">insideif';print_r($nextvidnid);echo '</pre>';
        $counterless++;
        break;
        
    }
}*/

/*echo '<pre style="display: none;">count';print_r ($nextvidnid);echo '</pre>';*/
/*if($counterless == 0){
    $nextvidnid  = $overlayniddata[0];
}

$redrtpath = url('node/' . $nextvidnid, array('absolute' => true));
//$vzrOverlaydataTitlenext = htmlentities($overlaynids->title);

//echo '<pre style="display: none;">vdvds';print_r($nextvidnid);echo '</pre>';
$vzrOverlaydataNodenext = $nodeidoverlayarray[$nextvidnid]->_field_data['nid']['entity'];
                //echo "next----";print_r($vzrOverlaydataNode);       

                                    
                $vzrOverlaydataTitlenext = htmlentities($vzrOverlaydataNodenext->title);
                $vzrOverlaydatadescnext = htmlentities($vzrOverlaydataNodenext->body['und'][0]['value']);
                $vzrOverlaydatadescnext=str_replace("&lt;p&gt;", "",$vzrOverlaydatadescnext);
                $vzrOverlaydatadescnext=str_replace("&lt;/p&gt;", "",$vzrOverlaydatadescnext);
               // echo "<pre>";print_r($vzrOverlaydatadesc); echo"</pre>";
                
                if(strlen($vzrOverlaydataTitlenext) > 70){
                    $vzrOverlaydataTitlenext = substr($vzrOverlaydataTitlenext, 0, strpos($vzrOverlaydataTitlenext, ' ', 65));
                    $vzrOverlaydataTitlenext .= '...';
                }else{
                    $vzrOverlaydataTitlenext = $vzrOverlaydataTitlenext;
                }

                if(strlen($vzrOverlaydatadescnext) > 100){
                    $vzrOverlaydatadescnext = substr($vzrOverlaydatadescnext, 0, strpos($vzrOverlaydatadescnext, ' ', 65));
                    $vzrOverlaydatadescnext .= '...';
                }else{
                    $vzrOverlaydatadescnext = $vzrOverlaydatadescnext;
                }
   
                $vzrOverlaydataDatenext = date('M j, Y', $vzrOverlaydataNodenext->created);

                 
                $vzrOverlaydataImgnext = '';
                $vzrOverlaydataAltnext = '';
                $vzrOverlaydataTtlnext = '';

              


                $vzrOverlaydataThbImgnext = field_get_items('node', $vzrOverlaydataNodenext, 'field_thumb_image');

  
                $vzrOverlaydataImgnext = image_style_url('must_watch', $vzrOverlaydataThbImgnext[0]['uri']);

                if(!empty($vzrOverlaydataThbImgnext[0]['alt'])){
                    $vzrOverlaydataAltnext = $vzrOverlaydataThbImgnext[0]['alt'];
                }else{
                    $vzrOverlaydataAltnext = $vzrOverlaydataNodenext->title;
                }

                if(!empty($vzrOverlaydataThbImgnext[0]['title'])){
                    $vzrOverlaydataTtlnext = $vzrOverlaydataThbImgnext[0]['title'];
                }else{
                    $vzrOverlaydataTtlnext = $vzrOverlaydataNodenext->title;
                }
                
                if($vzrOverlaydataNodenext->type == 'videos'){
                    $mosPopvidDur = field_get_items('node', $vzrOverlaydataNodenext, 'field_vzaar_video_duration');
                    $vzrOverlaydataContentClass = 'play';
                    
                    $vidTimeStamp = '';
                                
                    if(!empty($mosPopvidDur[0]['value'])){
                        $vidTimeStamp = $mosPopvidDur[0]['value'];
                        //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                    }     
                    else {
                        $vidTimeStampSecs = $nodeidoverlayarray[$nextvidnid]->field_field_brightcove_video[0]['rendered']['#video']->length;

                        $min = ($vidTimeStampSecs/1000/60) << 0;
                        $sec = round(($vidTimeStampSecs/1000) % 60);
                        $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
                       }
                                              

                    $vzrOverlaydataTimeStamp = '<span class="playTime">' . $vidTimeStamp . '</span>';
                    }else{
                        $vzrOverlaydataContentClass = 'read';
                        $vzrOverlaydataTimeStamp = '';
                    }
                $vzrOverlaydataPathnext = url('node/' . $vzrOverlaydataNodenext->nid, array('absolute' => true));*/

    }

//echo '<pre style="display:none">Original Result: ';print_r($vzrOverlaydataPathnext);echo '</pre>';

// video overlay end

//echo '<pre style="display:none">Original Result: ';print_r($similarStoriesRes);echo '</pre>';

shuffle($similarStoriesRes); // to randomize the result

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

$mostPopView = get_views_data('most_popular', 'block', array(0 => array('name' => 'type', 'value' => array('videos'))), array($node->nid));
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

/*
 * call the prev next function defined in custom_next_prev module
 * It takes 2 parameters
 * 1st is node id of the currently view node
 * 2nd is an array which needs a key as not_in or in for excluding a contenttype or showing only particular contenttype respectively
*/

$srView = get_views_data('series_related', 'block', array(0 => array('name' => 'field_series_stories_nid', 'value' => array($node->nid)), 1 => array('name' => 'type', 'value' => array('videos'))), array($node->nid));

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
// if its a part of the series and there is no next or prev id present, do not show next/prev link
if((count($nidArr) >0) && ($prevId=="")){
	$prevLink = "";
}
if((count($nidArr) >0) && ($nextId=="")){
	$nextLink = "";
}

$isBrightcove = "";
$vdzvideoid = "";
//echo '<pre style="display: none">';print_r($content['field_brightcove_video']);echo '</pre>';
if(!empty($content['field_vzaar_video_url']['#object']->field_vzaar_video_url['und'][0]['value'])){
    $isBrightcove = "vzaar";

    $brightcoveVideo = $content['field_vzaar_video_url']['#object']->field_vzaar_video_url['und'][0]['value'];
    $brightcoveVideoID = str_replace("video", "player", $brightcoveVideo);
    $brightcoveVideoID = str_replace("http://", "https://", $brightcoveVideoID);
    $vzaarurl=$brightcoveVideoID."?apiOn=true";

    $vdzvideoid = explode("/", $content['field_vzaar_video_url']['#object']->field_vzaar_video_url['und'][0]['value']);
    $vdzvideoid=$vdzvideoid[3];
    /*echo '<pre style="display: none">';print_r($vdzvideoid);echo '</pre>';*/

   // print_r($brightcoveVideo);
}
else if(!empty($content['field_brightcove_video'])){
    $isBrightcove = "brightcove";
    
    $brightcoveVideo = render($content['field_brightcove_video']);
    $brightcoveVideoID = $content['field_brightcove_video']['#items'][0]['brightcove_id'];
}
else if(!empty($content['field_vimeo_video_url'])){
    $isBrightcove = "brightvimeo";
    
    //$brightcoveVideo = render($content['field_vimeo_video_url']);
    //$vimeoVideoID = $content['field_vimeo_video_url']['#items'][0]['video_url'];
	//print_r($vimeoVideoID);
	
	$brightcoveVideo = $content['field_vimeo_video_url']['#object']->field_vimeo_video_url['und'][0]['value'];
    //$brightcoveVideoID = str_replace("video", "player", $brightcoveVideo);
    //$brightcoveVideoID = str_replace("http://", "https://", $brightcoveVideoID);
    //$vzaarurl=$brightcoveVideoID."?apiOn=true";

    $vdzvideoid = explode("/", $content['field_vimeo_video_url']['#object']->field_vimeo_video_url['und'][0]['value']);
    //$vdzvideoid=$vdzvideoid[3];
	$vimeoVideoID = $vdzvideoid[0]."//".$vdzvideoid[2]."/".$vdzvideoid[3]."/".$vdzvideoid[4];
    // echo '<pre style="display: block">';print_r($vdzvideoid);echo '</pre>';
	
	
}
else{
    $isBrightcove = "youtube";
    
    /*$youtubeVideo = $content['field_embed_video'][0][0]['#video_data']['id'];
    $youtubeVideo = explode(':', $youtubeVideo);
    $youtubeVideoId = $youtubeVideo[count($youtubeVideo) - 1];*/
    $youtubeVideo = $content['field_embed_video']['#items'][0]['video_url'];
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=embed/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $youtubeVideo, $matches);
    $youtubeVideoId = $matches[0];
}
//echo '<pre style="display:none">Original Result11: ';print_r($youtubeVideo);echo '</pre>';

//echo '<pre style="display: none">';print_r($content['field_embed_video']);echo '</pre>';

$twitterShare = html_entity_decode($title, ENT_QUOTES);
$twitterShare = str_replace('#', '%23', $title);

if(strlen($twitterShare) > 125){
	$pos = strpos($twitterShare, ' ', 125);
	if($pos != FALSE){
		$twitterShare = substr($twitterShare, 0, $pos) . '...';
	}
}

$twitterShare = addslashes(strip_tags($twitterShare));

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

$breadcrumb = drupal_get_breadcrumb();

$breadcrumbHTML = theme('breadcrumb', array('breadcrumb' => $breadcrumb));

//echo '<pre style="display: none">';print_r($twitterShare);echo '</pre>';
//echo '<pre style="display: none">';print_r($content['field_brightcove_video']);echo '</pre>';

drupal_add_css('.containing-block {
                  width: 100%;
                }
                .outer-container {
                  position: relative;
                  height: 0;
                  padding-bottom: 58.25%;
                }
                .BrightcoveExperience {
                  position: absolute;
                  top: 0;
                  left: 0;
                  width: 100%;
                  height: 100%;
                }', array('type' => 'inline')
);
drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/platform.js.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));
drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/jquery.nicescroll.js', array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));

/*drupal_add_js('var vzp="";
 var player="";

  var clock = 10;
  var countdownId = 0;

    function start() {
            //Start clock
            countdownId = setInterval("countdown()", 1000);
    }

    function countdown(){
        if(clock > 0){
            clock = clock - 1;
            $("#vdtimer").html(clock);
        }
        else {
           //Stop clock
            clearInterval(countdownId);
            $("#vidLoadr").css("display","block");
            $("#vidList").css("display","none");
           var redirect_url="'.$redrtpath.'";
            window.location.href=redirect_url;
            $("#vidLoadr").fadeIn();
            $("#vidList").fadeOut();
            //$("#vdtimer").html("0");
        }
    }', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 100));*/
?>

<?php if($isBrightcove=="youtube"){
	drupal_add_js('var tag = document.createElement("script");
	tag.src = "//www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName("script")[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
	var youtubeVideoId = "'.$youtubeVideoId.'";  
        
	
	var player;
	
	function onYouTubeIframeAPIReady() {
		player = new YT.Player("player", {
            width: "786",
            height: "452",
			videoId: youtubeVideoId,
			playerVars: {"wmode": "transparent", "rel": 0, "showinfo": 0, "autohide": 1},
			events: {
				"onReady": function(){},
				"onStateChange": onPlayerStateChange
			}
		});
	}', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 100));

	if($youtubeVideoId!=""){
		drupal_add_js('function onPlayerStateChange(event) {
			if(event.data == YT.PlayerState.ENDED){
						 $("#vdOverlay").css("display","block");
						 $(".relatedOverlayContent").niceScroll({
								cursorwidth : "4px",
								cursorborder : "none",
								autohidemode : "false",
								background : "#171819",
								cursorcolor : "#000000",
								railmargin : "2"
						 });

						 $("#closebtn").on("click",function(){
							  /*clock = 10;  
							  $("#vdtimer").html(clock);
							  clearInterval(countdownId);*/
							  $("#vdOverlay").css("display","none");
						});

						$("#replaybtn").on("click",function(){
							/*clock = 10;
							$("#vdtimer").html(clock);
							clearInterval(countdownId);*/
							 $("#vdOverlay").css("display","none");
								  onYouTubeIframeAPIReady();
								  event.target.playVideo();
						});  
				start();

			}
		}', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 101));
	}
}

drupal_add_js('$(document).ready(function(){
        $(".popularVids").niceScroll();
        
        $(".mobileReadMore").on("click",function(){
            if($(this).hasClass("open")){
                $(".slideBody").slideUp();
                $(this).removeClass("open");
            }else{
                $(".slideBody").slideDown();
                $(this).addClass("open");
            }
        });
        
        $(".addIconsBtn").on("click",function(){
            $(".socialHidden").fadeIn();
        });

        $(".closeIconBtn").on("click",function(){
            $(".socialHidden").fadeOut();
        });
    });', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 102));

if($isBrightcove!=""){ 
	drupal_add_js('$(window).load(function(){
            $(".videoSeriesBlock .rhsVideo .popularVids").css("max-height", $(".lhsVideo").height() - 32);
        });', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 103));

	if($deviceType == 'tablet'){
		drupal_add_js('var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

            window.addEventListener(orientationEvent, function() {
                $(".slideBody").hide();
                $(".mobileReadMore").removeClass("open");
                
                if($(window).width() >= 1024 ){
                    var containerHght = $(".lhsVideo").height();
                    $(".videoSeriesBlock .rhsVideo .popularVids").css("max-height", containerHght - 32);
                }
            }, false);', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 104));
	}else if($deviceType == 'computer'){
		drupal_add_js('var supportsOrientationChange = "onorientationchange" in window,
            orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

            window.addEventListener(orientationEvent, function() {
                $(".slideBody").hide();
                $(".mobileReadMore").removeClass("open");
                
                if($(window).width() >= 1024 ){
                    var containerHght = $(".lhsVideo").height();
                    $(".videoSeriesBlock .rhsVideo .popularVids").css("max-height", containerHght - 32);
                }
            }, false);', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 105));
	}
}else{
	drupal_add_js('var supportsOrientationChange = "onorientationchange" in window,
        orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

        window.addEventListener(orientationEvent, function() {
            $(".slideBody").hide();
            $(".mobileReadMore").removeClass("open");
        }, false);', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 106));
} ?>

<div class="pageBanner">
    <div class="videoSeriesBlock">
        <div class="lhsVideo">
        <?php /*<div class="playIcon"><img src="<?php echo $image_url; ?>play-video-icon.png" /></div>*/ ?>
           <?php if($isBrightcove=="vzaar"){ ?>
           <div class="videoContainer video-container">
                <?php echo "<iframe allowFullScreen allowTransparency='true' class='vzaar-video-player' frameborder='0' id='vzvd-".$vdzvideoid."' mozallowfullscreen name='vzvd-".$vdzvideoid."' src='".$vzaarurl."' title='vzaar video player' type='text/html' webkitAllowFullScreen width='768'></iframe>";?>            </div>
            <!--<div class="blackStrip"><span>Subscribe to 101India</span><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></div>-->
            
            <?php } else if($isBrightcove=="brightcove"){ ?>
            <div class="videoContainer">
                <div id="container2" class="containing-block">
                    <div id="container1" class="outer-container">

                        <!-- Start of Brightcove Player -->

                        <div style="display:none">

                        </div>

                        <!--
                        By use of this code snippet, I agree to the Brightcove Publisher T and C 
                        found at https://accounts.brightcove.com/en/terms-and-conditions/. 
                        -->

                        <object id="myExperience<?php echo $brightcoveVideoID; ?>" class="BrightcoveExperience">
                          <param name="wmode" value="transparent" />
                          <param name="bgcolor" value="#FFFFFF" />
                          <param name="width" value="480" />
                          <param name="height" value="270" />
                          <param name="playerID" value="3884556222001" />
                          <param name="playerKey" value="AQ~~,AAADiHImimE~,1I8ur9UTbWkfo3gwWnIwEuWFaygo_bvz" />
                          <param name="isVid" value="true" />
                          <param name="isUI" value="true" />
                          <param name="dynamicStreaming" value="true" />
                          <param name="@videoPlayer" value="<?php echo $brightcoveVideoID; ?>" />

                         <!-- smart player api params -->
                         <param name="includeAPI" value="true" />
                         <param name="templateLoadHandler" value="onTemplateLoad" />
                         <param name="templateReadyHandler" value="onTemplateReady" />
                        </object>

                        <!-- 
                        This script tag will cause the Brightcove Players defined above it to be created as soon
                        as the line is read by the browser. If you wish to have the player instantiated only after
                        the rest of the HTML is processed and the page load is complete, remove the line.
                        -->

                        <script type="text/javascript">brightcove.createExperiences();</script>

                        <!-- End of Brightcove Player -->
                    </div>
                </div>
            </div>
            <?php } else if($isBrightcove=="brightvimeo"){ ?>
            <div class="videoContainer video-container">
						<iframe id="player" src="<?php echo $vimeoVideoID; ?>?title=0&byline=0&portrait=0" width="768" height="452" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
			<div class="blackStrip"><span>Subscribe to 101India</span>
			<span class="subBtn"><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></span>
			</div>
            <?php } else{ ?>
                <div class="videoContainer video-container">
                    <div id="player"></div>
                </div>
            
            <div class="blackStrip"><span>Subscribe to 101India</span>
			<!-- <span class="subBtn" style="top:0;"><a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"><img src="http://india101dev.prod.acquia-sites.com/sites/default/files/image-upload/youtube101.png" border="0"></a></span> -->
			<span class="subBtn"><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></span>
			</div>
            <?php } ?>
            <?php
//RELATED VIDEO OVERLAY CODE STARTS HERE            

             if($isBrightcove=="vzaar" || $isBrightcove=="youtube"){?>
                 <div class="videoOverlay" id="vdOverlay" style="display:none;">
         <?php 
                if($similarCount > 1){
                    $similarCounter = 0;?>
            <div class="overlayTitle">
               
                <div class="titleBlock">You May also like :</div><div class="replayOption"><a href="javascript:;" id="replaybtn"><span>Replay</span></a></div>
                <div class="clear"></div>
                <div class="closeOverlay"><a id="closebtn" href="javascript:;">x</a></div>
            </div>
            <div class="relatedOverlayContent">
                <div class="vidLoader" id="vidLoadr" style="display:none;"><img src="<?php echo $base_url; ?>/sites/all/themes/new_101_india_theme/images/vid-loader.gif"></div>
                <ul id="vidList">
                
                <!-- Next overlay video data start-->
                <?php /*<li>
                <div class="overlayWrap">
                    <div class="leftView">
                        <a href="<?php echo $vzrOverlaydataPathnext;?>">
                            <img src="<?php echo $vzrOverlaydataImgnext; ?>" alt="<?php echo $vzrOverlaydataAltnext; ?>" title="<?php echo $vzrOverlaydataAltnext; ?>"/>
                        </a>
                    </div>
                    <div class="middleView">
                        <div class="vidTitle"><a onClick="clearInterval(countdownId);" href="<?php echo $vzrOverlaydataPathnext;?>"><?php echo $vzrOverlaydataTitlenext; ?></a></div><div class="videoTime"></div>
                        <div class="clear"></div>
                        <div class="vidDescContent">
                            <?php $vzrOverlaydatadescnext = html_entity_decode($vzrOverlaydatadescnext, ENT_QUOTES);
                            echo strip_tags($vzrOverlaydatadescnext); ?>
                        </div>
                    </div>
                    <div class="videoInfo">
                        <div class="vidDuration"><span><?php echo $vidTimeStamp ?></span></div>
                       
                        <div class="timer">
                            <span id="vdtimer">10</span>
                        </div>
                        
                    </div>
                    <div class="clear"></div>
                </div>
            </li>*/ ?>
            <!-- Next overlay video data end-->     
                    
    <?php
    //vzaar video overlay data
    $cnt=0;

    foreach($vzaarOverlaydata as $kSim=>$vzrOverlaydata){
            if($similarCounter < 8){
                if($vzrOverlaydata->nid == $node->nid){ // || $vzrOverlaydata->nid == $nextvidnid){
                    continue;
                }else{
                    $similarCounter++;
                    $cnt++;
                }
                $vzrOverlaydataNode = $vzrOverlaydata->_field_data['nid']['entity'];
                                    
                $vzrOverlaydataTitle = htmlentities($vzrOverlaydataNode->title);
                $vzrOverlaydatadesc = htmlentities($vzrOverlaydataNode->body['und'][0]['value']);
                $vzrOverlaydatadesc=str_replace("&lt;p&gt;", "",$vzrOverlaydatadesc);
                $vzrOverlaydatadesc=str_replace("&lt;/p&gt;", "",$vzrOverlaydatadesc);
               // echo "<pre>";print_r($vzrOverlaydatadesc); echo"</pre>";
                
                if(strlen($vzrOverlaydataTitle) > 70){
                    $vzrOverlaydataTitle = substr($vzrOverlaydataTitle, 0, strpos($vzrOverlaydataTitle, ' ', 65));
                    $vzrOverlaydataTitle .= '...';
                }else{
                    $vzrOverlaydataTitle = $vzrOverlaydataTitle;
                }

                if(strlen($vzrOverlaydatadesc) > 100){
                    $vzrOverlaydatadesc = substr($vzrOverlaydatadesc, 0, strpos($vzrOverlaydatadesc, ' ', 65));
                    $vzrOverlaydatadesc .= '...';
                }else{
                    $vzrOverlaydatadesc = $vzrOverlaydatadesc;
                }

                $vzrOverlaydataDate = date('M j, Y', $vzrOverlaydataNode->created);

                $vzrOverlaydataImg = '';
                $vzrOverlaydataAlt = '';
                $vzrOverlaydataTtl = '';

                $vzrOverlaydataThbImg = field_get_items('node', $vzrOverlaydataNode, 'field_thumb_image');

                $vzrOverlaydataImg = image_style_url('must_watch', $vzrOverlaydataThbImg[0]['uri']);

                if(!empty($vzrOverlaydataThbImg[0]['alt'])){
                    $vzrOverlaydataAlt = $vzrOverlaydataThbImg[0]['alt'];
                }else{
                    $vzrOverlaydataAlt = $vzrOverlaydataNode->title;
                }

                if(!empty($vzrOverlaydataThbImg[0]['title'])){
                    $vzrOverlaydataTtl = $vzrOverlaydataThbImg[0]['title'];
                }else{
                    $vzrOverlaydataTtl = $vzrOverlaydataNode->title;
                }
                
                if($vzrOverlaydataNode->type == 'videos'){
                    $mosPopvidDur = field_get_items('node', $vzrOverlaydataNode, 'field_vzaar_video_duration');
                    $vzrOverlaydataContentClass = 'play';
                    
                    $vidTimeStamp = '';
                                
                    if(!empty($mosPopvidDur[0]['value'])){
                        $vidTimeStamp = $mosPopvidDur[0]['value'];
                        //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
                    }     
                    else {
                        $vidTimeStampSecs = $vzrOverlaydata->field_field_brightcove_video[0]['rendered']['#video']->length;

                        $min = ($vidTimeStampSecs/1000/60) << 0;
                        $sec = round(($vidTimeStampSecs/1000) % 60);
                        $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
                       }
                                              

                    $vzrOverlaydataTimeStamp = '<span class="playTime">' . $vidTimeStamp . '</span>';
                    }else{
                        $vzrOverlaydataContentClass = 'read';
                        $vzrOverlaydataTimeStamp = '';
                    }

                $vzrOverlaydataPath = url('node/' . $vzrOverlaydataNode->nid, array('absolute' => true));
?>

                            <li>
                                <div class="overlayWrap">
                                    <div class="leftView">
                                        <a href="<?php echo $vzrOverlaydataPath;?>">
                                            <img src="<?php echo $vzrOverlaydataImg; ?>" alt="<?php echo $vzrOverlaydataAlt; ?>" title="<?php echo $vzrOverlaydataAlt; ?>"/>
                                        </a>
                                    </div>
                                    <div class="middleView">
                                        <div class="vidTitle"><a onClick="clearInterval(countdownId);" href="<?php echo $vzrOverlaydataPath;?>"><?php echo $vzrOverlaydataTitle; ?></a></div><div class="videoTime"></div>
                                        <div class="clear"></div>
                                        <div class="vidDescContent">
                                          <?php 
                            //$vzrOverlaydatadesc = str_replace('&nbsp;', ' ', $vzrOverlaydatadesc);
                //$vzrOverlaydatadesc = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $vzrOverlaydatadesc);
                $vzrOverlaydatadesc = html_entity_decode($vzrOverlaydatadesc, ENT_QUOTES);
                echo strip_tags($vzrOverlaydatadesc);?>
                                        </div>
                                    </div>
                                    <div class="videoInfo">
                                        <div class="vidDuration"><span><?php echo $vidTimeStamp ?></span></div>
                                       <?php //if ($cnt==1){

                                            //$redrtpath=$vzrOverlaydataPath;
                                        ?>
                                        <!--<div class="timer">
                                            <span id="vdtimer">10</span>
                                        </div>-->
                                        <?php // } else {?>
                                         <div class="playRelated">
                                            <a href="<?php echo $vzrOverlaydataPath;?>" onClick="clearInterval(countdownId);"></a>
                                        </div>
                                        <?php // }?>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </li>
                            <?php  }  }?>
                        </ul>
                    </div>
                    <?php }?>
            </div>
            <?php }
//RELATED VIDEO OVERLAY CODE ENDS HERE            

            ?>

        </div>
        <div class="rhsVideo">
        <?php if(!empty($srView->result)){ ?>
            <div class="queueTitle"><h2>FROM THE SAME SERIES</h2></div>
            <div class="popularVids">
                <ul>
                <?php foreach($srView->result as $kSer=>$seriesStories){
                    $seriesNode = $seriesStories->_field_data['nid']['entity'];

                    if($seriesStories->nid == $node->nid){
                        continue;
                    }

                    $seriesTitle = html_entity_decode($seriesNode->title, ENT_NOQUOTES, 'UTF-8');

                    if(strlen($seriesTitle) > 50){
                        $pos = strpos($seriesTitle, ' ', 45);
                        
                        if(!$pos){
                            $pos = strpos($seriesTitle, ' ', 25);
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

                    $seriesImg = image_style_url('video_rhs', $seriesThbImg[0]['uri']);

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
                        <a class="vidHover" href="<?php echo $seriesPath; ?>">
                            <div class="videoQueue">
                                <img src="<?php echo $seriesImg; ?>" alt="<?php echo $seriesAlt; ?>" title="<?php echo $seriesAlt; ?>" />
                                <span class="play"></span>
                                <?php print $seriesTimeStamp; ?>
                            </div>
                            <div class="queueDesc">
                                <h2><?php echo $seriesTitle; ?></h2>
                            </div>
                            <div class="clear"></div>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        <?php }else if(!empty($mostPopResArrSorted)){
            $mostPopCounter = 0; ?>
            <div class="queueTitle"><h2>MOST POPULAR</h2></div>
            <div class="popularVids">
                <ul>
                <?php foreach($mostPopResArrSorted as $kMos=>$mosPop){
                    if($mostPopCounter < 8){
                        $mosPopNode = $mosPop->_field_data['nid']['entity'];

                        $mosPopTitle = html_entity_decode($mosPopNode->title, ENT_NOQUOTES, 'UTF-8');

                        if(strlen($mosPopTitle) > 50){
                            $pos = strpos($mosPopTitle, ' ', 45);
                        
                            if(!$pos){
                                $pos = strpos($mosPopTitle, ' ', 25);
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
                        $mosPopImg = image_style_url('video_rhs', $mosPopThbImg[0]['uri']);

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
                    <li>
                        <a class="vidHover" href="<?php echo $mosPopPath; ?>">
                            <div class="videoQueue">
                                <img src="<?php echo $mosPopImg; ?>" />
                                <span class="play"></span>
                                <?php print $mosPopTimeStamp; ?>
                            </div>
                            <div class="queueDesc">
                                <h2><?php echo $mosPopTitle; ?></h2>
                            </div>
                            <div class="clear"></div>
                        </a>
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
        <!--<div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div>-->
        <div class="clear"></div>
    </div>
	
	<div class="articleContent">
        <div class="lhsContent">
            <?php print $breadcrumbHTML; ?>
            <div class="articleSummary">
                <h1><?php echo $title;?></h1>
                <?php /* ?><div class="metaDate"><?php echo date('F j, Y',$content['body']['#object']->published_at);?></div><?php */ ?>
                <?php echo $body[0]['value'];?>
            </div>
        </div>
        <div class="rhsContent">
            <div class="socialContent">
            <div class="socialIconsContainer">
                    <div class="socialVisible">
                        <ul>
                            <li><a href="javascript:;" onClick="socialIcons('facebook','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>fb-101.png" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('twitter','<?php echo $pageURL;?>','<?php echo $twitterShare;?>');"><img src="<?php echo $image_url; ?>twitter-101.png" /></a></li>
                            <!-- <li><a href="javascript:;" onClick="socialIcons('gplus','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>gplus-101.png" /></a></li> -->
                            <?php if($deviceType=='phone'){ ?>	
								<li><a href='whatsapp://send?text="<?php echo urlencode($title);?>" - <?php echo $pageURL;?>' data-action='share/whatsapp/share'>
								<img src="<?php echo $image_url; ?>whatsapp-101.png" /></a></li>
							<?php	}else{ ?>
								<li><a href="mailto:?subject=Share%20From%20101%20India&body=<?php echo $title." - ".$pageURL;?>"><img src="<?php echo $image_url; ?>message-icon-101.png" /></a></li>
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
                            <li><a href="javascript:;" onClick="socialIcons('reddit','<?php echo $pageURL;?>','<?php echo htmlentities($title);?>');"><img src="<?php echo $image_url; ?>reddit-social-101.png" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('pinterest','<?php echo $pageURL;?>','<?php echo htmlentities($title);?>','<?php echo $bannerImage; ?>');"><img src="<?php echo $image_url; ?>pinterst-social-101.png" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('tumblr','<?php echo $pageURL;?>','<?php echo htmlentities($title);?>','','<?php echo $body[0]['summary']; ?>');"><img src="<?php echo $image_url; ?>tumblr-social-101.png" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('delicious','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>delicious-social-101.png" /></a></li>
                            <li><a href="javascript:;" onClick="socialIcons('digg','<?php echo $pageURL;?>','<?php echo htmlentities($title);?>');"><img src="<?php echo $image_url; ?>digg-social-101.png" /></a></li>
                            <?php /*<li><a href="javascript:;" onClick="socialIcons();"><img src="<?php echo $image_url; ?>top-odkazy-social-101.png" /></a></li>*/ ?>
                    <?php /*        <li><a href="javascript:;" onClick="socialIcons('instapaper','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>i-social-101.png" /></a></li>
                     */ ?>       
							<?php /*<li><a href="javascript:;" onClick="insta();"><img src="<?php echo $image_url; ?>i-social-101.png" /></a></li>*/ ?>
                            <li><a href="javascript:;" onClick="socialIcons('linkedin','<?php echo $pageURL;?>');"><img src="<?php echo $image_url; ?>linkedIn-101.png" /></a></li>
							<?php if($deviceType!='computer'){ ?>	
								<li><a href="mailto:?subject=Share%20From%20101%20India&body=<?php echo $title." - ".$pageURL;?>"><img src="<?php echo $image_url; ?>message-inner-101.png" /></a></li>
							<?php	}	?>
                            <?php /*<li><a href="javascript:;" onClick="socialIcons();"><img src="<?php echo $image_url; ?>notes-101.png" /></a></li>*/ ?>
                        </ul>
                    </div>
                </div>
                
                <?php /*<div class="viewCount"><?php echo $totalViewsStr;?> <?php echo ($totalViews==0 || $totalViews > 1)?'Views':'View'; ?></div>*/ ?>
            </div>
            <?php if($deviceType=='phone'){ ?>	
            <div class="slideBody" style="display:block; clear:both; padding-top:0;">
                <div class="relatedVideosSection">
                <?php if(!empty($srView->result)){ ?>
					<div class="mobileReadMore open" style="width: 85%;">
						<div class="slideHeader"><a href="javascript:;">From The Series</a></div>
					</div>
                    <ul>
                    <?php foreach($srView->result as $kSer=>$seriesStories){
                        $seriesNode = $seriesStories->_field_data['nid']['entity'];

                        if($seriesStories->nid == $node->nid){
                            continue;
                        }

                        $seriesTitle = html_entity_decode($seriesNode->title, ENT_NOQUOTES, 'UTF-8');

                        if(strlen($seriesTitle) > 50){
                            $pos = strpos($seriesTitle, ' ', 45);
                        
                            if(!$pos){
                                $pos = strpos($seriesTitle, ' ', 25);
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

                        $seriesImg = image_style_url('video_rhs', $seriesThbImg[0]['uri']);

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
                            <a class="vidHover" href="<?php echo $seriesPath; ?>">
                                <div class="videoQueue">
                                    <img src="<?php echo $seriesImg; ?>" alt="<?php echo $seriesAlt; ?>" title="<?php echo $seriesAlt; ?>" />
                                    <span class="play"></span>
                                    <?php print $seriesTimeStamp; ?>
                                </div>
                                <div class="queueDesc">
                                    <h2><?php echo $seriesTitle; ?></h2>
                                </div>
                                <div class="clear"></div>
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                <?php }else if(!empty($mostPopResArrSorted)){
                    $mostPopCounter = 0; ?>
					<div class="mobileReadMore open" style="width: 85%;">
						<div class="slideHeader"><a href="javascript:;">Most Popular</a></div>
					</div>
                    <ul>
                    <?php foreach($mostPopResArrSorted as $kMos=>$mosPop){
                        if($mostPopCounter < 8){
                            $mosPopNode = $mosPop->_field_data['nid']['entity'];

                            $mosPopTitle = html_entity_decode($mosPopNode->title, ENT_NOQUOTES, 'UTF-8');

                            if(strlen($mosPopTitle) > 50){
                                $pos = strpos($mosPopTitle, ' ', 45);
                        
                                if(!$pos){
                                    $pos = strpos($mosPopTitle, ' ', 25);
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
                            $mosPopImg = image_style_url('video_rhs', $mosPopThbImg[0]['uri']);

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
                        <li>
                            <a class="vidHover" href="<?php echo $mosPopPath; ?>">
                                <div class="videoQueue">
                                    <img src="<?php echo $mosPopImg; ?>" />
                                    <span class="play"></span>
                                    <?php print $mosPopTimeStamp; ?>
                                </div>
                                <div class="queueDesc">
                                    <h2><?php echo $mosPopTitle; ?></h2>
                                </div>
                                <div class="clear"></div>
                            </a>
                        </li>
                        <?php }else{
                            break;
                        }
                            $mostPopCounter++;
                    } ?>
                    </ul>
                <?php } ?>
                </div>
            </div>
            <?php	} ?>
        </div>
        <div class="clear"></div>
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
                    $similarTitle = substr($similarTitle, 0, strpos($similarTitle, ' ', 65));
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
                                
                    if(!empty($mosPopvidDur[0]['value'])){
                        $vidTimeStamp = $mosPopvidDur[0]['value'];
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
    
    <div class="commentBox">
        <h2>Comments</h2>
        <div id="comments"><div class="fb-comments" data-href="<?php echo $pageURL;?>" data-width="100%" data-numposts="4" data-colorscheme="light"></div></div>
    </div>
    
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

<?php if($vdzvideoid!="" && $similarCounter>0){
	drupal_add_js('var playerid = "'.$vdzvideoid.'";
   // console.log(playerid);
    var getFrameID = document.getElementById("vzvd-"+playerid);
	window.addEventListener("load", function() { 
        player = new vzPlayer("vzvd-"+playerid); 
        player.ready(function() { 
            player.play2(); 
			player.addEventListener("playState", function(state) {
                if(state=="mediaEnded")
				{
                    $("#vdOverlay").css("display","block");
                     $(".relatedOverlayContent").niceScroll({
                            cursorwidth : "4px",
                            cursorborder : "none",
                            autohidemode : "false",
                            background : "#171819",
                            cursorcolor : "#000000",
                            railmargin : "2"
                        });
                     $("#closebtn").on("click",function(){
                          /*clock = 10;  
                          $("#vdtimer").html(clock);
                          clearInterval(countdownId);*/
                          $("#vdOverlay").css("display","none");
                    });
                     $("#replaybtn").on("click",function(){
                        /*clock = 10;
                        $("#vdtimer").html(clock);
                        clearInterval(countdownId);*/
                         $("#vdOverlay").css("display","none");
                                player.seekTo(0);
                                player.play2();  
                            });  
                    start();
                }
		   });
        }); 
    });', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 107));
} ?>