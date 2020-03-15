<!DOCTYPE html>
<html>
<?php include 'include/head.php';
     
      
      $path = base_url("uploads/images/user.jpg");
      $id = $this->session->userdata('admin')->id;
      
        $fetch = $this->admin_common_model->get_where('admin',['id'=>$id]);
        $row = $fetch[0];
        $button = "update";
        $btn_name = "Update Profile";        
        if($row['image']!=''){
          $path = base_url("uploads/images/".$row['image']);
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
            <label for="inputEmail3" class="col-sm-2 control-label">Admin Name</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="name" value="<?=$row['name'];?>">
            </div>
          </div>
         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="email" require value="<?=$row['email'];?>">
            </div>
          </div>
         
 
         <!--<div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
               <img src="<?=$path;?>" width="200" id="img">              
            </div>
          </div>

         

         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Profile Image</label>
            <div class="col-sm-8">
              <input type="file"  class="form-control" name="pro_image" onchange="readURL(this,'img');">
            </div>
         </div>-->
         
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
                 <img src="<?=$path;?>" alt="Avatar" style="width: 20%;">
              <input type="file" name="image" class="imgSrc">
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

<script src="editor/editor.js"></script>
    
    <script>
      $(document).ready(function() { 
        $("#txtEditor").Editor();
      });
    </script>


    <style type="text/css">
      #statusbar{ display: none; }
      a.btn-default[title="Source"]{ display: none; }
    </style>
    <script>
       $(document).ready(function () {
            
            $(".Editor-editor").html('<?= base64_decode($row['description']);?>');
           
            $(".Editor-editor").focus(function(){
                $(this).keyup(function() {
                    var content = $(this).html();
                   
                    $("#Text_Editor").val(content);
                });
              });
        
        });
    </script>
    
    

 </body>
</html>



<?php

extract($_REQUEST);

// for update profile
if(isset($update)){

$arr_data = $this->input->post();
$admin = $this->session->userdata('admin');

              $user_image = $row['image'];
            if($_FILES['image']['name']!=''){
    
                        unlink("uploads/images/" . $rest_image);
                        $n = rand(0, 100000);
                        $img = "CATEGORY_IMG" . $n . '.png';
                        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image'] = $img; 

            }

            if($arr_data['image']==''){
                $arr_data['image'] = $row['image'];
            }else{
                unlink("uploads/images/" . $row['image']);
            }


$arr_where = ['id'=>$arr_data['id']];
unset($arr_data['update']);
$result = $this->admin_common_model->update_data('admin',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;

$admin->name  = $arr_data['name'];
$this->session->set_userdata('admin',$admin);

        
if ($result) {
echo 
"<script> swal(
  'Success',
  'Update Profile Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/dashboard')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating Profile',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}


?>






