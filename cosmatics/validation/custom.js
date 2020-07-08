jQuery(document).ready(function(){ 
/**** mobile number masking *******/
	$('#customer_mobile').mask('(000) 000-0000');
	$('#user_mobile').mask('(000) 000-0000');
	$('#contact_number').mask('(000) 000-0000');
/**** mobile number masking *******/

$.validator.addMethod("pwcheck", function(value) {
   return /^[A-Za-z0-9\d=!\-@._*$%^&`~#()/+]*$/.test(value) // consists of only these
       && /[a-z]/.test(value) // has a lowercase letter
       && /\d/.test(value) // has a digit
},'Passwords must contain at least six characters, including uppercase, lowercase letters, numbers, and special symbols.');

$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');
  
    jQuery('#CustomerForm').validate(
	{
	rules:{
            user_name: {
                required: true
            },
			sname: {
                required: true,
                number : false
            },
            user_email: {
                required: true,
                email: true
            },
            user_mobile: {
                required: true,
                minlength: 14,
                maxlength: 14
            },
            user_country: {
                required: true
            },
            user_state: {
                required: true
            },
			customer_city: {
                required: true
            },
            pin_code: {
                digits:true,
                minlength: 6,
                maxlength: 6
            }
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "user_name") {
			error.appendTo("#name_error_msg");
		}else if (element.attr("name") == "user_email") {
			error.appendTo("#email_error_msg");
		}else if (element.attr("name") == "user_mobile") {
			error.appendTo("#mobile_error_msg");
		}else if (element.attr("name") == "user_dob") {
			error.appendTo("#dob_error_msg");
		}else if (element.attr("name") == "user_country") {
			error.appendTo("#country_error_msg");
		}else if (element.attr("name") == "user_state") {
			error.appendTo("#state_error_msg");
		}else if (element.attr("name") == "customer_city") {
			error.appendTo("#city_error_msg");
		}else if (element.attr("name") == "title") {
			error.appendTo("#title_error_msg");
		}else if (element.attr("name") == "sname") {
			error.appendTo("#sname_error_msg");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },

	});
	
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
			}
		}

	});
	
    jQuery('#ConsultantForm').validate(
	{
	rules:{
            account_type: {
                required: true
            },
            user_name: {
                required: true,
                number : false
            },
			sname: {
                required: true,
                number : false
            },
            user_email: {
                required: true,
                email: true
            },
            user_mobile: {
                required: true,
                minlength: 14,
                maxlength: 14
            },
            user_country: {
                required: true
            },
            user_state: {
                required: true
            },
			user_city: {
                required: true,
				number: false,
            },
            pin_code: {
                digits:true,
                minlength: 6,
                maxlength: 6
            }
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "user_name") {
			error.appendTo("#name_error_msg");
		}else if (element.attr("name") == "user_email") {
			error.appendTo("#email_error_msg");
		}else if (element.attr("name") == "user_mobile") {
			error.appendTo("#mobile_error_msg");
		}else if (element.attr("name") == "user_dob") {
			error.appendTo("#dob_error_msg");
		}else if (element.attr("name") == "user_country") {
			error.appendTo("#country_error_msg");
		}else if (element.attr("name") == "user_state") {
			error.appendTo("#state_error_msg");
		}else if (element.attr("name") == "user_city") {
			error.appendTo("#city_error_msg");
		}else if (element.attr("name") == "title") {
			error.appendTo("#title_error_msg");
		}else if (element.attr("name") == "sname") {
			error.appendTo("#sname_error_msg");
		}else if (element.attr("name") == "account_type") {
			error.appendTo("#account_type_error_msg");
		}else if (element.attr("name") == "getids") {
			error.appendTo("#catsubcat_error_msg");
		}else if (element.attr("name") == "contact_number") {
			error.appendTo("#contact_number_error_msg");
		}else if (element.attr("name") == "aadhar_no") {
			error.appendTo("#aadhar_no_error_msg");
		}else if (element.attr("name") == "pan_no") {
			error.appendTo("#pan_no_error_msg");
		}else if (element.attr("name") == "about_consultant") {
			error.appendTo("#about_consultant_error_msg");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },

});
jQuery('#ConsultantverificationForm').validate(
	{
	rules:{
            v_account_type: {
                required: true
            },
            v_user_name: {
                required: true
            },
			v_user_email: {
                required: true,
            },
            v_user_gender: {
                required: true
            },
            v_user_dob: {
                required: true
            },
            v_user_state: {
                required: true
            },
            v_user_city: {
                required: true
            },
			v_user_address: {
                required: true,
            },
            v_pin_code: {
                required:true,
            },
			v_expertise: {
                required:true,
            },
			v_user_photo: {
                required:true,
            },
			v_banner_image: {
                required:true,
            },
			v_company_name: {
                required:true,
            },
			v_about_consultant: {
                required:true,
            },
			v_company_address: {
                required:true,
            },
			v_pan_no: {
                required:true,
            },
			v_pan_photo: {
                required:true,
            },
			v_aadhar_photo: {
                required:true,
            },
			v_aadhar_no: {
                required:true,
            },
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "v_account_type") {
			error.appendTo("#v_account_type_error");
		}else if (element.attr("name") == "v_user_name") {
			error.appendTo("#v_user_name_error");
		}else if (element.attr("name") == "v_user_email") {
			error.appendTo("#v_user_emailerror");
		}else if (element.attr("name") == "v_user_gender") {
			error.appendTo("#v_user_gender_error");
		}else if (element.attr("name") == "v_user_dob") {
			error.appendTo("#v_user_dob_error");
		}else if (element.attr("name") == "v_user_state") {
			error.appendTo("#v_user_state_error");
		}else if (element.attr("name") == "v_user_city") {
			error.appendTo("#v_user_city_error");
		}else if (element.attr("name") == "v_user_address") {
			error.appendTo("#v_user_address_error");
		}else if (element.attr("name") == "v_pin_code") {
			error.appendTo("#v_pin_code_error");
		}else if (element.attr("name") == "v_expertise") {
			error.appendTo("#v_expertise_error");
		}else if (element.attr("name") == "v_user_photo") {
			error.appendTo("#v_user_photo_error");
		}else if (element.attr("name") == "v_banner_image") {
			error.appendTo("#v_banner_image_error");
		}else if (element.attr("name") == "v_company_name") {
			error.appendTo("#v_company_name_error");
		}else if (element.attr("name") == "v_about_consultant") {
			error.appendTo("#v_about_consultant_error");
		}else if (element.attr("name") == "v_company_address") {
			error.appendTo("#v_company_address_error");
		}else if (element.attr("name") == "v_pan_photo") {
			error.appendTo("#v_pan_photo_error");
		}else if (element.attr("name") == "v_pan_no") {
			error.appendTo("#v_pan_no_error");
		}else if (element.attr("name") == "v_aadhar_photo") {
			error.appendTo("#v_aadhar_photo_error");
		}else if (element.attr("name") == "v_aadhar_no") {
			error.appendTo("#v_aadhar_no_error");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },

});

	jQuery('#ConsultantInfoForm').validate(
	{
		rules:{
			catsubcat: {
				required: true
			},
			/* subcategory_id: {
				required: true
			}, */
			user_email: {
				required: true,
				email: true
			},
			contact_number: {
				minlength: 14,
				maxlength: 14
			},
			aadhar_no: {
				digits:true,
				minlength: 12,
				maxlength: 12
			},
			pan_no: {
				minlength: 10,
				maxlength: 10
			},
			pin_code: {
				digits:true,
				minlength: 6,
				maxlength: 6
			},
			about_consultant: {
				required: true,
				minlength: 20,
			}
		},
		highlight: function (element) {            
			jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "catsubcat") {
				error.appendTo("#procedure_error_message_tools");
			}else{
				error.insertAfter(element);
			}
			element.click(function(){
				jQuery(this).next('label.error').hide();
			});
		},
		success: function (element) {           
//            element  ;                        
		},
	});
	
	jQuery('#AgentInfoForm').validate(
		{
		rules:{
			category_id: {
				required: true
			},
			subcategory_id: {
				required: true
			},
			user_email: {
				required: true,
				email: true
			},
			contact_number: {
				minlength: 14,
				maxlength: 14
			},
			aadhar_no: {
				digits:true,
				minlength: 12,
				maxlength: 12
			},
			pan_no: {
				minlength: 10,
				maxlength: 10
			},
			pin_code: {
				digits:true,
				minlength: 6,
				maxlength: 6
			},
			about_consultant: {
				required: true,
				minlength: 20,
			}
		},
		highlight: function (element) {            
			jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
		},        
		success: function (element) {           
			//element  ;                        
		},
	});

	jQuery('#TicketForm').validate(
	{
		rules:{
            customer_id: {
                required: true
            },
            consultant_id: {
                required: true
            },
            category_id: {
                required: true
            },
            start_date: {
                required: true
            },
            close_date: {
                required: true
            },
            ticket_status: {
                required: true
            },
            payment_status: {
                required: true
            },
            status: {
                required: true
            },
            description: {
                required: true
				/* maxlength: 500 */
            },
			customer_pincode: {
                required: true,
                digits:true,
                minlength: 6,
                maxlength: 6
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
			/* casefilename: {
                required: true
            } */
			
			
	},messages: {
		description: "Please enter less than 500 characters.",
	},
	highlight: function (element) {            
		jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "customer_id") {
			error.appendTo("#procedure_error_message_tools");
		}else if(element.attr("name") == "userfile[]") {
			error.appendTo("#error_message_tools");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	},	
	success: function (element) {           
	//            element  ;                        
	},

});
jQuery('#AssignTicketForm').validate(
	{
	rules:{
            consultant_id: {
                required: true
            },
            assign_date: {
                required: true
            },
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },

});
jQuery('#Consultantverifystep5Form').validate(
	{
	rules:{
			bank_name: {
                required: true
            },
			account_no: {
                required: true,
				digits:true
            },
			ifsc_code: {
                required: true
            },
			accountholdername: {
                required: true
            },
			v_bank_name: {
                required: true
            },
            v_account_no: {
                required: true
            },
			v_ifsc_code: {
                required: true,
            },
            v_accountholdername: {
                required: true
            },
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "v_bank_name") {
			error.appendTo("#v_bank_name_error");
		}else if(element.attr("name") == "v_account_no") {
			error.appendTo("#v_account_no_error");
		}else if(element.attr("name") == "v_ifsc_code") {
			error.appendTo("#v_ifsc_code_error");
		}else if(element.attr("name") == "v_accountholdername") {
			error.appendTo("#v_accountholdername_error");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	}
});
/* jQuery('#Consultantverifystep4Form').validate(
	{
	rules:{
			'casefilename[]': 'required'
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "casefilename[]") {
			error.appendTo("#error_message_tools");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	},
	success: function (element) {
		
	},

}); */
jQuery('#Addremarkform').validate(
	{
	rules:{
            request_accepted: {
                required: true
            },
			/* admin_remark: {
                required: true
            } */
	},
});
jQuery('#AgentAssignTicketForm').validate({
	rules:{
            agent_id: {
                required: true
            },
            assign_date: {
                required: true
            },
	},
	highlight: function (element) {            
		jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
	},        
	success: function (element) {           
//            element  ;                        
	},
});

jQuery('#CategoryForm').validate({
	rules:{
		cat_name: {
			required: true
		},
		cat_status: {
			required: true
		},
		cat_desc: {
			required: true
		},
		cat_slogan: {
			required: true
		},
		headline: {
			required: true
		}
	},
	highlight: function (element) {  
	
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },
});

jQuery('#SubCategoryForm').validate(
	{
	rules:{
            pcat_name: {
                required: true
            },
            cat_name: {
                required: true
            },
            amount: {
                required: true,
                number: true
            },
            cat_status: {
                required: true
            },
			cat_slogan: {
                required: true
            }
	},
	highlight: function (element) {    

            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control'); 
			      
        },        
        success: function (element) {           
//            element  ;                        
        },
});

jQuery('#StateForm').validate(
	{
	rules:{
            country_name: {
                required: true
            },
            state_name: {
                required: true
            },
            state_status: {
                required: true
            }
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },
});

jQuery('#ExpertiseForm').validate(
	{
	rules:{
            exp_name: {
                required: true
            },
            exp_status: {
                required: true
            }
	},
	highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },
});
jQuery('#TicketStatusForm').validate(
	{
	rules:{
            ticket_status: {
                required: true
            },
			consultant_remark:{
				maxlength: 255
			}
	}
});

jQuery('#CustomerTicketForm').validate(
	{
	rules:{
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
                minlength: 14,
                maxlength: 14
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
			/* 'image[]':{
				required:true
			} */
	},
	messages: {
      description: "Please enter less than 500 characters.",
    }/* ,
	errorPlacement: function(error, element) {
		if (element.attr("name") == "image[]") {
			error.appendTo("#error_message_tools");
		}else if (element.attr("name") == "subcategory_id") {
			error.appendTo("#error_message_tools");
		}else{
			error.insertAfter(element);
		}
		element.click(function(){
			jQuery(this).next('label.error').hide();
		});
	} */,
	highlight: function (element) {            
		jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
	},        
	success: function (element) {           
		//	element  ;                        
	},

});

    jQuery('#ProfileForm').validate(
	{
	rules:{
		account_type: {
			required: true
		},
		user_name: {
			required: true,
		},
		user_email: {
			required: true,
			email: true
		},
		user_mobile: {
			required: true
		},
		user_country: {
			required: true
		},
		user_state: {
			required: true
		},
		user_city: {
			required: true
		},
		pin_code: {
			required: true,
			digits:true,
			minlength: 6,
			maxlength: 6
		},
		user_gender: {
			required: true
		},
		user_address: {
			required: true
		}
	},
	highlight: function (element) {            
		jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
	},        
	success: function (element) {           
//            element  ;                        
	},

	});

jQuery('#ChangePwForm').validate(
	{
        rules : {
			old_password : {
				required : true,
				pwcheck: true,
			},
			new_password : {
				required: true,
				pwcheck: true,
				maxlength: 50,
				minlength : 6,
			},
			confirm_password : {
				required : true,
				pwcheck: true,
				equalTo : "#new_password"
			}
        },
            messages: {
            confirm_password: {
                equalTo: "New password and confirm password schould be same",
            }
        },
		highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
//            element  ;                        
        },
});


	jQuery('#profilesetting').validate(
	{
        rules : {
		   user_email : {
				required : true,
				email : true
		   },
			user_name : {
			   required : true
		   },
		   user_mobile: {
				digits:true,
				required: true,
				minlength: 14,
				maxlength: 14
			},
		   user_country : {
			   required : true
		   },
		   user_city :{
			   required : true
		   },
		   pin_code : {
			   required : true
		   },
		   user_gender : {
			   required : true
		   },
//		   user_photo : {
//			   extension: "jpg|jpeg|png|gif",
//			   filesize: 1000000
//		   }
        },
        messages: {
            user_photo: {
                            extension: 'Only upload jpg | jpeg | png | gif files',
                            filesize: 'Max. file size limit exceeded!'
			}
        },
		highlight: function (element) {            
            jQuery(element).closest('.loginbox').removeClass('valid form-control').addClass('error-textbox form-control');           
        },        
        success: function (element) {           
		//element  ;                        
        },
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