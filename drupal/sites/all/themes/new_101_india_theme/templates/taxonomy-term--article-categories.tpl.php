<?php
global $base_url;

//Mobile detect code starts
$deviceType = '';
include_once DRUPAL_ROOT . '/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends


$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$urlArg = drupal_get_path_alias('taxonomy/term/'.$tid);
$tidExp = explode('/',$urlArg);
$cat = $tidExp[0];

$seededViewName = str_replace('-', '_', $cat);

if(strstr($cat,'101-')){
	if($cat == "101-travel"){
		header('location:'.$base_url.'/travel-food');
	}else if($cat == "101-janta"){
		header('location:'.$base_url.'/people');
	}else{
		header('location:'.$base_url.'/'.str_replace('101-','',$cat));
	}
}

$coverImage = '';
$coverImageAlt = '';
$coverImageTtl = '';

if(isset($field_cover_image) && !empty($field_cover_image)){
    $coverImage = image_style_url('home_page_category_image', $field_cover_image[0]['uri']);
    
    if(!empty($field_cover_image[0]['alt'])){
        $coverImageAlt = $field_cover_image[0]['alt'];
    }else{
        $coverImageAlt = $name;
    }
    
    if(!empty($field_cover_image[0]['title'])){
        $coverImageTtl = $field_cover_image[0]['title'];
    }else{
        $coverImageTtl = $name;
    }
}else{
    $coverImage = $image_url . 'category-banner.jpg';
    $coverImageAlt = $name;
    $coverImageTtl = $name;
}

//echo '<pre style="display: none">';print_r(strip_tags(render($content['field_cover_image']), '<img>'));echo '</pre>';
//echo '<pre style="display: none">';print_r($tidFor101);echo '</pre>';
//echo '<pre style="display: none">';print_r(gettype((int)$tid));echo '</pre>';
//echo '<pre style="display: none">';print_r($name);echo '</pre>';

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>

<?php

$cat = '101-'.$cat;

if($cat == "101-art"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-art'));
}else if($cat == "101-entertainment"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-entertainment'));
}else if($cat == "101-fashion"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-fashion'));
}else if($cat == "101-fiction"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-fiction'));
}else if($cat == "101-funny"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-funny'));
}else if($cat == "101-people"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-janta'));
}else if($cat == "101-love-sex"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-love-sex'));
}else if($cat == "101-music"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-music'));
}else if($cat == "101-specials"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-specials'));
}else if($cat == "101-travel-food"){
	$taxonomyPath = explode('/', drupal_get_normal_path('101-travel-food'));
}else{
	$taxonomyPath = array();
}

if(!empty($taxonomyPath)){
    $tidFor101 = $taxonomyPath[count($taxonomyPath) - 1];
}else{
    $tidFor101 = 0;
}

//echo '<pre style="display: none">';print_r(gettype((int)$tidFor101));echo '</pre>';


if($tidFor101 != 0){
    $tidArr = array((int)$tid, (int)$tidFor101);
}else{
    $tidArr = array((int)$tid);
}

// print_r($tidArr);

//echo '<pre style="display: none">';print_r($tidArr);echo '</pre>';

/*$recentContentArr = array();
$allNidArr = array();
$finalHPArr = array();

$getHPSeededView = get_views_data('category_listing', $seededViewName);
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
    
    $recentContView = get_views_data('category_listing', 'page', array(0 => array('name' => 'field_article_category_tid', 'value' => $tidArr)));
    $recentContentArr = $recentContView->result;
    
    foreach($recentContentArr as $rckey=>$rcVal){
        if(!in_array($rcVal->nid, $allNidArr)){
            $finalHPArr[] = $rcVal;
            $allNidArr[] = $rcVal->nid;
        }
    }

//echo '<pre style="display: none;">';print_r($finalHPArr);echo '</pre>';
}*/

//echo '<pre style="display: none;">seeded view is: ' . $seededViewName . '</pre>';

//echo '<pre style="display: none">';print_r($newArr);echo '</pre>';

$headingTitle = $cat2;
if($headingTitle==""){
	$headingTitle = str_replace('101-','',$cat);
}

$breadcrumb = drupal_get_breadcrumb();

$breadcrumbHTML = theme('breadcrumb', array('breadcrumb' => $breadcrumb));

$catClass = explode(' ', $name);
foreach($catClass as $k=>$catVal){
    if($k == 0){
        $catClass[$k] = strtolower($catVal);
    }else{
        $catClass[$k] = ucfirst($catVal);
    }        
}
$catClass = implode('', $catClass);
$catClass = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' '), array('', '', '', '',''), $catClass);

if(isset($_GET['page']) && !empty($_GET['page'])){
    $pageNo = (int)$_GET['page'] - 1;
}else{
    $pageNo = 0;
}
?>

<?php
    //drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular.min.js', array('type' => 'file', 'group' => JS_THEME, 'weight' => 20));

	drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/angular-sanitize.js', array('type' => 'file', 'group' => JS_THEME, 'weight' => 25));
?>


<div class="pageBanner series categoryList" >
    <div class="bannerImg <?php echo $catClass; ?>">
        <img class="bannerImg" src="<?php echo $coverImage; ?>" alt="<?php echo $coverImageAlt; ?>" title="<?php echo $coverImageTtl; ?>">
    </div>
    <div class="dataContainer">
        <div class="summary">
            <h1><?php print $name; ?></h1>
        </div>
        <div class="clear"></div>
    </div>
</div>

<?php //if(strtolower($name) == 'funny'){
$catView = get_views_data('new_category_listing', $seededViewName, array(), array(), $pageNo);
$catArr = $catView->render($seededViewName);
?>

<div class="listContent">
    <?php print $breadcrumbHTML; ?>
    
    <?php print $catArr; ?>
</div>

<?php /*}else{
?>

<div class="listContent">
    <?php print $breadcrumbHTML; ?>
    
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
                
                //echo '<pre style="display: none">Title is: '.strpos(trim($recentTitle), ' ', 81).'</pre>';
                //echo '<pre style="display: none">Title is: '.strlen(trim($recentTitle)).'</pre>';

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

<div class="listContent" ng-app="myapp">
    <?php /*<div class="breadCrumbs">
        <ul>
            <li><a href="/">Home</a> <span>&gt;&gt;</span></li>
            <li><span><?php echo $name; ?></span></li>
        </ul>
    </div>*/ ?>
    <?php // print $categoryListing->render(); ?>
	
	<?php /******* Home page data masonary *******//* ?>            
		
	<?php
		$scrollDistance='';
		$scrollDistance=($deviceType=='computer' ? 0 : 1);
	?>	
<div ng-controller="MyController" ng-Cloak>
				
				<div class="masonryContent" ng-init="myData.autoLoad()" infinite-scroll="myData.autoLoad();" infinite-scroll-distance="<?php echo $scrollDistance; ?>" infinite-scroll-disabled="check" infinite-scroll-immediate-check="false" masonry>
					<div class="masonry-brick item {{ x.linkClass }}"  ng-repeat="x in Data track by $index">
						<div class="dataContainer">
							<div class="metaDate"><span>{{(x.publication_date_published_at*1000) | date:'MMM dd, yyyy'}}</span></div>
							<div class="imageContent">
								<div class="categoryVal">
									<a href="{{x.url}}" >{{ x.typeName }}</a>
								</div>
								<a class="detailLink" href="{{x.path}}" ng-bind-html="x.thumb_image" ></a>
								<div class="iconWrap">
									<a href="{{x.path}}" >
										<img class="play" ng-if="x.type=='videos'" ng-src="{{x.contentIcon}}" alt="icon" />
										<img ng-if="x.type!='videos'" ng-src="{{x.contentIcon}}" alt="icon" />
										<div ng-bind-html="x.contentText"></div>
									</a>	
									<!-- <span>{{x.post_date | date:'hh:mm'}}</span> -->
								</div>
							</div>
							<div class="summary" >
								<h2><a href="{{x.path}}" >{{x.title}}</a></h2>
                                <div class="mobileDate"><span class="ng-binding">{{(x.publication_date_published_at*1000) | date:'MMM dd, yyyy'}}</span></div>
								<p ng-bind-html="x.description"></p>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div ng-if="busy" style="visibility: visible;" class="loader-new" id="views_infinite_scroll-ajax-loader"></div>
                <div ng-if="!busy" style="visibility: hidden;" class="loader-new" id="views_infinite_scroll-ajax-loader"></div>
				<div class="loader" id="loadMoreBtn" ng-click="myData.doClick();" ></div>
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
                    
                    var initialLoad = true;
					
					function insertData(title,description,article_category,thumb_image,type,path,publication_date_published_at,bcove_vid_length,yt_vid_url,vz_vid_url,video_duration){
						
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
                        var vz_video_length="";
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
						tempdata.publication_date_published_at = publication_date_published_at;
                        
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
											
											var rmv = ["&amp;","&AMP;","Amp;","amp;"," ", " ","&"];
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
									var rmv = ["&", "amp;","&AMP;","&amp;", "Amp;", " ", " "];
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
							tempdata.contentText = "<span>" + tempdata.vid_duration + "</span>";
                            tempdata.contentText = $sce.trustAsHtml(tempdata.contentText);
							tempdata.contentClass = " class=\"play\"";
						}else if(tempdata.type == "series"){
							tempdata.contentIcon = image_url + "series-icon.png";
							tempdata.contentText = "";
							tempdata.contentClass = "";
						}else{
							tempdata.contentIcon = image_url + "read-icon.png";
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
					loadonce = 0;
					
					function fetchData(){
						var NewData = [];
                        
                         if(loadonce == 0){
                     
                        responseSeededPromise = $http({
								url: Drupal.settings.basePath + "data/'.$tidExp[0].'-seeded-content",
								type: "get",
								async : false   
							});       
							responseSeededPromise.success(function(dataSeeded, status, headers, config) {
								for(i=0;i<dataSeeded.length;i++){
									series.push(dataSeeded[i].nid);
									var da = insertData(dataSeeded[i].title,dataSeeded[i].description,dataSeeded[i].article_category,dataSeeded[i].thumb_image,dataSeeded[i].type,dataSeeded[i].path,dataSeeded[i].publication_date_published_at,dataSeeded[i].bcove_video_length,dataSeeded[i].yt_video_url,dataSeeded[i].vz_vid_url,dataSeeded[i].video_duration);
									NewData.push(da);
								}
							})
                            loadonce =1;
                        }
                        
						
						//get 20 content 
                        $timeout(function() {
						var responsePromise = $http({
							url: Drupal.settings.basePath + "data/getContentByCat?tid[]='.$tidArr[0].''.((!empty($tidArr[1]))?'&tid[]='.$tidArr[1]:"").'",
							type: "get"
						});
						
						responsePromise.success(function(data, status, headers, config) {
							
							if(data.length>0){
								var baseUrl=window.location.origin;
								for(i=0;i<data.length;i++){
									if((series.indexOf(data[i].nid))==-1){
										series.push(data[i].nid);
										var da = insertData(data[i].title,data[i].description,data[i].article_category,data[i].thumb_image,data[i].type,data[i].path,data[i].publication_date_published_at,data[i].bcove_video_length,data[i].yt_video_url,data[i].vz_vid_url,data[i].video_duration);
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
										document.getElementById("loadMoreBtn").style.visibility = "visible";
									}
									else{
										document.getElementById("loadMoreBtn").style.visibility = "hidden";
									}
								}
								
                                if(initialLoad == true){
                                    initialLoad = false;
                                    $scope.loaded = true;
                                }else{
                                    $scope.busy = false;
                                    //console.log("in fetch data function");
                                    $scope.Data.push.apply($scope.Data, fArray);
                                    $scope.loaded = true;
                                }
									
							}else{
								$(".listContent").html("<div class=\"noData\"><p>No Results Found in this Category</p></div>");		
							}	
						});
						responsePromise.error(function(data, status, headers, config) {
							console.log("AJAX failed! "+data);
						});
                        }, 1000);    
					}
					
					var loadCount=0;
					$scope.myData.autoLoad = function() {
						if(loadCount<3)
						{
							document.getElementById("loadMoreBtn").style.visibility = "hidden";
							$scope.busy = true;
                            //console.log("in autoload function");
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
						document.getElementById("loadMoreBtn").style.visibility = "hidden";
						$scope.busy = true;
                        //console.log("in click function");
						if($scope.loaded){
							$scope.loaded = false;
							$timeout(function() {
								fetchData();
							}, 1000);
						}
					}
				});', array('type' => 'inline', 'group' => JS_THEME, 'weight' => 200)
);
}*/
?>