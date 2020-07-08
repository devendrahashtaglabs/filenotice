<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
}
.bs-example{
    margin: 20px;
}
.rotate{
	-webkit-transform: rotate(90deg);  /* Chrome, Safari, Opera */
	-moz-transform: rotate(90deg);  /* Firefox */
	-ms-transform: rotate(90deg);  /* IE 9 */
	transform: rotate(90deg);  /* Standard syntax */    
}
.verifyinput {
	float: right;
}
.comboTreeArrowBtn{
	display:none;
}
</style>
<?php 
	$categoryid 		= !empty($consultant)?$consultant->category_id:'';
	$subcategoryid 		= !empty($consultant)?$consultant->subcategory_id:'';
	$categoryidarr 		= explode(',',$categoryid);
	$subcategoryidarr 	= explode(',',$subcategoryid);
	$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
	$selectedcategories = implode(',',$allcat);
?>
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
						<h3 class="card-title"><?php echo $page_title; ?></h3>
						<div class="row" style="margin-top: 25px; margin-bottom: 85px">
						  <div class="active-screen">
							  <div class="number-account">
								<span class="number one">
									<a href="<?php echo $step1; ?>">1</a>
								</span>
								<span class="text-part">
									Personal<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number two">
									<a href="<?php echo $step2; ?>">2</a>
								</span>
								<span class="text-part">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three">
									<a href="<?php echo $step3; ?>">3</a>
								</span>
								<span class="text-part">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four active">
									<a href="<?php echo $pageUrl; ?>">4</a>
								</span>
								<span class="text-part active">
									Sub Category <br/>Margin Info 
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five">
									<a href="javascript:void(0);">5</a>
								</span>
								<span class="text-part">
									Bank<br/>Info 
								</span>
							  </div>
							</div>
						</div>						
                    </div>
                    <?php echo form_open($pageUrl, array('class' => 'create_users form-inline', 'id' => 'ConsultantForm')); ?>
                    <div class="card-body">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
							$categories 		= $consultant->category_id;
							$categoryArray 		= explode(',',$categories);
							$subcategories 		= $consultant->subcategory_id;
							$subcategoryArray 	= explode(',',$subcategories);
                        ?>
						<div class="row my-5">
							<div class="form-group col-8">
								<?php 
									echo form_label('Category & Subcategory*', 'getids');
								?>
								<input type="text" id="catsubcat" name="catsubcat" placeholder="Select Category & Subcategory" autocomplete="off" disabled="disabled" style="width: 765px;"/>
								<input type="hidden" id="getids" name="getids" value="<?php echo $selectedcategories; ?>">
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>								
							</div>
							<div class="col-4 verifyinput">
								<input type="checkbox" id="v_catsubcat" name="v_catsubcat" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_catsubcat == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
								<label for="v_catsubcat" id="v_catsubcat_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_catsubcat == 1)?'Verified':'Not verified'; ?></label>
								<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							</div>
						</div>
                        <div class="row">
							<div class="col-12">
								<h4>Selected Category & Subcategory</h4>
							</div>
						</div>
                        <div class="row">
                            <div class="col-12">
								<div class="bs-example">
									<div class="panel-group" id="accordion">
										<?php 
											$count = 1;
											foreach($categoryArray as $singlecategory){
												$categorydata = $this->category_model->getCategoryById($singlecategory);
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
														$subcount = 1;
														foreach($subcategoryArray as $subcategory){
															$subcategorydata = $this->category_model->getCategoryById($subcategory);
															if(!empty($subcategorydata)){
																if($subcategorydata->parent_id == $singlecategory){
													?>
														<div class="form-group row">
															<label for="staticEmail" class="col-sm-4 col-form-label"><?php echo $subcategorydata->name; ?> ( <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcategorydata->amount; ?> ) </label>
															<div class="col-sm-8 fromares">
																<span>Please fill the margin of subcategory amount <input type="number" class="form-control" name="subcategory_<?php echo $subcategorydata->id; ?>" style="width:10%" min="10" value="10" required="required">  %.</span><?php if($subcount > 1){ ?><span style="float:right;" class="removesubcat" data-id="<?php echo $subcategorydata->id; ?>" data-parentid="<?php echo $subcategorydata->parent_id; ?>"><i class="fa fa-times" aria-hidden="true"></i></span> <?php } ?>
															</div>
														</div>
													<?php $subcount++;} }  } ?>
												</div>
											</div>
										</div>
										<?php $count++; } ?>
									</div>
								</div>
                            </div>
							<div class="col-md-12">								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="allverified_step4" id="allverified" <?php if($verifiedconsultantdata->allverified_step4 == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>> <label for="allverified">All subcategory margin are verified. </label></p>
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
                            <div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_user_btn", "value" => "Verify & Next"));
                                echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list') . '" class="btn btn-danger">Cancel</a>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
<?php
	$allcategoryarray 		= [];
	$parentcategoryarray 	= [];
	$subcategoryarray 		= [];
	$a = 0;
	foreach($category as $key => $value){
		$allcategoryarray[$a]['id'] 	= $value->id;
		$allcategoryarray[$a]['title'] 	= $value->name;
		$allsubcat = $this->category_model->listSubCategoryById($value->id);
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
	disabled: true,
	selectableLastNode:true,
	selected:<?php echo json_encode($allcat); ?>,
	hiddeninput:'#getids'
});
comboTree3.setSource(SampleJSONData2); 
</script>
<script>
	$(document).ready(function(){
		var base_url = '<?php echo base_url(); ?>';
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
        	$(this).siblings(".panel-heading").find(".glyphicon").addClass("rotate");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").addClass("rotate");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("rotate");
        });
		$('.removesubcat').click(function(){
			var user_id 		= '<?php echo $consultant->user_id; ?>';
			var subcatid 		= $(this).data('id');
			var subcatparentid 	= $(this).data('parentid');
			if (confirm('Are you sure you want to remove this subcategory?')) {
				$.ajax({
					url: base_url+'admin/consultant/removesubcat',
					data: {'subcatid': subcatid,'subcatparentid': subcatparentid,'user_id': user_id}, 
					type: "post",
					success: function(data){
						if(data == true){
							location.reload();							
						}
						//$("#ad_sub_qualification").html(data);
					}
				});
			}
		});
		
		$('#v_catsubcat').click(function() {
			if($('#v_catsubcat').prop('checked')){
				$('#v_catsubcat').val('1');
				$('#v_catsubcat_lbl').text('Verified');
			}else{
				$('#v_catsubcat').val('0');
				$('#v_catsubcat_lbl').text('Not verified');
			}
		});

		$('#allverified').click(function() {
			if($(this).prop('checked')){
				$(this).val('1');
			}else{
				$(this).val('0');
			}
		});
    });
</script>