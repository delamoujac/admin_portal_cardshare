<?php include 'include/head.php'; ?>
<link rel="stylesheet" href="<?=base_url('assets/admincss/css/style.default.css');?>">

<body class="loginpage" style="background: url(<?=base_url('uploads/images/login.jpg
');?>) 6% 0 no-repeat;background-size: 200% 100%;">


	<div class="loginbox">
    	<div class="loginboxinner">
        	
            <div class="logo">
            	<img alt="" src="<?php echo base_url('uploads/images/'.$setting['icon']); ?>" width = "100"/>
                 
                <!--<h1 style="margin-top:10px;"><span>ADMIN</span> LOGIN</h1>-->
            </div><!--logo-->
           
            <br clear="all" />

             <?php if($this->session->flashdata('success')){ ?>
             <div class="notibar msgerror" style="background: rgba(76, 175, 80, 0.81) url(assets/admincss/images/notifications.png) no-repeat 0 0;
    background-position: 0 -103px;"><p style="color:#fff"><?= $this->session->flashdata('success'); ?></p></div>
            <?php } ?>
          
          <?php include("session_msg.php");  ?>
            <form id="login" action="<?php echo base_url(); ?>admin/go" method="post">
            	
                <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" placeholder="Username or Email" />
                    </div>
                </div>
                
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="password" id="password" placeholder="Password" />
                    </div>
                </div>

                <div class="keep" style="margin-top:0px;margin-bottom:5px; float:right"><a href="<?php echo base_url('admin/view_page/forgotpassword'); ?>" style="color:#fcfcfc">Forgot Password?</a></div>
                
                <button type="submit">Sign In</button>
                
                  
            
            </form>
            
        </div><!--loginboxinner-->
    </div><!--loginbox-->


</body>

</html>
