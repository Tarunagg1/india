<?php

/**
 * @file
 * Implimentation of hook_form_system_theme_settings_alter()
 *
 * To use replace "adaptivetheme_subtheme" with your themeName and uncomment by
 * deleting the comment line to enable.
 *
 * @param $form: Nested array of form elements that comprise the form.
 * @param $form_state: A keyed array containing the current state of the form.
 */
/* -- Delete this line to enable.
function adaptivetheme_subtheme_form_system_theme_settings_alter(&$form, &$form_state)  {
  // Your knarly custom theme settings go here...
}
// */

  // Include custom form validation and submit functions
  
  require_once(drupal_get_path('theme', 'adaptivetheme') . '/inc/forms/at_core.validate.inc');
  require_once(drupal_get_path('theme', 'adaptivetheme') . '/inc/forms/at_core.submit.inc');
	require_once(DRUPAL_ROOT . "/modules/node/node.pages.inc");
function new_101_india_theme_form_system_theme_settings_alter(&$form, $form_state) {
	
  $form['mobile_logo'] = array(
    '#title' => t('MOBILE LOGO SETTING'),
    '#description' => t('Upload logo for Mobile'),
    '#type' => 'managed_file',
    '#upload_location' => 'public://mobile-logo/',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
    '#default_value' => theme_get_setting('mobile_logo'),
  );
  
  $form['mobile_overlay_logo'] = array(
    '#title' => t('MOBILE OVERLAY LOGO'),
    '#description' => t('Upload logo for Mobile Overlay'),
    '#type' => 'managed_file',
    '#upload_location' => 'public://mobile-overlay-logo/',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
    '#default_value' => theme_get_setting('mobile_overlay_logo'),
  );

	$form['mobilebg'] = array(
    '#type'          => 'textfield',
    '#title'         => t('mobile menu background-color'),
    '#default_value' => theme_get_setting('mobilebg'),
  );
  
  $form['mobilebg_over'] = array(
    '#type'          => 'textfield',
    '#title'         => t('mobile menu over background-color'),
    '#default_value' => theme_get_setting('mobilebg_over'),
    '#description'   => t("Place this text in the widget spot on your site."),
  );

}

	$form['#submit'][] = 'new_101_india_theme_settings_form_submit';
	// Get all themes.
	$themes = list_themes();
	// Get the current theme
	$active_theme = $GLOBALS['theme_key'];
	
	
	$form_state['build_info']['files'][] = str_replace("/$active_theme.info", '', $themes[$active_theme]->filename) . '/theme-settings.php';
	

	
	
function new_101_india_theme_settings_form_submit(&$form, $form_state) {
	
$image_fid = $form_state['values']['mobile_logo'];
  $image = file_load($image_fid);
  if (is_object($image)) {
    // Check to make sure that the file is set to be permanent.
    if ($image->status == 0) {
      // Update the status.
      $image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($image);
      // Add a reference to prevent warnings.
      file_usage_add($image, 'new_101_india_theme', 'theme', 1);
     }
  }

$image_overlay_fid = $form_state['values']['mobile_overlay_logo'];
  $image_overlay = file_load($image_overlay_fid);
  if (is_object($image_overlay)) {
    // Check to make sure that the file is set to be permanent.
    if ($image_overlay->status == 0) {
      // Update the status.
      $image_overlay->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($image_overlay);
      // Add a reference to prevent warnings.
      file_usage_add($image_overlay, 'new_101_india_theme', 'theme', 1);
     }
  }  
}