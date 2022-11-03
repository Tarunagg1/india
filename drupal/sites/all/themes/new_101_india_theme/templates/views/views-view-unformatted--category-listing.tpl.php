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
?>
  <div<?php if ($classes_array[$id]) { print ' class="item ' . $classes_array[$id] .' '.$linkClass.'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>