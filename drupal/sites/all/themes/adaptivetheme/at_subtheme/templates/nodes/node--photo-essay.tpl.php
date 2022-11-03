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

global $base_url;

$url = $base_url.$node_url;

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
$twitterShare = $title;

if(strlen($twitterShare) > 125){
	$pos = strpos($twitterShare, ' ', 125);
	if($pos != FALSE){
		$twitterShare = substr($twitterShare, 0, $pos) . '...';
	}
}

$twitterShare = addslashes(html_entity_decode(strip_tags($twitterShare), ENT_QUOTES));

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
?>
<script type="text/javascript">
function titleBar(){
	
	$(window).on("scroll", function(){
		var $titlebar = $('.titleBar');
				var $title = $('.postDetailContent .title');
                var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
				if (scrollTop > $title.offset().top+200) {
					 $titlebar.fadeIn("fast");
					 //console.log("titlebar show");
			    }
				else{
					$titlebar.fadeOut("fast");
					 //console.log("titlebar hide");
				}
	});

}

$(document).ready(function() {
    titleBar();
});
</script>

<?php drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/sticky.js'); ?>

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
								<a href="javascript:void(0);" onClick="socialIcons('facebook','<?php echo $url;?>');"  class="fb">facebook</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);"  onClick="socialIcons('twitter','<?php echo $url;?>','<?php echo $twitterShare;?>');" class="tw">twitter</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);"  onClick="socialIcons('gplus','<?php echo $url;?>');" class="gplus">gplus</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);" onClick="slideToComment();" class="mail">email</a>
							</span>
						</div>
			 		</div>
				</div>
			</div>
		</div>
		<div class="postDetail">
			<?php if($image = render($content['field_cover_image'])){ ?>
			<div class="coverImage">
				<?php print $image; ?>
			</div>
			<?php } ?>
			<div class="postDetailContent">
				<div class="content">
					<h1 class="title"><?php echo $title;?></h1>
					<div class="summary">
						<?php echo $body[0]['value'];?>
					</div>
					<div class="postInfo">
						<div class="postButton">
							<span class="button">
								<a href="javascript:void(0);" onClick="socialIcons('facebook','<?php echo $url;?>');"  class="fb">facebook</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);"  onClick="socialIcons('twitter','<?php echo $url;?>','<?php echo $twitterShare;?>');" class="tw">twitter</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);"  onClick="socialIcons('gplus','<?php echo $url;?>');" class="gplus">gplus</a>
							</span>
							<span class="button">
								<a href="javascript:void(0);" onClick="slideToComment();" class="mail">email</a>
							</span>
							<span class="button views"><?php echo $totalViewsStr;?> <?php echo ($totalViews==0 || $totalViews > 1)?'Views':'View'; ?></span>
						</div>
						<div class="postMeta">
							<span class="date"><?php echo date('jS M, Y',strtotime($datetime));?></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="postContent">
					<?php 
						$essay = $content['field_essay']['#items'];
						foreach($essay as $key=>$desc){ ?>
							
							<?php if(isset($desc['field_essay_title']['und']) && !empty($desc['field_essay_title']['und'])){ ?>
								<div class="contentHeading"><?php echo strip_tags($desc['field_essay_title']['und'][0]['value']);?></div>
							<?php } ?>
							
							<?php if(isset($desc['field_listicle_body']['und']) && !empty($desc['field_listicle_body']['und'])){ ?>
								<?php echo $desc['field_listicle_body']['und'][0]['value'];?>
							<?php } ?>
							
							<?php if(isset($desc['field_image']['und']) && !empty($desc['field_image']['und'])){ ?>
								<p>
									<img src="<?php echo $imagePath = image_style_url('listicle_photoessay',$desc['field_image']['und'][0]['uri']); ?>" />
								</p>
							<?php } ?>
					<?php } ?>
					</div>
					
					<div id="comments"><div class="fb-comments" data-href="<?php echo $url;?>" data-width="100%" data-numposts="4" data-colorscheme="light"></div></div>
					
				</div>
				
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
					<div class="sidebar">
					<section class="relatedStories">
						<div class="wrapper">
							<h2>Must Watch</h2>
							
							<div>
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
					</div>
					<?php }
					}?>
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