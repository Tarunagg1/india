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
 
//Mobile detect code starts
$deviceType = '';
require_once '/mnt/vol1/101india.com/sites/all/themes/adaptivetheme/at_subtheme/mobile-detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
//Mobile detect code ends

	drupal_add_js(drupal_get_path('theme','adaptivetheme_subtheme').'/js/jquery.fitvids.js');

	hide($content['comments']);
	hide($content['links']);
	
	global $base_url;

	$pageURL = $base_url.$node_url;
	$statistics = statistics_get($node->nid);
	$totalViews = $statistics['totalcount'];
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

/*
 * call the prev next function defined in custom_next_prev module
 * It takes 2 parameters
 * 1st is node id of the currently view node
 * 2nd is an array which needs a key as not_in or in for excluding a contenttype or showing only particular contenttype respectively
*/
$srView = views_get_view('series_related');
$srView->set_display('block');
$srView->set_arguments(array($node->nid));
$filter_1 = $srView->get_item('block', 'filter', 'field_series_stories_nid');
$filter_1['value'] = array($node->nid);
$srView->set_item('block', 'filter', 'field_series_stories_nid', $filter_1);
$srView->pre_execute();
$srView->execute();

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

$next_prev = custom_prev_next_node($prevId, $nextId, $similarArticleTypeObj->tid, $node->nid, array('not_in' => array('page', 'series','subscription_entries')));

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
$isBrightcove = FALSE;

if(!empty($content['field_brightcove_video'])){
	$isBrightcove = TRUE;
	
	$brightcoveVideo = render($content['field_brightcove_video']);
    $brightcoveVideoID = $content['field_brightcove_video']['#items'][0]['brightcove_id'];
}else{
	$isBrightcove = FALSE;
	
	$youtubeVideo = $content['field_embed_video'][0][0]['#video_data']['id'];
	$youtubeVideo = explode(':', $youtubeVideo);
	$youtubeVideoId = $youtubeVideo[count($youtubeVideo) - 1];
}

$twitterShare = $title;

if(strlen($twitterShare) > 125){
	$pos = strpos($twitterShare, ' ', 125);
	if($pos != FALSE){
		$twitterShare = substr($twitterShare, 0, $pos) . '...';
	}
}

$twitterShare = addslashes(html_entity_decode(strip_tags($twitterShare), ENT_QUOTES));

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
?>

<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/APIModules_all.js"></script>

<?php if(!$isBrightcove){ ?>
	<script type="text/javascript">

	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
	var youtubeVideoId = '<?php echo $youtubeVideoId ?>';
	
	var player;
	
	function onYouTubeIframeAPIReady() {
		player = new YT.Player('player', {
			videoId: youtubeVideoId,
			playerVars: {'wmode': 'transparent', 'rel': 0, 'autoplay': 0, 'autohide': 1},
			events: {
				'onReady': function(){},
				'onStateChange': function(){}
			}
		});
        
        $('.player').fitVids();
	}
	</script>
<?php } ?>

<script type="text/javascript">
	function titleBar(){
		$(window).on("scroll", function(){
			var $titlebar = $('.titleBar');
			var $title = $('#titleShow');
	        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	        
			if (scrollTop > $title.offset().top+150) {
				 $titlebar.fadeIn("fast");
		    }else{
				$titlebar.fadeOut("fast");
			}
		});
	}
	
	$(document).ready(function(){
		titleBar();
        
        $('.player').fitVids();
	});
</script>

<?php if(!empty($nextLink) || !empty($prevLink)){ ?>
<div class="floatingControl">
	<ul>
		<?php if(!empty($nextLink)){ ?>
			<li class="next"><a href="<?php echo $nextLink; ?>"><span>next</span></a></li>
		<?php } ?>
		<?php if(!empty($prevLink)){ ?>
			<li class="previous"><a href="<?php echo $prevLink; ?>"><span>previous</span></a></li>
		<?php } ?>
		<?php /*<li class="cancel"><a href="#"><span>cancel</span></a></li>*/ ?>
	</ul>
</div>
<?php } ?>

<section class="detailContent">
	<div class="titleBar" style="display:none;">
		<div class="titleBarWrap">
			<div class="titleBarLhs">
				 <div class="title"><?php echo $title;?></div>
				 <div class="postMeta">
					<span class="date"><?php echo date('jS M, Y',strtotime($datetime));?></span> | <span class="tag"> <?php echo $content['field_article_category'][0]['#markup'];?> </span>
				 </div>
			</div> 
			<div class="titleBarRhs">
				<div class="postInfo">
					 <div class="postButton">
						<span class="button">
							<a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $pageURL; ?>');" class="fb">facebook</a>
						</span>
						<span class="button">
							<a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $pageURL; ?>','<?php echo $twitterShare; ?>');" class="tw">twitter</a>
						</span>
						<span class="button">
							<a href="javascript:void(0);" onclick="javascript:socialIcons('gplus','<?php echo $pageURL; ?>');" class="gplus">gplus</a>
						</span>
						<span class="button">
							<a href="javascript:void(0);" onclick="javascript:slideToComment();" class="mail">email</a>
						</span>
					</div>
				</div>
			</div>
		</div>
    </div>
	<div class="postDetail">
		<div class="videoDetail">
			<div class="player">
				<div class="videoPlay">
					<?php if($isBrightcove){ ?>
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
					<?php }else{ ?>
						<div id="player"></div>
					<?php } ?>
				</div>
				
				<div class="playerControl" style="display:none;">
					<!--<div class="button pause"><a href="javascript:;" onclick="pause()" class="pause"><span>pause</span></a></div>
					<div class="button"><a href="javascript:;" onClick="$('.volumeChange').fadeIn();" class="volume"><span>volume</span></a></div>
					<div class="button volumeChange" style="display:none;">
						<section class="volSection">   
							<span class="tooltip"></span>   
							<div id="slider"></div>  
							<span class="volumeAdjust"></span>  
						</section>
					</div>
					
					<div class="seek">
						<div class="videoTimer">
							<span class="timerStart">4.25</span>
							<span class="timerEnd">9.25</span>
							<div class="clear"></div>
						</div>                                    
						<div class="progressLoad">
							<div class="progressFill" style="width:0%;"></div>
						</div>
					</div>
                    <div class="clear"></div>-->    
				</div>
			</div>
		</div>
		
		<div id="titleShow"></div>
		<div class="postDetailContent">
		<div class="videoDesc">
            <h1 class="title"><?php echo $title;?></h1>
			<div class="summary">
			   <?php echo $body[0]['value'];?>
			</div>
		   <div class="postMeta">
				 <span class="date"><?php echo date('jS M, Y',strtotime($datetime));?></span> | <span class="tag"> <?php echo $content['field_article_category'][0]['#markup'];?> </span>
			</div>
			
			<div class="fbComment" id="comments">
				<div class="fb-comments" data-href="<?php echo $pageURL; ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			</div>
		</div>
		<div class="videoStats">
			<div class="postInfo">
				<div class="postButton">
					<span class="button">
						<a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $pageURL; ?>');" class="fb">facebook</a>
					</span>
					<span class="button">
						<a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $pageURL; ?>','<?php echo $twitterShare; ?>');" class="tw">twitter</a>
					</span>
					<span class="button">
						<a href="javascript:void(0);" onclick="javascript:socialIcons('gplus','<?php echo $pageURL; ?>');" class="gplus">gplus</a>
					</span>
					<span class="button">
						<a href="javascript:void(0);" onclick="javascript:slideToComment();" class="mail">email</a>
					</span>
				</div>
				<div class="views">
					<h3><?php echo $totalViewsStr;?> <span><?php echo ($totalViews==0 || $totalViews > 1)?'Views':'View'; ?></span></h3>
				</div>
				<div class="clear"></div>
			</div>
		 </div>
		<div class="clear"></div>
		</div>
	</div>
</section>
    
    <?php
        if(!empty($srView->result)){
            //echo '<pre style="display: none">';print_r($srView->result);echo '</pre>';
            print $srView->render('block');
        }
    ?>
    
	<?php
	if(!empty($taxonomyIdArr)){
		$similarStories = views_get_view('related_stories');
		$similarStories->set_display('block');
		$filter_1 = $similarStories->get_item('block', 'filter', 'field_tags_tid');
		$filter_1['value'] = $taxonomyIdArr;
		$filter_2 = $similarStories->get_item('block', 'filter', 'nid');
		$filter_2['value'] = array($node->nid);
		$similarStories->set_item('block', 'filter', 'tid', $filter_1);
		$similarStories->pre_execute();
		$similarStories->execute();
	
		$similarCount = count($similarStories->result);
	
		if($similarCount > 1){ ?>
	<section class="wetPaintSection similarStoriesSection">
		<div class="wrapper">
			<h2>Must Watch</h2>
			
			<div class="wetPaintContent">
				<?php foreach($similarStories->result as $sKey=>$similarStories){
					
					if($similarStories->nid == $node->nid){
						continue;
					}
					
					$similarNode = $similarStories->_field_data['nid']['entity'];
					
					$similarTitle = $similarNode->title;
					
					$similarSummary = field_get_items('node', $similarNode, 'body');
				
					if(!empty($similarSummary[0]['summary'])){
						if(strlen($similarSummary[0]['summary']) > 165){
							$similarSummary = substr($similarSummary[0]['summary'], 0, 165);
							$similarSummary .= '...';
						}else{
							$similarSummary = $similarSummary[0]['summary'];
						}
					}else{
						if(strlen($similarSummary[0]['value']) > 165){
							$similarSummary = substr(strip_tags($similarSummary[0]['value']), 0, 165);
							$similarSummary .= '...';
						}else{
							$similarSummary = strip_tags($similarSummary[0]['value']);
						}
					}
					
					$shareText = $similarTitle;
									
					if(strlen($shareText) > 125){
						$pos = strpos($shareText, ' ', 125);
						if($pos != FALSE){
							$shareText = substr($shareText, 0, $pos) . '...';
						}
					}
					
					$shareText = addslashes(html_entity_decode($shareText, ENT_QUOTES));
					
					$similarDate = date('j M. Y', $similarNode->created);
					
					$similarArticleType = field_get_items('node', $similarNode, 'field_article_category');
					
					$similarArticleTypeName = '';
					
					if(!empty($similarArticleType)){
						$similarArticleTypeObj = taxonomy_term_load($similarArticleType[0]['tid']);
						$similarArticleTypeName = $similarArticleTypeObj->name;
					}
					
					$similarImg = '';
					$similarAlt = '';
					$similarTtl = '';
					
					$similarThbImg = field_get_items('node', $similarNode, 'field_thumb_image');
					
					if(empty($similarThbImg)){
						$similarThbImg = field_get_items('node', $similarNode, 'field_cover_image');
					}
					
					$similarImg = image_style_url('hp_wet_paint', $similarThbImg[0]['uri']);
					
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
					
					$similarStoryContentTypeImage = '';
	
					if($similarNode->type == 'blogs' || $similarNode->type == 'listicles'){
						$similarStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/listicle-icon.png';
					}else if($similarNode->type == 'photo_essay'){
						$similarStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/pic-icon.png';
					}else if($similarNode->type == 'prodcast'){
						$similarStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/podcast-icon.png';
					}else if($similarNode->type == 'series'){
						$similarStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/series-icon.png';
					}else if($similarNode->type == 'videos'){
						$similarStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/video-icon.png';
					}
					
					$similarPath = url('node/' . $similarNode->nid, array('absolute' => true));
				?>
				<div class="itemWrap">
					<div class="topicImageContainer">
						<a href="<?php echo $similarPath; ?>"><img src="<?php echo $similarImg; ?>" alt="<?php echo $similarAlt; ?>" title="<?php echo $similarTtl; ?>" /></a>
					</div>
					<div class="description">
						<div class="topicHeader"><a href="<?php echo $similarPath; ?>"><?php echo $similarTitle; ?></a></div>
						<div class="topicSummary">
							<p><?php echo $similarSummary; ?> <a class="readMore" href="<?php echo $similarPath; ?>">Read More</a></p>
						</div>
						<div class="mediaIconHolder">
							<div class="mediaIcon video">
								<a href="<?php echo $similarPath; ?>"><img src="<?php echo $similarStoryContentTypeImage; ?>" /></a>
							</div>
							<div class="mediaIcon more">
								<div class="socialShare">
					                <div class="shareIcon"></div>
					                
					                <ul class="postButton">
										<li><a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $similarPath;?>');" class="fb">facebook</a></li>
										
										<li><a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $similarPath;?>','<?php echo $shareText; ?>');" class="tw">Twitter</a></li>
										
										<li><a href="javascript:void(0);" onClick="javascript:socialIcons('gplus','<?php echo $similarPath;?>');" class="gplus">Gplus</a></li>
										
										<li><a href="<?php print $similarPath; ?>#comments" class="mail">Email</a></li>
					                </ul>
					                <div class="clear"></div>
					            </div>
							</div>
							<span><?php echo $similarDate; echo (!empty($similarArticleTypeName)?' | '.$similarArticleTypeName.'':''); ?></span>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
		</div>
	</section>
	<?php }
}?>

<script type="text/javascript">
    var player,
      APIModules,
      videoPlayer,
      experienceModule;
			
    // utility
    logit = function (context, message) {
      if (console) {
          console.log(context, message);
      }
    };
         
    function onTemplateLoad(experienceID) {
      <?php if($deviceType == 'phone' || $deviceType == 'tablet'){ ?>
        player = brightcove.api.getExperience(experienceID);
      <?php }else{ ?>
        player = brightcove.getExperience(experienceID);
      <?php } ?>
      APIModules = brightcove.api.modules.APIModules;
    }
         
    function onTemplateReady(evt) {
      videoPlayer = player.getModule(APIModules.VIDEO_PLAYER);
      experienceModule = player.getModule(APIModules.EXPERIENCE);
			   
      videoPlayer.getCurrentRendition(function(renditionDTO) {
				 
        if (renditionDTO) {
            calulateNewPercentage(renditionDTO.frameWidth, renditionDTO.frameHeight);
        }else{
            videoPlayer.addEventListener(brightcove.api.events.MediaEvent.PLAY, function(event){
                calulateNewPercentage(event.media.renditions[0].frameWidth, event.media.renditions[0].frameHeight);	 
            });
        }
      });
				 
      var evt = document.createEvent('UIEvents');
      evt.initUIEvent('resize',true,false,0);
      window.dispatchEvent(evt);
			 
      //videoPlayer.play();
    }
			
    function calulateNewPercentage(width,height) {
      var newPercentage = ((height / width) * 100) + "%";
        
      document.getElementById("container1").style.paddingBottom = newPercentage;
    }
    
    <?php if($deviceType == 'phone'){ ?>
        window.onresize = function(evt) {
          var resizeWidth = window.innerWidth,
              resizeHeight = Math.round((resizeWidth*9)/16);

          //alert("Width: "+resizeWidth+", Height: "+resizeHeight+" Window Width: "+window.innerWidth+" Window Height: "+window.innerHeight);
          //console.log("Height: " + $(".BrightcoveExperience").innerHeight());

          if (experienceModule.experience.type == "html"){
              experienceModule.setSize(resizeWidth, resizeHeight)
          }
        }
    <?php }else if($deviceType == 'tablet'){ ?>
        window.onresize = function(evt) {
          var resizeWidth = window.innerWidth;
            
          if(resizeWidth <= 767){
              resizeWidth = resizeWidth;
          }else if(resizeWidth > 767 && resizeWidth < 1024){
              resizeWidth -= 180;
          }else{
              resizeWidth -= 200;
          }
            
          var resizeHeight = Math.round((resizeWidth*9)/16);

          //alert("Width: "+resizeWidth+", Height: "+resizeHeight+" Window Width: "+window.innerWidth+" Window Height: "+window.innerHeight);
          //console.log("Height: " + $(".BrightcoveExperience").innerHeight());

          if (experienceModule.experience.type == "html"){
              experienceModule.setSize(resizeWidth, resizeHeight)
          }
        }
    <?php }else{ ?>
        window.onresize = function(evt) {
          var resizeWidth = $(".BrightcoveExperience").width(),
              resizeHeight = $(".BrightcoveExperience").height();

          //alert("Width: "+resizeWidth+", Height: "+resizeHeight+" Window Width: "+window.innerWidth+" Window Height: "+window.innerHeight);
          //console.log("Height: " + $(".BrightcoveExperience").innerHeight());

          if (experienceModule.experience.type == "html"){
              experienceModule.setSize(resizeWidth, resizeHeight)
          }
        }
    <?php } ?>
    
</script>