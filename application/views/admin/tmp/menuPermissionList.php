<!DOCTYPE html>
<html>
<?php 

 $menu_permission = $this->db->group_by('roll')->get('menu_permission')->result_array();

?>
<?php include 'include/head.php'; ?>

<?php include 'include/script.php' ?>

<!-- for datatable -->

<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

<script>

  $(document).ready(function() {
    $('#example').DataTable();
  } );

  </script>

<body class="hold-transition skin-blue sidebar-mini" id="" ng-app="myApp">

<div class="wrapper" >
<?php include 'include/header.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <form action="" method="POST" id="bulk_form">

      <span class="fs30 cdG">Menu Permission</span> 
         <a href="<?=base_url('admin/view_page/addMenuPermission');?>"><button type="button" class=" btn  btn-info-add btn-md mt-10 ml10" > Add New</button></a>

        <div class="row mt10">
           <div class="col-xs-12 cdG">

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="box-body table-responsive no-padding ">
             <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                  
                  <th>User Name</th>  
                  <!--<th>Permission Menu</th>               
                  <th>Permission Sub Menu </th> -->
                </tr>
        </thead>
        <tfoot>
            <tr>
                  
                  <th>User Name</th>  
                  <!--<th>Permission Menu</th>               
                  <th>Permission Sub Menu </th>-->
                </tr>
        </tfoot>
        <tbody>
           <?php $i=2; foreach($menu_permission as $row){ 

                $admin = $this->admin_common_model->fetch_recordbyid('admin',['id'=>$row['roll']]);
           ?>

                <tr>
                
                  <td>
                  <div class="row">
                    <div class="col-sm-3">
                       <?php
                        if ($admin->image == ''){
                          $img_url = base_url('uploads/images/no_image.png');
                        }else{
                          $img_url = base_url('uploads/images/'.$admin->image);
                        }
                      ?>
                      <img src="<?=$img_url;?>" alt="" width="50"> 
                    </div><!-- col-sm-2 -->
                    <div class="col-sm-9">
                    <sapn><?= $admin->name; ?>
                        <div>
                        <span><a href="<?=base_url('admin/view_page/addMenuPermission/'.$row['roll']);?>" class="cdG">Edit</a> | </span>  
                        <span><a href="#" class="cdG" onclick="deleteMenuPermission('<?=$row["roll"];?>')">Delete</a></span>
                        </div>
                    </sapn></div><!-- /row -->
                
                  </div><!-- col-sm-10 -->
                </td>
                <!--<td><p><?= $this->admin_common_model->fetch_recordbyid('sidebar_menu',['id'=>$row['menu_id']])->name;  ?></p></td>
               <td><p><?= $this->admin_common_model->fetch_recordbyid('sidebar_sub_menu',['id'=>$row['sub_menu_id']])->name; ?></p></td>     -->
              
                
               </tr>


               <?php $i++; } ?>
        </tbody>
    </table>
            </div>
    </div><!--#home-->



  </div><!--tab-content-->


    </div> <!-- /.col-xs-12 -->
        </div><!-- /row -->
       </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->



 </body>
</html>


<script>
// delete function
function deleteMenuPermission(roll)
{
  swal({
  title: "Are you sure?",
  text: "You want to permanently remove this item!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, delete it!",
  closeOnConfirm: false
},
function(){



        $.ajax({
          url: "<?=base_url('admin/delete_perm');?>",
          data: {'table': 'menu_permission', 'roll': roll}, // change this to send js object
          type: "POST",
          success: function(result){
            alert(result);
            swal("Deleted!", "Your selected item has been deleted.", "success");
  
            $('.confirm').click(function(){
               location.reload();
            });
             

          }
        });

  

});

} 
// end delete function

</script>

<style type="text/css">
.table-striped > tbody > tr:nth-of-type(2n+1){
background-color: #fff;
}

.table-striped > tbody > tr{background-color: #f6f6f6;  }

</style>

<script type="text/javascript">
  $(function () {
    $('.checkboxPar').change(function(){ 
      $("#home input:checkbox").prop('checked', $(this).prop("checked"));
    })
  })

  $(function () {
    $('.checkboxPar1').change(function(){ 
      $("#menu1 input:checkbox").prop('checked', $(this).prop("checked"));
    })
  })

  $(function () {
    $('.checkboxPa2').change(function(){ 
      $("#menu2 input:checkbox").prop('checked', $(this).prop("checked"));
    })
  })

</script>
