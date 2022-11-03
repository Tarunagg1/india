<?php
	//echo "<!-- Form array is: \n";print_r(array_keys($form));echo " -->";
	
	hide($form['hybridauth']);
?>

<div class="userForm">
	<?php print drupal_render_children($form);
	
	if (module_exists('hybridauth') && !user_is_logged_in()) {
	  $element['#type'] = 'hybridauth_widget';
	  print drupal_render($element);
	}
    ?>
</div>