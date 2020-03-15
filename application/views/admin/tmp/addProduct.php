<!DOCTYPE html>
<html>
<?php include 'include/head.php';
     
      $button = "submit";
      $btn_name = "Add Product";
      $path = base_url("uploads/images/notfound.png");
      $path1 = base_url("uploads/images/notfound.png");
      $path2 = base_url("uploads/images/notfound.png");
      $id = $this->uri->segment(4);
      if($id!=''){
        $fetch = $this->admin_common_model->get_where('product',['id'=>$id]);
        $row = $fetch[0];
        $button = "update";
        $btn_name = "Update Product";        
        if($row['image1']!=''){
          $path1 = base_url("uploads/images/".$row['image1']);
        }
         if($row['image2']!=''){
          $path2 = base_url("uploads/images/".$row['image2']);
        }
         if($row['image3']!=''){
          $path3 = base_url("uploads/images/".$row['image3']);
        }
        if($row['image4']!=''){
          $path4 = base_url("uploads/images/".$row['image4']);
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
            <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="name" required value="<?=$row['name'];?>">
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Category Name</label>
            <div class="col-sm-8">
            
              <select class="form-control" name = "cat_id">
                  <option>-select-</option>
                 <?php  $category = $this->admin_common_model->get_all('category');
                 foreach($category as $res){?>
                  <option value = "<?php echo $res['id']?>" <?php if($res['id'] == $row['cat_id']){echo "selected";}?>><?php echo $res['category_name']?></option>
                  <?php } ?>
              </select>
            </div>
          </div>
          
          
          
          
          
          
             <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
            <div class="col-sm-8">
            
              <select class="form-control" name = "user_id">
                  <option>-select-</option>
                 <?php  $category = $this->admin_common_model->get_all('users');
                 foreach($category as $res){?>
                  <option value = "<?php echo $res['id']?>" <?php if($res['id'] == $row['user_id']){echo "selected";}?>><?php echo $res['user_name']?></option>
                  <?php } ?>
              </select>
            </div>
          </div>
          
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="price" required value="<?=$row['price'];?>">
            </div>
          </div>
          
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-8">
             <textarea name="description" id="description" rows="4" cols="82"><?=$row['description'];?></textarea>
            </div>
          </div>
          
          
           <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Image1</label>
            <div class="col-sm-8">
               <label>
                 <img src="<?=$path1;?>" width="200" id="image1">
                 <input type="file"  class="form-control" name="image1" onchange="readURL(this,'image1');" style="display:block">
               </label>              
            </div>
          </div> 
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Image2</label>
            <div class="col-sm-8">
               <label>
                 <img src="<?=$path2;?>" width="200" id="image2">
                 <input type="file"  class="form-control" name="image2" onchange="readURL(this,'image2');" style="display:block">
               </label>              
            </div>
          </div>
          
          
             <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Image3</label>
            <div class="col-sm-8">
               <label>
                 <img src="<?=$path3;?>" width="200" id="image3">
                 <input type="file"  class="form-control" name="image3" onchange="readURL(this,'image3');" style="display:block">
               </label>              
            </div>
          </div>
          
             <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Image4</label>
            <div class="col-sm-8">
               <label>
                 <img src="<?=$path4;?>" width="200" id="image4">
                 <input type="file"  class="form-control" name="image4" onchange="readURL(this,'image4');" style="display:block">
               </label>              
            </div>
          </div>
          

          

               <?php /*$fetch_product_image = $this->admin_common_model->get_where('product_images',['product_id'=>$id]);
        //echo "<pre>";print_r($fetch_product_image);
        if($fetch_product_image == '')
        {
              $img1 = base_url('uploads/images/notfound.png');
              $img2 = base_url('uploads/images/notfound.png');
              $img3 = base_url('uploads/images/notfound.png');
        }else{
        
            $img1 = base_url("uploads/images/".$fetch_product_image[0]['product_image']);
            $img2 = base_url("uploads/images/".$fetch_product_image[1]['product_image']);
            $img3 = base_url("uploads/images/".$fetch_product_image[2]['product_image']);
        }
*/
    ?>
             
            <!--  <div class="dialog">
      <span class="close-thik" onclick="remove_img('img1','<?=$id;?>','image')" style=""></span>
      <label>            
        <img id="img1" src="<?= $img1; ?>" class="upload_file">
        <input name="product_image[]" id="fileUpload1" onchange="readURL(this,'img1');" accept="image/gif, image/jpeg" type="file">             
      </label>
    </div>
    
        <div class="dialog">
      <span class="close-thik" onclick="remove_img('img1','<?=$id;?>','image')" style=""></span>
      <label>            
        <img id="img2" src="<?= $img2; ?>" class="upload_file">
        <input name="product_image[]" id="fileUpload1" onchange="readURL(this,'img2');" accept="image/gif, image/jpeg" type="file">             
      </label>
    </div>
    
        <div class="dialog">
      <span class="close-thik" onclick="remove_img('img1','<?=$id;?>','image')" style=""></span>
      <label>            
        <img id="img3" src="<?= $img3; ?>" class="upload_file">
        <input name="product_image[]" id="fileUpload1" onchange="readURL(this,'img3');" accept="image/gif, image/jpeg" type="file">             
      </label>
    </div>-->
    
              
              </div>
       
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
       
          
       <!--   <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
                 <img src="<?=$path;?>" alt="Avatar">
              <input type="file" name="image" class="imgSrc">
            
                 <img src="<?=$path1;?>" alt="Avatar">
              <input type="file" name="image2" class="imgSrc">
           
                 <img src="<?=$path2;?>" alt="Avatar" >
              <input type="file" name="image3" class="imgSrc">
            </div>
          </div>-->
          
          
          
          
          

 
         <!--<div class="form-group">
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



 if($_FILES['image1']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG1" . $n . '.png';
                        move_uploaded_file($_FILES['image1']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image1'] = $img; 

            }
            
if($_FILES['image2']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG2" . $n . '.png';
                        move_uploaded_file($_FILES['image2']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image2'] = $img; 

            }
            
if($_FILES['image3']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG3" . $n . '.png';
                        move_uploaded_file($_FILES['image3']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image3'] = $img; 

            }
if($_FILES['image4']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG4" . $n . '.png';
                        move_uploaded_file($_FILES['image4']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image4'] = $img; 

            }            
            
            
            

  unset($arr_data['submit'],$arr_data['id']);
$result = $this->admin_common_model->insert_data('product',$arr_data); 
//echo $this->db->last_query(); die;
             
        
if ($result) {
    
    

echo 
"<script> swal(
  'Success',
  'Add Product Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/productList')."';
});

</script>";
}
    


}// end if submit


// for update restaurant
if(isset($update)){

$arr_data = $this->input->post();




 if($_FILES['image1']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG1" . $n . '.png';
                        move_uploaded_file($_FILES['image1']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image1'] = $img; 

            }
            
if($_FILES['image2']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG2" . $n . '.png';
                        move_uploaded_file($_FILES['image2']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image2'] = $img; 

            }
            
if($_FILES['image3']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG3" . $n . '.png';
                        move_uploaded_file($_FILES['image3']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image3'] = $img; 

            }
if($_FILES['image4']['name']!=''){
    
                        $n = rand(0, 100000);
                        $img = "PRODUCT_IMG4" . $n . '.png';
                        move_uploaded_file($_FILES['image4']['tmp_name'], "uploads/images/" . $img);
                        $arr_data['image4'] = $img; 

            }            
            
            
            
            

        


$arr_where = ['id'=>$arr_data['id']];
 unset($arr_data['update']);
$result = $this->admin_common_model->update_data('product',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
             
        
if ($result) {


echo 
"<script> swal(
  'Success',
  'Update Product Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/productList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating Product',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}


?>






