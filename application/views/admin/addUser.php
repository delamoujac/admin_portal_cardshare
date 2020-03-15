<!DOCTYPE html>
<html>
<?php include 'include/head.php';
     
      $button = "submit";
      $btn_name = "Add User";
      $path = base_url("uploads/images/user.jpg");
      $id = $this->uri->segment(4);
      if($id!=''){
        $fetch = $this->admin_common_model->get_where('users',['id'=>$id]);
        $row = $fetch[0];
        $button = "update";
        $btn_name = "Update User";        
        if($row['image']!=''){
          $path = base_url("uploads/images/".$row['image']);
        }
      }
      

 ?>

<body class="hold-transition skin-blue sidebar-mini" id="">
<div class="wrapper">
<?php include 'include/header.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content" id="crop-avatar">
   <div class="row ">
      <div class="col-sm-12 cdG">
      <span class="fs30 "><?=$btn_name;?></span> 
      <!--<p><?=$btn_name;?> and add them to this site.  </p>-->
    </div>
   <div class="col-sm-12 cdG">
          <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
          <input type="hidden"  class="form-control" name="id" value="<?=$row['id'];?>">
         
         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="first_name" required value="<?=$row['first_name'];?>">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="last_name" required value="<?=$row['last_name'];?>">
            </div>
          </div>

         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">User Email</label>
            <div class="col-sm-8">
              <input type="email"  class="form-control" name="email" required value="<?=$row['email'];?>">
            </div>
          </div>


          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-8">
              <input type="password"  class="form-control" name="password" required value="<?=$row['password'];?>">
            </div>
          </div>
   
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Mobile</label>
            <div class="col-sm-8">
              <input type="phone"  class="form-control" name="mobile" value="<?=$row['mobile'];?>" maxlength="15">
            </div>
          </div>
          
                       

        
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-8">
              <select class="form-control" name = "gender">
                  <option>-select-</option>
                  <option value = 'Male' <?php if($row['gender'] == 'Male'){echo "selected";}?>>Male</option>
                  <option value = 'Female' <?php if($row['gender'] == 'Female'){echo "selected";}?>>Female</option>
              </select>
            </div>
          </div>
          
          <!--<div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Date Of Birth</label>
            <div class="col-sm-8">
              <input type="date"  class="form-control" name="dob" value="<?=$row['dob'];?>">
            </div>
          </div>-->
          
          <!-- <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
                 <img src="<?=$path;?>" alt="Avatar" style="
    width: 20%;
">
              <input type="file" name="image" class="imgSrc">
            </div>
          </div>-->
                     <div class="col-md-8 col-md-offset-2">
          
          <div class="dialog">
      <span class="close-thik" onclick="remove_img('img1','','image')" style=""></span>
      <label>            
        <img id="img1" src="<?=$path;?>" class="upload_file">
        <input name="image" id="fileUpload1" onchange="readURL(this,'img1');" accept="image/gif, image/jpeg" type="file">             
      </label>
    </div>
    </div>
          
 
        <!-- <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
               <div class="avatar-view img-load" id="add-media" title="Click to change image">
                  <img src="<?=$path;?>" alt="Avatar">        
                  <input type="hidden" name="image" class="imgSrc">
               </div>              
            </div>
          </div>-->


        


  <div class="form-group">
    <div class=" col-sm-2 col-sm-offset-2">
      <button type="submit" name="<?=$button;?>" class="btn btn-dang-add mr10 "><?=$btn_name;?></button>
    </div>
  </div>
</form>


   </div><!-- /.col-sm-9 -->


  
  </div><!-- /.row -->



<!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="<?=base_url('crop_image/crop.php');?>" enctype="multipart/form-data" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
                  <input type="hidden" name="path" value="../uploads/images/">
                  <input type="hidden"  name="base_url" value="<?=base_url('uploads/images');?>/">
                  <input type="hidden"  name="wth" value="150">
                  <input type="hidden"  name="hth" value="150">
                  <input type="hidden" value="1" id="aspectRatio" >
                  
                  <label for="avatarInput">Local upload</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <div class="col-md-9">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                      <!--<button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>-->
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                      <!--<button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>-->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
   <!-- end Cropping modal -->



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include 'include/script.php' ?>


<script>

   function readURL(input,id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+id)
                    .attr('src', e.target.result);
                    
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

    

 </body>
</html>



<?php

extract($_REQUEST);
// for add holidays
if(isset($submit)){

            $arr_data = $this->input->post();

            $arr_data['password']=md5($arr_data['password']);

            if($_FILES['image']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "USER_IMG" . $n . '.png';
                        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image'] = $img; 

            }


unset($arr_data['submit'],$arr_data['id']);
$result = $this->admin_common_model->insert_data('users',$arr_data); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Add User Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/userList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Add User',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}

}// end if submit


// for update restaurant
if(isset($update)){

$arr_data = $this->input->post();


            $user_image = $row['image'];
            if($_FILES['image']['name']!=''){
    
                        unlink("uploads/images/" . $rest_image);
                        $n = rand(0, 100000);
                        $img = "USER_IMG" . $n . '.png';
                        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image'] = $img; 

            }

            if($arr_data['image']==''){
                $arr_data['image'] = $row['image'];
            }else{
                unlink("uploads/images/" . $row['image']);
            }

            $arr_data['password']=md5($arr_data['password']);

$arr_where = ['id'=>$arr_data['id']];
unset($arr_data['update']);
$result = $this->admin_common_model->update_data('users',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Update User Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/userList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating User',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}


?>

  <style>
     .dialog {
    padding-right: 18px;
    float: left;
    position: relative;
}
.close-thik{
   background: #FFF none repeat scroll 0% 0%;
color: #0A0A0A;
font: 14px/100% arial,sans-serif;
position: absolute;
right: 20px;
text-decoration: none;
text-shadow: 0px 1px 0px #FFF;
top: 5px; 
}
.dialog label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
}
.upload_file {
    width: 120px;
    height: 100px;
    border: 1px solid #0070BC;
}
.dialog input{
        visibility: hidden;
    position: absolute;

}

     </style>







