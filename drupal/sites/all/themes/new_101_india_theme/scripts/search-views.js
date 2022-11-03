function loaderClicked(){
	$('#autopager-load-more').css('visibility', 'hidden');
}

$(document).ready(function(){
	Drupal.behaviors.views_infinite_scroll = {
	  attach: function (context, settings) {
		$.autopager.option("checkifLoaded", true);
		$('#autopager-load-more').css('visibility', 'visible');
	  }
	};
});