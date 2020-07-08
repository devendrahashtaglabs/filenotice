<?php if(!empty($usersdata)){ ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $section_name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo $breadcrumb; ?>
                </div>
            </div>
        </div>
    </section>
    <style type="text/css">
        .direct-chat-text a {color: white !important;}
        .direct-chat-text a:hover {color: wheat !important;}
        img.direct-chat-img.chat-img-class {float: left;}
        .direct-chat-messages{
            height: 350px;            
        }
		#inners {width:100%;height:325px;overflow:scroll;padding:15px;}
		#loader {display:none;}
		#MsgBox {min-height:40px;}
		.date {font-size:9px;color:#1f1f1f;}
		.file-field input[type="file"] {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			width: 100%;
			padding: 0;
			margin: 0;
			cursor: pointer;
			filter: alpha(opacity=0);
			opacity: 0;
		}
		.btn-floating {
			position: relative;
			z-index: 1;
			display: inline-block;
			padding: 0;
			margin: 10px 0;
			overflow: hidden;
			vertical-align: middle;
			cursor: pointer;
			border-radius: 50%;
			-webkit-box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
			box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
			-webkit-transition: all 0.2s ease-in-out;
			transition: all 0.2s ease-in-out;
			width: 38px;
			height: 38px;
		}
		.file-field {
			position: relative;
		}
		.md-form {
			position: relative;
		}
		.btn-floating i {
			display: inline-block;
			width: inherit;
			color: #fff;
			text-align: center;
		}
		.btn-floating i {
			font-size: 1.25rem;
			line-height: 38px;
		}
		.peach-gradient {
			background: linear-gradient(40deg, #343a40, #0069d9) !important;
		}
		.customtexts {
			padding-left: 0;
		}
		.cusotmcontrol.md-form {
			padding-right: 0;
		}
		.input-group-append.subntithis {
			float: left;
			width: 64%;
		}
		.mysmdgs {
			float: right;
			width: 83%;
			text-align: right;
			position: relative;
			color: red;
			font-size: 13px;
		}
		.customtexts #message {
			border-radius: 25px;
		}
		.file-field .file-path-wrapper {
			padding-left: 10px;
			overflow: hidden;
			position: absolute;
			top: 35px;
		}
		.input-group-append.subntithis {
			float: left;
			width: 100%;
			display: block;
		}
		.file-path.validate.form-control{
			border-radius:25px;
		}
		#uploaded-file {
			margin-top: 5%;
		}
		.card-footer{
			min-height:400px;
		}
	</style>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">
                        <div class="">
							<h3 class="card-title"><?php //echo $page_title; ?></h3>
						</div>
						<div class="row mt-3">
							<div class="col-md-4 col-xs-12">
								<?php echo form_label('Ticket Id : ', 'ticket_id_lbl'); ?>
								<span class="ticket-id"><b><?php echo ' '.isset($usersdata->ticket_id)?$usersdata->ticket_id:'';?></b></span>
							</div>
							<div class="col-md-4 col-xs-12">
								<?php echo form_label('Agent Category : ', 'category_id'); ?>
								<span class=""><?php echo ' '.isset($usersdata->cname)?$usersdata->cname:'';?></span>
							</div>
							<?php 
								$subcatdata = $this->category_model->get_category_data($usersdata->consultantsubcat);
							?>
							<div class="col-md-4 col-xs-12">
								<?php echo form_label('Agent Subcategory : ', 'subcategory_id'); ?>
								<?php if(!empty($subcatdata)){ ?>
									<span class=""><?php echo ' '.isset($subcatdata->name)?$subcatdata->name:'';?></span>
								<?php } ?>
							</div>
							<div class="col-md-4 col-xs-12">
								<?php echo form_label('Customer Name : ', 'customername'); ?>
								<span class=""><?php 
									$customername = isset($usersdata->customername)?ucfirst($usersdata->customername):'';
									$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $customername)));
									$lowercaseTitle = strtolower($new_string); 
									$ucTitleString 	= ucwords($lowercaseTitle);
									echo ' '.$ucTitleString;
								?></span>
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<div id='inners'>
							<div id="MsgBox">
								<?php //echo $html;?>
							</div>    
						</div>
                        <div class="card-footer">
                            <form id="create-conversation" enctype="multipart/form-data">
								<?php 
									if(!empty($ticketid)){
										$ticketdata = $this->ticket_model->getTicketById($ticketid);
										if($ticketdata->ticket_status == '20' || $ticketdata->ticket_status == '21' || $ticketdata->ticket_status == '22' || $ticketdata->ticket_status == '92' || $ticketdata->ticket_status == '93'){
								?>
									<div class="input-group">
									<div style="display:none"><img id='loader' src='https://precedentjd.com/wp-content/themes/student/img/loader.gif' style='visibility:hidden ;width:50px'></div>
                                    
                                   
										<div class="col-md-10 customtexts"><input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control"></div>
										<div class="col-md-1 cusotmcontrol md-form">
											<div class="file-field">
												<a class="btn-floating peach-gradient mt-0 float-left" id="fileicon">
													<i class="fa fa-paperclip" aria-hidden="true"></i>
													<input type="file" name="upload_file" id="upload_file">
												</a>
												<div class="file-path-wrapper">
													<!--<input class="file-path validate form-control" type="text" placeholder="Upload your file" id="uploaded-file">-->
													<p id="uploaded-file"></p>
												</div>
											</div>                 

										</div> 
										<div class="col-md-1">										
										<span class="input-group-append subntithis">
											<input type="submit" name="submit" class="btn btn-primary send_massege" style="width: 100%;" value="Send"/>
										</span>
										</div>
										<input type="button" name="refresh" class="btn btn-primary" value="Refresh" style="display:none;"/>
                                        <?php echo '<div class="mysmdgs">Supporting  file format doc, pdf , docx, txt, jpg, png, jpeg and size 2mb.</div>';?>										
									</div>
																		
									
									<?php echo '<div class=" row col-md-7 pull-right chat-success-msg-sent-img" style="padding-left: 52px;"></div>';?>
								<?php echo '<div class="chat-success-msg-sent"></div>'; } } ?>
								<input type="hidden" name="ticketid" id="chatticketid" value="<?php echo $ticketid; ?>" />
								<input type="hidden" name="lastid" id="lastid" 
								value="<?php if(isset($chatdatas)){ echo $chatdatas; } ?>" />
								<input type="hidden" name="chatcountstart" id="chatcountstart" value="0" />
								<input type="hidden" name="chatcountlimit" id="chatcountlimit" value="7" />
								<input type="hidden" name="nochat" id="nochat" value="0" />
                            </form>
							<div id="chatBoxes">						
								<div class='inners'>
									<!-- WHERE YOU WILL LOAD CONTENT-->
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 
}else{
	redirect(base_url().'ticket/assign');
} ?>
<script>
	$(document).ready(function(){
		$('#fileicon').click(function(){
			$('#upload_file').change(function() {
				var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
				$('#uploaded-file').html(filename);
			});
		});
	});
    //MsgBoxclass="direct-chat-messages"
    /* setInterval(function(){
        // alert("Hello"); 
        
        jQuery.ajax({
                type: "GET",
                url: "<?php //echo base_url().'ticket/getChatDataByAjax/'.$ticketid; ?>",
                data: {},
                success: function (responseText)
                {
                    
                    //console.log(responseText);
					
                    $('#MsgBox').html(responseText);
                   // alert($('.direct-chat-messages').prop("scrollHeight"));
                    //$('.direct-chat-messages').animate({scrollTop: ($('#MsgBox').prop("scrollHeight")+125)}, 0);
                    $('.direct-chat-messages').animate({scrollTop: ($('.direct-chat-messages').prop("scrollHeight"))}, 0);
                    //scrollToBottom("direct-chat-messages");
                    //var objDiv = document.getElementsByClassName("direct-chat-messages");
                   // objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
    
    }, 3000);  */
    
// function showLoading(){
// document.getElementById("loading").style = "visibility: visible";
// }
// function hideLoading(){
// document.getElementById("loading").style = "visibility: hidden";
// }

</script>    