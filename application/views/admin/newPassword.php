<!DOCTYPE html>
<?php include 'include/head.php';
      $button = "submit";
      $btn_name = "Change New Password";
      $path = base_url("uploads/images/no_image.png");
      $token= $this->uri->segment(4); //echo $id;die;
      // if($id!=''){
      //   $fetch = $this->admin_common_model->get_where('users',['token'=>$token]);
      //   $row = $fetch[0];
      //   $button = "update";
      //   $btn_name = "Update Password";        
      //   if($row['image']!=''){
      //     $path = base_url("uploads/images/".$row['image']);
      //   }
      // }
      

 ?>

<html>
<head>
<title>ManarGiftStore</title>

<link href="https://fonts.googleapis.com/css?family=Mukta+Malar:400,500,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<style type="text/css">
body{
  font-family: 'Mukta Malar', sans-serif; 
  outline: none !important; 
  background-color: #f0f0f0;
}


 .bg-section{
  position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 40%;
margin: 0 auto; 
background-color: #fff; 
box-shadow: 0px 0px 5px #b0b0b0; 
padding: 15px;
width: 37%;
padding: 30px;
 } 
 .bg-lin{
     font-size: 15px;
    text-align: center;
    margin:20px 0;
 }
.form-control {
    border-radius: 0px;
    box-shadow: none;
    height: 43px;
    font-size: 15px;
}
.button{
     background-color: #fbbc12;
    color: #fff;
    border-radius: 2px;
    font-size: 20px;
    padding: 4px 20px;
    box-shadow: 4px 3px 10px #d2c5c5;
}
</style>

<body>

<section class="bg-section">
  <img src="<?=base_url('uploads/images/logo.png');?>" class="center-block" style="width:150px;">
  <p class="bg-lin">Change your Card Share Account password  </p>

          <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
          <input type="hidden"  class="form-control" name="id" id="token" value="<?=$token;?>">

  <div class="form-group">
    <input type="password" class="form-control" name="password" id="pass" required value="" placeholder="Password">
  </div>

  
<div class="text-center">
   <button type="button" name="<?=$button;?>" class="btn button submi_btn"><?=$btn_name;?></button>
</div>
 
</form>

</section>



<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>


<script>
$('.submi_btn').click(function(){

var pass = $('#pass').val();
var token = $('#token').val();

if (pass==''){
  return;
}
// window.location.href =  "<?=base_url('webservice/view_welcomepage');?>";
// return;

 $.ajax({
          url: "<?=base_url('webservice/reset_password');?>",
          data: {'password': pass, 'token': token}, // change this to send js object
          type: "POST",
          success: function(result){
              console.log (result['status']);

              if (result['status']==1) {
              

                swal(
                'Success',
                'Change Password Successfully',
                'success'
              ); 
              
              $('.confirm').click(function(){
                    window.close();
              });
            }else{

              swal(
                'Error',
                'You have failed to change your Password.Try again.',
                'error'
              ); 
              
              $('.confirm').click(function(){
                    window.close();
                  
              });
            }
            //alert(result);

          }
        });

});
</script>
