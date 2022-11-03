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
<?php foreach ($rows as $id => $row): ?>
    <?php print $row; ?>
	<?php if($id == 5){ ?>
		<div class="yellowBg">
			<div class="toLeft subsYoutube">
				<!-- <div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></di<a href="https://www.youtube.com/channel/UCZwZrym87YpirLIFBzTnWQA" target="_blank"><img src="http://india101dev.prod.acquia-sites.com/sites/default/files/image-upload/youtube101.png" border="0"></a> -->
								<div class="g-ytsubscribe" data-channelid="UCZwZrym87YpirLIFBzTnWQA" data-layout="default" data-count="default"></div>
			</div>
			<div class="toRight">
				<ul class="followOpts">
					<li class="first">Follow us</li>
					<li class="social">
						<a href="https://www.facebook.com/101India" target="_blank" title="Facebook" class="fb_circle"></a>
					</li>
					<li class="social">
						<a href="https://twitter.com/101India" target="_blank" title="Twitter" class="twit_circle"></a>
					</li>
					<li class="social">
						<a href="http://i.instagram.com/101india/" target="_blank" title="Instagram" class="insta_circle"></a>
					</li>
					<li class="last">@101India</li>
				</ul>
			</div>
		</div>
	<?php }?>
<?php endforeach; ?>
