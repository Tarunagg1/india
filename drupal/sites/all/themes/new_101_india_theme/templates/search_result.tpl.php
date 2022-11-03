<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
global $base_url;
$image_url = $base_url . '/' . drupal_get_path('theme', 'new_101_india_theme') . '/images/';

$url = urldecode($url);
//echo "url -----::><br/> ".$url;
//echo "url encode-----> ".htmlspecialchars_decode($url, ENT_NOQUOTES);
$path = preg_replace('/\//','',parse_url($url,PHP_URL_PATH),1); 
//echo '<br/> path....<br/>' . $path;
$org_path = drupal_lookup_path("source", $path);
//echo '<br/> org_path....<br/>' . $org_path;
$node = menu_get_object("node", 1, $org_path);
$nodeval=$node->nid;
//echo "new";
//print $nodeval;


/*$url = str_replace("%E2%80%99","’",$url);
$whatIWant = substr($url, strpos($url, ".com/") + 5);

echo "want: -- ".$whatIWant;
$abc = drupal_lookup_path('source', $whatIWant);
//echo "drupal node path--->".$abc;

//echo "node url: -- ".$url;
//echo "baba : -- ".str_replace("%E2%80%99","’",$url);
$nodeval = substr($abc, strpos($url, "node/") + 5);
echo "node id--: -- ".$nodeval;
$usrl_al = drupal_get_normal_path($whatIWant);*/

?> 

<?php
    if($node->type != 'subscription_entries'){
    $node = node_load($nodeval);
    $recentImg = '';
    //echo '<pre style="display: none">';print_r($node);echo '</pre>';
    //$search_result['title'] = $node->title;
    //$summary = $node->body['und'][0]['summary'];
    //$category = $node->field_article_category['und'][0]['value'];
    //$search_result['thumb_img'] = $node->field_thumb_image['und'][0]['uri'];
    //echo $title. "<br/>";
    //echo $summary. "<br/>";
    //echo $thumb_img. "<br/>";
    //print $snippet;
    //echo $node->timestamp;
    /*$recentThbImg = field_get_items('node', $node, 'field_thumb_image');

    if(empty($recentThbImg)){
        $recentThbImg = field_get_items('node', $node, 'field_cover_image');
    }*/
    //$recentImg = image_style_url('hp_whats_section', $recentThbImg['und'][0]['uri']);

    //$recentImg = image_style_url('hp_whats_section', $recentThbImg[0]['uri']);
    //dpm($snippet);
    $recentImg = image_style_url('hp_whats_section', $node->field_thumb_image['und'][0]['uri']);
    if(empty($recentImg)){
        $recentImg = image_style_url('hp_whats_section', $node->field_cover_image['und'][0]['uri']);
    }
   // echo $recentImg;
    $recentDate = date('j M, Y', $node->created);

    $recentSummary = $node->body['und'][0];

    $contentTypeName = $snippet;
    $contentTypeName = $node->field_article_category['und'][0]['tid'];
    $contentTypeName = taxonomy_term_load($contentTypeName);
    $contentTypeName = $contentTypeName->name;
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
    
    if(!empty($node->field_thumb_image['und'][0]['alt'])){
        $recentAlt = $node->field_thumb_image['und'][0]['alt'];
    }else{
        $recentAlt = $node->title;
    }

    /**
    if(!empty($node->field_thumb_image['und'][0]['title'])){
        $recentTtl = $node->field_thumb_image['und'][0]['title'];
    }else{
    **/

    $recentTtl = $node->title;
    

    if(!empty($recentSummary['summary'])){
        if(strlen($recentSummary['summary']) > 160){
            $recentSummary = substr($recentSummary['summary'], 0, strpos($recentSummary['summary'], ' ', 155));
            $recentSummary .= '...';
        }else{
            $recentSummary = $recentSummary['summary'];
        }
    }else{
        if(strlen($recentSummary['value']) > 160){
            $pos = strpos(strip_tags($recentSummary['value']), ' ', 155);
            $recentSummary = substr(strip_tags($recentSummary['value']), 0, $pos);
            $recentSummary .= '...';
        }else{
            $recentSummary = strip_tags($recentSummary['value']);
        }
    }

    if($node->type == 'videos'){
        $recentContentIcon = $image_url . 'video-play-icon.png';
        //$whatsNewContentText = '<span>' . '</span>';
        $recentClass = ' class="play"';

        $videoDuration = field_get_items('node', $node, 'field_vzaar_video_duration');

        $vidTimeStamphot = '';

        if(!empty($videoDuration[0]['value'])){
            $vidTimeStamphot = $videoDuration[0]['value'];

            //echo '<pre style="display:none">Video Time Stamp for YT is: ' . $vidTimeStamp . '</pre>';
        }else{
            $vidTimeStampSecs = $node->field_field_brightcove_video[0]['rendered']['#video']->length;

            $min = ($vidTimeStampSecs/1000/60) << 0;
            $sec = round(($vidTimeStampSecs/1000) % 60);
            $vidTimeStamphot = ((strlen($min) == 1)?'0'.$min:$min) . ':' . ((strlen($sec) == 1)?'0'.$sec:$sec);

            //echo '<pre style="display:none">Video Time Stamp for Bcove is: ' . $vidTimeStamp . '</pre>';
        }

        $recentContentText = '<span class="timeSpan">' . $vidTimeStamphot . '</span>';
    }else if($node->type == 'series'){
        $recentContentIcon = $image_url . 'play-icon-series.png';
        $recentContentText = '';
        $recentClass = '';
    }else{
        $recentContentIcon = $image_url . 'read-icon.jpg';
        $recentContentText = '';
        $recentClass = '';
    }
}
    ?> 



<!--<div class="page homePg">
<div class="containerwrap">
<div class="contentWrap contentSlide">
   
      
    
    
    
    
        <div class="listContent">
            <div class="masonryContent" id="displayData">-->
        <?php if($node->type != 'subscription_entries'){ ?> 
        <div class="masonry-brick item <?php echo $linkClass; ?> <?php echo $node->nid;?>">
            <div class="dataContainer">
                <?php /* ?><div class="metaDate"><span><?php echo $recentDate; ?></span></div><?php */ ?>
                <div class="imageContent">
                    <div class="categoryVal">
                        <a href="<?php echo $typeLink; ?>" ><?php print $typeName; ?></a>
                    </div>
                    <a class="detailLink" href="<?php echo $url; ?>">
                        <img src="<?php echo $recentImg; ?>" alt="<?php echo $recentAlt; ?>" title="<?php echo $recentTtl; ?>" />
                    </a>
                    <?php if($node->type == 'videos') { ?>
                    <div class="iconWrap vidOpt"> 
                       <a href="<?php echo $url; ?>" class="playVid"><span class="yellowPLay"></span><?php echo $recentContentText; ?></a>
                       <div class="clear"></div>
                    </div>
                    <?php }else if(($node->type == 'series') && ($node->field_video_checkbox['und'][0]['value'] == 1)) { ?>
                    <div class="iconWrap vidOpt"> 
                        <a class="playVid" href="<?php echo $url; ?>"><span class="yellowPLay"></span></a>
                    </div>
                    <?php }else if(($node->type == 'series') && ($node->field_video_checkbox['und'][0]['value'] == 0)) { $recentContentIcon = $image_url . 'read-icon.jpg'; ?>
                    <div class="iconWrap" >
                        <a href="<?php echo $url; ?>">  
                            <img<?php echo $recentClass; ?> src="<?php echo $recentContentIcon; ?>" /><?php echo $recentContentText; ?>
                        </a>    
                    </div>
                    <?php }else{ ?>
                    <div class="iconWrap" >
                        <a href="<?php echo $url; ?>">  
                            <img<?php echo $recentClass; ?> src="<?php echo $recentContentIcon; ?>" />  
                        </a>    
                    </div>
                    <?php } ?>
                </div>
                <div class="summary">
                    <h2><a href="<?php echo $url; ?>" ><?php echo $recentTtl; ?></a></h2>
                    <p><?php echo $recentSummary; ?></p>
                    <?php /* ?><div class="mobileDate"><span><?php echo $recentDate; ?></span></div><?php */ ?>
                </div>
                <div class="clear"></div>
            </div>
        </div> 
        <?php } ?>
                <!--</div>
</div>
    </div>
</div>
    <div class="clear"></div>
        <div class="test"></div>
    <div class="colRhs">
    </div>
    <div class="clear"></div>
</div>-->
