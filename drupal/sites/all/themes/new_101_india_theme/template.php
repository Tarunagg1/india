<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 *
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "adaptivetheme_subtheme" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "adaptivetheme_subtheme".
 * 2. Uncomment the required function to use.
 */


/**
 * Preprocess variables for the html template.
 */
/* -- Delete this line to enable.
function adaptivetheme_subtheme_preprocess_html(&$vars) {
  global $theme_key;

  // Two examples of adding custom classes to the body.

  // Add a body class for the active theme name.
  // $vars['classes_array'][] = drupal_html_class($theme_key);

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  // $vars['classes_array'][] = css_browser_selector();

}
// */


/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function adaptivetheme_subtheme_process_html(&$vars) {
}
// */


/**
 * Override or insert variables for the page templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_page(&$vars) {
}
function adaptivetheme_subtheme_process_page(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_node(&$vars) {
}
function adaptivetheme_subtheme_process_node(&$vars) {
}
// */


/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_comment(&$vars) {
}
function adaptivetheme_subtheme_process_comment(&$vars) {
}
// */


/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_block(&$vars) {
}
function adaptivetheme_subtheme_process_block(&$vars) {
}
// */

function new_101_india_theme_preprocess_page(&$vars) {
    //echo '<pre style="display: none">';print_r($_SERVER['REQUEST_URI']);echo '</pre>';
    /*if($_SERVER['REQUEST_URI'] == '/node'){
        //echo '<pre style="display: none">This is node page</pre>';
        global $base_url;
        header("Location: " . $base_url);
    }*/
    
    $element = array(
        '#tag' => 'meta',
        '#attributes' => array(
            "property" => "fb:pages",
            "content" => "1518576811694561",
        ),
        '#weight' => '50',
    );

    drupal_add_html_head($element,'fb_instatnt_articles');
}
function new_101_india_theme_css_alter(&$css) {
    
    //echo '<pre style="display:none;">';print_r(count($css));echo '</pre>';
 
    // Remove Drupal core css

    $exclude = array(
    /*'modules/system/system.base.css' => FALSE,*/
        'modules/system/system.menus.css' => FALSE,
        'modules/system/system.messages.css' => FALSE,
        'modules/system/system.theme.css' => FALSE,
        'modules/comment/comment.css' => FALSE,
        'modules/field/theme/field.css' => FALSE,
        'modules/search/search.css' => FALSE,
        'modules/node/node.css' => FALSE,
        'modules/user/user.css' => FALSE,
        'sites/all/modules/counter/counter.css' => FALSE,
        'sites/all/modules/date/date_api/date.css' => FALSE,
        'sites/all/modules/date/date_popup/themes/datepicker.1.7.css' => FALSE,
        'sites/all/modules/date/date_repeat_field/date_repeat_field.css' => FALSE,
        'sites/all/modules/views/css/views.css' => FALSE,
        'sites/all/modules/ctools/css/ctools.css' => FALSE,
        'sites/all/modules/improved_multi_select/improved_multi_select.css' => FALSE,
        'sites/all/themes/adaptivetheme/at_core/css/at.layout.css' => FALSE,
        'public://adaptivetheme/new_101_india_theme_files/new_101_india_theme.default.layout.css' => FALSE,
    );

    $css = array_diff_key($css, $exclude);
    
    //echo '<pre style="display:none;">';print_r(count($css));echo '</pre>';
 
}

function new_101_india_theme_js_alter(&$javascript) {
    // Remove Drupal core js

    $exclude = array(
        'sites/all/modules/improved_multi_select/improved_multi_select.js' => FALSE,
    );

    $javascript = array_diff_key($javascript, $exclude); 
}

function new_101_india_theme_preprocess_image(&$variables) {
    $attributes = $variables['attributes'];
  foreach (array('width', 'height') as $key) {
    unset($attributes[$key]);
    unset($variables[$key]);
  }
}

function new_101_india_theme_form_simple_subscription_form_alter(&$form, &$form_state, &$form_id){
    //echo '<pre style="display: none">';print_r($form);echo '</pre>';
    
    $form['header']['#prefix'] = '<ul><li><div class="simple_subscription_header title">';
    $form['header']['#suffix'] = '</div></li>';
    
    $form['mail']['#prefix'] = '<li><div class="subscribeForm">';
    $form['mail']['#attributes']['class'] = array('textBox');
    $form['mail']['#attributes']['placeholder'] = array('Enter your email id');
    //$form['mail']['#size'] = 0;
    
    $form['submit']['#attributes']['class'] = array('subscribeBtn');
    $form['submit']['#suffix'] = '</div></li></ul>';
    $form['#submit'][] = 'new_101_india_theme_simple_subscribe_after_submit';
}

function new_101_india_theme_form_apachesolr_search_custom_page_search_form_alter(&$form, &$form_state, &$form_id){
    //secho '<pre style="display: none">';print_r($form_id);echo '</pre>';
    //echo '<pre style="display: none">';print_r($form);echo '</pre>';
    $form['basic']['keys']['#prefix'] = '<div class="searchBox">';
    $form['basic']['keys']['#suffix'] = '</div>';
    $form['basic']['keys']['#title'] = '';
    $form['basic']['submit']['#attributes']['class'] = array('searchBtn');
    $form['basic']['submit']['#prefix'] = '<div class="datePick">';
    $form['basic']['submit']['#suffix'] = '</div>';
    
    
}

function new_101_india_theme_theme_apachesolr_search_suggestions($variables) {
  return '<div class="spelling-suggestions"><dl class="form-item"><dt><strong>Did you mean</strong></dt>';
    foreach ((array) $variables['links'] as $link) {
    $output .= '<dd>' . $link . '</dd>';
  }
  $output .= '</dl></div>';
  return $output;
}

function new_101_india_theme_apachesolr_search_noresults() {
  return t('<div class="listContent"><div class="view-empty wrapper noData"><p>YOUR SEARCH YIELDED NO RESULT</p></div></div>');
}    

function new_101_india_theme_form_user_profile_form_alter(&$form, &$form_state, &$form_id){
    $form['#attributes']['class'] = array('editProfile');
    hide($form['field_name']);
    hide($form['field_gender']);
    $form['account']['mail']['#disabled'] = TRUE;
    $form['account']['current_pass']['#description'] = 'Enter your current password to change your <em class="placeholder">Password</em>. <a href="/user/password" title="Request new password via e-mail.">Request new password</a>.';
    
   //echo '<pre style="display: none">';print_r($form);echo '</pre>';
}

function new_101_india_theme_form_user_login_alter(&$form, &$form_state, &$form_id){
   $form['#attributes']['class'] = array('editProfile');
}

function new_101_india_theme_form_user_register_form_alter(&$form, &$form_state, &$form_id){
   $form['#attributes']['class'] = array('editProfile');
}

function new_101_india_theme_form_user_pass_alter(&$form, &$form_state, &$form_id){
   $form['#attributes']['class'] = array('editProfile');
}

function new_101_india_theme_form_user_pass_reset_alter(&$form, &$form_state, &$form_id){
   $form['#attributes']['class'] = array('editProfile');
}

function new_101_india_theme_simple_subscribe_after_submit(){
    setcookie("user_subscribed", "just subscribed", time()+(60*60*24*30), "/");
}

function new_101_india_theme_preprocess_html(&$vars) {
    $errors = form_get_errors();
    //echo '<pre style="display: none">';print_r($errors);echo '</pre>';
    //echo '<pre style="display: none">';print_r($_SESSION);echo '</pre>';
    
    /*$GLOBALS['simpSubMailErr'] = $_SESSION['already_mail_err'];
    unset($_SESSION['already_mail_err']);*/
    
    if (!empty($errors)) {
    // Clear errors.
    form_clear_error();
    // Clear error messages.
    $error_messages = drupal_get_messages('error');
    // Initialize an array where removed error messages are stored.
    $removed_messages = array();

    // Remove all errors originated by the 'foo][bar' element.
    foreach ($errors as $name => $error_message) {
      if ($name == 'mail') {
        $removed_messages[] = $error_message;
        unset($errors[$name]);
      }
    }

    // Reinstate remaining errors.
    foreach ($errors as $name => $error) {
      form_set_error($name, $error);
      // form_set_error() calls drupal_set_message(), so we have to filter out
      // these from the error messages as well.
      $removed_messages[] = $error;
    }

    // Reinstate remaining error messages (which, at this point, are messages that
    // were originated outside of the validation process).
    if(count($errors) > 1){
        foreach (array_diff($error_messages['error'], $removed_messages) as $message) {
          drupal_set_message($message, 'error');
        }
    }
  }
    
    $argArr = arg();

    if($argArr[0] == 'node' && count($argArr) > 1){
        $currNode = node_load($argArr[1]);

        $link = url('node/'.$currNode->nid, array('absolute' => TRUE)) . '?amp';

        $element = array(
            '#tag' => 'link',
            '#attributes' => array(
                "rel" => "amphtml",
                "href" => $link,
            ),
            '#weight' => '1',
        );

        $modKey = 'amp';
        
        if($currNode->type == 'blogs'){
            drupal_add_html_head($element, $modKey);
        }else if($currNode->type == 'listicles'){
            drupal_add_html_head($element, $modKey);
        }else if($currNode->type == 'photo_essay'){
            drupal_add_html_head($element, $modKey);
        }else if($currNode->type == 'videos'){
            drupal_add_html_head($element, $modKey);
        }
    }
}
function new_101_india_theme_html_head_alter(&$head_elements) {
    $headKeys = array_keys($head_elements);

    foreach ($headKeys as $head) {
        if(strstr($head, 'amphtml')){
            unset($head_elements[$head]);
        }
    }
}
function new_101_india_theme_theme() {
  $items = array();
  $items['user_login'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'new_101_india_theme') . '/templates',
    'template' => 'user-login-register',
  );
  $items['user_register_form'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'new_101_india_theme') . '/templates',
    'template' => 'user-login-register',
  );
  $items['user_pass'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'new_101_india_theme') . '/templates',
    'template' => 'user-login-register',
  );
  
  return $items;
}
function new_101_india_theme_menu_link($variables) {
    //echo '<pre style="display:none">';print_r(($variables['element']));echo '</pre>';
    $element = $variables['element'];
    $sub_menu = '';
    $output = '';
    $mobile_sub_menu = '';
    $mobile_sub_menu_dropdown = '';
    global $base_url;
    
    $menuLinkName = $element['#title'];
    $menuLink = drupal_get_path_alias($element['#href']);
    
    $textClass = explode(' ', $menuLinkName);
    foreach($textClass as $tk=>$cat){
        if($tk == 0){
            $textClass[$tk] = strtolower($cat);
        }else{
            $textClass[$tk] = ucfirst($cat);
        }        
    }
    $textClass = implode('', $textClass);
    $linkClass = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' ', 'Arts & Culture'), array('', '', '', '','', 'brief'), $textClass);
    if($menuLinkName == 'Series'){
        $element['#attributes']['class'] = array('menuItems', $linkClass, 'new-tab');
    }
    else{
        $element['#attributes']['class'] = array('menuItems', $linkClass);
    }
    
    $element['#localized_options']['attributes']['class'] = array('menuLink', 'waves-effect');
    
    if(in_array('last', $variables['element']['#attributes']['class'])){
        //echo '<pre style="display:none">';print_r(($variables['element']));echo '</pre>';
        $mobile_sub_menu = '<li class="menuItems footerLink"><a class="menuLink waves-effect" href="'.$base_url.'/about-us">ABOUT US</a></li>
                            <li class="menuItems footerLink"><a class="menuLink waves-effect" href="'.$base_url.'/contact-us">CONTACT US</a></li>
                            <li class="menuItems footerLink"><a class="menuLink waves-effect" href="'.$base_url.'/terms-and-conditions">TERMS</a></li>
                            <li class="menuItems footerLink"><a class="menuLink waves-effect" href="'.$base_url.'/privacy-policy">PRIVACY</a></li>
                            <!-- <li class="menuItems footerLink"><a class="menuLink waves-effect" href="javascript:;">NEWSLETTER</a></li>
                            <li class="menuItems footerLink"><span class="menuLink waves-effect">&copy; 101 INDIA DIGITAL PVT.LTD</span></li>
                            <li class="menuItems footerLink"><span class="menuLink waves-effect">ALL RIGHTS RESERVED</span></li>-->';
    }

    if ($element['#below']) {
        //$element['#localized_options']['attributes']['data-activates'] = array('dropdown1');
        $belowLink = '';
        
        foreach($element['#below'] as $bKey=>$below){
            //echo '<pre style="display: none">In the below section: ' . $bKey;print_r($below);echo '</pre>';
            if(isset($below['#title'])){
                $textClassother = explode(' ', $below['#title']);
                foreach($textClassother as $tk=>$cat){
                    if($tk == 0){
                        $textClassother[$tk] = strtolower($cat);
                    }else{
                        $textClassother[$tk] = ucfirst($cat);
                    }        
                }
                $textClassother = implode('', $textClassother);
                $linkClassothers = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' ', 'Arts & Culture'), array('', '', '', '','', 'brief'), $textClassother);
                $below['#localized_options']['attributes']['class'][] = 'waves-effect'; 
                $below['#localized_options']['attributes']['class'][] = $linkClassothers;
                //print_r($below['#localized_options']['attributes']['class']);
                $classname = implode(' ', $below['#localized_options']['attributes']['class']);
                //echo $classname."<br>";
                /*foreach($below['#localized_options']['attributes']['class'] as $bKeyother=>$belowother){
                    print_r($belowother);
                }*/
                $belowAliasLink = drupal_get_path_alias($below['#href']);
                $belowLink .= '<li><a href="/'.$belowAliasLink.'" class="'.$classname.'">'.$below['#title'].'</a></li>';
            }
        }
        $sub_menu = '<ul id="dropdown1" class="dropdown-content">' . $belowLink . '</ul>';
        /*$mobile_sub_menu_dropdown = '<li class="menuItems about">
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li class="active">
                                        <div class="collapsible-header active">
                                            <a class="menuLink waves-effect" href="'.$menuLink.'">OTHERS</a>
                                        </div>
                                        <div class="collapsible-body">
                                            <ul>
                                            '.$belowLink.'
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>';*/
    }
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);

    
    //echo '<pre style="display:none">' . '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>" . "</pre>\n";
    
        return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n" . $mobile_sub_menu_dropdown . "\n" . $mobile_sub_menu . "\n";
}

function new_101_india_theme_menu_tree($variables) {
    //return '<ul id="slide-out" class="side-nav">' . $variables ['tree'] . '</ul>';
    return '<ul class="side-nav deskMenu">' . $variables ['tree'] . '</ul>';
}

/*function new_101_india_theme_breadcrumb($variables){
    //echo '<pre style="display:none">';print_r(($variables['breadcrumb']));echo '</pre>';
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        $totalCrumbs = count($breadcrumb);
        
        $crumbs = '<div class="breadCrumbs"><ul>';

        $i = 1;

        foreach($breadcrumb as $value) {
            if ($i != $totalCrumbs){
             $crumbs .= '<li>'.strip_tags($value, '<a>').'<span> &gt;&gt; </span></li>';
             $i++;
            }
            else {
                $crumbs .= '<li><span>'.strip_tags($value).'</span></li>';
            }
        }

        $crumbs .= '</ul></div>';
    }
    
    //echo '<pre style="display:none">';print_r($crumbs);echo '</pre>';
    return $crumbs;
}*/

function new_101_india_theme_breadcrumb($variables){
    //echo '<pre style="display:none">';print_r(array_keys($variables));echo '</pre>';
    
    $links = array();
    $path = '';

    // Get URL arguments
    $arguments = explode('/', request_uri());
    
    // Remove empty values
    foreach ($arguments as $key => $value) {
        if (empty($value)) {
            unset($arguments[$key]);
        }
    }
    $arguments = array_values($arguments);
    
    //echo '<pre style="display:none">';print_r($arguments);echo '</pre>';

    // Add 'Home' link
    $homeCrumb = l(t('Home'), '<front>');
    if (!empty($arguments)) {
        $links[] = '<li>' . $homeCrumb . '<span> &gt;&gt; </span></li>';
    }else{
        $links[] = '<li>' . $homeCrumb . '</li>';
    }

    $argArr = arg();
    
    //echo '<pre style="display:none">';print_r(($argArr));echo '</pre>';

    // Add other links
    if (!empty($arguments)) {
        foreach ($arguments as $key => $value) {
            // Don't make last breadcrumb a link
            if ($key == (count($arguments) - 1)) {
                if($argArr[0] != 'node'){
                    $links[] = '<li><span>' . drupal_get_title() . '</span></li>';
                }
            } else {
                if (!empty($path)) {
                    if($value == '101-janta'){
                        $path .= '/people';
                    }else{
                        $path .= '/'. str_replace('101-', '', $value);
                    }
                } else {
                    if($value == '101-janta'){
                        $path .= 'people';
                    }else{
                        $path .= str_replace('101-', '', $value);
                    }                    
                }
                
                $category = '';
                
                if($value == '101-janta'){
                    $category = 'People';
                }else if($value == 'arts-culture'){
                    $category = 'Arts & Culture';
                }else{
                    $category = ucwords(strtolower(str_replace('_', ' ', str_replace('-', ' ', str_replace('101-', '', $value)))));
                }
                
                $crumb = l($category, $path);
                if($argArr[0] == 'node' && count($argArr) == 2){
                    $links[] = '<li>' . $crumb . '</li>';
                }else{
                    $links[] = '<li>' . $crumb . '<span> &gt;&gt; </span></li>';
                }
            }
        }
    }

    // Set custom breadcrumbs
    drupal_set_breadcrumb($links);

    // Get custom breadcrumbs
    $breadcrumb = drupal_get_breadcrumb();

    //echo '<pre style="display:none">';print_r(('<div class="breadCrumbs"><ul>'. implode("", $breadcrumb) .'</ul></div>'));echo '</pre>';
    
    // Hide breadcrumbs if only 'Home' exists
    if (count($breadcrumb) > 1) {
        return '<div class="breadCrumbs"><ul>'. implode("", $breadcrumb) .'</ul></div>';
    }
}

function get_static_node_html_tpl(){
    $result = db_select('node', 'n')
        ->fields('n', array('nid'))
        ->condition('type', 'page','=')
        ->execute()
        ->fetchAll();

    $nidsStaticPagesArr = array(); // Store all the node ids of static pages in this array

    foreach($result as $nKey=>$node){
        $nidsStaticPagesArr[] = $node->nid;
    }
    
    return $nidsStaticPagesArr;
}

function get_views_data($viewName, $viewDisplay, $filters = array(), $argument = array(), $page = 0){
    $viewData = views_get_view($viewName);
    $viewData->set_display($viewDisplay);
    
    if(!empty($argument)){
        $viewData->set_arguments($argument);
    }
    
    if(!empty($filters)){
        foreach($filters as $key=>$value){
            $filterItem = $viewData->get_item($viewDisplay, 'filter', $value['name']);
            $filterItem['value'] = $value['value'];
            $viewData->set_item($viewDisplay, 'filter', $value['name'], $filterItem);
        }
    }
    
    if($page != 0){
        $viewData->set_current_page($page);
    }
    
    $viewData->pre_execute();
    $viewData->execute();

    return $viewData;
}

function get_last_node_id_from_system(){
    $lastNid = db_query_range("SELECT nid FROM {node} ORDER BY nid DESC", 0, 1)->fetchField();
    return $lastNid;
}

function get_search_view_result($searchView){
    $searchView->pre_execute();
    $searchView->execute();
    
    return $searchView;
}

function new_101_india_theme_pager($variables) {
  //echo '<pre style="display: none">';print_r($variables);echo '</pre>';
    $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = 7;
  //$quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  //$pager_max = $pager_total[$element];
  $pager_max = $pager_total[$element];
    //echo '<pre style="display: none"> pager_first:';print_r($pager_current);print_r($pager_first);echo '</pre>';
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  /*if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }*/
    if ($pager_last >= $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }


    
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.
//if($pager_max > $quantity){ 
  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('1')), 'element' => $element, 'parameters' => $parameters));
/*} else{
    $li_first = '';
}*/
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    //if($pager_max > $quantity){    
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t($pager_max)), 'element' => $element, 'parameters' => $parameters));
    /*} else {
        $li_last = '';
    }*/
/*if ($pager_current <= 4) {
    // Adjust "center" if at end of query.
   // $i = $i + ($pager_max - $pager_last);
    $li_first = '';
  }  */
  if ($pager_total[$element] > 1) {
      
   /* if ($li_first) {
        echo "here";
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }*/
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );  
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i <= $pager_max) {
          
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
        $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );  
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    /*if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }*/
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
}