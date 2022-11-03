<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): 

    $contentTypeName = $view->result[$id]->field_field_article_category[0]['rendered']['#markup'];

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
    }
?>
  <div<?php if ($classes_array[$id]) { print ' class="item ' . $classes_array[$id] .' '.$linkClass.'"';  } ?>>
    <?php print $row; ?>
  </div> 
  <?php if($id == 5){ ?>
		<div class="yellowBg">
			<div class="toLeft subsYoutube">
				<!-- <a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"><img src="http://india101dev.prod.acquia-sites.com/sites/default/files/image-upload/youtube101.png" border="0"></a> -->
								<div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div>
			</div>
			<div class="toRight">
				<ul class="followOpts">
					<li class="first">Follow us</li>
					<li class="social">
						<a href="https://www.facebook.com/101India" title="Facebook" target="_blank" class="fb_circle"></a>
					</li>
					<li class="social">
						<a href="https://twitter.com/101India" title="Twitter" target="_blank" class="twit_circle"></a>
					</li>
					<li class="social">
						<a href="http://i.instagram.com/101india/" title="Instagram" target="_blank" class="insta_circle"></a>
					</li>
					<li class="last">@101India</li>
				</ul>
			</div>
		</div>
	<?php } ?>
<?php endforeach; ?>