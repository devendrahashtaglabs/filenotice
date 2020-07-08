<style>
.form-group:last-of-type {
    margin-top: unset;
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
                            <h3 class="card-title"><?php echo $page_title; ?></h3>
                        </div>
                        <?php
                        echo form_open_multipart($pageUrl, array('class' => 'Edit_subcategory', 'id' => 'SubCategoryForm'));
                        ?>
                        <div class="card-body floating-laebls">
                            <div class="row">
                                <div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Category Name','pcat_name');
											$option=array();
											foreach ($categories as $key => $value){
												$option[$value->id] = ucfirst($value->name); 
											}
											echo form_dropdown('pcat_name', $option,$selected=$row->parent_id, $extra ='class="form-control input", id="pcat_name"');
											echo '<div class="error-msg">' . form_error('pcat_name') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->name)?'focus':'';?>">
										<?php
											echo form_label('Name*','cat_name');
											echo form_input(array('name' => 'cat_name', 'class' => 'form-control input', 'value' => $row->name, 'id' => "cat_name"));
											echo form_input(array('name' => 'id','type'=>'hidden' ,'value' => $row->id, 'id' => "id"));
											echo '<div class="error-msg">' . form_error('cat_name') . '</div>';
										?>
									</div>
								</div>
                           </div>
                           <div class="row">
                                <div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->amount)?'focus':'';?>">
										<?php
											echo form_label('Amount*','amount');
											echo form_input(array('name' => 'amount', 'class' => 'form-control input', 'value' => $row->amount, 'id' => "amount", 'maxlength' => '5'));
											echo '<div class="error-msg">' . form_error('amount') . '</div>';
										?>										
									</div> 
								</div> 
								<div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Status*','cat_status');
											echo form_dropdown('cat_status', $options=array(
												''=>'Select Status',
												'1'=>'Active',
												'0'=>'Inactive',

											), $selected=$row->status,$extra ='class="form-control input" id="cat_status"');
											echo '<div class="error-msg">' . form_error('cat_status') . '</div>';   
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Locate in city', 'cat_city');
										?>
											<span class="text-danger" style="font-size:10px;">(If you want select all then leave selection by default it is all selected.)</span>
										<?php 
											$cityquery 		= $this->user_model->getCityList('','');
											foreach($cityquery as $city){
												$cityoptions[$city->city_id] = $city->city_name;
											}
											if(!empty($row)){
												$mapped_city = explode(',',$row->mapped_city);
											}
											echo form_multiselect('cat_city[]', $cityoptions, set_value('cat_city',$mapped_city), $extra = 'class="form-control input" id="cat_city" multiple="multiple"');
											echo '<div class="error-msg">' . form_error('cat_city') . '</div>'; 
										?>
									</div>
                                </div>
								<div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Recurring Payment', 'recurring_payment');

											echo form_dropdown('recurring_payment', $options = array(
												'' => 'Select Payment Status',
												'1' => 'True',
												'0' => 'False',
													), $selected = $row->recurring_payment, $extra = 'class="form-control input",id="recurring_payment"');
											echo '<div class="error-msg">' . form_error('recurring_payment') . '</div>';
										?>
									</div>
                                </div>
							</div>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->cat_slogan)?'focus':''; ?>">
										<?php
											echo form_label('Slogan*', 'cat_slogan');
											echo form_input(array('name' => 'cat_slogan',
												'class' 		=> 'form-control input',
												'value' 		=> set_value('cat_slogan',$row->cat_slogan),
												'id' 			=> "cat_slogan",
												'placeholder' 	=> 'Category Slogan'
											));
											echo '<div class="error-msg">' . form_error('cat_slogan') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Banner', 'banner'); 
										?>
										<span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 2MB)</span>
										<?php
											$data = array(
												'type' 	=> 	'file',
												'name' 	=> 	'banner',
												'id'   	=> 	'cat_banner',
												'value' => 	set_value('banner'),
												'class' => 	'form-control input',
												'style' =>	'line-height:17px;'
											);
											echo form_input($data);
											echo '<div class="error-msg">' . form_error('user_photo') . '</div>';
										?>
										<?php 
											if(!empty($row->banner)){
										?>
											<img src="<?php echo base_url().'uploads/category/banner/'.$row->banner; ?>" class="img-responsive" width="50" height="50"/> 
										<?php }else{ ?>
											<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" class="img-responsive" width="50" height="50"/>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Faq', 'cat_faq'); 
											$faqoptions = [];
											foreach($faq as $faqdata){
												if($faqdata->show_homepage != 1){
													$faqoptions[$faqdata->id] = $faqdata->faq_que;
												}
											}
											$faq 		 = $row->faq;
											$selectedfaq = '';
											if(!empty($faq)){
												$selectedfaq = explode(',',$faq);
											}
											echo form_dropdown('cat_faq[]', $faqoptions, set_value('cat_faq',$selectedfaq), $extra = 'class="form-control input" id="cat_faq" multiple="multiple"');
											echo '<div class="error-msg">' . form_error('cat_faq') . '</div>'; 
										?>
									</div>
                                </div>
                                <div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->meta_keyword)?'focus':''; ?>">
										<?php
											echo form_label('Meta Keywords','meta_keywd');
											echo form_textarea(array('name' => 'meta_keywd',
												'class' => 'form-control input', 
												'value' => $row->meta_keyword,
												'id' => "meta_keywd",
												'cols' => '4',
												'rows' => '3'
												));
											echo '<div class="error-msg">' . form_error('meta_keywd') . '</div>';
										?>									
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->meta_tag)?'focus':''; ?>">
										<?php
											echo form_label('Meta Tag','meta_tag');
											echo form_textarea(array('name' => 'meta_tag',
												'class' => 'form-control input',
												'value' =>$row->meta_tag,
												'id' => "meta_tag",
												'cols' => '4',
												'rows' => '3'
												));
											echo '<div class="error-msg">' . form_error('meta_tag') . '</div>';
										?>									
									</div> 
								</div> 
								<div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->meta_description)?'focus':''; ?>">
										<?php
											echo form_label('Meta Description','meta_desc');
											echo form_textarea(array('name' => 'meta_desc',
												'class' => 'form-control input',
												'value' =>$row->meta_description,
												'id' => "meta_desc",
												'cols' => '4',
												'rows' => '3'
												));
											echo '<div class="error-msg">' . form_error('meta_desc') . '</div>';
										?>									
									</div>
								</div>
                            </div>
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<?php
											echo form_submit(array("class" => "btn btn-primary", "id" => "update_cat_btn", "value" => "Submit"));
											echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('user_type') . '/admin/category/subcategory_list') . '" class="btn btn-default">Cancel</a>';	
										?>
									</div>
								</div>
							</div>
                        </div>
						<?php echo form_close(); ?>
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
       
    </section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#cat_city').select2({
			placeholder:'Select City'
		});
		$('#cat_faq').select2({
			placeholder:'Select FAQ'
		});
		$('#cat_banner').on('change', function() { 
			var fileExt = $(this).val().split('.').pop();
			if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' ){
				if (this.files[0].size > 2097152) { 
					var extension = file.substr( (file.lastIndexOf('.') +1) );
					alert("Try to upload file less than 2MB!"); 
					$(this).val('');
				}
			}else{
				alert("Try to upload allowed file type!"); 
				$(this).val('');
			}
		});
	});
</script>
