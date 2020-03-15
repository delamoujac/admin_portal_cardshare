<?php include 'include/head.php'; ?>
<link rel="stylesheet" href="<?=base_url('assets/admincss/css/style.default.css');?>">

<body class="loginpage" style="background: url(<?=base_url('uploads/images/login.jpg');?>) 6% 0 no-repeat;"">

	<div class="loginbox">
    	<div class="loginboxinner">
        	
            <div class="logo">
            	<img alt="" src="<?php echo base_url('uploads/images/'.$setting['logo']); ?>" width = "100"/>
                 
                <h1 style="margin-top:10px;"><span>FORGOT</span> PASSWORD</h1>
            </div><!--logo-->
           
            <br clear="all" />
          
          <?php include("session_msg.php");  ?>
          <?php if($this->session->flashdata('success')){ ?>
             <div class="notibar msgsuccess" style="background-position: 0 -103px;"><p><?= $this->session->flashdata('success'); ?></p></div>
            <?php } ?>

            <form id="login" action="<?php echo base_url('admin/forgot_password'); ?>" method="post">
            	
                <!--<div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" placeholder="Employee Code" />
                    </div>
                </div>-->
                  <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="email" id="email" placeholder="Email" />
                    </div>
                </div>
               
                <div class="keep" style="margin-top:0px;margin-bottom:5px; float:right"><a href="<?php echo base_url(); ?>admin"  style="color:#fcfcfc">Login</a></div>
                
                <button type="submit">Forgot Password</button>                
                
            
            </form>
            
        </div><!--loginboxinner-->
    </div><!--loginbox-->


</body>

</html>

<style>

</style>