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
						echo form_open_multipart($pageUrl, array('class' => 'Edit_category', 'id' => 'CategoryForm'));
					?>
					<div class="card-body floating-laebls">
						<div class="row">
							<div class="col-6">                            
								<div class="form-group inputBox <?php echo !empty($row->name)?'focus':''; ?>">
									<?php
										echo form_label('Name*', 'cat_name');
										echo form_input(array('name' => 'cat_name', 'class' => 'form-control input', 'value' => $row->name, 'id' => "cat_name"));
										echo form_input(array('name' => 'id', 'type' => 'hidden', 'value' => $row->id, 'id' => "id"));
										echo '<div class="error-msg">' . form_error('cat_name') . '</div>';
									?>
								</div>
							</div>
							<?php /*<div class="form-group col-6">
								<?php
								echo form_label('Amount*', 'amount');
								echo form_input(array('name' => 'amount', 'class' => 'form-control', 'value' => $row->amount, 'id' => "amount", 'maxlength' => '5'));
								echo '<div class="error-msg">' . form_error('amount') . '</div>';
								?>
							</div> */ ?>
							<div class="col-6">                            
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Status*', 'cat_status');
										echo form_dropdown('cat_status', $options = array(
											'' => 'Select Status',
											'1' => 'Active',
											'0' => 'Inactive',
												), $selected = $row->status, $extra = 'class="form-control input",id="cat_status"');
										echo '<div class="error-msg">' . form_error('cat_status') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row"> 
							<div class="col-6">                            
								<div class="form-group inputBox <?php echo !empty($row->cat_icon)?'focus':''; ?>">
									<?php
										echo form_label('Category Icon', 'cat_icon');
										echo form_input(array('name' => 'cat_icon', 'class' => 'form-control input', 'value' => set_value('cat_icon',$row->cat_icon), 'id' => "cat_icon"));
									?>
									<p>Find new class name <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Click Here</a></p>
									<?php 
										echo '<div class="error-msg">' . form_error('cat_icon') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">                            
								<div class="form-group inputBox <?php echo !empty($row->cat_slogan)?'focus':''; ?>">
									<?php
										echo form_label('Slogan*', 'cat_slogan');
										echo form_input(array('name' => 'cat_slogan',
											'class' 		=> 'form-control input',
											'value' 		=> set_value('cat_slogan',$row->cat_slogan),
											'id' 			=> "cat_slogan"
										));
										echo '<div class="error-msg">' . form_error('cat_slogan') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">                            
								<div class="form-group inputBox <?php echo !empty($row->headline)?'focus':''; ?>">
									<?php
										echo form_label('Headline*', 'headline');
										echo form_input(array('name' => 'headline',
											'class' 		=> 'form-control input',
											'value' 		=> set_value('headline',$row->headline),
											'id' 			=> "headline",
										));
										echo '<div class="error-msg">' . form_error('headline') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">                            
								<div class="form-group inputBox <?php echo !empty($row->cat_description)?'focus':''; ?>">
									<?php
										echo form_label('Description*', 'cat_desc');
										echo form_textarea(array('name' => 'cat_desc',
											'class' => 'form-control input',
											'value' => set_value('cat_desc',$row->cat_description),
											'id' 	=> "cat_desc",
											'cols' 	=> '4',
											'rows' 	=> '1'));
										echo '<div class="error-msg">' . form_error('cat_desc') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
        						<div class="form-group inputBox focus">
									<?php 
										echo form_label('Feature Image', 'cat_featureimage'); 
									?>
									<span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 1MB)</span>
									<?php
										$data = array(
											'type' 	=> 	'file',
											'name' 	=> 	'cat_featureimage',
											'id'   	=> 	'cat_featureimage',
											'value' => 	set_value('cat_featureimage'),
											'class' => 	'form-control input',
											'style' =>	'line-height:17px;'
										);
										echo form_input($data);
										echo '<div class="error-msg">' . form_error('user_photo') . '</div>';
									?>
									<?php 
										if(!empty($row->cat_featureimage)){
									?>
										<img src="<?php echo base_url().'uploads/category/'.$row->cat_featureimage; ?>" class="img-responsive" width="50" height="50"/> 
									<?php }else{ ?>
										<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" class="img-responsive" width="50" height="50"/>
									<?php } ?>
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
        						<div class="form-group inputBox <?php echo !empty($row->meta_tag)?'focus':''; ?>">
									<?php
										echo form_label('Meta Tag', 'meta_tag');
										echo form_textarea(array('name' => 'meta_tag',
											'class' => 'form-control input',
											'value' => $row->meta_tag,
											'id' 	=> "meta_tag",
											'cols'	=>'4',
											'rows'	=>'3'));
										echo '<div class="error-msg">' . form_error('meta_tag') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
        						<div class="form-group inputBox <?php echo !empty($row->meta_keyword)?'focus':''; ?>">
									<?php
										echo form_label('Meta Keywords', 'meta_keywd');
										echo form_textarea(array('name' => 'meta_keywd', 'class' => 'form-control input', 'value' => $row->meta_keyword, 'id' => "meta_keywd",'cols'=>'4',
											'rows'=>'3'));
										echo '<div class="error-msg">' . form_error('meta_keywd') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
        						<div class="form-group inputBox <?php echo !empty($row->meta_description)?'focus':''; ?>">
									<?php
										echo form_label('Meta Description', 'meta_desc');
										echo form_textarea(array('name' => 'meta_desc', 'class' => 'form-control input', 'value' => $row->meta_description, 'id' => "meta_desc",'cols'=>'4',
										'rows'=>'3'));
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
										echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('user_type') . '/admin/category/category_list') . '" class="btn btn-default">Cancel</a>';
									?>
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
<script>
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
	$('#cat_featureimage').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' ){
			if (this.files[0].size > 1097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 1MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	});
</script>