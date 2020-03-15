<!DOCTYPE html>
<html>
<?php include 'include/head.php';
     
      $button = "submit";
      $btn_name = "Add Setting";
      $path = base_url("uploads/images/no_image.png");
      $path1 = base_url("uploads/images/no_image.png");
      $id = $this->uri->segment(4);
      if($id!=''){
        $fetch = $this->admin_common_model->get_where('setting',['id'=>$id]);
        $row = $fetch[0];
        $button = "update";
        $btn_name = "Update Setting";        
        if($row['logo']!=''){
          $path = base_url("uploads/images/".$row['logo']);
          $path1 = base_url("uploads/images/".$row['icon']);
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
   <div class="col-sm-9 cdG">
           <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
          <input type="hidden"  class="form-control" name="id" value="<?=$row['id'];?>">
         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Title Name</label>
            <div class="col-sm-9">
              <input type="text"  class="form-control" name="name" value="<?=$row['name'];?>">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label"></label>
            <div class="col-sm-4">
                <label for="inputEmail3" class="control-label">Logo Image</label> <br>
               <img src="<?=$path;?>"  id="img" width="100">              
            </div>
            <div class="col-sm-4 col-sm-offset-1">
                <label for="inputEmail3" class="control-label">Icon Image</label> <br>
               <img src="<?=$path1;?>"  id="img1"  width="30">              
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Change Logo</label>
            <div class="col-sm-9">
              <input type="file"  class="form-control" name="logo" onchange="readURL(this,'img');">
            </div>
          </div>
          
         


  <div class="form-group">
    <div class=" col-sm-2 col-sm-offset-3">
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
                $('#'+id+",#img1")
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

            /*if($_FILES['user_image']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "USER_IMG" . $n . '.png';
                        move_uploaded_file($_FILES['user_image']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image'] = $img; 

            }*/


unset($arr_data['submit'],$arr_data['id']);
$result = $this->admin_common_model->insert_data('users',$arr_data); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Add Users Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/userList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Add Users',
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


            $logo = $row['logo'];
            $icon = $row['icon'];
            if($_FILES['logo']['name']!=''){
                           
                        $n = rand(0, 100000);
                        $file_ext = end(explode(".", $_FILES['logo']['name']));
                        $logo = "logo_IMG" . date('Ymdhis') . '.'.$file_ext ;
                        $icon = $logo;//"icon_IMG" . date('Ymdhis') . '.'.$file_ext ;
                        move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/images/" . $logo);
    
                        $target_path = 'uploads/images/';
                        $thumb_path = 'uploads/images/';
    
                        $upload_image = $target_path.$logo;
                        list($width,$height) = getimagesize($upload_image);

                        // for thumb size image

                        $thumb_logo = $thumb_path.$logo;
                        $thumb_icon = $thumb_path.$icon;

                        if ($file_ext == 'gif' || $file_ext == 'GIF')
                            $resource = imagecreatefromgif($upload_image);
                        else if ($file_ext == 'png')
                            $resource = imagecreatefrompng($upload_image);
                        else if ($file_ext == 'jpg' || $file_ext == 'jpeg')
                             $resource = imagecreatefromjpeg($upload_image);

                        //$this->create_thumb(100,70,$width,$height,$resource,$thumb_logo,$file_ext);
                        //$this->create_thumb(30,30,$width,$height,$resource,$thumb_icon,$file_ext);
                        

            }

            $arr_data['logo'] = $logo; 
            $arr_data['icon'] = $icon; 


$arr_where = ['id'=>$arr_data['id']];
unset($arr_data['update']);
$result = $this->admin_common_model->update_data('setting',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Update Setting Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/settingList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating Setting',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}




function create_thumb($desired_width,$desired_height,$width,$height,$resource,$destination,$file_ext){
     
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    switch ($file_ext)
    {
    case "png":
        
        $background = imagecolorallocate($virtual_image, 0, 0, 0);        
        
        imagecolortransparent($virtual_image, $background);
       
        imagealphablending($virtual_image, false);
       
        imagesavealpha($virtual_image, true);

        break;

    case "gif":
        
        $background = imagecolorallocate($virtual_image, 0, 0, 0);        
       
        imagecolortransparent($virtual_image, $background);

        break;
        
    case "GIF":
        
        $background = imagecolorallocate($virtual_image, 0, 0, 0);        
       
        imagecolortransparent($virtual_image, $background);

        break;
    }
 
    
    imagecopyresampled($virtual_image, $resource, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    if ($file_ext == 'gif' || $file_ext == 'GIF')
        imagegif($virtual_image, $destination);
    else if ($file_ext == 'png')
        imagepng($virtual_image, $destination, 1);
    else if ($file_ext == 'jpg' || $file_ext == 'jpeg')
        imagejpeg($virtual_image, $destination, 100);


    // for full size image     


    //echo '<img src="'.$destination.'">'; 

}


?>






