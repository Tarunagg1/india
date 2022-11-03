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
<?php //echo '<pre style="display:none">' ;print_r(($fields['field_brightcove_video']->content));echo '</pre>';

global $base_url;

$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$contentTypeImage = '';
$contenttypeDisplayName = '';

if($fields['type']->content == 'videos'){
    $contentIcon = $image_url . 'video-play-icon.png';
    $contentText = '';
    //$contentText = '<span>' . '</span>';
    $contentClass = ' class="play"';
}else{
    $contentIcon = $image_url . 'read-icon.png';
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


/*if(strstr($contentTypeName,'101')){
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
}*/

$title = trim($fields['title']->content);
$pos = 0;

if(strlen(trim($title)) > 90){
    $title = substr(trim($title), 0, strpos(trim($title), ' ', 86));
    $title .= '...';
    $pos = strpos($title, ' ', 86);
}else{
    $title = $title;
    $pos = strpos($title, ' ', 86);
}

$summary = htmlentities(trim(strip_tags($fields['body']->content)));

if(strlen($summary) > 90){
    $summary = substr($summary, 0, strpos($summary, ' ', 86));
    $summary .= '...';
}else{
    $summary = $summary;
    //$summary .= '...';
}
?>

<div class="dataContainer">
    <?php /* ?><div class="metaDate"><span><?php print $fields['created']->content; ?></span></div><?php */ ?>
    <div class="imageContent">
        <div class="categoryVal"><?php echo $typeName; ?></div>
        <a class="detailLink" href="<?php print $fields['path']->content; ?>"><?php print $fields['field_thumb_image']->content; ?></a>
        <div class="iconWrap">
            <a href="<?php print $fields['path']->content; ?>"><img<?php echo $contentClass; ?> src="<?php echo $contentIcon; ?>" alt="icon" /><?php $contentText; ?></a>
        </div>
    </div>
    
    <div class="summary">
        <h2><a href="<?php print $fields['path']->content; ?>"><?php print $title; ?></a></h2>
        <?php /* ?><div class="mobileDate"><span><?php print $fields['created']->content; ?></span></div><?php */ ?>
        <p><?php print $summary; ?></p>
    </div>
    <div class="clear"></div>
</div>