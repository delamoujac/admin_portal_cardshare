<!DOCTYPE html>
<html>
<?php


function in_array_r($check, $menu_id, $sub_menu_id,$array) {
    foreach ($array as $item) {

        if($check=='menu_id'){
          
           if($item['menu_id']==$menu_id){
              return true;
           }
 
        }

        if($check=='sub_menu_id'){
          
           if($item['menu_id']==$menu_id && $item['sub_menu_id']==$sub_menu_id){
              return true;
           }

        }    

    }

    return false;
}



      include 'include/head.php';
      $admin_users = $this->admin_common_model->get_where('admin',"id NOT IN(1)");

      $sidebar_menu = $this->admin_common_model->get_all('sidebar_menu');
      $button = "submit";
      $btn_name = "Add Permission Menu";
      
      $id = $this->uri->segment(4);
      if($id!=''){
        $fetch = $this->admin_common_model->get_where('menu_permission',['roll'=>$id]);

        //$row = $fetch[0];
        //$button = "update";
        $btn_name = "Update Permission Menu";        
        
      }
      


 ?>

<style>
.form-group input[type="checkbox"] {
    display: inline-block;
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
         

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Select User</label>
            <div class="col-sm-8">
              <select class="form-control" name="roll"> 
              <?php foreach($admin_users as $arr){ ?>
                 <option <?php if($id==$arr['id']){echo "selected"; } ?> value="<?=$arr['id'];?>"> <?=$arr['name'];?> </option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Select Menu</label>
            <div class="col-sm-8">
               
		<div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
             
                <div class="panel">
			<div class="panel-heading" role="tab" id="heading<?=$i;?>">
			  <h4 class="panel-title">
			   <label role="button"><input type="checkbox" id="checkAll" name="all" value="all"> All Permission</label>
			  </h4>
			</div>
                 </div>

		<?php $i = 1; foreach($sidebar_menu as $arr){

      		$sidebar_sub_menu = $this->admin_common_model->get_where('sidebar_sub_menu',['menu_id'=>$arr['id']]);
                $class = $checked = '';
                if(in_array_r('menu_id', $arr['id'], false, $fetch)==true){
                  $class='in';
                  $checked = 'checked';
                }
		?>

		  <div class="panel">
			<div class="panel-heading" role="tab" id="heading<?=$i;?>">
			 <h4 class="panel-title">
			 <label role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?=$i;?>" aria-expanded="true" aria-controls="collapse<?=$i;?>"><input type="checkbox" <?=$checked;?> name="menu_id[]" value="<?=$arr['id'];?>"> <?=$arr['name'];?></label>
			 </h4>
			 </div>
		    <div id="collapse<?=$i;?>" class="panel-collapse collapse <?=$class;?>" role="tabpanel" aria-labelledby="heading<?=$i;?>">
			 <div class="panel-body" style="padding-left: 40px;">	 
			     <?php foreach($sidebar_sub_menu as $arr1){
                              $checked = '';
                              if(in_array_r('sub_menu_id', $arr['id'], $arr1['id'], $fetch)==true){
                                 $checked = 'checked';
                              }
                              ?>
			     <div class="checkbox">
			     <label><input type="checkbox" <?=$checked;?> name="sub_menu_id<?=$i;?>[]" value="<?=$arr1['id'];?>"> <?=$arr1['name'];?></label>
			     </div>
			     <?php } ?>

			 </div>
		    </div>
		 </div>
		 <!-- end of panel -->
			     
		<?php $i++; } ?>
			   

		</div>
		<!-- end of #accordion -->


            </div>
       	  </div>


          <!--<div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Select Menu</label>
            <div class="col-sm-8">
               <select class="form-control" name="menu_id" required onchange="getSubMenu(this.value)"> 
              <?php foreach($sidebar_menu as $arr){ ?>
                 <option <?php if($row['menu_id']==$arr['id']){echo "selected"; } ?> value="<?=$arr['id'];?>"> <?=$arr['name'];?> </option>
              <?php } ?>
              </select>
            </div>
          </div>
                  
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Select Sub Menu</label>
            <div class="col-sm-8">
               <select class="form-control sub_menu_ids" name="sub_menu_id"> 
              <?php foreach($sidebar_sub_menu as $arr){ ?>
                 <option <?php if($row['sub_menu_id']==$arr['id']){echo "selected"; } ?> value="<?=$arr['id'];?>"> <?=$arr['name'];?> </option>
              <?php } ?>
              </select>
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


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include 'include/script.php' ?>


<script>
// getSubMenu function
function getSubMenu(id)
{
        $('.sub_menu_ids').html("<option> Loading ... </option>");
        $.ajax({
          url: "<?=base_url('admin/getSubMenu');?>",
          data: {'id': id}, // change this to send js object
          type: "POST",
          success: function(result){
            //alert(result);
            $('.sub_menu_ids').html(result);
          }
        });
 


} 
// end delete function

</script>

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


<script>
    
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

</script>

 </body>
</html>



<?php


extract($_REQUEST);
// for add holidays
if(isset($submit)){

 
$arr_data = $this->input->post();    

   

//unset($arr_data['submit'],$arr_data['id']);
$this->admin_common_model->delete_data('menu_permission',['roll'=>$arr_data['roll']]);

foreach ($arr_data['menu_id'] as $val) {
	$arr = [];

	foreach ($arr_data['sub_menu_id'.$val] as $val1) {
		$arr = [];
		$arr = ['roll'=>$arr_data['roll'],'menu_id'=>$val,'sub_menu_id'=>$val1];
		$result = $this->admin_common_model->insert_data('menu_permission',$arr); 
                
	}
}


//echo $this->db->last_query(); die;
             
        
if ($result) {
echo 
"<script> swal(
  'Success',
  'Add Permission Menu Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/menuPermissionList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Add Permission Menu',
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
$result = $this->admin_common_model->update_data('menu_permission',$arr_data, $arr_where); 
//echo $this->db->last_query(); die;
             
        
if ($result) {
echo 
"<script> swal(
  'Success',
  'Update Permission Menu Successfully',
  'success'
); 

$('.confirm').click(function(){
        window.location='".base_url('admin/view_page/menuPermissionList')."';
});

</script>";

    }else{

echo "<script> swal(
  'Error',
  'Error In Updating Permission Menu',
  'error'
); 

$('.confirm').click(function(){
        window.location='';
});

</script>";

}// end if result




}


?>






