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

if($fields['type']->content == 'blogs' || $fields['type']->content == 'listicles'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/listicle-icon.png';
}else if($fields['type']->content == 'photo_essay'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/pic-icon.png';
}else if($fields['type']->content == 'prodcast'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/podcast-icon.png';
}else if($fields['type']->content == 'series'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/series-icon.png';
}else if($fields['type']->content == 'videos'){
	$contentTypeImage = $base_url . '/' . drupal_get_path('theme', 'adaptivetheme_subtheme') . '/images/video-icon.png';
}

$url = $base_url . $fields['path']->content;

$shareImage = '';

if(isset($fields['field_home_page_featured_image']) && !empty($fields['field_home_page_featured_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_home_page_featured_image']->content,$shareImageArr);
}else if(isset($fields['field_thumb_image']) && !empty($fields['field_thumb_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_thumb_image']->content,$shareImageArr);
}else if(isset($fields['field_cover_image']) && !empty($fields['field_cover_image'])){
	preg_match_all('/(src)=("[^"]*")/i',$fields['field_cover_image']->content,$shareImageArr);
}

//echo '<pre style="display: none">';print_r($shareImageArr);echo '</pre>';

$shareImage = str_replace('"', '', $shareImageArr[2][0]);

//echo '<pre style="display: none">';print_r($shareImage);echo '</pre>';

$shareText = strip_tags($fields['title']->content);

if(strlen($shareText) > 125){
	$pos = strpos($shareText, ' ', 125);
	if($pos != FALSE){
		$shareText = substr($shareText, 0, $pos) . '...';
	}
}

$shareText = addslashes(html_entity_decode($shareText, ENT_QUOTES));

if(isset($fields['field_short_title']) && !empty($fields['field_short_title']->content)){
	$shortTitle = $fields['field_short_title']->content;
}else{
	$shortTitle = substr($fields['title']->content, 0, 80);
}
?>

<a href="<?php print $fields['path']->content; ?>"><img src="<?php print $shareImage; ?>" alt="<?php echo $shortTitle; ?>" title="<?php echo $shortTitle; ?>" /></a>

<div class="imageOverlay">
	<div class="rhsContainer">
		<h2><a href="<?php print $fields['path']->content; ?>"><?php print $shortTitle; ?></a></h2>
		<p><?php print strip_tags($fields['body']->content); ?> <a href="<?php print $fields['path']->content; ?>">Read More</a></p>
		<?php /*<span>24 Sept. 2014</span>*/ ?><span><?php print $fields['created']->content; echo (isset($fields['field_article_category']) && !empty($fields['field_article_category'])?' | '.$fields['field_article_category']->content.'':''); ?></span>
	</div>
	<div class="lhsContainer">
		<div class="videoContainer">
			<a href="<?php print $fields['path']->content; ?>"><img src="<?php echo $contentTypeImage; ?>" alt="icon" /></a>
		</div>
		<div class="cameraContainer">
        	<div class="socialShare">
                <div class="shareIcon"></div>
                
                <ul class="postButton">
					<li><a href="javascript:void(0);" onclick="javascript:socialIcons('facebook','<?php echo $url;?>','','');" class="fb">facebook</a></li>
					
					<li><a href="javascript:void(0);" onclick="javascript:socialIcons('twitter','<?php echo $url;?>','<?php echo $shareText; ?>','');" class="tw">Twitter</a></li>
					
					<li><a href="javascript:void(0);" onClick="javascript:socialIcons('gplus','<?php echo $url;?>','','');" class="gplus">Gplus</a></li>
					
					<li><a href="<?php print $fields['path']->content; ?>#comments" class="mail">Email</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
	</div>
	<?php /*<span class="date"><?php print $fields['created']->content; echo (isset($fields['field_article_category']) && !empty($fields['field_article_category'])?' | '.$fields['field_article_category']->content.'':''); ?></span>*/ ?>
	<div class="clear"></div>
</div>