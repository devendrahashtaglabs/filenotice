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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                    <?php 
                    echo form_open_multipart($pageUrl);
                    ?>
                    <div class="card-body">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="row">
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Category Name', 'category_id');
                                $option = array("" => "Select Category");
                                foreach ($category as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
                                echo form_dropdown('category_id', $option, $selected = set_value('category_id',$consultant->category_id), $extra = 'class="form-control change-category" data-section="create_consultant" data-selectedid=""');
                                echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Subcategory name', 'subcategory_id');
                                    $option = array('' => 'Select Sub-category');
                                    echo form_dropdown('user_state', $option, $selected = set_value('subcategory_id'), $extra = 'class= "form-control" id="create_consultant"');
                                    echo '<div class="error-msg">' . form_error('subcategory_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Expertise', 'expertise_text[]');

                                $option = array();
                                foreach ($expertise as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
                                echo form_multiselect('expertise_text[]', $option, $selected = $value->id, $extra = 'class="form-control", id="expertise_text"');
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Education', 'education_text');
                                $data = array(
                                    'name' => 'education_text',
                                    'class' => 'form-control',
                                    'value' => set_value('education_text', $consultant->education),
                                    'rows' => '3',
                                    'placeholder' => 'Education'
                                );
                                echo form_textarea($data);
                                echo '<div class="error-msg">' . form_error('education_text') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Contact Number', 'contact_number');
                                echo form_input(array('name' => 'contact_number', 'class' => 'form-control', 'value' => set_value('contact_number', $consultant->telephone), 'placeholder' => 'Contact Number'));
                                echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Profile Picture', 'user_photo'); ?>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <?php
                                        $data = array(
                                            'type' => 'file',
                                            'name' => 'user_photo',
                                            'id' => 'user_profile_photo',
                                            'value' => set_value('user_photo'),
                                            'class' => 'custom-file-input'
                                        );
                                        echo form_input($data);
                                        echo form_label('Profile Picture', 'user_profile_photo', array('class' => 'custom-file-label'));
                                        ?>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Aadhar Number', 'aadhar_no');
                                echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control', 'value' => set_value('aadhar_no', $consultant->aadhaar_card_number), 'id' => "aadhar_no", 'placeholder' => 'Enter Aadhar Number '));
                                echo '<div class="error-msg">' . form_error('aadhar_no') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Aadhar Photo', 'aadhar_photo'); ?>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <?php
                                        $data = array(
                                            'type' => 'file',
                                            'name' => 'aadhar_photo',
                                            'id' => 'user_aadhar_photo',
                                            'value' => set_value('aadhar_photo'),
                                            'class' => 'custom-file-input'
                                        );
                                        echo form_input($data);
                                        echo form_label('Aadhar Photo', 'user_aadhar_photo', array('class' => 'custom-file-label'));
                                        ?>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Pan Number', 'pan_no');
                                echo form_input(array('name' => 'pan_no', 'class' => 'form-control', 'value' => set_value('pan_no', $consultant->pan_card_number), 'id' => "pan_no", 'placeholder' => 'Enter Pan Number '));
                                echo '<div class="error-msg">' . form_error('pan_no') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Pan Photo', 'pan_photo'); ?>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <?php
                                        $data = array(
                                            'type' => 'file',
                                            'name' => 'pan_photo',
                                            'id' => 'user_pan_photo',
                                            'value' => set_value('pan_photo'),
                                            'class' => 'custom-file-input'
                                        );
                                        echo form_input($data);
                                        echo form_label('Pan Photo', 'user_pan_photo', array('class' => 'custom-file-label'));
                                        ?>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Experience', 'experience');
                                $data = array(
                                    'name' => 'experience',
                                    'class' => 'form-control',
                                    'value' => set_value('experience', $consultant->experience),
                                    'rows' => '2',
                                    'placeholder' => 'experience'
                                );
                                echo form_textarea($data);
                                echo '<div class="error-msg">' . form_error('experience') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_user_btn", "value" => "Submit"));
                                echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. 'admin/consultant/consultant_list') . '" class="btn btn-danger">Cancel</a>';
                                ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>