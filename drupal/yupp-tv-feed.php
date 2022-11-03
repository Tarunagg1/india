<?php
define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$whatsNewView = views_get_view('yupp_tv_feeds');
$whatsNewView->set_display('page');
$whatsNewView->pre_execute();
$whatsNewView->execute();
$whatsNewRes = $whatsNewView->result;


header("Content-type: application/xml"); 

echo '<?xml version="1.0"?>
<rss xmlns:media="https://search.yahoo.com/mrss/" xmlns:dcterms="http://purl.org/dc/terms/" version="2.0">
<channel><title>101 India</title><link>'.$base_url.'</link>'; 

//$tagg = array();

foreach ($whatsNewRes as $key=>$val){
/*echo "<!--<pre> The array is :-";
print_r($whatsNewRes);
echo "</pre>-->";*/
    
$tags_tid = $val->_field_data['nid']['entity']->field_tags['und'];
    
$tag = $val->field_field_tags;
$tag_name = array();
for($i=0; $i<count($tag); $i++){
    $tag_name[] = $tag[$i]['raw']['taxonomy_term']->name;
}
$tag_name = implode(',', $tag_name);
$tag_name = str_replace('&', '&amp;' , $tag_name);
$tag_name = html_entity_decode($tag_name, ENT_QUOTES | ENT_HTML5);        
    
$title = $val->_field_data['nid']['entity']->title; 
$nid= $val->nid;

/* Converting Mins into seconds starts */
$duration = $val->_field_data['nid']['entity']->field_vzaar_video_duration['und'][0]['value'];
$durationArr = explode(':', $duration);
$mins = $durationArr[0];
$secs = $durationArr[1];
$durationInSecs = ((int)$mins * 60) + ((int)$secs);
/* Converting Mins into seconds ends */

//$publish_date = $val->node_created;
$publish_date = $val->publication_date_published_at;    
//gmdate("Y-m-d\TH:i:s\Z", $publish_date);     
$publish_date = gmdate("D, d M Y H:i:s", $publish_date);   
//$article_category = $val->field_field_article_category[0]['raw']['taxonomy_term']->name; 
$video_feed_description = $val->_field_data['nid']['entity']->body['und'][0]['value'];
$video_feed_description = htmlentities(strip_tags($video_feed_description));

$video_feed_description = str_replace(array('&', '<', '>', '\'', '"', "'", '&rsquo;'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;', '&apos;', '&apos;'), $video_feed_description);
    
$video_feed_description = html_entity_decode($video_feed_description, ENT_QUOTES | ENT_HTML5);

$video_feed_description = str_replace('&rsquo;', '&apos;', $video_feed_description);

$video_feed_description = html_entity_decode($video_feed_description, ENT_QUOTES | ENT_HTML5);
    

//$article_category=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $article_category);    
//$thumb_image_url = $val->_field_data['nid']['entity']->field_thumb_image['und'][0]['uri'];

$thumb_img_url = field_get_items('node',$val->_field_data['nid']['entity'], 'field_thumb_image');    
$thumbimage = image_style_url('hp_recent', $thumb_img_url[0]['uri']);
    

$bcove_url = field_get_items('node',$val->_field_data['nid']['entity'], 'field_brightcove_video');        
$brightcove_final_url = image_style_url('hp_recent', $bcove_url['und'][0]['brightcove_id']);  
    
$bcove_video_id = $val->_field_data['nid']['entity']->field_brightcove_video['und'][0]['brightcove_id'];    
$bcove_final_url = "http://link.brightcove.com/services/player/bcpid3884556224001?bckey=AQ~~,AAADiHImimE~,1I8ur9UTbWlo1Up_5nMBpEAVeMzFyI8d&amp;bctid=".$bcove_video_id;    
$video_type_media = $val->_field_data['nid']['entity']->type;
    
$video_vzaar_url= $val->_field_data['nid']['entity']->field_vzaar_video_url['und'][0]['value'];
    
$video_youtube_url= $val->field_data_field_embed_video_field_embed_video_video_url;    
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=embed/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video_youtube_url, $matches);
$youtube_embed_code = $matches[0];
$youtube_final_url = "http://www.youtube.com/watch?v=$youtube_embed_code";
    
$video_brightcove_url= $val->_field_data['nid']['entity']->field_field_brightcove_video['und'][0]['value'];
    
    $final_video_url = '';
    if($video_vzaar_url != ''){
        $final_video_url = $video_vzaar_url;
    } else if($video_youtube_url != ''){
        $final_video_url = $youtube_final_url;
    } else if($bcove_video_id != ''){
        $final_video_url = $bcove_final_url;
    } else {
        $final_video_url = $final_video_url;
    }  
 
/*echo '<item> 
<title>'.$title.'</title>
<link>'.$final_video_url.'</link>
<description>'.$video_feed_description.'</description>
<pubDate>'.$publish_date.'</pubDate>
<guid>'.$nid.'</guid>
<media:content type="video/mp4" medium="video" url="'.$final_video_url.'" isDefault="true"/>
<media:thumbnail url="'.$thumbimage.'"/>
</item>';*/ 

echo '<item>
<title>'.htmlspecialchars($title).'</title>
<description>'.htmlspecialchars($video_feed_description).'</description>
<guid>'.htmlspecialchars($nid).'</guid>
<tags>'.htmlspecialchars($tag_name).'</tags>
<pubDate>'.$publish_date.'</pubDate>
<media:thumbnail url="'.$thumbimage.'" width="400" height="224"/>
<media:group>
<media:content url="'.$final_video_url.'" type="video/mp4" medium="video" duration="'.$durationInSecs.'" />
</media:group>
</item>';     
    
}
echo "</channel></rss>";
?>