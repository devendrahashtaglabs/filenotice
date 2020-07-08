<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $site_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php /*<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/plugins/font-awesome/css/font-awesome.min.css'; ?>">*/?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/jquerysctipttop.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/plugins/datatables/dataTables.bootstrap4.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/adminlte.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/select2.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/dropdowntree.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/materialdesignicons.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/custom.css'; ?>">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/validation/form-validation-style.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/style.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/newtheme.css'; ?>">
       <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
        <style>
            .form-group:last-of-type {
               margin-top:10px;
            }
        </style>
		<script src="<?php echo base_url() . 'cosmatics/plugins/jquery/jquery.min.js'; ?>" type="text/javascript"></script>
		<script src="<?php echo base_url() . 'cosmatics/js/select2.min.js'; ?>" type="text/javascript"></script>
		<script src="<?php echo base_url() . 'cosmatics/js/dropdowntree.js'; ?>" type="text/javascript"></script>
		<script src="<?php echo base_url() . 'cosmatics/js/icontains.js'; ?>" type="text/javascript"></script>
		<script src="<?php echo base_url() . 'cosmatics/validation/mask.min.js'; ?>" type="text/javascript"></script>
    </head>
    <?php
    if (($this->session->userdata('is_logged_in') == true) || (!empty($this->session->userdata('user_id')))) {
        $class = 'sidebar-mini';
        $divwrapper = '<div class="wrapper">';
    } else {
        $class = 'login-page';
        $divwrapper = '';
    }
    ?>
    <body class="hold-transition <?php echo $class; ?>">
        <?php
        echo $divwrapper;
        