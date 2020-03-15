<?php
  $setting = $this->db->get('setting')->result_array()[0];
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$setting['name'];?> | Admin-Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->

  <link rel="icon" href="<?php echo base_url('uploads/images/'.$setting['icon']); ?>" sizes="16x16" type="image/png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>  
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="<?=base_url('assets/admin');?>/chart/morris/morris.css">
  <link rel="stylesheet" href="<?=base_url('assets/admin');?>/dist/css/Admin.css">
  <link rel="stylesheet" href="<?=base_url('assets/admin');?>/dist/css/myDefault.css">
  <link rel="stylesheet" class="themestyle" href="<?=base_url('assets/admin');?>/dist/css/skin-blue.css">
  

  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/admin');?>/font/OpenSans-Light/font.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
  
  <!-- sweet alert -->
  <script src="<?=base_url('sweetAlert/sweetalert-dev.js');?>"></script>
  <link rel="stylesheet" href="<?=base_url('sweetAlert/sweetalert.css');?>"> 

  <!-- links for crop image -->  
  <link rel="stylesheet" href="<?=base_url('crop/dist/cropper.min.css');?>"> 
  <link rel="stylesheet" href="<?=base_url('crop/css/main.css');?>">

</head>
