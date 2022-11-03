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
?>

<script type="text/javascript">
	$(window).load(function(){
		var $container = $('#newBorn');
		$container.masonry({
			itemSelector: '.itemWrap',
			gutter:5,
            isResizable:true
			//columnWidth:  $container.width() / 3,
			
		}).imagesLoaded(function(){
			$container.masonry('reloadItems');
		});
	});
	
	$(document).ready(function(){
		 Drupal.behaviors.views_infinite_scroll = {
	      attach: function (context, settings) {
			$('#newBorn').imagesLoaded(function(){
				$('#newBorn').masonry('reloadItems').masonry();
			});
              
            $('#newBorn').masonry( 'on', 'layoutComplete', function(){
                $.autopager.option("checkifLoaded", true);
            });
              
            var md = new MobileDetect(window.navigator.userAgent);
              
            if(md.mobile() || md.tablet()){
                $('.socialShare').off();
                $('.socialShare').on('click', function(){
                    if($(this).hasClass('active')){
                        $(this).removeClass('active');
                    }else{
                        $(this).addClass('active');
                    }
                });
            }else{
                $('.socialShare').off();
                $('.socialShare').on('mouseenter', function(){
                    $(this).addClass('active');
                });

                $('.socialShare').on('mouseleave', function(){
                    $(this).removeClass('active');
                });
            }
	      }
	    };
	});
</script>

<section class="<?php print $classes; ?> mustWatchSection content newBornSection">
	<div class="wrapper">
		<h2>New Born</h2>
	
		<?php if ($rows): ?>
			<div class="view-content listed" id="newBorn">
				<?php print $rows; ?>
			</div>
		<?php elseif ($empty): ?>
			<div class="view-empty wrapper listed">
				<?php print $empty; ?>
			</div>
		<?php endif; ?>
		
		<?php if ($pager): ?>
			<div class="loadMore">
				<?php print $pager; ?>
			</div>
		<?php endif; ?>
		
		<?php if ($more): ?>
			<?php print $more; ?>
		<?php endif; ?>

	</div>
</section>