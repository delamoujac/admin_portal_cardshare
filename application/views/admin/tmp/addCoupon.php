<!DOCTYPE html>
<html>
<?php include 'include/head.php';
     
      $button = "submit";
      $btn_name = "Add Coupon";
      $path = base_url("uploads/images/user.jpg");
      $id = $this->uri->segment(4);
      if($id!=''){
        $fetch = $this->admin_common_model->get_where('coupon',['id'=>$id]);
        $row = $fetch[0];
        $button = "update";
        $btn_name = "Update Coupon";        
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
            <label for="inputEmail3" class="col-sm-2 control-label">Coupon</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="code" required value="<?=$row['code'];?>">
            </div>
          </div>



          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">%</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="type" required value="<?=$row['type'];?>">
            </div>
          </div>
   
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Usable</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="usable" value="<?=$row['usable'];?>" maxlength="10">
            </div>
          </div>
         
          
       


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



unset($arr_data['submit'],$arr_data['id']);
$result = $this->admin_common_model->insert_data('coupon',$arr_data); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Add Coupon Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/couponList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Add Coupon',
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




$arr_where = ['id'=>$arr_data['id']];
unset($arr_data['update']);
$result = $this->admin_common_model->update_data('coupon',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Update Coupon Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/couponList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating Coupon',
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







