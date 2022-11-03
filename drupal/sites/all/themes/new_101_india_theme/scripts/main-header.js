$(document).ready(function(){
    $('#email_id').keypress(function(e){
      if(e.keyCode==13){
          submitSubscription();
      }else{
          $('#errorMessage').hide();
      }
    });

    $('#email_id').on("focus", function(){
        $('#errorMessage').hide();
    });
	$('#close_pop').click(function(){
		console.log('close pop main headerjs');
		//$("#subscribe_pop").hide();
		//$('.overlay').hide();
		$( ".popContainer" ).animate({
			top: "-100%"
		  }, 900, function() {
			// Animation complete.
			$("#subscribe_pop").hide();
			$("#youtube_subscribe").hide();
			$('.overlay').hide();
			/*setTimeout(function() {
				$('.overlay').hide();
			}, 3500);*/
			
		  });
	});
});
function showSubscribepop(){
	//alert('hello');
	$('#youtube_subscribe').hide();
	$('.overlay').show();
	$('#subscribe_pop').show();
}

function submitSubscription(){
    $(".thankYouText").hide();
    $("#errorMessage").hide();

    var email = $('#email_id').val();
	if(email == ''){
		$(".errMsg").show();
		$(".errMsg").html("Please enter e-mail address");
	}
    if(validateEmail(email)){

        $(".subscribeBtn").hide();
        $(".loader").fadeIn();

        $.ajax({
                type:'POST',
                url: Drupal.settings.basePath + 'submit-subscriptions',
                data:'email='+email,
                success:function(data){

                    if($.trim(data)=="Failure"){
                        $(".errMsg").show();
                        $(".errMsg").html("Invalid e-mail address");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else if($.trim(data)=="Already Exist"){
                        $(".errMsg").show();
                        $(".errMsg").html("This e-mail id is already registered with us.");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else if($.trim(data)=="Database error occured"){
                        $(".errMsg").show();
                        $(".errMsg").html("Database error occured");

                        $(".subscribeBtn").fadeIn();
                        $(".loader").hide();
                    }else{
                        $('#email_id').val("");
                        $("#subForm").fadeOut();
                        $(".thankYouText").fadeIn();
                        $("#email_id").hide();
						$(".errMsg").hide();
                        $(".loader").hide();
                        setTimeout(function() {
                            $('.thankYouText').fadeOut();
                        }, 10000);
                    }

                }
        });
    }else{
        $(".errMsg").show();
        $(".errMsg").html("Invalid e-mail address");
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