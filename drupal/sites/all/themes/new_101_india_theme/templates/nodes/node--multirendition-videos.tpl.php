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

$isBrightcove = FALSE;

if(!empty($content['field_brightcove_video'])){
	$isBrightcove = TRUE;
	
	$brightcoveVideo = render($content['field_brightcove_video']);
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

$twitterShare = addslashes(strip_tags($twitterShare));

//echo '<pre style="display: none">';print_r($brightcoveVideo);echo '</pre>';
//echo '<pre style="display: none">';print_r($content['field_brightcove_video']);echo '</pre>';
?>

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
        
        $('.videoPlay').fitVids();
	});
	
	var supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
	
	
	if(orientationEvent == 'orientationchange'){
		window.addEventListener(orientationEvent, function() {
			setTimeout(function(){
				$('.videoPlay').css('max-width', '100%');
				//$BCLcontainingBlock.css('max-height', height + 'px');
				$('videoPlay').fitVids();
			}, 500);
		
		}, false);
	}
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
					<span class="date"><?php echo date('jS M, Y',strtotime($datetime));?></span>
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
                    <?php print $brightcoveVideo; ?>
                    <script type="text/javascript">brightcove.createExperiences();</script>
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
            <h1 class="title" style="display:none;"><?php echo $title;?></h1>
			<div class="summary">
			   <?php echo $body[0]['value'];?>
			</div>
		   <div class="postMeta">
				 <span class="date"><?php echo date('jS M, Y',strtotime($datetime));?></span>
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
            
            <?php if(!isset($_COOKIE['user_subscribed'])){ ?>
                <div class="subscribeNow">
                    <div class="subscribeWrap">
                        <?php $block = module_invoke('simple_subscription', 'block_view', 'subscribe');
                        print render($block['content']); ?>
                    </div>
                </div>
            <?php }else if($_COOKIE['user_subscribed'] == 'just subscribed'){ ?>
                <div class="subscribeNow">
                    <div class="subscribeWrap">
                        <?php $block = module_invoke('simple_subscription', 'block_view', 'subscribe');
                        print render($block['content']); ?>
                    </div>
                </div>

                <?php drupal_add_js('$(document).ready(function(){
                                setTimeout(function(){
                                    $("#simple-subscription-form").fadeOut("slow");
                                },5000); });',
                    array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
                );

                setcookie("user_subscribed", "subscribed", time()+(60*60*24*30), "/");
            } ?>
            
		 </div>
		<div class="clear"></div>
		</div>
	</div>
</section>
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