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
<?php //echo '<pre style="display:none">' ;print_r(array_keys($fields));echo '</pre>';

global $base_url;

$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$contentTypeImage = '';
$contenttypeDisplayName = '';

if($fields['type']->content == 'videos'){
    $contentIcon = $image_url . 'video-play-icon.png';
    //$contentText = '';
    //$contentText = '<span>' . '</span>';
    $contentClass = ' class="play"';
    $contentText = '<span class="timeSpan">' . $fields['field_vzaar_video_duration']->content . '</span>';
}else if($fields['type']->content == 'series'){
    $contentIcon = $image_url . 'play-icon-series.png';
    $contentText = '';
    $contentClass = '';
}else{
    $contentIcon = $image_url . 'read-icon.jpg';
    $contentText = '';
    $contentClass = '';
}

$contentTypeName = $fields['field_article_category']->content;

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
        $typeLink = strtolower(str_replace(array('&', 'amp;', '&amp;', 'Amp;'), array('', '', '', ''), str_replace('101 ','',$contentTypeName)));
        $typeLink = $base_url.'/'.strtolower(str_replace('--', '-',str_replace(' ', '-', $typeLink)));
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
    $typeLink = strtolower($contentTypeName);
    
    if($typeLink == 'the brief'){
        $typeLink = 'brief';
    }
    
    $typeLink = $base_url.'/'.strtolower(str_replace('--', '-',str_replace(' ', '-', $typeLink)));
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

$title = trim($fields['title']->content);
$pos = 0;

if(strlen(trim($title)) > 90){
    $pos = strpos($title, ' ', 86);
    if($pos){
        $title = substr(trim($title), 0, $pos);
        $title .= '...';
    }
}else{
    $title = $title;
    $pos = strpos($title, ' ', 86);
}

$summary = htmlentities(strip_tags($fields['body']->content));

if(strlen($summary) > 160){
    $spos = strpos($summary, ' ', 155);
    if($spos){
        $summary = substr(trim($summary), 0, $spos);
        $summary .= '...';
    }
}else{
    $summary = $summary;
    //$summary .= '...';
}
?>

<div class="dataContainer">
    <?php //print '<p>' . $view->get_current_page() . '</p>'; ?>
    <?php /* ?><div class="metaDate"><span><?php print $fields['created']->content; ?></span></div><?php */ ?>
    <div class="imageContent">
        <div class="categoryVal"><a href="<?php echo $typeLink; ?>"><?php echo $typeName; ?></a></div>
        <a class="detailLink" href="<?php print $fields['path']->content; ?>"><?php print $fields['field_thumb_image']->content; ?></a>
		<?php if($fields['type']->content == 'videos'){ ?>
		<div class="iconWrap vidOpt"> 
		   <a href="<?php print $fields['path']->content; ?>" class="playVid"><span class="yellowPLay"></span><?php echo $contentText; ?></a>
		   <div class="clear"></div>
		</div>
		<?php }else if($fields['type']->content == 'series'){ ?>
		<div class="iconWrap vidOpt"> 
			<a class="playVid" href="<?php print $fields['path']->content; ?>"><span class="yellowPLay"></span></a>
		</div>
		<?php } else { ?>
        <div class="iconWrap">
            <a href="<?php print $fields['path']->content; ?>"><img<?php echo $contentClass; ?> src="<?php echo $contentIcon; ?>" alt="icon" /><?php print $contentText; ?></a>
        </div>
		<?php } ?>
    </div>
    
    <div class="summary">
        <h2><a href="<?php print $fields['path']->content; ?>"><?php print $title; ?></a></h2>
        <?php /* ?><div class="mobileDate"><span><?php print $fields['created']->content; ?></span></div><?php */ ?>
        <p><?php
        $summary = html_entity_decode($summary, ENT_QUOTES);
        print $summary; ?></p>
    </div>
    <div class="clear"></div>
</div>