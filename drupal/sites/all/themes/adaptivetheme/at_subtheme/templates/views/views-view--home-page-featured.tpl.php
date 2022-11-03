<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
  /*drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/owl.carousel.css');
 drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/owl.theme.css');*/
/* version 2.0.0-beta.2.4 css starts */
 drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/owl.carousel-2.0.0-beta.2.4.css');
 drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/owl.theme.default.css');
/* version 2.0.0-beta.2.4 css ends */
 drupal_add_css(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/css/owl.transitions.css');
 
//drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/owl.carousel.min.js');
/* version 2.0.0-beta.2.4 js starts */
 drupal_add_js(drupal_get_path('theme', 'adaptivetheme_subtheme') . '/scripts/owl.carousel.2.0.0-beta.2.4.min.js');
/* version 2.0.0-beta.2.4 js ends */

/*?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#owl-example").owlCarousel({
	        slideSpeed : 300,
	        autoPlay : true,
	        items:2,
            scrollPerPage: true,
	        pagination:true,
	        stopOnHover : true,
	        itemsDesktop: false,
	        itemsMobile : [800,1]
        });
	});
</script>
*/ ?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#owl-example").owlCarousel({
            loop:true,
            autoplay:true,
            autoplayHoverPause:true,
            autoplayTimeout: 4000,
            //autoHeight:true,
            responsive:{
                0:{
                    items:1,
                    slideBy: 1
                },
                1025:{
                    items:2,
                    slideBy: 2
                }
            }
        });
	});
</script>

<section class="<?php print $classes; ?> featuredContent">
	<div class="wrapper">
		
	  <?php print render($title_prefix); ?>
	  <?php if ($title): ?>
	    <?php //print $title; ?>
	  <?php endif; ?>
	  <?php print render($title_suffix); ?>
	  <?php if ($header): ?>
	    <div class="view-header">
	      <?php print $header; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($exposed): ?>
	    <div class="view-filters">
	      <?php print $exposed; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($attachment_before): ?>
	    <div class="attachment attachment-before">
	      <?php print $attachment_before; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($rows): ?>
	    <div id="owl-example" class="view-content owl-carousel owl-theme">
	      <?php print $rows; ?>
	    </div>
	  <?php elseif ($empty): ?>
	    <div class="view-empty wrapper">
	      <?php print $empty; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($pager): ?>
	    <?php print $pager; ?>
	  <?php endif; ?>
	
	  <?php if ($attachment_after): ?>
	    <div class="attachment attachment-after">
	      <?php print $attachment_after; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($more): ?>
	    <?php print $more; ?>
	  <?php endif; ?>
	
	  <?php if ($footer): ?>
	    <div class="view-footer">
	      <?php print $footer; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($feed_icon): ?>
	    <div class="feed-icon">
	      <?php print $feed_icon; ?>
	    </div>
	  <?php endif; ?>

	</div>
</section><?php /* class view */ ?>