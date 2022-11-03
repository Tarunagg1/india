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
global $base_url;
 drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/jquery.jscrollpane.min.js');
 drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/jquery.mousewheel.js');
 drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/menu.js');
 drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/jquery.jscrollpane.custom.css');
?>

<div class="menu">
    <div class="navWrap">
        <div class="sideOptions menuoptions">
			
            <ul>
				<?php /*<li>
				    <a class="tooltip menuOption1 " href="javascript:;"><span class="tooltipText textOnHover">WET PAINT</span></a>
				</li>
				<li>
				    <a class="tooltip menuOption2 " href="javascript:;"><span class="tooltipText textOnHover">EPIC SHIT</span></a>
				</li>
				<li>
					<a class="tooltip menuOption3 " href="javascript:;"><span class="tooltipText textOnHover">SEEN MOST</span></a>
				</li>
				<li>
					<a class="tooltip menuOption4 " href="javascript:;"><span class="tooltipText textOnHover">101s</span></a>
				</li>
				<li class="listSearchItem listItem">
					<a class="tooltip menuOption5 " href="javascript:;"><span class="tooltipText textOnHover">SEARCH</span></a>
				</li>*/ ?>
				<li class="listMoreItem listItem">
					<a class="tooltip menuOption6 " href="javascript:;"><span class="tooltipText textOnHover">Menu</span></a>
				</li>
			</ul>
            
            
			
            <div class="bottomMenu">
                <ul>
                    <?php /*
                	<li>
                    	<div class="searchContent">
							<input type="text" class="searchBox" size="21" maxlength="120" placeholder="SEARCH"><input type="submit" value=" " class="searchBtn" />
						</div>
                    </li>
                   <li><span class="tooltipText">LOGIN</span></li>
                    <li><span class="tooltipText">SIGNUP</span> </li> */ ?>
                    <li><a href="<?php echo $base_url."/about-us" ?>"><span class="tooltipText">About Us</span></a></li>
                    <li><a href="<?php echo $base_url."/contact-us" ?>"><span class="tooltipText">Contact Us</span></a></li>
                    <li><a href="<?php echo $base_url."/terms-and-conditions" ?>"><span class="tooltipText">Terms &amp; Conditions</span></a></li>
                    <li><a href="<?php echo $base_url."/privacy-policy" ?>"><span class="tooltipText">Privacy Policy</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>