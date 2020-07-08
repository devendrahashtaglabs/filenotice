jQuery(document).ready(function(){ 

/**** mobile number masking *******/
$('#customer_mobile').mask('(000) 000-0000');
$('#phone').mask('(000) 000-0000');
$('#consultant_phone').mask('(000) 000-0000');
$('#consltant_phone').mask('(000) 000-0000');

/**** mobile number masking *******/
/**** smoth scroll *******/
	$(".appoinment").click(function(e) {
		e.preventDefault();		
		var position = $($(this).attr("href")).offset().top;
		$("body, html").animate({
			scrollTop: position
		} ,1000 );
	});
/**** smoth scroll *******/

$.validator.addMethod("pwcheck", function(value) {
   return /^[A-Za-z0-9\d=!\-@._*$%^&`~#()/+]*$/.test(value) // consists of only these
       && /[a-z]/.test(value) // has a lowercase letter
       && /\d/.test(value) // has a digit
},'Passwords must contain at least six characters, including uppercase, lowercase letters, numbers, and special symbols.');

function isValidDate(dateString) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  if(!dateString.match(regEx)) return false;  // Invalid format
  var d = new Date(dateString);
  var dNum = d.getTime();
  if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
  return d.toISOString().slice(0,10) === dateString;
}


$.validator.addMethod("ageMinCheck", function (value, element) {
	let TODAY = new Date(Date.now());
	let EIGHTEEN_YEARS_BACK = new Date((new Date(TODAY).getFullYear() - 18)+"-"+(new Date(TODAY).getMonth()+1)+"-"+new Date(TODAY).getDate());
	let EIGHTY_YEARS_BACK = new Date((new Date(TODAY).getFullYear() - 80)+"-"+(new Date(TODAY).getMonth()+1)+"-"+new Date(TODAY).getDate());
	var newdobdate 	= value.split("-").reverse().join("-");
	var correctdate	= isValidDate(newdobdate);
	var dateofbirth = value.split("-");
	if(dateofbirth.length >= 3){
		if(correctdate){
			let USER_INPUT 	= new Date(newdobdate); 
			// Validate Now
			let result = EIGHTEEN_YEARS_BACK > USER_INPUT // true if over 18, false if less than 18	
			let result1 = EIGHTY_YEARS_BACK < USER_INPUT // true if over 18, false if less than 18
			if(result == true && result1 == true){
				return true;
			}else{
				return false;
			}
		}else{
			$('#c_dob').val('');
			alert("Enter correct dob format.Please choose date from calendar!");
		}
	}
}, "You are not old enough!"); 

$.validator.addMethod("coAgeMinCheck", function (value, element) {
	let TODAY = new Date(Date.now());
	let EIGHTEEN_YEARS_BACK = new Date((new Date(TODAY).getFullYear() - 18)+"-"+(new Date(TODAY).getMonth()+1)+"-"+new Date(TODAY).getDate());
	let EIGHTY_YEARS_BACK = new Date((new Date(TODAY).getFullYear() - 80)+"-"+(new Date(TODAY).getMonth()+1)+"-"+new Date(TODAY).getDate());
	var newdobdate 	= value.split("-").reverse().join("-");
	var correctdate	= isValidDate(newdobdate);
	var dateofbirth = value.split("-");
	if(dateofbirth.length >= 3){
		if(correctdate){
			let USER_INPUT 	= new Date(newdobdate); 
			// Validate Now
			let result = EIGHTEEN_YEARS_BACK > USER_INPUT // true if over 18, false if less than 18	
			let result1 = EIGHTY_YEARS_BACK < USER_INPUT // true if over 18, false if less than 18
			if(result == true && result1 == true){
				return true;
			}else{
				return false;
			}
		}else{
			$('#co_dob').val('');
			alert("Enter correct dob format.Please choose date from calendar!");
		}
	}
}, "You are not old enough!"); 

jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");
	jQuery('#ticketformfront').validate({
		rules:{
				fname: {
					required: true
				},
				sname: {
					required: true
				},
				email: {
					required: true
				},
				subcatid: {
					required: true
				},
				status: {
					required: true
				},
				description: {
					required: true,
					/* maxlength: 500 */
				},
				customer_pincode: {
					required: true,
					digits:true,
					minlength: 6,
					maxlength: 6
				},
				customer_mobile: {
					required: true,
					/* minlength: 14,
					maxlength: 14 */
				},
				customer_country: {
					required: true,
				},
				customer_state: {
					required: true,
				},
				customer_city: {
					required: true,
					maxlength: 100
				},
				customer_address: {
					required: true,
					maxlength: 200
				},
				terms: {
					required: true,
				},
				username: {
					required: true,
				},
				useremail: {
					required: true,
				}
				
		},
		messages: {
		  customer_pincode: {
			minlength: "Enter at least 6 characters.",
			maxlength: "Enter at least 6 characters.",
			digits: "Enter only digit.",
		  }
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "image[]") {
				error.appendTo("#error_message_tools");
			}else if (element.attr("name") == "subcatid") {
				error.appendTo("#subcat_error_message_tools");
			}else if (element.attr("name") == "description") {
				error.appendTo("#desc_error_message_tools");
			}else if (element.attr("name") == "terms") {
				error.appendTo("#terms_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){
				jQuery(this).next('label.error').hide();
			});
		}/* ,
		highlight: function (element) {            
			jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
		},        
		success: function (element) {           
			//	element  ;                        
		}, */

	});
	var form_customers = jQuery('#form_customers').validate({
		rules:{
			fname: {
				required: true,
				maxlength: 50
			},
			sname: {
				required: true,
				maxlength: 50
			},
			email: {
				required: true,
				email: true,
				maxlength: 50
			},
			gender: {
				required: true,
			},
			phone: {
				required: true,
				minlength: 14,
				maxlength: 14
			},
			c_dob: {
				//required: true,
				ageMinCheck: true
			},
			c_password: {
				required: true,
				pwcheck: true,
				maxlength: 50,
				minlength : 6,
			},
			c_cpassword: {
				required: true,
				maxlength: 50,
				equalTo: "#c_password"
			},
			c_country: {
				required: true,
			},
			c_state: {
				required: true,
			},
			c_city: {
				required: true,
				digits: false,
				maxlength: 50,
			},
			c_pin: {				
				noSpace:true,
				required: true,
				digits:true,
				minlength: 6,
				maxlength: 6,
			},
			c_address: {
				required: true,
				maxlength: 255
			},
			acc_type: {
				required: true,
			},
			catsubcat: {
				required: true
			},/* 
			subcat_id: {
				required: true,
			}, */
			terms:{
				required: true
			}
			
		},
		messages: {
		  c_dob: {
			required: "Please enter you date of birth.",
			ageMinCheck: "Age must be in between 18 to 80years old!",
		  }
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "catsubcat") {
				error.appendTo("#procedure_error_message_tools");
			}else if (element.attr("name") == "terms") {
				error.appendTo("#terms_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){
				jQuery(this).next('label.error').hide();
			});
		}
	});
	jQuery('.resetbtn').click(function(){
		form_customers.resetForm();
	});
	
	/*** consultant form ***/
	var form_consultant = jQuery('#form_consultant').validate({
		rules:{
			fname: {
				required: true,
				maxlength: 50
			},
			sname: {
				required: true,
				maxlength: 50
			},
			email: {
				required: true,
				email: true,
				maxlength: 50
			},
			gender: {
				required: true,
			},
			phone: {
				required: true,
				minlength: 14,
				maxlength: 14
			},
			co_dob: {
				required: true,
				coAgeMinCheck: true
			},
			co_password: {
				required: true,
				pwcheck: true,
				maxlength: 50,
				minlength : 6,
			},
			co_cpassword: {
				required: true,
				maxlength: 50,
				equalTo: "#co_password"
			},
			c_country: {
				required: true,
			},
			c_state: {
				required: true,
			},
			c_city: {
				required: true,
				digits: false,
				maxlength: 50,
			},
			c_pin: {				
				noSpace:true,
				required: true,
				digits:true,
				minlength: 6,
				maxlength: 6,
			},
			c_address: {
				required: true,
				maxlength: 255
			},
			acc_type: {
				required: true,
			},
			catsubcat: {
				required: true
			},/* 
			subcat_id: {
				required: true,
			}, */
			terms:{
				required: true
			}
		},
		messages: {
		  co_dob: {
			required: "Enter you date of birth.",
			ageMinCheck: "Age must be in between 18 to 80years old!",
		  }
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "catsubcat") {
				error.appendTo("#subcat_error_message_tools");
			}else if (element.attr("name") == "terms") {
				error.appendTo("#terms_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){
				jQuery(this).next('label.error').hide();
			});
		}
	});
	jQuery('.conresetbtn').click(function(){
		form_consultant.resetForm();
	});
	
	/*** consultant form ***/	
	
	jQuery('#FilenoticeLoginForm').validate({
		rules:{
			username: {
				required: true,
				email: true,
			},
			password: {
				required: true,
				//pwcheck: true,
			}
		}

	});
	/***** subcategory form **********/
	jQuery('#payment_form').validate({
		rules:{
			fname: {
				required: true,
				number:false,
				digits:false,				
			},
			email: {
				required: true,
				email: true,
			},
			mobile: {
				required: true,
				digits: true,
			},
			terms: {
				required: true,
			}
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "terms") {
				error.appendTo("#terms_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){
				jQuery(this).next('label.error').hide();
			});
		}

	});
	jQuery('#form_resets').validate({
		rules:{
			newpassword: {
				required: true,
				pwcheck: true,
				maxlength: 50,
				minlength : 6,
			},
			confirmpassword: {
				required: true,
				equalTo: "#newpassword"
			}
		}
	});
	jQuery('#enquiryform').validate({
		rules:{
			username: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			phone: {
				required: true,
				digits:true,
				maxlength:14,
				minlength:14
			},
			user_query: {
				required: true,
			},			
		}
	});
	jQuery('#forgot-form').validate({
		rules:{
			email: {
				required: true,
				email: true,
				maxlength:50
			}			
		}

	});
	jQuery('.reply_form').validate({
		rules:{
			reply_text: {
				required: true,
			}			
		}

	});
	$.validator.addMethod("greaterThan",
		function (value, element, param) {
			var $otherElement = $(param);
			//alert(parseInt(value, 10) <= parseInt($otherElement.val(), 10));
			return parseInt(value, 10) >= parseInt($otherElement.val(), 10);
		}		
	);
	
	$('.remain-char').hide();
});
function countChar(val,highest_character) {
	var len = val.value.length;
	if( val.value.trim().length == '0' ){
		//alert('Before any letter you can not enter space!');
		$(val).val('');
		$('.remain-char').hide();
		return false;
	}
	if(len == '0'){
		$('.remain-char').hide();
	}
	if (len >= highest_character) {
		$('.remain-char').hide();
		val.value = val.value.substring(0, highest_character);
		alert("You have exceeded the maximum character limit");
	} else {
		if(len > 0){
			$('.remain-char').show();
		}
		$('#charNum').text(highest_character - len);
	}
};
