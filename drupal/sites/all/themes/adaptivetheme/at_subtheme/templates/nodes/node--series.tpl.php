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

//echo '<pre style="display: none">';print_r(($content['field_tags']));echo '</pre>';
//echo '<pre style="display: none">';print_r($base_url);echo '</pre>';

$pageURL = $base_url.$node_url;

$pageImage = '';

if(isset($content['field_cover_image']['#items']) && !empty($content['field_cover_image']['#items'])){
	$image = field_get_items('node', $node, 'field_cover_image');
	
	$pageImage = image_style_url('hp_series', $image[0]['uri']);
}else{
	$image = field_get_items('node', $node, 'field_thumb_image');
	
	$pageImage = image_style_url('hp_series', $image[0]['uri']);
}

$firstStory = array();

$firtStoryNid = 0;

foreach($content['field_series_stories']['#items'] as $frKey=>$frNode){
	if(empty($frNode['access']) || $frNode['access'] != 1){
		continue;
	}
	
	$firtStoryNid = $frNode['nid'];
	
	$firstStory = $frNode['node'];
	
	break;
}

$firstStorySumm = field_get_items('node', $firstStory, 'body');

if(isset($firstStorySumm[0]['summary']) && !empty($firstStorySumm[0]['summary'])){
	$firstStorySumm = $firstStorySumm[0]['summary'];
}else if(isset($firstStorySumm[0]['value']) && !empty($firstStorySumm[0]['value'])){
	$firstStorySumm = strip_tags($firstStorySumm[0]['value']);
}

if(!empty($firstStorySumm)){
	if(strlen($firstStorySumm) > 165){
		$firstStorySumm = substr($firstStorySumm, 0, 165);
	}
	$firstStorySumm .= '...';
}

$firstStoryDate = date('j M. Y', $firstStory->created);

$firstStoryImg = '';

$firstStoryCovImg = field_get_items('node', $firstStory, 'field_cover_image');
$firstStoryAlt = '';
$firstStoryTtl = '';

if(!empty($firstStoryCovImg)){
	$firstStoryImg = image_style_url('hp_series', $firstStoryCovImg[0]['uri']);
	
	if(!empty($firstStoryCovImg[0]['alt'])){
		$firstStoryAlt = $firstStoryCovImg[0]['alt'];
	}else{
		$firstStoryAlt = $firstStory->title;
	}
	  
	if(!empty($firstStoryCovImg[0]['title'])){
		$firstStoryTtl = $firstStoryCovImg[0]['title'];
	}else{
		$firstStoryTtl = $firstStory->title;
	}
}else{
	$firstStoryThbImg = field_get_items('node', $firstStory, 'field_thumb_image');
	
	$firstStoryImg = image_style_url('hp_series', $firstStoryThbImg[0]['uri']);
	
	if(!empty($firstStoryThbImg[0]['alt'])){
		$firstStoryAlt = $firstStoryThbImg[0]['alt'];
	}else{
		$firstStoryAlt = $firstStory->title;
	}
	  
	if(!empty($firstStoryThbImg[0]['title'])){
		$firstStoryTtl = $firstStoryThbImg[0]['title'];
	}else{
		$firstStoryTtl = $firstStory->title;
	}
}

$firstStoryPath = url('node/' . $firstStory->nid, array('absolute' => true));

$firstStoryContentTypeImage = '';

if($firstStory->type == 'blogs' || $firstStory->type == 'listicles'){
	$firstStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/listicle-icon.png';
}else if($firstStory->type == 'photo_essay'){
	$firstStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/pic-icon.png';
}else if($firstStory->type == 'prodcast'){
	$firstStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/podcast-icon.png';
}else if($firstStory->type == 'series'){
	$firstStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/series-icon.png';
}else if($firstStory->type == 'videos'){
	$firstStoryContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/video-icon.png';
}

$firstStoryArticleType = field_get_items('node', $firstStory, 'field_article_category');

$firstStoryArticleTypeName = '';

if(!empty($firstStoryArticleType)){
	$firstStoryArticleTypeObj = taxonomy_term_load($firstStoryArticleType[0]['tid']);
	$firstStoryArticleTypeName = $firstStoryArticleTypeObj->name;
}

$firstStoryShareText = $firstStory->title;

if(strlen($firstStoryShareText) > 125){
	$pos = strpos($firstStoryShareText, ' ', 125);
	if($pos != FALSE){
		$firstStoryShareText = substr($firstStoryShareText, 0, $pos) . '...';
	}
}

$firstStoryShareText = addslashes(html_entity_decode(strip_tags($firstStoryShareText), ENT_QUOTES));

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
$next_prev = custom_prev_next_node($node->nid, array('not_in' => array('page', 'series')));

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

$url = $base_url . $node_url;
	
//echo '<pre style="display: none">';print_r(field_get_items('node', $firstStory, 'field_article_category'));echo '</pre>';
?>

<script type="text/javascript">
	$(window).load(function(){
		var $container = $('#seriesStory');
		$container.masonry({
			itemSelector: '.itemWrap',
			gutter:5,
            isResizable:true
			//columnWidth:  $container.width() / 3,
			
		}).imagesLoaded(function(){
			$container.masonry('reloadItems');
		});
	});
</script>
  
<div class="topContent">
	<div class="lhsContent">
        <div class="storyContainer">
            <h1><?php print $title; ?></h1>
            
            <?php print $body[0]['value']; ?>
            
            <div class="socialIconsContainer">
                <div class="twitterIcon">
                	<a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $pageURL; ?>','<?php echo $twitterShare; ?>');"><img src="<?php echo $base_url .'/'.drupal_get_path('theme', 'adaptivetheme_subtheme'); ?>/images/twitter-icon.png" /></a>
            	</div>
                <div class="fbIcon">
                	<a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $pageURL; ?>');"><img src="<?php echo $base_url .'/'.drupal_get_path('theme', 'adaptivetheme_subtheme'); ?>/images/fb-icon.png" /></a>
            	</div>
                <div class="gplusIcon">
                	<a href="javascript:void(0);" onclick="javascript:socialIcons('gplus','<?php echo $pageURL; ?>');"><img src="<?php echo $base_url .'/'.drupal_get_path('theme', 'adaptivetheme_subtheme'); ?>/images/gplus-icon.png" /></a>
            	</div>
            	<div class="views">
            		
            	</div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="rhsContent">
        <div class="imageContainer">
            <a href="<?php echo $firstStoryPath; ?>">
            	<img src="<?php echo $firstStoryImg; ?>" alt="<?php echo $firstStoryAlt; ?>" title="<?php echo $firstStoryTtl; ?>" />
            </a>
            <div class="imageOverlay">
                    <div class="rhsContainer">
                        <h2><a href="<?php echo $firstStoryPath; ?>"><?php echo $firstStory->title; ?></a></h2>
                        <p><?php echo (!empty($firstStorySumm)?$firstStorySumm:''); ?> <a href="<?php echo $firstStoryPath; ?>">Read More</a></p>
                        <span><?php echo $firstStoryDate; echo (!empty($firstStoryArticleTypeName)?' | '.$firstStoryArticleTypeName.'':''); ?></span>
                    </div>
                    <div class="lhsContainer">
                        <div class="videoContainer">
                            <a href="<?php echo $firstStoryPath; ?>"><img src="<?php echo $firstStoryContentTypeImage; ?>" /></a>
                        </div>
                        <div class="cameraContainer">
                            <div class="socialShare">
				                <div class="shareIcon"></div>
				                
				                <ul class="postButton">
									<li><a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $firstStoryPath;?>');" class="fb">facebook</a></li>
									
									<li><a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $firstStoryPath;?>','<?php echo $firstStoryShareText; ?>');" class="tw">Twitter</a></li>
									
									<li><a href="javascript:void(0);" onClick="javascript:socialIcons('gplus','<?php echo $firstStoryPath;?>');" class="gplus">Gplus</a></li>
									
									<li><a href="<?php print $firstStoryPath; ?>#comments" class="mail">Email</a></li>
				                </ul>
				                <div class="clear"></div>
				            </div>
                        </div>
                    </div>
                    <span class="date"><?php echo $firstStoryDate; ?></span>
                    <div class="clear"></div>
                </div>
        </div>
    </div>
	<div class="clear"></div>
</div>

<?php if($relatedStoriesCount > 1){ ?>
<section class="mustWatchSection content">
	<div class="wrapper">
		<div class="listed" id="seriesStory">
			<?php foreach($content['field_series_stories']['#items'] as $rKey=>$stories){
				if($firtStoryNid == $stories['nid']){
					continue;
				}
				
				if(empty($stories['access']) || $stories['access'] != 1){
					continue;
				}
				
				$entity = $stories['node'];
				
				$storyTitle = '';
				
				$shortTitle = field_get_items('node', $entity, 'field_short_title');
				
				if(!empty($shortTitle)){
					$storyTitle = $shortTitle[0]['value'];
				}else{
					$storyTitle = $entity->title;
				}
				
				if(strlen($storyTitle) > 65){
					$storyTitle = substr($storyTitle, 0, 65);
				}
				
				$summary = field_get_items('node', $entity, 'body');
	
				if(!empty($summary[0]['summary'])){
					if(strlen($summary[0]['summary']) > 165){
						$summary = substr($summary[0]['summary'], 0, 165);
						$summary .= '...';
					}else{
						$summary = $summary[0]['summary'];
					}
				}else{
					if(strlen($summary[0]['value']) > 165){
						$summary = substr($summary[0]['value'], 0, 165);
						$summary .= '...';
					}else{
						$summary = $summary[0]['value'];
					}
				}
				
				$storyArticleType = field_get_items('node', $entity, 'field_article_category');

				$storyArticleTypeName = '';
				
				if(!empty($storyArticleType)){
					$storyArticleTypeObj = taxonomy_term_load($storyArticleType[0]['tid']);
					$storyArticleTypeName = $storyArticleTypeObj->name;
				}
				
				$date = date('j M. Y', $entity->created);
				
				$storyImg = '';
				$storyAlt = '';
				$storyTtl = '';
				
				$storyThbImg = field_get_items('node', $entity, 'field_thumb_image');
				
				$storyImg = image_style_url('hp_wet_paint', $storyThbImg[0]['uri']);
				
				if(!empty($storyThbImg[0]['alt'])){
					$storyAlt = $storyThbImg[0]['alt'];
				}else{
					$storyAlt = $entity->title;
				}
				  
				if(!empty($storyThbImg[0]['title'])){
					$storyTtl = $storyThbImg[0]['title'];
				}else{
					$storyTtl = $entity->title;
				}
				
				$storyContentTypeImage = '';
	
				if($entity->type == 'blogs' || $entity->type == 'listicles'){
					$storyContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/listicle-icon.png';
				}else if($entity->type == 'photo_essay'){
					$storyContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/pic-icon.png';
				}else if($entity->type == 'prodcast'){
					$storyContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/podcast-icon.png';
				}else if($entity->type == 'series'){
					$storyContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/series-icon.png';
				}else if($entity->type == 'videos'){
					$storyContentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/video-icon.png';
				}
				
				$storyShareText = $entity->title;
	
				if(strlen($storyShareText) > 125){
					$pos = strpos($storyShareText, ' ', 125);
					if($pos != FALSE){
						$storyShareText = substr($storyShareText, 0, $pos) . '...';
					}
				}
				
				$storyShareText = addslashes(html_entity_decode(strip_tags($storyShareText), ENT_QUOTES));
				
				$path = url('node/' . $entity->nid, array('absolute' => true));
			?>
			<div class="itemWrap">
				<div class="masonryItemWrapper pattern">
					<div class="topicImageContainer">
		            	<a href="<?php echo $path; ?>">
		            		<img src="<?php echo $storyImg; ?>" alt="<?php echo $storyAlt; ?>" title="<?php echo $storyTtl; ?>" />
		        		</a>
		            </div>
		            <div class="description">
		                <div class="topicHeader"><a href="<?php echo $path; ?>"><?php echo $storyTitle; ?></a></div>
		                
		                <div class="topicSummary">
		                    <p><?php echo $summary; ?> <a class="readMore" href="<?php echo $path; ?>">Read More</a></p>
		                </div>
		                <div class="mediaIconHolder">
		                    <div class="mediaIcon video">
		                    	<a href="<?php echo $path; ?>"><img src="<?php echo $storyContentTypeImage; ?>" /></a>
		                    </div>
		                    <div class="mediaIcon more">
		                    	<div class="socialShare">
					                <div class="shareIcon"></div>
					                
					                <ul class="postButton">
										<li><a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $path;?>');" class="fb">facebook</a></li>
										
										<li><a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $path;?>','<?php echo $storyShareText; ?>');" class="tw">Twitter</a></li>
										
										<li><a href="javascript:void(0);" onClick="javascript:socialIcons('gplus','<?php echo $path;?>');" class="gplus">Gplus</a></li>
										
										<li><a href="<?php print $path; ?>#comments" class="mail">Email</a></li>
					                </ul>
					                <div class="clear"></div>
					            </div>
		                    </div>
		                    <span><?php echo $date; echo (!empty($storyArticleTypeName)?' | '.$storyArticleTypeName.'':''); ?></span>
		                    <div class="clear"></div>
		                </div>
		            </div>
		        </div>
	        </div>
	        <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<div id="comments" class="fbCommentBox">
	<div class="fb-comments" data-href="<?php echo $url;?>" data-width="100%" data-numposts="4" data-colorscheme="light"></div>
</div>

<?php
	$similarStories = views_get_view('other_series');
	$similarStories->set_display('block');
    $similarStories->set_arguments(array($node->nid));
	$filter_1 = $similarStories->get_item('block', 'filter', 'nid');
	$filter_1['value'] = array($node->nid);
	$similarStories->set_item('block', 'filter', 'tid', $filter_1);
	$similarStories->pre_execute();
	$similarStories->execute();

	$similarCount = count($similarStories->result);

	if($similarCount > 0){ ?>
	<section class="wetPaintSection similarStoriesSection">
		<div class="wrapper">
			<h2>Other Series</h2>
			
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
						$similarSummary = $similarSummary[0]['summary'] . '...';
					}
				}else{
					if(strlen($similarSummary[0]['value']) > 165){
						$similarSummary = substr(strip_tags($similarSummary[0]['value']), 0, 165);
						$similarSummary .= '...';
					}else{
						$similarSummary = strip_tags($similarSummary[0]['value']) . '...';
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
<?php } ?>