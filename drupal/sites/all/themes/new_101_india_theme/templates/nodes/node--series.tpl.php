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

//echo '<pre style="display: none">';print_r(($content['field_tags']));echo '</pre>';
//echo '<pre style="display: none">';print_r($base_url);echo '</pre>';

global $base_url;

//Mobile detect code starts
$deviceType = '';
include_once DRUPAL_ROOT . '/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends

$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$pageURL = $base_url.$node_url;

$pageImage = '';

if(isset($content['field_cover_image']['#items']) && !empty($content['field_cover_image']['#items'])){
	$image = field_get_items('node', $node, 'field_cover_image');
	
	$pageImage = image_style_url('big_image', $image[0]['uri']);
}else{
	$image = field_get_items('node', $node, 'field_thumb_image');
	
	$pageImage = image_style_url('big_image', $image[0]['uri']);
}

$relatedStoriesCount = count($content['field_series_stories']['#items']);

$taxonomyIdArr = array();

if(isset($content['field_tags']['#items']) && !empty($content['field_tags']['#items'])){
	foreach($content['field_tags']['#items'] as $tKey=>$term){
		$taxonomyIdArr[] = $term['tid'];
	}
}

/*
 * call the prev next function defined in custom_next_prev module
 * It takes 2 parameters
 * 1st is node id of the currently view node
 * 2nd is an array which needs a key as not_in or in for excluding a contenttype or showing only particular contenttype respectively
*/
$similarArticleType = field_get_items('node', $node, 'field_article_category');
$similarArticleTypeObj = taxonomy_term_load($similarArticleType[0]['tid']);
$next_prev = custom_prev_next_node($similarArticleTypeObj->tid, $node->nid, array('not_in' => array('page', 'series')));

$nextLink = '';
$prevLink = '';

if(isset($next_prev['next']['link']) && !empty($next_prev['next']['link'])){
	$nextLink = $next_prev['next']['link'];
}

if(isset($next_prev['prev']['link']) && !empty($next_prev['prev']['link'])){
	$prevLink = $next_prev['prev']['link'];
}
$twitterShare = $title;

if(strlen($twitterShare) > 125){
	$pos = strpos($twitterShare, ' ', 125);
	if($pos != FALSE){
		$twitterShare = substr($twitterShare, 0, $pos) . '...';
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

$breadcrumb = drupal_get_breadcrumb();

$breadcrumbHTML = theme('breadcrumb', array('breadcrumb' => $breadcrumb));
	
//echo '<pre style="display: none">';print_r(field_get_items('node', $firstStory, 'field_article_category'));echo '</pre>';
?>

<?php
    drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular.min.js', array('type' => 'file', 'group' => JS_THEME, 'weight' => 20));

	drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular-sanitize.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));

	drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/ng-infinite-scroll.min.js',array('type' => 'file', 'group' => JS_THEME, 'weight' => 100));
?>

<?php
$nid = $node->nid;
$urlArg = drupal_get_path_alias('node/'.$nid);
$nidExp = explode('/',$urlArg);
$catName = $nidExp[0];
$series_image = field_get_items('node', $node, 'field_series_detail_image');
$series_pageImage = image_style_url('series_detail_image', $series_image[0]['uri']);
if($catName == 'series') { ?>
<div class="pageBanner-series">
	<div class="series-detail-img">
		<img class="bannerImg" src="<?php echo $series_pageImage; ?>" alt="<?php print $title; ?>" title="<?php print $title; ?>">
	</div>
	<!--<hr class="hr-title">-->
	<?php 
		$title_101 = substr($title,0,3);
		$remaining_title = substr($title,3);
	?>
	<div class="series-detail-title">
	    <div class="title-101"><div class="para-101"><?php echo $title_101;?></div><?php print $remaining_title; ?></div>
	</div>
	<div class="series-detail-desc"><?php print $node->body['und'][0]['value'];?></div>
	</div>
<?php } else { ?> 
<div class="pageBanner series">
    <img class="bannerImg" src="<?php echo $pageImage; ?>" alt="<?php print $title; ?>" title="<?php print $title; ?>">
    <div class="dataContainer">
        <div class="summary">
            <h1><?php print $title; ?></h1>
            <?php /* ?><div class="metaDate"><span><?php echo date('M j, Y', $content['body']['#object']->published_at); ?></span></div><?php */ ?>
            <!--<p>Watch the chamchas doing their assanas for their master.</p>-->
            <?php /*<p><?php print strip_tags($body[0]['value']); ?></p>*/ ?>
        </div>
        <div class="clear"></div>
    </div>
    </div>
    <?php } ?>

<div class="listContent">
    <?php /*<div class="breadCrumbs">
        <ul>
            <li><a>Home</a> <span>&gt;&gt;</span></li>
            <li><a>Funny</a></li>
        </ul>
    </div>*/ ?>
    <?php print $breadcrumbHTML; ?>
	
	<?php
		$scrollDistance='';
		$scrollDistance=($deviceType=='computer' ? 0 : 1);
	?>
	
    <div ng-app="myapp">
			<div ng-controller="MyController" ng-Cloak>
				<div class="masonryContent" ng-init="myData.autoLoad()" infinite-scroll="myData.autoLoad()" infinite-scroll-distance="<?php echo $scrollDistance; ?>" infinite-scroll-disabled="check"  infinite-scroll-immediate-check="false">
					<div class="masonry-brick item {{ x.linkClass }}" ng-repeat="x in Data">
						<div class="dataContainer">
							<?php /* ?><div class="metaDate"><span>{{(x.post_date*1000) | date:'MMM dd, yyyy'}}</span></div><?php */ ?>
							<div class="imageContent">
								<div class="categoryVal">
									<a href="{{x.url}}" >{{ x.typeName }}</a>
								</div>    
								<a class="detailLink" href="{{x.path}}" ng-bind-html="x.thumb_image" ></a>
								<div class="iconWrap vidOpt" ng-if="x.type=='videos'"> 
								   <a href="{{x.path}}" class="playVid"><span class="yellowPLay"></span><span class="timeSpan">{{x.contentText}}</span></a>
								   <div class="clear"></div>
								</div>
								<div class="iconWrap vidOpt" ng-if="x.type=='series'"> 
								   <a href="{{x.path}}" class="playVid"><span class="yellowPLay"></span></a>
								</div>	
								<div class="iconWrap" ng-if="x.type!='videos'">
									<a href="{{x.path}}" >
										<!--<img class="play" ng-if="x.type=='videos'" ng-src="{{x.contentIcon}}" alt="video icon" />-->
										<img ng-if="x.type!='videos'" ng-src="{{x.contentIcon}}" alt="video icon" />
										<div ng-bind-html="x.contentText"></div>
									</a>	
									<!-- <span>{{x.post_date | date:'hh:mm'}}</span> -->
								</div>
							</div>
							<div class="summary" >
								<h2><a href="{{x.path}}" >{{x.title}}</a></h2>
								<p ng-bind-html="x.description"></p>
								<div class="mobileDate"><span>{{(x.post_date*1000) | date:'MMM dd, yyyy'}}</span></div>
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
</div>

<?php
drupal_add_js('var lastnid;
var myapps = angular.module("myapp", ["ngSanitize","infinite-scroll"]).controller("MyController", function($scope, $http,$timeout, $sce) {
	
	$scope.myData = {};
	$scope.Data = [];
	series = [];
	seriesNid = [];
	dataAllSeries = [];
	$scope.loaded = true;
	finalArray = [];
	
	function insertData(title,description,article_category,thumb_image,type,path,post_date,bcove_vid_length,yt_vid_url,vz_vid_url,video_duration){
		
		var baseUrl="";
		if(!window.location.origin){
			baseUrl = window.location.protocol + "//" + window.location.host;
		}else{
			baseUrl = window.location.origin;
		}
		
		var tempdata = {};
		var title = title.replace(/&#039;/g,"\'");
		title = title.replace(/&quot;/g,"\"");
		title = title.replace(/&amp;/g,"&");
		var description = description;
		
		var tmp = document.createElement("DIV");
		tmp.innerHTML = description; 
		description = tmp.textContent || tmp.innerText; 
		
		if(typeof(description) == "undefined"){
			description = " ";
		}
		
		
		var maxLength = 86; 				// maximum number of characters to extract
		if(description.length>90){
			var trimmedDescription = description.substr(0, maxLength);
			trimmedDescription = trimmedDescription.substr(0, Math.min(trimmedDescription.length, trimmedDescription.lastIndexOf(" ")))+"....";
		}
		else{
			var trimmedDescription = description;
		}
		if(title.length>90){
			var trimmedTitle = title.substr(0, maxLength);
			trimmedTitle = trimmedTitle.substr(0, Math.min(trimmedTitle.length, trimmedTitle.lastIndexOf(" ")))+"....";
		}else{
			var trimmedTitle = title;
		}
		//re-trim if we are in the middle of a word
		
		var bcove_video_length = "";
		var yt_video_url = "";
		var yt_vid_duration = "";
		var vzaar_vid_url="";
		var vzaar_vid_id="";
		var vz_video_length = "";
		var vid_duration = "";
		
		if(type == "videos"){
			if(video_duration != "" && video_duration != null && video_duration != undefined){
				vid_duration = video_duration;
				
			}else if(bcove_vid_length != "" && bcove_vid_length != null && bcove_vid_length != undefined){
				bcove_video_length = bcove_vid_length;
			
				var bcove_vid_duration = bcove_video_length.split("</strong>");
				bcove_vid_duration = bcove_vid_duration[1].split("</span>");
				bcove_vid_duration = Number(bcove_vid_duration[0].trim());

				var min = (bcove_vid_duration/1000/60) << 0,
				sec = Math.round((bcove_vid_duration/1000) % 60);
				min = (min.toString().length==1) ? "0"+min : min;
				sec = (sec.toString().length==1) ? "0"+sec : sec;
				vid_duration = min + ":" + sec;
			}
		}
		
		tempdata.title = trimmedTitle.trim();
		tempdata.description = trimmedDescription;
		tempdata.article_category = article_category.trim();
		tempdata.thumb_image = thumb_image.trim();
		tempdata.type = type.trim();
		tempdata.path = path.trim();
		tempdata.post_date = post_date.trim();
		
		if(type == "videos"){
			tempdata.vid_duration = vid_duration;
		}
		
		var categoryName = article_category;
		if(categoryName){
			var posCat=categoryName.indexOf("101");
			if(posCat >= 0){
				if(categoryName == "101 Travel"){
					tempdata.url = baseUrl+"/travel-food";
					tempdata.typeName = "Travel & Food";
					tempdata.linkClass = "travelFood";
				}else if(categoryName == "101 Janta"){
					tempdata.url = baseUrl+"/people";
					tempdata.typeName = "People";
					tempdata.linkClass = "people";
				}else{
					textClass = categoryName.replace("101 ", "");
					textClassName = textClass;
					textClass = textClass.split("&");
					textClasstemp = [];
					for(j=0;j<textClass.length;j++){
						if(j==0){
							textClasstemp[j] = textClass[j];
							textClass[j] = textClass[j].toLowerCase();
						
						}else{
							var f = textClass[j].charAt(0).toUpperCase();
							textClass[j] = f + textClass[j].substr(1);
							
							var rmv = ["&amp;","Amp;","amp;"," ", " ","&"];
							for(cc=0;cc<rmv.length;cc++){
								textClasstemp[j] = textClass[j];
								var found = textClasstemp[j].indexOf(rmv[cc]);
								if(found!=-1){
									textClasstemp[j] = textClasstemp[j].replace(rmv[cc], "");
									break;	
								}
							}
						}
					}
					textClassNameLast = textClasstemp.join("&");
					textClass = textClass.join("");
					var textUrl;
					var rmv = ["&", "amp;", "&amp;", "Amp;", " ", " "];
					for(l=0;l<rmv.length;l++){
						var found = textClass.indexOf(rmv[l]);
						textUrl = textClass.replace(rmv[l], "-");
						textClassName = textClassName.replace(rmv[l], "");
						if(found!=-1){
							textClass = textClass.replace(rmv[l], "");
						}
					}
					tempdata.url = baseUrl+"/"+textUrl.toLowerCase();
					tempdata.typeName = textClassNameLast;
					tempdata.linkClass = textClass;
				}
			}else{
				textClass = categoryName;
				textClass = textClass.split("&");
				if(textClass == "The Brief"){
					textClass = "brief";
				}
				textClasstemp = [];
				for(j=0;j<textClass.length;j++){
					if(j==0){
						textClasstemp[j] = textClass[j];
						textClass[j] = textClass[j].toLowerCase();	
					}else{
						textClasstemp[j] = textClass[j];
						var rmv = ["&", "amp;", "&amp;", "Amp;", " ", " "];
						for(cc=0;cc<rmv.length;cc++){
							var found = textClass[j].indexOf(rmv[cc]);
							if(found!=-1){
								textClasstemp[j] = textClasstemp[j].replace(rmv[cc], "");
								break;
							}
						}
						var f = textClass[j].charAt(0).toUpperCase();
						textClass[j] = f + textClass[j].substr(1);
					}
				}
				if(textClass == "brief"){
					textClassNameLast = "The Brief";
					tempdata.typeName = textClassNameLast;
				}else{
					textClassNameLast = textClasstemp.join("&");
					tempdata.typeName = textClassNameLast;
				}	
				
				if(textClass != "brief"){
					textClass = textClass.join("");
				}	
				
				var rmv = ["&", "amp;", "&amp;", "Amp;", " ", " "];
				for(l=0;l<rmv.length;l++){
					var found = textClass.indexOf(rmv[l]);
					if(found!=-1){
						textClass = textClass.replace(rmv[l], "");
					}
				}

				tempdata.linkClass = textClass;
					
				for(p=0;p<textClasstemp.length;p++){
					textClasstemp[p]=textClasstemp[p].trim();
				}
				if(textClass != "brief"){
					textUrl = textClasstemp.join("-");
				}else{
					textUrl = "brief";
				}	
				tempdata.url = baseUrl+"/"+textUrl.toLowerCase();
			}
		}
		var image_url=baseUrl+"/sites/all/themes/new_101_india_theme/images/";
		if(tempdata.type == "videos"){
			tempdata.contentIcon = image_url + "video-play-icon.png";
			tempdata.contentText = "";
			tempdata.contentText = tempdata.vid_duration;
			tempdata.contentText = $sce.trustAsHtml(tempdata.contentText);
			tempdata.contentClass = " class=\"play\"";
		}else if(tempdata.type == "series"){
			tempdata.contentIcon = image_url + "play-icon-series.png";
			tempdata.contentText = ""; 
			tempdata.contentClass = "";
		}else{
			tempdata.contentIcon = image_url + "read-icon.jpg";
			tempdata.contentText = "";
			tempdata.contentClass = "";
		}
		return tempdata;
	}				
					
		
	function findWithAttr(array, attr, value) {	
		for(var i = 0; i < array.length; i += 1) {
			if(array[i].nid == value) {
				return i;
			}
		}
	}					
	countFinal = 0;
	
	function fetchData(){
		var NewData = [];
		
		//get 20 content 		
		var responsePromise = $http({
			url: Drupal.settings.basePath + "data/getContentBySeries",
			type: "get",
			async : false,
			params: {
				nid: '.$node->nid.'
			}
		});
		
		responsePromise.success(function(data, status, headers, config) {
			
			var baseUrl=window.location.origin;
			for(i=0;i<data.length;i++){
				if((series.indexOf(data[i].node))==-1){
					series.push(data[i].node);
					var da = insertData(data[i].title,data[i].description,data[i].article_category,data[i].thumb_image,data[i].type,data[i].path,data[i].post_date,data[i].bcove_video_length,data[i].yt_video_url,data[i].vz_vid_url,data[i].video_duration);
					NewData.push(da);
				}
			}

			if(NewData.length>0)
			{
				for(j=0;j<NewData.length;j++){
					finalArray.push(NewData[j]);	
				}
			}
			
			if(data.length)
			{
				lastnid=data[data.length-1].nid;        // To get las nid from list
			}
			
			l=countFinal+11;
			fArray = [];
			for(k=countFinal;k<=l;k++)
			{
				if(finalArray[k])
				{
					fArray.push(finalArray[k]);
					countFinal=k;
					countFinal=++countFinal;
					document.getElementById("loadMore").style.visibility = "visible";
				}
				else{
					$scope.check = true;
					document.getElementById("loadMore").style.visibility = "hidden";
				}
			}
			
			$scope.busy = false;
			$scope.Data.push.apply($scope.Data, fArray);
			$scope.loaded = true;
			console.log("before function call");
			setTimeout(appendYellowBar, 2000);
			console.log("after function call");
		});
		responsePromise.error(function(data, status, headers, config) {
			console.log("AJAX failed! "+data);
		});	
	}
	
	var loadCount=0;
	$scope.myData.autoLoad = function() {
		if(loadCount<3)
		{
			document.getElementById("loadMore").style.visibility = "hidden";
			$scope.busy = true;
			if($scope.loaded){
				$scope.loaded = false;
				$timeout(function() {
					fetchData();
					loadCount++;
				}, 1000);
			}
		}
		else{
			$scope.check = true;
		}
	}
	
	$scope.myData.doClick = function() {
		document.getElementById("loadMore").style.visibility = "hidden";
		$scope.busy = true;
		if($scope.loaded){
			$scope.loaded = false;
			$timeout(function() {
				fetchData();
			}, 1000);
		}
	}

	
});', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 100));
?>