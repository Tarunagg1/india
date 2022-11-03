<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
//echo '<pre style="display: none">';print_r($variables['pager']);echo '</pre>';

?>



<!-- added by ketan -->
<div class="search-result" style="margin: 20px 20px 30px; font-size: 15px; font-weight: bold; ">
<em>
<?php
  $pageNo = $_GET['page'];
  $totalResults = $variables['response']->response->numFound;
  if($totalResults == 1)
  {
    print "Showing item 1 of 1 result";
  }
  else
  {
    print "Showing items ".(($pageNo*12)+1)." - ".(  $totalResults < (($pageNo+1)*12)? $totalResults : (($pageNo+1)*12)  );
    print " of ".$totalResults." results";
  }
?>
</em>
</div>
<!-- end added by ketan -->




<div class="listContent">
    <div class="masonryContent" id="displayData">
        <?php if ($search_results): ?>
          <!--<h2 class="cmnHrd"><?php //print t('Search results');?></h2>-->
          <!--<ol class="search-results searchRecds <?php //print $module; ?>-results">-->
            <?php print $search_results; ?>
          <!--</ol>-->
        <div class="pagerContainer">
            <?php print $pager; ?>
        </div>
        <?php else : ?>
          <?php /*<h2 class="cmnHrd"><?php print t('Your search yielded no results');?></h2>
          <div class="noSearchResult">
            <?php print search_help('search#noresults', drupal_help_arg()); ?>
          </div>*/ ?>
        <?php endif; ?>
    </div>
</div>    
