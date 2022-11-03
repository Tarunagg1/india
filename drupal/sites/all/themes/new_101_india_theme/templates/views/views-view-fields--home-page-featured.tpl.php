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
global $base_url;

//echo '<pre style="display: none">';print_r(array_keys($fields));echo '</pre>';

$theme_url = drupal_get_path('theme', 'new_101_india_theme');
$image_url = $base_url . '/' . $theme_url . '/images/';

$contentTypeImage = '';
$contenttypeDisplayName = '';

if($fields['type']->content == 'videos') {
    $contentIcon = $image_url . 'video-play-icon.png';
    //$contentText = '<span>' . '</span>';
    $contentClass = ' class="play"';
    
    $vidTimeStamp = '';
    
    
    if(!empty($fields['field_vzaar_video_duration']->content)){

        $vidTimeStamp = $fields['field_vzaar_video_duration']->content;
        
       //echo '<pre style="display: none">';print_r($vidTimeStamp);echo '</pre>';
    }else if(!empty($fields['field_brightcove_video']->content)){
       // echo '<pre style="display:none">In Bcove: \n' ;print_r(($fields['field_brightcove_video']->content));echo '</pre>';
        
        $vidTimeStampSecs = explode(':', $fields['field_brightcove_video']->content);

        $min = ((int)$vidTimeStampSecs[1]/1000/60) << 0;
        $sec = round(((int)$vidTimeStampSecs[1]/1000) % 60);
        $vidTimeStamp = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);
    }else{
        $vidTimeStamp="";
    }

    
    $contentText = '<span class="timeSpan">' . $vidTimeStamp . '</span>';
}else{
    $contentIcon = $image_url . 'read-icon.jpg';
    $contentText = '';
    $contentClass = '';
}

$descPosition = '';

if(!empty($fields['field_hp_desc_pos']->content)){
    $descPosition = $fields['field_hp_desc_pos']->content;
}else{
    $descPosition = 'bottomLeft';
}
?>
<img class="transImg" src="<?php echo $image_url;?>transparent-bg-new.png">
<a href="<?php print $fields['path']->content; ?>" class="bannerImg">
    <?php if(!empty($fields['field_home_page_featured_image'])){
        print $fields['field_home_page_featured_image']->content;
    }else if(!empty($fields['field_cover_image'])){
        print $fields['field_cover_image']->content;
    }else{
        print $fields['field_thumb_image']->content;
    }?>
</a>

<div class="dataContainer <?php echo $descPosition; ?>">
    <div class="imageContent">
        
		<?php if($fields['type']->content == 'videos'){ ?>
		<div class="iconWrap vidOpt"> 
		   <a href="<?php print $fields['path']->content; ?>" class="playVid"><span class="yellowPLay"></span><?php echo $contentText; ?></a>
		   <div class="subsBtn"><div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div></div>
		   <!-- <div class="subsBtn"><a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"href=""><img src="http://india101dev.prod.acquia-sites.com/sites/default/files/image-upload/youtube101.png" border="0"></a></div> -->
		   <div class="clear"></div>
	    </div>
		<?php } else if(($fields['type']->content == 'series') && ($fields['field_video_checkbox']->content == 1)) { ?>
		<div class="iconWrap vidOpt"> 
		   <a class="playVid" href="<?php print $fields['path']->content; ?>"><span class="yellowPLay"></span><?php echo $contentText; ?></a>
           <div class="clear"></div>
		</div>
        <?php } else if(($fields['type']->content == 'series') && ($fields['field_video_checkbox']->content == 0)) { 
            $contentIcon = $image_url . 'read-icon.jpg';
        ?>
        <div class="iconWrap">
            <a href="<?php print $fields['path']->content; ?>"><img<?php echo $contentClass; ?> src="<?php echo $contentIcon; ?>" alt="icon" /><?php echo $contentText; ?></a>
        </div>
		<?php } else { ?>
		<div class="iconWrap">
            <a href="<?php print $fields['path']->content; ?>"><img<?php echo $contentClass;?> src="<?php echo $contentIcon; ?>" alt="icon" /><?php echo $contentText; ?></a>
        </div>
		<?php } ?>
    </div>
    <a href="<?php print $fields['path']->content; ?>">
        <div class="summary">
            <h2><?php print $fields['title']->content; ?></h2>
            <?php /* ?><div class="metaDate"><span><?php print $fields['created']->content; ?></span></div><?php */ ?>
            <?php // print $fields['body']->content; ?>
        </div>
    </a>
    <div class="clear"></div>
</div>














