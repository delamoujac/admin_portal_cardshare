<?php

  if(!$this->session->userdata('admin')){
    redirect('admin');
  }
  $admin = $this->session->userdata('admin');
  
  $page = $this->uri->segment(3);

  if($page ==""){
      $page = $this->uri->segment(2);
  }

  if($admin->image==''){
     $admin->image = 'user.png';
  } 
  
?>
 <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?=base_url('admin/dashboard');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?=base_url('uploads/images/'.$setting['logo']);?>" width="50px"> </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
       <span class="sr-only">Toggle navigation</span>
     </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav ">


          <!-- Notifications Menu -->

          <!-- Tasks Menu --> 
                    <!-- User Account Menu -->
          <li class="dropdown user user-menu ">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle cdG" style="padding-left: 0;" data-toggle="dropdown">
             <span class="hidden-xs cdG fs18"><?= $admin->name; ?> <!-- <label class="clr">Admin</label> --> </span>
              <!-- The user image in the navbar-->
              <img src="<?=base_url('uploads/images/'.$admin->image);?>" class="user-image rMl0" >
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
             
            </a>
            <div class="dropdown-content">
             <a href="<?=base_url('admin/view_page/profile');?>"><i class="fa fa-user"></i> &nbsp; Profile</a>
             <a href="<?=base_url('admin/view_page/change_password');?>"><i class="fa fa-cog"></i> &nbsp; Change Password</a>
             <!--<a href="logout.php"><i class="fa fa-sign-out"></i> &nbsp; Logout</a>-->
          </div>
<!--             <ul class="dropdown-menu">
  The user image in the menu
  <li class="user-header">
    <img src="<?=base_url();?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

    <p>
      Welkon Admin
      <small>Member since Nov. 2012</small>
    </p>
  </li>
  Menu Body
  <li class="user-body">
    <div class="row">
      <div class="col-xs-4 text-center">
        <a href="#">Followers</a>
      </div>
      <div class="col-xs-4 text-center">
        <a href="#">Sales</a>
      </div>
      <div class="col-xs-4 text-center">
        <a href="#">Friends</a>
      </div>
    </div>
    /.row
  </li>
  Menu Footer
  <li class="user-footer">
    <div class="pull-left">
      <a href="#" class="btn btn-default btn-flat">Profile</a>
    </div>
    <div class="pull-right">
      <a href="#" class="btn btn-default btn-flat">Sign out</a>
    </div>
  </li>
</ul> -->
          </li>
          <li class="dropdown tasks-menu ">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle clg" data-toggle="dropdown">
            Help 
             
            </a>
          
          </li>
        <li class="dropdown tasks-menu ">
         <a  class="dropdown-toggle clg pl0 pr0" style="padding-left: 0; padding-right: 0;" data-toggle="dropdown">
           |   
            </a>
        </li>
          <li class="dropdown tasks-menu ">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle clg" data-toggle="dropdown">
           Contact
             
            </a>
          
          </li>

           <li class="dropdown tasks-menu ">
            <!-- Menu Toggle Button -->
            <a href="<?=base_url('admin/admin_logout');?>" class="dropdown-toggle " >
           <i class="fas fa-sign-in-alt"></i>
           <span class="clg">Log Out </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
    <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <section class="sidebar">

      <!-- Sidebar Menu -->
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
       
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview <?php if($page=='dashboard'){echo 'active'; }?>"><a href="<?=base_url('admin/dashboard');?>">Dashboard</a></li>        
        <?php

            $arr_menu = $this->db->query("SELECT * FROM sidebar_menu ORDER BY id ASC")->result_array();
            
            $roll = $admin->id;
            foreach($arr_menu as $list){ 

            $link = "#";
            if($list['link']!=''){
                $link = $list['link'];
            }
            
            $for_page = $this->db->query("SELECT * FROM sidebar_sub_menu WHERE menu_id = '".$list['id']."' AND link = '".$page."'")->result_array();
            
            $check = "";
            if($for_page){
                $check = $page;
            }
            
            $for_roll = $this->db->query("SELECT * FROM menu_permission WHERE menu_id = '".$list['id']."' AND roll = '$roll'")->result_array();
            if($list['id']==3 && $admin->type=='USER'){
              $for_roll = true;
            }
            
            if($for_roll || $roll == 1 || $list['id']==10){
        ?>
        
        <li class="treeview <?php if($page==$list['link'] || $page==$check){echo 'active';}?>">
          <a href="<?=base_url('admin/view_page/'.$link);?>" att=""><?=$list['favicon'];?> &nbsp; <?=$list['name'];?></a>
          <?php if($list['link']==''){ 
                $arr_submenu = $this->db->query("SELECT * FROM sidebar_sub_menu WHERE menu_id = '".$list['id']."' ORDER BY id ASC")->result_array();
                
          ?>
          <ul class="treeview-menu" >
                <?php foreach($arr_submenu as $lists){   
                        $for_roll = $this->db->query("SELECT * FROM menu_permission WHERE menu_id = '".$list['id']."' AND sub_menu_id = '".$lists['id']."'  AND roll = '$roll'")->result_array();

                        if($lists['id']==4 && $admin->type=='USER'){
                           $for_roll = true;
                         }
                        
                        if($for_roll || $roll == 1 || $lists['id'] == 20 || $lists['id'] == 21){
                    ?>
                    <li class="<?php if($page==$lists['link']){echo 'active';}?>"><a href="<?=base_url('admin/view_page/'.$lists['link']);?>"><?=$lists['name'];?></a></li>
                <?php } } ?>
          </ul>
          <?php } ?>
        </li>
       
        
        <?php } } 

        ?>
       

       <?php /* <li class="treeview <?php if($page=='adminList' || $page=='AdNwAdmin'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-users" aria-hidden="true"></i> &nbsp; Sub Admin</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='adminList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/adminList');?>">All Admins</a></li>
            <li class="<?php if($page=='AdNwAdmin'){echo 'active';}?>"><a href="#AdNwAdmin.php">Add New</a></li>
          </ul>
        </li>

        <li class="treeview <?php if($page=='userList' || $page=='AdNwUser'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-user" aria-hidden="true"></i> Users</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='userList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/userList');?>">All Users</a></li>
            <!--<li class="<?php if($page=='userList'){echo 'active';}?>"><a href="#AdNwUser.php">Add New</a></li>-->
          </ul>
        </li>

        

        <li class="treeview <?php if($page=='paymentList' || $page=='orderList'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-credit-card-alt" aria-hidden="true"></i> &nbsp; Purchase</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='paymentList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/paymentList');?>">Payments</a></li>
            <li class="<?php if($page=='orderList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/orderList');?>">Orders</a></li>            
          </ul>
        </li>        

        <li class="treeview <?php if($page=='restaurantList' || $page=='addRestaurant' || $page=='restaurantCat' || $page=='restaurantSubCat' || $page=='restaurantReview' || $page=='addRestaurantReview'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-cutlery" aria-hidden="true"></i> Restaurant</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='restaurantList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/restaurantList');?>">All Restaurants</a></li>
           <li class="<?php if($page=='restaurantOffer'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/restaurantOffer');?>">Restaurants Offer</a></li>
            <li class="<?php if($page=='restaurantCat'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/restaurantCat');?>">Restaurants Category</a></li>
           <li class="<?php if($page=='restaurantSubCat'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/restaurantSubCat');?>">Restaurants Product</a></li>
           <li class="<?php if($page=='restaurantReview'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/restaurantReview');?>">Restaurants Reviews</a></li>
          </ul>
        </li>

       


       <li class="treeview <?php if($page=='shopList' || $page=='addShop' || $page=='shopCat' || $page=='shopSubCat' || $page=='shopReview' || $page=='addShopReview'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-shopping-basket" aria-hidden="true"></i> &nbsp; Shop</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='shopList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/shopList');?>">All Shops</a></li>
            <li class="<?php if($page=='shopCat'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/shopCat');?>">Shops Category</a></li>
            <li class="<?php if($page=='shopSubCat'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/shopSubCat');?>">Shops Product</a></li>
            <li class="<?php if($page=='shopReview'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/shopReview');?>">Shop Reviews</a></li>
          </ul>
        </li>


        <li class="treeview <?php if($page=='promoList' || $page=='addPromo'){echo 'active';}?>">
          <a href="#" att=""><i class="fa fa-product-hunt" aria-hidden="true"></i> &nbsp; Promo Codes</a>
          <ul class="treeview-menu" >
            <li class="<?php if($page=='promoList'){echo 'active';}?>"><a href="<?=base_url('admin/view_page/promoList');?>">Promo Code List</a></li>                        
          </ul>
        </li> 
         */ ?>

       
        
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

