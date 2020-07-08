<?php 
	$categoryid 		= !empty($usersData)?$usersData->category_id:'';
	$subcategoryid 		= !empty($usersData)?$usersData->subcategory_id:'';
	$categoryidarr 		= explode(',',$categoryid);
	$subcategoryidarr 	= explode(',',$subcategoryid);
	$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
	$selectedcategories = implode(',',$allcat);
?>
<style type="text/css">
	.select2-container--default.select2-container--focus .select2-selection--multiple {
	border: 1px solid #ced4da !important;
	outline: 0;
	height: 38px;
}
.select2-container--default .select2-selection--multiple {
	background-color: white;
	border: 1px solid #ced4da !important;
	border-radius: 4px;
	cursor: text;
	height: 38px;
}
.form-group:last-of-type {
	margin-top: 0;
}
.img-fluid {
	margin: 15px 0 0;
}
#qualification, #experience_yr, #ad_qualification {
	float: left;
	width: 49%;
}
#sub_qualification, #experience_mn, #ad_sub_qualification {
	float: left;
	width: 49%;
	margin-left: 10px;
}
.form-group.col-12.mt-5.pb-3.border-bottom{
	margin-top: 25px !important;
}
.profilebg {
	background: #f4f4ff;
	padding: 10px;
	display: block;
	float: left;
	width: 100%;
}
.btn.btn-warning {
    background: #F3781E;
    color: #fff;
    border: 2px solid #F3781E;
}
.btn.btn-danger {
    background: #263a7d;
    color: #fff;
    border: 2px solid #263a7d;
}
.titkeofpgr{
	font-size: 18px;
	font-weight: 600;
	margin: 0;
	color: #263a7d;
}
.col-sm-4.col-form-label {
	position: relative !important;
}
</style>
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
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Margin on category & subcategory</h3>
						<div class="row" style="min-height: 130px;">
						  <div class="active-screen">
							  <div class="number-account">
								  <span class="number one">
									<a href="<?php echo $profile; ?>">1</a>
								   </span>
								   <span class="text-part">
										Personal<br>Info
									</span>
							  </div>
							  <div class="number-account">
								<span class="number two">
									<a href="<?php echo $profile2; ?>">2</a>
								 </span>
								 <span class="text-part">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three ">
									<a href="<?php echo $profile3; ?>">3</a>
								</span>
								<span class="text-part ">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four active">
									<a href="<?php echo $profile4; ?>">4</a>
								</span>
								<span class="text-part active">
									Sub Category<br>Margin Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five notreached">
									<a href="<?php echo $profile5; ?>">5</a>
								</span>
								<span class="text-part">
									Bank<br>Info
								</span>
							  </div>
							</div>
						</div>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'ConsultantInfoForm')); ?>
                    <div class="card-body floating-laebls">
                    	<div class="profilebgs">
                        <?php
							if ($this->session->flashdata('responce_msg') != "") {
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
							}
							$categories 		= $usersData->category_id;
							$categoryArray 		= explode(',',$categories);
							$subcategories 		= $usersData->subcategory_id;
							$subcategoryArray 	= explode(',',$subcategories);
                        ?>
                        <div class="row">
							<div class="col-12">
								<h4 class="titkeofpgr">Selected Category & Subcategory</h4>
							</div>
						</div>
                        <div class="row my-5">
                            <div class="col-12">
								<div class="bs-example">
									<div class="panel-group" id="accordion">
										<?php 
											$count = 1;
											foreach($categoryArray as $category){
												$categorydata = $this->category_model->get_category_data($category);
										?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>" class="" aria-expanded="true"><span class="glyphicon glyphicon-menu-right"></span> <?php echo !empty($categorydata)?$categorydata->name:''; ?></a>
												</h4>
											</div>
											<div id="collapse<?php echo $count; ?>" class="panel-collapse collapse in show">
												<div class="panel-body">
													<?php 
														foreach($subcategoryArray as $subcategory){
															$subcategorydata = $this->category_model->get_category_data($subcategory);
															if($subcategorydata->parent_id == $category){
													?>
														<div class="form-group row">
															<label for="staticEmail" class="col-sm-4 col-form-label"><?php echo $subcategorydata->name; ?> ( <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcategorydata->amount; ?> ) </label>
															<div class="col-sm-8 fromares">
																<?php 
																	$margin_percentage = $usersData->margin_percentage;
																	if(empty($margin_percentage)){
																?>
																	<span> 10% margin of subcategory amount. </span>
																<?php 
																	}else{
																		$margin =	json_decode($margin_percentage);
																		foreach($margin as $marginpercent){
																			if($marginpercent->subcatid == $subcategory ){
																?>
																		<span> <?php echo $marginpercent->margin_percent; ?>% margin of subcategory amount. </span>
																	<?php } ?>
																<?php } } ?>
															</div>
														</div>
													<?php } } ?>
												</div>
											</div>
										</div>
										<?php $count++; } ?>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "create_user_btn", "value" => "Submit & Next"));
										echo '&nbsp;&nbsp;<a href="' . base_url('profile') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
							</div>
                        </div>
                    </div>
                </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="profile_pic_modal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo base_url('/users/customerController/change_image');?>">
<strong>Upload Image:</strong> <br><br>
<input type="file" name="profile-pic" id="profile-pic" />
<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />
<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
<input type="hidden" name="action" value="" id="action" />
<input type="hidden" name="image_name" value="" id="image_name" />
<div id='preview-profile-pic'></div>
<div id="thumbs" style="padding:5px; width:600p"></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
</div>
</div>
</div>
</div>
<script>
jQuery(document).ready(function(){
	/* When click on change profile pic */	
	jQuery('#change-profile-pic').on('click', function(e){
        jQuery('#profile_pic_modal').modal({show:true});        
    });	
	jQuery('#profile-pic').on('change', function()	{
		jQuery("#preview-profile-pic").html('');
		jQuery("#preview-profile-pic").html('Uploading....');
		jQuery("#cropimage").ajaxForm({
		target: '#preview-profile-pic',
		success:    function() { 
				jQuery('img#photo').imgAreaSelect({
				aspectRatio: '1:1',
				onSelectEnd: getSizes,
			});
			jQuery('#image_name').val(jQuery('#photo').attr('file-name'));
			}
		}).submit();
	});
	/* handle functionality when click crop button  */
	jQuery('#save_crop').on('click', function(e){
    e.preventDefault();
	var base_url = '<?php echo base_url("/users/customerController/change_image");?>';
    params = {
            targetUrl: base_url+'?action=save',
            action: 'save',
            x_axis: jQuery('#hdn-x1-axis').val(),
            y_axis : jQuery('#hdn-y1-axis').val(),
            x2_axis: jQuery('#hdn-x2-axis').val(),
            y2_axis : jQuery('#hdn-y2-axis').val(),
            thumb_width : jQuery('#hdn-thumb-width').val(),
            thumb_height:jQuery('#hdn-thumb-height').val()
        };
        saveCropImage(params);
    });
    /* Function to get images size */
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
			jQuery('#hdn-x1-axis').val(x_axis);
			jQuery('#hdn-y1-axis').val(y_axis);
			jQuery('#hdn-x2-axis').val(x2_axis);
			jQuery('#hdn-y2-axis').val(y2_axis);
			jQuery('#hdn-thumb-width').val(thumb_width);
			jQuery('#hdn-thumb-height').val(thumb_height);
        } else {
            alert("Please select portion..!");
		}
    }
    /* Function to save crop images */
    function saveCropImage(params) {
		jQuery.ajax({
			url: params['targetUrl'],
			cache: false,
			dataType: "html",
			data: {
				action: params['action'],
				id: jQuery('#hdn-profile-id').val(),
				t: 'ajax',
				w1:params['thumb_width'],
				x1:params['x_axis'],
				h1:params['thumb_height'],
				y1:params['y_axis'],
				x2:params['x2_axis'],
				y2:params['y2_axis'],
				image_name :jQuery('#image_name').val()
			},
			type: 'Post',
		   	success: function (response) {
					jQuery('#profile_pic_modal').modal('hide');
					jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
					jQuery("#profile_picture").attr('src', response);
					jQuery("#cropped_banner_image").val(response);
					jQuery("#preview-profile-pic").html('');
					jQuery("#profile-pic").val();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
			}
		});
    }
	$("#expertise_text").select2( {
		placeholder: "Select Expertise",
		allowClear: true,
		container:'body'
	} );
	$('#user_banner_image').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' ){
			if (this.files[0].size > 2097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 1MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	}); 
	$('#user_aadhar_photo,#user_pan_photo').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'pdf' || fileExt === 'png' || fileExt === 'jpeg' ){
			if (this.files[0].size > 2097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 1MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	}); 
});
</script>
<?php /*
<script type="text/javascript">
<?php
	$allcategoryarray 		= [];
	$parentcategoryarray 	= [];
	$subcategoryarray 		= [];
	$a = 0;
	foreach($category as $key => $value){
		$allcategoryarray[$a]['id'] 	= $value->id;
		$allcategoryarray[$a]['title'] 	= $value->name;
		$allsubcat = $this->category_model->getsubcategory($value->id);
		$newa = 0;
		foreach($allsubcat as $subcat){
			$subcategoryarray[$newa]['id'] 	= $subcat->id;
			$subcategoryarray[$newa]['title'] 	= $subcat->name;
			$newa++; 
		}
		$allcategoryarray[$a]['subs'] = $subcategoryarray;
		$a++; 
	}
?>

var SampleJSONData2 = <?php echo json_encode($allcategoryarray); ?>;
var comboTree3;
comboTree3 = $('#catsubcat').comboTree({
	source : SampleJSONData2,
	isMultiple: true,
	cascadeSelect: true,
	collapse: true,
	selectableLastNode:true,
	selected:<?php echo json_encode($allcat); ?>,
	hiddeninput:'#getids'
});
comboTree3.setSource(SampleJSONData2);
</script>*/ ?>