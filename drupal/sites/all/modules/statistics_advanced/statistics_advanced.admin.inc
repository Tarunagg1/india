<?php

/**
 * @file
 * Admin page callbacks for the statistics_advanced module.
 */

/**
 * Administration settings form.
 *
 * @see system_settings_form()
 */
function statistics_advanced_settings_form() {
  $accesslog_enabled = variable_get('statistics_enable_access_log', 0);
  $counter_enabled = variable_get('statistics_count_content_views', 0);
  $node_types = node_type_get_names();
  $counter_node_types = statistics_advanced_var('counter_node_types');

  // Add the any missing node types to the counter node types default value.
  // @todo Use array_diff with array_keys()?
  foreach (array_keys($node_types) as $node_type) {
    if (!isset($counter_node_types[$node_type])) {
      $counter_node_types[$node_type] = $node_type;
    }
  }

  $form['statistics_advanced_ignore_crawlers'] = array(
    '#type' => 'checkbox',
    '#title' => t('Do not log visits from search engines and crawlers'),
    '#description' => t('This feature requires the <a href="@link">browscap module</a>. If enabled, crawlers will not increase the node counters or be logged in the access log.', array('@link' => 'http://drupal.org/project/browscap')),
    '#default_value' => statistics_advanced_var('ignore_crawlers'),
    '#disabled' => !module_exists('browscap') || !$accesslog_enabled || !$counter_enabled,
  );

  $form['statistics_advanced_ignore_repeat_views'] = array(
    '#type' => 'checkbox',
    '#title' => t("Only allow unique content views to increment a content's view counter."),
    '#default_value' => statistics_advanced_var('ignore_repeat_views'),
    '#description' => t('Requires "count content views" enabled. Checking for repeat anonymous visits requires the "enable access log" above.'),
    '#disabled' => !$counter_enabled,
  );
  $form['statistics_advanced_counter_node_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Show view counter for the following content types'),
    '#default_value' => $counter_node_types,
    '#options' => $node_types,
    '#disabled' => !$counter_enabled,
  );

  $form['resets'] = array(
    '#type' => 'fieldset',
    '#title' => t('Resets'),
  );
  $form['resets']['reset_accesslog'] = array(
    '#type' => 'submit',
    '#value' => t('Clear access log'),
    '#submit' => array('statistics_advanced_reset_accesslog'),
  );
  $form['resets']['reset_counter'] = array(
    '#type' => 'submit',
    '#value' => t('Reset all node counters'),
    '#submit' => array('statistics_advanced_reset_counters'),
  );

  return system_settings_form($form);
}

/**
 * Resets the node view counter.
 */
function statistics_advanced_reset_counters() {
  db_delete('node_counter')->execute();
}

/**
 * Clears the access log.
 */
function statistics_advanced_reset_accesslog() {
  db_delete('accesslog')->execute();
}
