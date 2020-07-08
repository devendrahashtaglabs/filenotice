<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }

</script> 
<style>
.form-group:last-of-type {
	margin-top:0px;
}
.amount{
	min-height:60px;
}

.services {
	min-height: 298px;
	margin-bottom: 70px;
	padding: 20px 15px;
}
.desc h3 {
	font-size: 18px;
	min-height: 35px;
	margin: 0 0 10px;
}
.services.catcitydiv{
	background: #00000057;	
}
.services.catcitydiv .details {
	position: absolute;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
}

.active-screen .number::after {
	top: 0;
}
.active-screen .number a i {
	position: relative;
	top: 18px;
}
.active-screen .number.four::after {
	content: "";
}
#getcategory {
	height: 35px;
	margin: 0;
	line-height: 17px;
	padding: 5px 10px;
	background: #263a7d;
	border: 2px solid #263a7d;
	border-radius: 30px;
}
#getcategory:hover{
	background: #263a7d !important;
	border: 2px solid #263a7d !important;
}
.amount{
	min-height:60px;
}

.services {
	min-height: 298px;
	margin-bottom: 70px;
	padding: 20px 15px;
}
.desc h3 {
	font-size: 18px;
	min-height: 35px;
	margin: 0 0 10px;
}
.services.catcitydiv .details {
	position: absolute;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
}
.services.catcitydiv .details p {
    color: red;
    font-size: 12px;
    padding: 2px;
    display: flex;
    height: 100%;
    justify-content: center;
    align-items: center;
    margin: auto;
    margin-top: -120px;
}

.services.catcitydiv {
	background: #dce3f9 !important;
}
.services.catcitydiv .desc {
	opacity: 0.2;
}
.services .icon {
  width: 90px;
  height: 90px;
  
  display: table;
  text-align: center;
  margin: -75px auto 0 auto;
  margin-bottom: 30px;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  border-radius: 50%;
  -webkit-transition: 0.3s;
  -o-transition: 0.3s;
  transition: 0.3s;
}
@media screen and (max-width: 992px) {
  .services .icon {
    margin: 0 auto 30px auto;
  }
}
.services .icon i {
  display: table-cell;
  vertical-align: middle;
  height: 90px;
  font-size: 40px;
  line-height: 40px;
  color: #fff;
}

.amount.section {
	float: left;
	width: 100%;
	margin: 0 0 0px;
}
.select2.select2-container.select2-container--default {
	width: 300px !important;
	text-align: left !important;
}
.select2-container--default .select2-selection--single {
	border-radius: 25px;
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
            <div class="col-md-12" >
                <div class="card categorypaged">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>						
                    </div>
                    <?php
						echo form_open_multipart($pageUrl, array('class' => 'create_ticket', 'id' => 'getcityform'));
                    ?>
                    
                    <div class="card-body">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
                        <div class="row">
                        	<div class="chooseloactoin">
                            <div class="fotmares">
								<?php
									//echo form_label('Select City','user_city');
									if(!empty($currentcityid)){
										$cityid = $currentcityid;
									}else{
										$currentcitydata 	= $this->session->userdata('currentcitydata');
										$cityid 			= !empty($currentcitydata)?$currentcitydata->city_id:'';
									}
									$option = array();
									foreach ($allcity as $key => $value) {
										$option[$value->city_id] = ucfirst($value->city_name);
									}
									echo form_dropdown('user_city', $option, $selected = set_value('user_city',$cityid), $extra = 'class="form-control" id="user_city"');
								?>
							</div>
							<div class="gobtns" >
								<?php
									echo form_submit(array("class" => "btn btn-info", "id" => "getcategory", "value" => "Go"));
								?>
                            </div>
                        </div>
						</div>
						<div class="row" style="margin-top:80px;">
							<?php 
								if(!empty($categories)){
									foreach($categories as $category){
										$cat_icon 			= !empty($category->cat_icon)?$category->cat_icon:'fa fa-home';
										$str 				= $category->name .'/'.$category->id .'/'.$category->name; 
										$catid 				= base64_encode($str);
										$subcatamountdata 	= $this->category_model->getsubcategory($category->id);
										if(in_array($category->id,$showparentcategory)){
											$url 		= base_url().'ticket/create/?catid='.$catid;
											$class		= '';
											$divclass	= '';
										}else{
											$url 		= 'javascript:void(0);';
											$class		= 'catlink';
											$divclass	= 'catcitydiv';
										}
										$derciption = '';
										if(!empty($category->cat_description)){
											$derciption = substr($category->cat_description, 0, 150).'....';
										}
							?>
									<div class="col-md-3 text-center animate-box srarea">	 <div class="imagservice">
										<?php if(!empty($category->cat_featureimage)){ ?>
											<img src="<?php echo base_url().'uploads/category/'.$category->cat_featureimage; ?>" style="width: 100%;height: 180px;"> 
										<?php }else{ ?>
											<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" style="width: 100%;height: 180px;"> 	
										<?php } ?>
									</div>			
									<div class="services <?php echo $divclass; ?>">	
										<a href="<?php echo $url;?>" class="<?php echo $class; ?>" <?php if(!empty($class)){ ?> style="cursor:auto" <?php } ?>>					
											<span class="icon"><i class="<?php echo $cat_icon; ?>"></i></span>
											<div class="desc">							
												<h3><?php echo $category->name; ?></h3>							
												<?php 
													if(!empty($subcatamountdata)){
														$singlesubcat 	= $subcatamountdata[0];
														$amount 		= $singlesubcat->amount; 
												?>
													<div class="amount section">
														<div class="pricesectin"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $amount; ?></div>
														<div class="seconrtsecitin">
															<span class="startint">Starts From</span>
															<span class="onwardds">Onwards</span>
														</div> 								
													</div>
												<?php } ?>
												<p><?php echo $derciption; ?></p>
											</div>
											<?php if(!empty($class)){ ?>
												<div class="details">
													<h4 class="sorrytext btn btn-block btn-danger">SORRY !</h4>
													<p>We are currently unavailable in your area. We are expanding, please check back soon.</p>
												</div>
											<?php } ?>
										</a>
									</div>				
								</div>
							<?php }} ?>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </section>
</div>
<script>
	$('#user_city').select2({
		placeholder:'Select City'
	});
</script>
