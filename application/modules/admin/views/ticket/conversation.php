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
            height: 450px;            
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
							<div class="col-md-6 col-xs-12">
								<?php echo form_label('Ticket Id : ', 'ticket_id_lbl'); ?>
								<span class=""><b><?php echo ' '.isset($usersdata->ticket_id)?$usersdata->ticket_id:'';?></b></span>
							</div>
							<div class="col-md-6 col-xs-12">
								<?php echo form_label('Consultant Category : ', 'category_id'); ?>
								<span class=""><?php echo ' '.isset($usersdata->cname)?$usersdata->cname:'';?></span>
							</div>
							<div class="col-md-6 col-xs-12">
								<?php 
									$subcatdata = $this->category_model->getCategoryById($usersdata->consultantsubcat);
								?>
								<?php echo form_label('Consultant Subcategory : ', 'subcategory_id'); ?>
								<span class=""><?php echo ' '.isset($subcatdata->name)?$subcatdata->name:'';?></span>
							</div>
							<div class="col-md-6 col-xs-12">
								<?php echo form_label('Consultant Name : ', 'consultantname'); ?>
								<span class=""><?php 
									$consultantname = isset($usersdata->consultantname)?ucfirst($usersdata->consultantname):'';
									$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $consultantname)));
									$lowercaseTitle = strtolower($new_string); 
									$TitleString 	= ucwords($lowercaseTitle);
									echo ' '.$TitleString;
								?></span>
							</div>
							<div class="col-md-6 col-xs-12">
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
                        <div id="MsgBox">
                        <?php echo $html;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 
}else{
	redirect(base_url().'admin/ticket/assign_list');
} ?>

<script>
    //MsgBoxclass="direct-chat-messages"
    setInterval(function(){// alert("Hello"); 
        var ticketid = '<?php echo $ticketid; ?>';
        jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/ticket/getChatDataByAjax/'.$ticketid; ?>",
                data: {'ticketid':ticketid},
                success: function (responseText)
                {
                    
                    $('#MsgBox').html(responseText);
                   // alert($('.direct-chat-messages').prop("scrollHeight"));
                    //$('.direct-chat-messages').animate({scrollTop: ($('#MsgBox').prop("scrollHeight")+125)}, 0);
                    $('.direct-chat-messages').animate({scrollTop: ($('.direct-chat-messages').prop("scrollHeight"))}, 0);
                    //scrollToBottom("direct-chat-messages");
                    //var objDiv = document.getElementsByClassName("direct-chat-messages");
                   // objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
    
    }, 3000);
    


</script>  