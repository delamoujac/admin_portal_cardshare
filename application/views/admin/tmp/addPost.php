<!DOCTYPE html>
<html>
<?php include 'include/head.php';

$admin_data = $this->session->userdata('admin');
$button = "submit";
$btn_name = "Add post";
$path = base_url("uploads/images/no_image.png");
       $id = $this->uri->segment(4);
       if($id!=''){
         $fetch = $this->admin_common_model->get_where('post',['id'=>$id]);
         $row = $fetch[0];
         $button = "update";
         $btn_name = "Update post";        
         if($row['image']!=''){
           $path = base_url("uploads/images/".$row['image']);
         }
       }




?>

<style type="text/css">
input[type=file] {
  display: none!important;
}

.upload_file {
  width: 120px;
  height: 100px;
  border: solid 1px #0070bc;
}

/* for close */
[class*='close-'] {
  background: #fff;
  color: #0a0a0a;
  font: 14px/100% arial, sans-serif;
  position: absolute;
  right: 20px;
  text-decoration: none;
  text-shadow: 0 1px 0 #fff;
  top: 5px;
}

.close-thik:after {
  content: '✖'; /* UTF-8 symbol */
  cursor: pointer;
}

/* Dialog */

.dialog {
  padding-right: 15px;
  float: left;
  position: relative;

}
.sizes{
  width: 86%;
  float: left;
  margin-right: 1%;
}

.xcrud-button {
  display: inline-block;
  margin: 1px 1px 0 0;
  height: 28px;
  line-height: 28px;
  background: #8D8D8D;
  color: #fff;
  text-decoration: none;
  border: none;
  padding: 0 10px;
  cursor: pointer;
  vertical-align: top;
}
.pd0{
  padding:2px 0px;
}

</style>

<body class="hold-transition skin-blue sidebar-mini" id="">
  <div class="wrapper">
    <?php include 'include/header.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
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
              <input type="text"  class="form-control" name="product_name" required value="<?=$row['product_name'];?>">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="price" id="price"  value="<?=$row['price'];?>">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Discount Percent %</label>
            <div class="col-sm-8">
              <input type="text"  class="form-control" name="discount_percent" id="discount_percent" value="<?php if(!empty($row)){echo $row['discount_percent'];}?>">
            </div>
          </div>

        

        
         
        
       

        <!-- <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label"></label>
          <div class="col-sm-8">
           <label>
             <img src="<?=$path;?>" width="200" id="image"Product>
             <input type="file"  class="form-control" name="product_iamge" onchange="readURL(this,'image');" style="display:none">
           </label>              
         </div>
       </div> -->

       <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Product Image</label>
        <div class="col-sm-8">

          <?php $fetch_product_image = $this->admin_common_model->get_where('post_image',['post_id'=>$row['id']]);
        //echo "<pre>";print_r($fetch_product_image);
          $img1 = base_url("uploads/images/".$fetch_product_image[0]['image']);
         


          ?>

          <div class="dialog">
            <span class="close-thik" onclick="remove_img('img1','<?=$id;?>','image')" style="<?=$style;?>"></span>
            <label>            
              <img id="img1" src="<?= $img1; ?>" class="upload_file">
              <input type="file"  name="image[]" id="fileUpload1" onchange="readURL(this,'img1');" accept="image/gif, image/jpeg" value="<?php echo $img1?$img1:'';?>">             
            </label>
          </div>
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

function getCategoryType(category_id){
 $.ajax({
  url: "<?=base_url('admin/get_category_type');?>",
          data: {'category_id': category_id}, // change this to send js object
          type: "POST",
          success: function(result){
            //alert(result);
            $("select[name='category_type_id']").html(result);
            

          }
        });

}

$("#discount_percent").blur(function(){
  var price = $("#price").val();
  var discount_percent = $("#discount_percent").val();
  var discount_price =  (price * discount_percent) / 100;
  var sale_price = price - discount_price;
  $("#sale_price").val(sale_price);
});

</script>



</body>
</html>



<?php

extract($_REQUEST);
// for add holidays
if(isset($submit)){

  $arr_data = $this->input->post();

  
  
    //$arr_data['color'] = explode(',',$arr_data['color']);
    //$arr_data['size'] = explode(',',$arr_data['size']);

  unset($arr_data['submit'],$arr_data['id'],$arr_data['image']);
  $result = $this->admin_common_model->insert_data('post',$arr_data); 
//echo $this->db->last_query(); die;


  if ($result) {

    $cnt = count($_FILES['image']['name']);

    for($i=0; $i<$cnt; $i++)
    { 
   // if ($i==0) {
      if($_FILES['image']['name'][$i]!=""){
        unlink("uploads/images/" . $row['image']);                                  
        $n = rand(0, 100000);
        $img = "PRODUCT_IMG" . $n . '.png';
        move_uploaded_file($_FILES['image']['tmp_name'][$i], "uploads/images/" . $img);
        $arr_data['product_image'] = $img;
        $image_result = $this->admin_common_model->insert_data('post_image',['post_id'=>$result,'image'=>$arr_data['image']]); 

      }
  // }
    }

    if($image_result){

      echo 
      "<script> swal(
      'Success',
      'Add Post Successfully',
      'success'
      ); 

      $('.confirm').click(function(){
        window.location='".base_url('admin/view_page/postList')."';
        });

        </script>";
      }
    }else{

      echo "<script> swal(
      'Error',
      'Error In Add Post',
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

  $cnt = count($_FILES['product_image']['name']);
  for($i=0; $i<$cnt; $i++)
  { 
    if($_FILES['product_image']['name'][$i]!=""){
      unlink("uploads/images/" . $row['image']);                                  
      $n = rand(0, 100000);
      $img = "PRODUCT_IMG" . $n . '.png';
      move_uploaded_file($_FILES['product_image']['tmp_name'][$i], "uploads/images/" . $img);
      $arr_data['product_image'] = $img;
      $image_result = $this->admin_common_model->insert_data('product_images',['product_id'=>$arr_data['id'],'product_image'=>$arr_data['product_image']]); 

    }
  }
  // }
  
  
  
  
  
  


  $arr_where = ['id'=>$arr_data['id']];
  unset($arr_data['update'],$arr_data['product_image']);
  $result = $this->admin_common_model->update_data('products',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;


  if ($result) {



    echo 
    "<script> swal(
    'Success',
    'Update product Successfully',
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






