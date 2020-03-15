<!DOCTYPE html>
<html>
<?php include 'include/head.php'; ?>
<body class="hold-transition skin-blue sidebar-mini" id="home" style="height:100vh">
<div class="wrapper">
    
  
    
    
<?php 
$res = $this->db->query("SELECT count(id) AS id,create_time FROM `users`  GROUP BY DATE_FORMAT(create_time, '%Y-%m')")->result_array();

foreach($res AS $val){
 
 $date = date('Y-m', strtotime($val['create_time'])); 
 $users[] = ['y'=>$date, 'item1'=>$val['id']];

}

$users = json_encode($users);

$res = $this->db->query("SELECT count(id) AS id,create_time FROM `users` GROUP BY DATE_FORMAT(create_time, '%Y-%m')")->result_array();

foreach($res AS $val){
 
 $date = date('Y-m', strtotime($val['create_time'])); 
 $drivers[] = ['y'=>$date, 'item1'=>$val['id']];

}

$drivers = json_encode($drivers);

 include 'include/header.php'; ?>
  
  <link rel="stylesheet" href="<?=base_url('assets/admin/dist/css/styles.css');?>"> 

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
     <div class="box box-info">
          


            <div class="box-body cdG">

             <!-- <div class="col-sm-12">
                 
                   <a href="<?php //echo base_url('admin/view_page/addAdmin');?>"><button type="button" class=" btn  btn-infoicutom btn-lg cw">Create Sub Admin</button></a>
                 

              </div><!-- /.col-sm-12 -->
              
              <div class="col-sm-6 ">
                <h1 >Welcome to  <?= $this->db->get('setting')->row()->name;?></h1>
                <!--<p class="fontOSL fs22">We’ve assembled some links to get you started:</p>
                <h3 class="fw600">Get Started</h3>-->
              </div> <!-- /.col-sm-6 -->

              <div class="col-sm-6">
                 
                <?php if($admin->type=='ADMIN'){ ?>

                 <!--<div class="col-sm-6" onclick="location.href='<?=base_url('admin/view_page/userList');?>'" style="cursor:pointer">
                   <div class="panel panel-blue panel-widget ">
                      <div class="row no-padding">
                         <div class="col-sm-3 widget-left">
                            <i class="fa fa-user-plus" aria-hidden="true" style="font-size:3em"></i>
                         </div>
                         <div class="col-sm-9 widget-right">
                            <div class="large">
                              <?= $this->db->where("MONTH( create_time ) = MONTH( CURRENT_DATE( ) )")->get('users')->num_rows();?>
                            </div>
                            <div class="text-muted">New Users</div>
                         </div>
                      </div>
                   </div>
                </div>

                <div class="col-sm-6" onclick="location.href='<?=base_url('admin/view_page/userList');?>'" style="cursor:pointer">
                   <div class="panel panel-blue panel-widget ">
                      <div class="row no-padding">
                         <div class="col-sm-3 widget-left">
                            <i class="fa fa-user" aria-hidden="true" style="font-size:3em"></i>
                         </div>
                         <div class="col-sm-9 widget-right">
                            <div class="large">
                              <?= $this->db->get('users')->num_rows();?>
                            </div>
                            <div class="text-muted">All Users</div>
                         </div>
                      </div>
                   </div>
                </div>-->
               <?php } ?>
                             
             
              </div><!-- /.col-sm-6 -->

              

            </div>
            
          </div>
          
          
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-12">
                        <div class="social_activities">               
                            <a class="activities_s bluebox" href="<?=base_url('admin/view_page/userList')?>">
                                <div class="block_label">
                                    <span class="user_icon" style="    background: none;"> <i class="fa fa-user" aria-hidden="true"></i> </span><div class="clear"></div>
                                    Total Users
                                    <span><?= $this->db->get('users')->num_rows();?></span>

                                </div>
                            </a>                
                                  
                           <a class="activities_s pealbox" href="<?=base_url('admin/view_page/categoryList')?>">
                                <div class="block_label">
                                    <span class="seller_icon" style="    background: none;"> <i class="fa fa-list" aria-hidden="true"></i>  </span><div class="clear"></div>
                                    Total  Category
                                      <span> <?= $this->db->get('category')->num_rows();?></span>

                                </div>  
                            </a>  
                            
                            <!-- <a class="activities_s purplebox"  href="<?=base_url('admin/view_page/categoryList')?>">
                                <div class="block_label">
                                    <span class="seller_icon"></span><div class="clear"></div>
                                    Total  Like
                                    <span> <?= $this->db->get('like')->num_rows();?></span>
                                </div>  
                            </a> 
                            -->
                        <!--   <a class="activities_s bluebox" href="<?=base_url('admin/view_page/subCategorList')?>">
                                <div class="block_label">
                                    <span class="seller_icon"></span><div class="clear"></div>
                                    Total Comment
                                    <span> <?= $this->db->get('comment')->num_rows();?></span>
                                </div>  
                            </a> -->               
                                       
                
                        </div>
                </div>
        </div> 



        <!-- <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-12">
                        <div class="social_activities">               
                            <a class="activities_s bluebox" href="#qc_users.php">
                                <div class="block_label">
                                    <span class="user_icon"></span><div class="clear"></div>
                                    Total Request
                                    <span><?= $this->db->get('users')->num_rows();?></span>
                                </div>
                            </a>                
                                
                            <a class="activities_s purplebox" href="#qc_location_map.php">
                                <div class="block_label">
                                    <span class="store_icon"></span><div class="clear"></div>
                                    Pending Request
                                    <span><?= $this->db->get_where('users',['id'=>'1'])->num_rows();?></span>
                                </div>
                            </a>         
                           <a class="activities_s bluebox" href="#qc_coupon.php">
                                <div class="block_label">
                                    <span class="seller_icon"></span><div class="clear"></div>
                                    Cancel Request
                                    <span><?= $this->db->get_where('users',['id'=>'1'])->num_rows();?></span>
                                </div>  
                            </a>                
                                         
                          
                           <a class="activities_s pealbox" href="#qc_balance.php">
                                <div class="block_label">
                                    <span class="store_icon"></span><div class="clear"></div>
                                    Total Earning
                                    <span><?= $this->db->get('users')->num_rows();?></span>
                                </div>
                            </a>  
                
                        </div>
                </div>
        </div>  -->

      <div class="row">
         <?php /* <div class="col-sm-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Activity</h3>
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>               
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              
                <table class="table no-margin">
                 
                  <tbody>
                  <tr>  
                    <td style="border-top: 0px;"> <p class="box-title">Publishing Soon</p> </td>
                  </tr>                  
                  <tr class="clg">
                    <td>Today, 15:30</td>
                    <td><a>De kracht van sociale media</a></td>
                  </tr>
                  <tr class="clg">
                    <td>Tomorrow, 15:30</td>
                    <td><a>De kracht van sociale media</a></td>
                  </tr>
                  <tr>  <td> <p class="box-title">Recently Published</p> </td></tr>
                    <tr class="clg">
                    <td>Today, 15:30</td>
                    <td><a>De kracht van sociale media</a></td>
                  </tr>
                  <tr class="clg">
                    <td>Tomorrow, 15:30</td>
                    <td><a>De kracht van sociale media</a></td>
                  </tr>
                  <tr class="clg">
                    <td>Tomorrow, 15:30</td>
                    <td><a>De kracht van sociale media</a></td>
                  </tr>

                  </tbody>


                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        
            <!-- /.box-footer -->
          </div>
          </div> */?>

        <!--<div class="col-sm-6">
          <!-- AREA CHART -->
         <!-- <div class=" box box-info">
                    <div class="box-header with-border">
              <h3 class="box-title">Users Registraion Analytics </h3>
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
               
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="user-chart" style="height: 300px;"></div>
            </div>
         
          </div>
        </div><!--col-sm-6-->


        <!--<div class="col-sm-6">
          <!-- AREA CHART -->
          <!--<div class=" box box-info">
                    <div class="box-header with-border">
              <h3 class="box-title">Drivers Registraion Analytics </h3>
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
               
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="driver-chart" style="height: 300px;"></div>
            </div>
         
          </div>
        </div><!--col-sm-6-->
          <!-- /.box -->

        <!-- /.col (RIGHT) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include 'include/script.php' ?>
<script src="<?=base_url('assets/admin');?>/plugins/morris/morris.min.js"></script>

<script>
  $(function () {
    "use strict";

    // AREA CHART
    var area = new Morris.Area({
      element: 'user-chart',
      resize: true,
      data: <?=$users;?>,
      xkey: 'y',
      ykeys: ['item1'],
      labels: ['Users'],
      lineColors: ['#a0d0e0'],
      hideHover: 'auto'
    });

 
  });
</script>

<script>
  $(function () {
    "use strict";

    // AREA CHART
    var area = new Morris.Area({
      element: 'driver-chart',
      resize: true,
      data: <?=$drivers;?>,
      xkey: 'y',
      ykeys: ['item1'],
      labels: ['Drivers'],
      lineColors: ['#a0d0e0'],
      hideHover: 'auto'
    });

 
  });
</script>

</body>
</html>


