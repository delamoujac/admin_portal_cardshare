<!DOCTYPE html>
<html>
<?php include 'include/head.php';
?>

<body class="hold-transition skin-blue sidebar-mini" id="">
<div class="wrapper">
<?php include 'include/header.php';

      $button = "update";
      $btn_name = "Change Password";
      $admin = $this->session->userdata('admin');
      
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
   <div class="row ">
      <div class="col-sm-12 cdG">
      <span class="fs30 "><?=$btn_name;?></span> 
    </div>
   <div class="col-sm-9 cdG">
          <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" onsubmit="return checkValidate()">
          <input type="hidden"  class="form-control" name="id" value="<?=$admin->id;?>">
         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Old Password</label>
            <div class="col-sm-9">
              <input type="password"  class="form-control" name="old_password" value="">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">New Password</label>
            <div class="col-sm-9">
              <input type="password"  class="form-control" name="password" id="user_password" value="">
              <span id="u_pas_error"></span>
            </div>
          </div>

         
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Confirm Password</label>
            <div class="col-sm-9">
              <input type="password"  class="form-control" name="cnfm_password" id="cnfm_password"  value="">
              <span id="c_pas_error"></span>
            </div>
          </div>

         



  <div class="form-group">
    <div class=" col-sm-3 col-sm-offset-3">
      <button type="submit" name="<?=$button;?>" class="btn btn-dang-add mr10 "><?=$btn_name;?></button>
    </div>
  </div>
</form>


   </div><!-- /.col-sm-9 -->


  
  </div><!-- /.row -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include 'include/script.php' ?>


 </body>
</html>
<style type="text/css">
     #u_pas_error,#c_pas_error{
        color: #ED3236;
        font-weight:bold;
      }
</style>
<script type="text/javascript">

      function checkValidate()
      {
        document.getElementById('u_pas_error').innerHTML="";
        document.getElementById('c_pas_error').innerHTML="";
       
       

        str = "";

        var user_password = document.getElementById('user_password').value;
            cnfm_password = document.getElementById('cnfm_password').value;
          
        

       if(user_password=="")
       {
          document.getElementById('u_pas_error').innerHTML="This Field Is Required";
          str = "error";
       }
       else 
       {       
            if(user_password.length<4)
            { 
               document.getElementById('u_pas_error').innerHTML="Password must be 4-digits Required";
               str = "error";
            }
          
       }

       if(cnfm_password=="")
       {
          document.getElementById('c_pas_error').innerHTML="This Field Is Required";
          str = "error";
       }
       else 
       {
          if(cnfm_password.length<4)
            {
              document.getElementById('c_pas_error').innerHTML="Password must be 4-digits Required";
              str = "error";
            }
       }

       if(user_password=="" && cnfm_password=="")
       {}
       else
       {
          if(user_password==cnfm_password)
          {}else{
             alert("Password Does't match");
             document.getElementById('user_password').value="";
             document.getElementById('cnfm_password').value="";
             str = "error";
          }
       }

      

        if(!str=="")
        {
          return false;
        }
        
      }
    </script> 


<?php

extract($_REQUEST);


// for update restaurant
if(isset($update)){

$arr_data = $this->input->post();  

$admin = $this->session->userdata('admin');
if(md5($arr_data['old_password'])!=$admin->password){

  echo "<script> swal(
  'Error',
  'Old password does not match',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";
die;

}   

$arr_where = ['id'=>$arr_data['id']];
$arr_data['password']=md5($arr_data['password']);

unset($arr_data['update'],$arr_data['cnfm_password'],$arr_data['old_password']);

$result = $this->admin_common_model->update_data('admin',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
            
$admin->password  = $arr_data['password'];
$this->session->set_userdata('admin',$admin); 
        
if ($result) {
echo 
"<script> swal(
  'Success',
  'Password Changed Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/dashboard')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Change Password',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}


?>






