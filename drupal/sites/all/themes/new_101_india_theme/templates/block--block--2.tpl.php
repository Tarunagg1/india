<?php
/**
 * This block is for Custom Menu for the site
 * 
 * @file
 * Adativetheme implementation to display a block.
 *
 * The block template in Adaptivetheme is a little different to most other themes.
 * Instead of hard coding its markup Adaptivetheme generates most of it in
 * adaptivetheme_process_block(), conditionally printing outer and inner wrappers.
 *
 * This allows the core theme to have just one template instead of five.
 *
 * You can override this in your sub-theme with a normal block suggestion and use
 * a standard block template if you prefer, or use your own themeName_process_block()
 * function to control the markup. For example a typical navigation tempate might look
 * like this:
 *
 * @code
 * <nav id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
 *   <div class="block-inner clearfix">
 *     <?php print render($title_prefix); ?>
 *     <?php if ($block->subject): ?>
 *       <h2<?php print $title_attributes; ?>><?php print $block->subject; ?></h2>
 *     <?php endif; ?>
 *     <?php print render($title_suffix); ?>
 *     <div<?php print $content_attributes; ?>>
 *       <?php print $content ?>
 *     </div>
 *   </div>
 * </nav>
 * @endcode
 *
 * Adativetheme supplied variables:
 * - $outer_prefix: Holds a conditional element such as nav, section or div and
 *                  includes the block id, classes and attributes.
 * - $outer_suffix: Closing element.
 * - $inner_prefix: Inner div with .block-inner and .clearfix classes.
 * - $inner_suffix: Closing div.
 * - $title: Holds the block->subject.
 * - $content_processed: Pre-wrapped in div and attributes, but for some
 *   blocks these are stripped away, e.g. menu bar and main content.
 * - $is_mobile: Mixed, requires the Mobile Detect or Browscap module to return
 *   TRUE for mobile.  Note that tablets are also considered mobile devices.  
 *   Returns NULL if the feature could not be detected.
 * - $is_tablet: Mixed, requires the Mobile Detect to return TRUE for tablets.
 *   Returns NULL if the feature could not be detected.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 * @see adaptivetheme_preprocess_block()
 * @see adaptivetheme_process_block()
 */
// drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/jquery.jscrollpane.min.js');
// drupal_add_js(drupal_get_path('theme', 'new_101_india_theme') . '/scripts/menu.js');

//echo '<pre style="display: none">';print_r(array_keys($variables));echo '</pre>';

global $base_url;
if(!isset($_SESSION["user_subscribed"])){ ?>
<script>
	function submitSubscription(){
		
		$(".thankYou").hide();
		$("#errorMessage").hide();
		
		var email = $('#email_id').val();
		if(validateEmail(email)){
		
			$(".subscribeBtn").hide();
			$(".loader").fadeIn();
			
			$.ajax({
					type:'POST',
					url:'<?php echo $base_url.'/submit-subscriptions';?>',
					data:'email='+email,
					success:function(data){
						
						if($.trim(data)=="Failure"){
							$("#errorMessage").show();
							$("#errorMessage").html("Invalid e-mail address");
							
							$(".subscribeBtn").fadeIn();
							$(".loader").hide();
						}else if($.trim(data)=="Already Exist"){
							$("#errorMessage").show();
							$("#errorMessage").html("This e-mail id is already registered with us.");
							
							$(".subscribeBtn").fadeIn();
							$(".loader").hide();
						}else if($.trim(data)=="Database error occured"){
							$("#errorMessage").show();
							$("#errorMessage").html("Database error occured");
							
							$(".subscribeBtn").fadeIn();
							$(".loader").hide();
						}else{
							$('#email_id').val("");
							$("#subForm").fadeOut();
							$(".thankYou").fadeIn();
						}
						
					}
			});
		}else{
			$("#errorMessage").show();
			$("#errorMessage").html("Invalid e-mail address");
		}
	}
	function validateEmail(sEmail) {
		var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if (filter.test(sEmail)) {
			return true;
		}
		else {
			return false;
		}
	}
</script>
<div class="subscribeNow">
	<div class="subscribeWrap">
		<ul id="subForm">
			<li>
				<div class="title">Subscribe to our newsletter</div>
			</li>
			<li>
				<div class="subscribeForm">
					<input type="text" id="email_id" class="textBox" placeholder="Enter your email id" value="" size="30" maxlength="100">
                    <?php if(!$is_front){ ?>
                        <div class="clear"></div>
                    <?php } ?>
                    <input type="button" value="submit" onClick="submitSubscription()" class="subscribeBtn">
                    <span class="loader" style="display:none;"></span>
					<div class="clear"></div>
				</div>
				<div class="messages error" id="errorMessage" style="display:none;"></div>
			</li>
		</ul>
		<div class="thankYou messages status" style="display:none;">
			<ul>
				<li class="message-item">Thank you for subscribing.</li>
				<li class="message-item">You were successfully added to the newsletter recipients.</li>
			</ul>
		</div>
	</div>
</div>
<?php } ?>