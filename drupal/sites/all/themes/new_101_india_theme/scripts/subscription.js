function submitSubscription(){
	
	$(".thankYou").hide();
	$(".error").hide();
	
	var email = $('#email_id').val();
	if(validateEmail(email)){
		$.ajax({
				type:'POST',
				url:'submit-subscriptions',
				data:'email='+email,
				success:function(data){
					
					if($.trim(data)=="Failure"){
						$(".error").show();
						$(".error").html("Invalid e-mail address "+email);
					}else if($.trim(data)=="Already Exist"){
						$(".error").show();
						$(".error").html("This e-mail id is already registered with us.");
					}else if($.trim(data)=="Database error occured"){
						$(".error").show();
						$(".error").html("Database error occured");
					}else{
						$('#email_id').val("");
						$(".thankYou").show();
					}
					
				}
		});
	}else{
		$(".error").show();
		$(".error").html("Invalid e-mail address "+email);
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