<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php //echo '<pre style="display:none">' ;var_dump($fields['body']->content);echo '</pre>';
global $base_url;

$contentTypeImage = '';
$contenttypeDisplayName = '';

if($fields['type']->content == 'blogs'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/listicle-icon.png';
    $contenttypeDisplayName = 'Blog';
}else if($fields['type']->content == 'listicles'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/listicle-icon.png';
    $contenttypeDisplayName = 'Listicle';
}else if($fields['type']->content == 'photo_essay'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/pic-icon.png';
    $contenttypeDisplayName = 'Photo Essay';
}else if($fields['type']->content == 'prodcast'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/podcast-icon.png';
    $contenttypeDisplayName = 'Podcast';
}else if($fields['type']->content == 'series'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/series-icon.png';
    $contenttypeDisplayName = 'Series';
}else if($fields['type']->content == 'videos'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/video-icon.png';
    $contenttypeDisplayName = 'Video';
}

$url = $base_url . $fields['path']->content;

/*$shareImage = '';

if(isset($fields['field_thumb_image']) && !empty($fields['field_thumb_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_cover_image']->content,$shareImageArr);
}else if(isset($fields['field_cover_image']) && !empty($fields['field_cover_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_cover_image']->content,$shareImageArr);
}else if(isset($fields['field_home_page_featured_image']) && !empty($fields['field_home_page_featured_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_cover_image']->content,$shareImageArr);
}

//echo '<pre style="display: none">';print_r($shareImageArr);echo '</pre>';

$shareImage = str_replace('"', '', $shareImageArr[2][0]);

//echo '<pre style="display: none">';print_r($shareImage);echo '</pre>';*/

$shareText = strip_tags($fields['title']->content);

if(strlen($shareText) > 125){
	$pos = strpos($shareText, ' ', 125);
	if($pos != FALSE){
		$shareText = substr($shareText, 0, $pos) . '...';
	}
}

$shareText = addslashes($shareText);


$contentTypeName = $fields['field_article_category']->content;

if(strstr($contentTypeName,'101')){
	if($contentTypeName == "101 Travel"){
		$typeLink = $base_url.'/travel-food';
	}else if($contentTypeName == "101 Janta"){
		$typeLink = $base_url.'/people';
	}else{
		$typeLink = $base_url.'/'.strtolower(str_replace('101 ','',$contentTypeName));
	}
}else{
	$typeLink = $base_url.'/'.strtolower($contentTypeName);
}
?>

<div class="masonryItemWrapper pattern">
	<div class="topicImageContainer">
		<a href="<?php print $fields['path']->content; ?>"><?php print $fields['field_thumb_image']->content; ?></a>
	</div>
	
	<div class="description">
	    <div class="topicHeader">
	        <a href="<?php print $fields['path']->content; ?>"><?php print $fields['title']->content; ?></a>
	    </div>
	    <div class="topicSummary">
	        <p><?php print strip_tags($fields['body']->content); ?>... <a class="readMore" href="<?php print $fields['path']->content; ?>">Read More</a></p>
	    </div>
	    <div class="mediaIconHolder">
	        <div class="mediaIcon video">
	        	<?php /*<img src="<?php echo $contentTypeImage; ?>" />*/ ?><p><?php echo $contenttypeDisplayName; ?></p>
	        </div>
	        <?php /*<div class="mediaIcon more">
	            <div class="socialShare">
	                <div class="shareIcon"></div>
	                <ul class="postButton">
						<li><a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $fields['path']->content;?>');" class="fb">facebook</a></li>
						
						<li><a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $fields['path']->content;?>','<?php echo $shareText; ?>');" class="tw">Twitter</a></li>
						
						<li><a href="javascript:void(0);" onClick="javascript:socialIcons('gplus','<?php echo $fields['path']->content;?>');" class="gplus">Gplus</a></li>
						
						<?php if($fields['type']->content != 'series'){ ?>
							<li><a href="<?php print $fields['path']->content; ?>#comments" class="mail">Email</a></li>
						<?php } ?>
	                </ul>
	                <div class="clear"></div>
	            </div>
	        </div>*/ ?>
	        <span><?php print $fields['created']->content; ?>
				<a href="<?php echo $typeLink;?>">
					<?php echo (isset($fields['field_article_category']) && !empty($fields['field_article_category'])?' | '.$fields['field_article_category']->content.'':''); ?>
				</a>
			</span>
	        <div class="clear"></div>
	    </div>
	</div>
</div>