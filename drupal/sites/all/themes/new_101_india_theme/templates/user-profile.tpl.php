<?php
/**
 * @file
 * Adaptivetheme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Adaptivetheme variables:
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.  
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 */

$userInfo = user_load(arg(1)); // to get information of the currently viewed user. 

$mainArrKey = array_keys($user_profile);

if(in_array('profile_main', $mainArrKey)){
 	hide($user_profile['profile_main']);
 }

if(in_array('hybridauth_identities', $mainArrKey)){
 	hide($user_profile['hybridauth_identities']);
 }

//$userDetails = get_object_vars($user); // $user gives information about the currently logged in user and not the user being viewed
$userDetails = get_object_vars($userInfo); // use the information stored in $userInfo as it provides info of the user being viewed

//echo '<pre style="display: none"> User object: ';print_r(arg());echo '</pre>';

if(isset($userDetails["data"]["hybridauth"])){
	
	$userInformation = $userDetails["data"]["hybridauth"];
	
	//$userName = $user_profile["field_name"][0]["#markup"];
    $userName = $userInformation["displayName"];
	$email = $userInformation["email"];
	$profilePic = "<img src='".$userInformation["photoURL"]."' />";
	
	$gender = field_get_items("user",$userInfo,"field_gender");
	$gender = ucwords($gender[0]["value"]);
	$provider = $userInformation["provider"];
	
	if($provider=="Google"){
		$img_url = $userDetails["picture"]->uri;
		if($img_url){
			$profile = image_style_url('profile_pic', $img_url);
			$profilePic = "<img src='".$profile."' />";
		}
	}
	
}else{
	$userName = (isset($user_profile["field_name"]) && !empty($user_profile["field_name"]))?$user_profile["field_name"][0]["#markup"]:'';
	$email = $userDetails["mail"];
	$profilePic = $user_profile['user_picture'];
	$gender = field_get_items("user",$userInfo,"field_gender");
	$gender = ucwords($gender[0]["value"]);
	$provider = "normal";
    //echo '<pre style="display: none"> User object: ';print_r($userName);echo '</pre>';
}

global $base_url;
$user_name = '';
$userGender = '';
$userDOB = '';
$userInterest = array();
$userContact = '';
$userAlterEmail = '';

if(in_array('profile_main', $mainArrKey)){
 	foreach($user_profile['profile_main']['view']['profile2'] as $keyFN=>$valFN){
        
        if(isset($valFN['field_name']) && !empty($valFN['field_name'])){
            $user_name = $valFN['field_name']['#items'][0]['value'];
        }
        
        if(isset($valFN['field_gender']) && !empty($valFN['field_gender'])){
            $userGender = $valFN['field_gender']['#items'][0]['value'];
        }
        
        if(isset($valFN['field_dob']) && !empty($valFN['field_dob'])){
            $userDOB = date('jS M Y', strtotime($valFN['field_dob']['#items'][0]['value']));
        }
        
        if(isset($valFN['field_interest']) && !empty($valFN['field_interest'])){
            foreach($valFN['field_interest']['#items'] as $keyInt=>$interest){
                $userInterest[$keyInt]['name'] = $interest['taxonomy_term']->name;
                $userInterest[$keyInt]['link'] = $base_url . '/' . strtolower($interest['taxonomy_term']->name);
            }
        }
        
        if(isset($valFN['field_contact_number']) && !empty($valFN['field_contact_number'])){
            $userContact = $valFN['field_contact_number']['#items'][0]['value'];
        }
        
        if(isset($valFN['field_alternate_email_id']) && !empty($valFN['field_alternate_email_id'])){
            $userAlterEmail = $valFN['field_alternate_email_id']['#items'][0]['email'];
        }
        
 		break;
	}
 }
?>
<article id="user-<?php print $user->uid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="profileImage">
        <?php print strip_tags(render($profilePic), '<img>'); ?>
    </div>
    <div class="profileDetails">
        <?php if(!empty($user_name)){ ?>
        <div class="profileInfo">
            <span class="title">Name :</span>
            <span><?php echo $user_name; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($email)){ ?>
        <div class="profileInfo">
            <span class="title">Email :</span>
            <span><?php echo $email; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($userGender)){ ?>
		<div class="profileInfo">
            <span class="title">Gender :</span>
            <span><?php echo $userGender; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($userDOB)){ ?>
        <div class="profileInfo">
            <span class="title">DOB :</span>
            <span><?php echo $userDOB; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($userContact)){ ?>
        <div class="profileInfo">
            <span class="title">Contact Number :</span>
            <span><?php echo $userContact; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($userAlterEmail)){ ?>
        <div class="profileInfo">
            <span class="title">Alternate Email ID :</span>
            <span><?php echo $userAlterEmail; ?></span>
        </div>
        <?php } ?>
        
        <?php if(!empty($userInterest)){ ?>
        <div class="profileInfo">
            <span class="title">Interest :</span>
            <span>
            <?php $i = 0;
            foreach($userInterest as $keyUInt=>$uInterest){
                if($i == 0){
                    echo $uInterest['name'];
                }else{
                    echo ', ' . $uInterest['name'];
                }
                
                $i++;
            } ?>
            </span>
        </div>
        <?php } ?>
        
        <div class="profileInfo">
            <?php /*<span class="title">Recently Viewed Articles :</span>*/ ?>
            <?php
            
                /*$recentlyViewed = get_views_data('recently_read', 'block');
                $resultArr = $recentlyViewed->result;

                if(!(empty($resultArr))){
                    foreach($resultArr as $key=>$res){ ?>
                    <div><?php echo $res->node_title; ?></div>
                <?php	}
                } */
            ?>
        </div>
    </div>
    <div class="clear"></div>
</article>
<?php //print $recentlyViewed->render(); ?>