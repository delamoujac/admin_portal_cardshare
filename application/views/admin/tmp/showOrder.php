<!DOCTYPE html>
<html>
<?php include 'include/head.php';

$button = "submit";
$btn_name = "Add Product";
$path = base_url("uploads/images/user.jpg");
$id = $this->uri->segment(4);
if($id!=''){
  $fetch = $this->admin_common_model->get_where('product',['id'=>$id]);
  $row = $fetch[0];
  $button = "update";
  $btn_name = "Update Product";        
  if($row['product_image']!=''){
    $path = base_url("uploads/images/".$row['product_image']);
  }
}

$adminUser = $this->session->userdata('admin');
$adminId = $adminUser->id;
$adminType = $adminUser->user_type;

?>


<style type="text/css">
.colorbg{
      width: 15px;
    height: 19px;
    background-color: rgba(220, 20, 20, 0);
    padding: 6px 10px;
    position: absolute;
}


.prod-mange  input[type="color"] {
 -webkit-appearance: none; border: none; width: 20px;  height:20px;
 }

.prod-mange  input[type="color"]::-webkit-color-swatch-wrapper {
  padding: 0;
  }

 .prod-mange  input[type="color"]::-webkit-color-swatch {
   border: none;
 }


  .wizard {
    margin: 20px auto;
    background: #fff;
  }
  .tab-content{border:0px;}
  .wizard .nav-tabs {
    position: relative;
    margin: 0px auto;
    margin-bottom: 0;
    border-bottom-color: #e0e0e0;
    width: 100%;
    text-align: center;
  }

  .wizard > div.wizard-inner {
    position: relative;
  }

  .connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 63%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
  }

  .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
  }

  span.round-tab {
   width: 33px;
   height: 33px;
   line-height: 33px;
   display: inline-block;
   border-radius: 100px;
   background: #fff;
   border: 2px solid #e0e0e0;
   z-index: 2;
   position: absolute;
   left: 0;
   text-align: center;
   font-size: 18px;

 }
 span.round-tab i{
  color:#555555;
}
.wizard li.active span.round-tab {
 background-color: #5bc0de;
 border: 2px solid #5bc0de;
 color: #fff;
}
.wizard li.active span.round-tab i{
  color: #5bc0de;
}



.wizard .nav-tabs > li {
  width: 20%;
  display: inline-block;
  float: none;
}





.wizard .nav-tabs > li a {
  width: 24px;
  height: 35px;
  margin: 0px auto;
  border-radius: 100%;
  padding: 0;
}

.wizard .nav-tabs > li a:hover {
  background: transparent;
}
.wizard .nav-tabs > li a:active {
  background: transparent;
}
.wizard .tab-pane {
  position: relative;
  padding-top: 50px;
}

.wizard h3 {
  margin-top: 0;
}
.m-top{ 
  margin-top:25px;
}
@media( max-width : 585px ) {    
}
.ls, input, label{
  letter-spacing:1px;
}
.color-teal{
  color:#5bc0de;
}
.nav-tabs{
  background-color:#fff;
  border-bottom:0px;
}
.bg-trans{
  background-color:transparent;
}
.f-right{
  float:right;
}
.icon-size{
  font-size:24px;
}
.m-10{
  margin-right:10px;
}
.p0{
  padding:0px;
}

.nav-tabs li a p{
  display: inline-block;
  position: absolute;
  top: 38px;
  left: 0px;
  right: 0;
}

.bg-order{
  background-color: #fff;
  padding: 20px;
  margin-bottom: 15px;
} 
.bg-order tr td:first-child{
  font-weight: 500;

}
.prod-mange p{
 margin-bottom: 10px;
 font-size: 13px;
 color: #989494;
}
.prod-mange h4{
 margin-bottom: 11px;
 font-size: 22px;
 margin-top: 17px;
}
</style>

<body class="hold-transition skin-blue sidebar-mini" id="">
  <div class="wrapper">
    <?php include 'include/header.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content" id="crop-avatar">
       <div class="row ">
        <div class="col-sm-12 cdG">
          <span class="fs30 ">Order Details</span> 
          <!--<p><?=$btn_name;?> and add them to this site.  </p>-->
        </div>
        <div class="col-sm-12 cdG">
          <?php
          $where = "(id = '$id') GROUP BY order_id";

    //$fetch = $this->admin_common_model->get_where('place_order',$where);

          $fetch = $this->admin_common_model->get_where('place_order',$where);

          if ($fetch) {

            foreach($fetch as $val)
            {

              $products = $total = array();

              $fetch1 = $this->admin_common_model->get_where('place_order',['order_id'=>$val['order_id']]);

$cart_id  = explode(',' , $fetch1[0]['cart_id']); 
              foreach($cart_id as $val1){

                $product = array();

                $cart = $this->admin_common_model->get_where('add_to_cart',['product_id'=>$val1]); 

                $get = $this->admin_common_model->get_where('product',['id'=>$cart[0]['product_id']]); 
                
                $product_image = $this->admin_common_model->get_where('product_images',['product_id'=>$cart[0]['product_id']]);

                if(!empty($product_image[0]['product_image'])){
                $get[0]['product_image']= base_url().'uploads/images/'.$product_image[0]['product_image'];
                }else
                {
                    $get[0]['product_image']= base_url().'uploads/images/'.$product_image[0]['notfound.png'];
                }

                $get[0]['quantity'] = $cart[0]['quantity'];



                $total[] = ($get[0]['price'] * $cart[0]['quantity']);                             
                $product = $get[0];                           
                $products[] = $product; 

              }
              $val['total'] = array_sum($total);
              $val['product'] = $products; 
              $data[] = $val;
            }
          }
      // echo "<pre>";print_r($data);
          ?>


          <div class="bg-order">

            <div class="clearfix row">

              <div class="col-md-12">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Order ID</td>
                      <td><?php echo $data[0]['order_id'];?></td>
                    </tr>
                    <tr>
                      <td>Order Date</td>
                      <td><?php echo date("D , d M Y",strtotime($data[0]['created_date']));?></td>
                      <!-- <td><?php echo $data[0]['created_date'];?></td> -->
                    </tr>
                   <tr>
                      <td>Total Amount</td>
                      <td><?php echo number_format($data[0]['total'],2);?> through <strong><?php if($data[0]['shipping_method']=='COD'){echo "Cash On Delivery";}else{echo 'Online Payment';}?></strong></td>
                    </tr>
                    <tr>
                      <td>User Name</td>
                      <?php
                      $userdata = $this->admin_common_model->get_where('users',['id'=>$data[0]['user_id']]);
                      ?>
                      <td><?php echo $userdata[0]['username'];?></td>
                    </tr>
                    <tr>
                    <?php  
                     $address = $this->admin_common_model->get_where('add_address',['id'=>$data[0]['address_id']]);
                    ?>
                      <td>Address</td>
                       <?php 
                       $full_address = $address[0]['area'] ." Block ".$address[0]['block']." Street ".$address[0]['street'];
                       if($address[0]['avenue'] != ""){
                        $full_address .=  " ".$address[0]['avenue'];
                       }
                        $full_address .= " House ".$address[0]['house'];
                        if($address[0]['floor'] != ""){
                          $full_address .=  " ".$address[0]['floor'];
                        }
                        if($address[0]['appartment'] != "")
                        {
                           $full_address .=  " ".$address[0]['appartment'];
                        }
                       ?>
                      <td><?php echo $full_address ; ?></td>
                    </tr>
                   
                  </tbody>
                </table>
              </div>

              <div class="col-md-12">
               <div class="form-design">


                <div class="wizard">
                  <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="<?php if($data[0]['status']=='Pending'){echo 'active';};?>">
                      <a>
                        <span class="round-tab"> 1 </span>
                        <p>Order</p>
                      </a>
                    </li>

                   <!-- <li role="presentation" class="<?php if($data[0]['status']=='Cancel'){echo 'active';};?>">
                      <a>
                        <span class="round-tab">2
                        </span>
                        <p>Cancel </p>
                      </a>
                    </li>
                    <li role="presentation" class="<?php if($data[0]['status']=='Shipped'){echo 'active';};?>">
                      <a>
                        <span class="round-tab">3
                        </span>
                        <p>Shipped </p>
                      </a>
                    </li>-->

                    <li role="presentation" class="<?php if($data[0]['status']=='Delivered'){echo 'active';};?>">
                      <a>
                        <span class="round-tab">2
                        </span>
                        <p>Delivered</p>
                      </a>
                    </li>

                  </ul>
                </div>

                <form role="form">

                  <div class="tab-content">

                    <div class="tab-pane <?php if($data[0]['status']=='Pending'){echo 'active';};?>" role="tabpanel" id="step1">
                      <div class="heading-line" style="text-align: center;font-size: 38px;">
                       Your item has been Pending
                     </div>
                   </div>

                   <div class="tab-pane <?php if($data[0]['status']=='Delivered'){echo 'active';};?>" role="tabpanel" id="step2">
                     <div class="heading-line" style="text-align: center;font-size: 38px;">
                       Your item has been delivered
                     </div>
                   </div>
             </div>
           </form>
         </div>

       </div> 
     </div>

   </div>

 </div>

 <?php
// $products = explode($data[0]['cart_id']);
 foreach($data[0]['product'] as $product) {
 ?>
 <div class="bg-order">

  <div class="clearfix row">
   <div class="col-md-6">
     <div class="prod-mange">
       <div class="media">
        <div class="media-left media-middle">
          
          <a href="#">
            <img class="media-object" style="width: 110px;height: 100px;min-width: 100%;object-fit: contain;margin: 0 auto;" src="<?php echo $product['product_image'];?>">
          </a>
         
        </div>
        <div class="media-body">
          <h4 class="media-heading"><?php echo $product['product_name'];?></h4>
          
          <p>Product Price : <?php echo $product['price'];?></p>
          <p>Product Quantity : <?php echo $product['quantity'];?></p>
          <p>Special Request : <?php echo $cart[0]['remark'];?></p>
         <!-- <p>Seller: <?php 
          $seller = $this->admin_common_model->get_where('users',['id'=>$product['user_id']]);

          echo $seller[0]['name']?$seller[0]['name']:'Seller Name Not Available';?></p>-->
        </div>
      </div>
    </div>  
  </div> 

</div>

</div>
<?php } ?>



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

$("#discount_percent").blur(function(){
  var price = $("#price").val();
  var discount_percent = $("#discount_percent").val();
  var discount_price =  (price * discount_percent) / 100;
  var sale_price = price - discount_price;
  $("#sale_price").val(sale_price);
});

function getSubCategory(category_id){
 $.ajax({
  url: "<?=base_url('admin/get_sub_category');?>",
          data: {'category_id': category_id}, // change this to send js object
          type: "POST",
          success: function(result){
            //alert(result);
            $("select[name='subcategory_id']").html(result);
            

          }
        });

}

</script>

<!-- script for add more -->
<script type="text/javascript">


 $(document).ready(function() {
      var max_fields      = 10; //maximum input boxes allowed
      var wrapper         = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              
              $(wrapper).append("<div class='col-sm-12 pd0'><input type='text'  class='form-control sizes' name='size[]'><a href='#' class='remove_field'><i class='fa fa-times'></i></a></div>"); 
            }else{
              alert('You can not add more Fields');
            }
            auto();
          });
      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('div').remove(); x--;
      })
    });

  </script>

  <!-- script for add more color -->
  <script type="text/javascript">


   $(document).ready(function() {
      var max_field      = 10; //maximum input boxes allowed
      var wrappers         = $(".input_fields"); //Fields wrappers
      var add_buttons      = $(".add_field"); //Add button ID
      
      var x = 1; //initlal text box count
      $(add_buttons).click(function(e){ //on add input button click
        e.preventDefault();
          if(x < max_field){ //max input box allowed
              x++; //text box increment
              
              $(wrappers).append("<div class='col-sm-12 pd0'><input type='color'  class='form-control sizes' name='color[]'><a href='#' class='remove_field'><i class='fa fa-times'></i></a></div>"); 
            }else{
              alert('You can not add more Fields');
            }
            auto();
          });
      
      $(wrappers).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('div').remove(); x--;
      })
    });

  </script>




</body>
</html>



<?php

extract($_REQUEST);
// for add holidays
if(isset($submit)){

  $arr_data = $this->input->post();

  if($_FILES['product_image']['name']!=''){

    $n = rand(0, 100000);
    $img = "PRODUCT_IMG" . $n . '.png';
    move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/images/" . $img);
    $arr_data['product_image'] = $img; 

  }

  $price_format = number_format($arr_data['price'], 2);
  $arr_data['price'] = str_replace(',', '', $price_format);

  $sale_price_format = number_format($arr_data['sale_price'], 2);
  $arr_data['sale_price'] = str_replace(',', '', $sale_price_format);

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

}else{

  echo "<script> swal(
  'Error',
  'Error In Add Product',
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

  $user_image = $row['product_image'];
  if($_FILES['product_image']['name']!=''){

    unlink("uploads/images/" . $rest_image);
    $n = rand(0, 100000);
    $img = "PRODUCT_IMG" . $n . '.png';
    move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/images/" . $img);
    $arr_data['product_image'] = $img; 

  }


  $arr_where = ['id'=>$arr_data['id']];
  unset($arr_data['update']);
  $result = $this->admin_common_model->update_data('product',$arr_data, $arr_where); 
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

