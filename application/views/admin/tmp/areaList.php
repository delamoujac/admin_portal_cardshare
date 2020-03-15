<!DOCTYPE html>
<html>

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
<?php include 'include/header.php';

      $category = $this->admin_common_model->get_all('kuwait_areas');
     
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <form action="" method="POST" id="bulk_form">

      <span class="fs30 cdG">Areas </span> <a href="<?=base_url('admin/view_page/addArea');?>"><button type="button" class=" btn  btn-info-add btn-md mt-10 ml10" > Add New</button></a>

          <!-- <div class="box-body bcw mt20 ">
              <div class="">
                <div class="row pt10 ">
              
                <div class="col-sm-2">
                  <div class="form-group">
                    <select class="form-control " tabindex="-1" aria-hidden="true" name="bulk_action">
                      <option value="">---Bulk Select---</option>
                       <option value="delete">Delete</option>                   
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <a href="#" onclick="$('#bulk_form').submit()" class=" btn btn-default-add btn-block">Bulk Action</a>  
                </div>

              </div>
              </div>
              
        </div>-->

         



        <div class="row mt10">
           <div class="col-xs-12 cdG">

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="box-body table-responsive no-padding ">
             <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                  <!--<th><div class="[ form-group ] mb0">
                              <input name="action" id="user1" class="checkboxPar" type="checkbox" value="all">
                              <div class="[ btn-group ]">
                                  <label for="user1" class="[ myradioBtn ]">
                                      <span class="[ glyphicon glyphicon-ok ]"></span>
                                      <span></span>
                                  </label>
                              </div>

                        </div> </th>-->
                  <th>Area Name</th> 
                  <th>City Name</th> 
                </tr>
        </thead>
        <tfoot>
            <tr>
                  <!--<th><div class="[ form-group ] mb0">
                              <input name="action" id="user1" class="checkboxPar" type="checkbox" value="all">
                              <div class="[ btn-group ]">
                                  <label for="user1" class="[ myradioBtn ]">
                                      <span class="[ glyphicon glyphicon-ok ]"></span>
                                      <span></span>
                                  </label>
                              </div>

                        </div> </th>-->
                  <th>Area Name</th>
                  <th>City Name</th> 
                 
                </tr>
        </tfoot>
        <tbody>
           <?php $i=2; foreach($category as $row){ 
              
               ?>

                <tr>
            
                 
                <td><span><?php echo $row['name']?></span><br>
                 <span><a href="#" class="cdG" onclick="deleteArea('<?=$row["id"];?>')">Delete</a></span></td>
                 
                 <?php  $city = $this->admin_common_model->get_where('kuwait_city' , ['id'=>$row['city_id']]); ?>
                <td><?=$city[0]['city_name']?></td>

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


 <!-- start the model here -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Create Shop Owner</h4>
                </div>

               <form action="<?=base_url('admin/create_owner');?>" method="POST">

                <div class="modal-body">
                 
                  <input type="hidden"  class="form-control" id="user_id" name="user_id">

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Select Shop</label>
                    <div class="col-sm-8">
                       <select class="form-control" name="shop_id"> 
                        <?php  foreach($shops as $arr){ ?>
                           <option value="<?=$arr['id'];?>"> <?=$arr['name'];?> </option>
                       <?php } ?>
                       </select>
                    </div>
                 </div>
            
                </div>
                <div class="modal-footer" style="text-align: center;">
                  <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
              </div>
 
              </form>
              
            </div>
        </div>
  <!-- end the model here -->


 </body>
</html>


<script>
// for open dialog popup
    $('select').change(function () {
        
     if ($(this).val() == "notification") {
            $('#dialog-modal').click();
        }
    });

</script>


<script>
// delete function
function deleteArea(id)
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
          url: "<?=base_url('admin/delete_data');?>",
          data: {'table': 'kuwait_areas', 'id': id}, // change this to send js object
          type: "POST",
          success: function(result){
            //alert(result);
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

