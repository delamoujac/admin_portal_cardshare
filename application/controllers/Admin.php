<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller

{
  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */ function upt_user_stts()
  {
      $status = $this->input->post('status');
      $id = $this->input->post('id');
      $this->admin_common_model->update_data("users",['status'=>$status],['id'=>$id]);
      
  }
  function __construct()
  {
                parent::__construct();
                $this->load->helper('url');
                $this->load->model('admin/authentication_model');                
                $this->load->model('admin/admin_common_model');
                $this->load->library(array('form_validation','session'));
                $this->load->helper('string');
                $this->load->model('Webservice_model');
                error_reporting(0);
                 define("SITE_EMAIL",'info@cskwt.com'); 
                
  }

  public  function index()
  {
    $this->load->view('admin/index');
  }

  public  function dashboard()
  {
    $this->load->view('admin/dashboard');
    
  }

public  function status($id)
  {
     $status = $this->input->get_post('status', TRUE);

     $this->admin_common_model->update_data('users',['status'=>$status],['id'=>$id]);
 
    if($status !='Active'){
            redirect('admin/view_page/userList');
      }
 else {

            redirect('admin/view_page/userList');
         }
  }
public function upload_user()
{  

 
 if($_FILES['name']['type']=="text/csv")
 {
         $file = $_FILES['name']['tmp_name']; 
         $handle = fopen($file, 'r');
         $c = 0;
         while(($col = fgetcsv($handle, 1000, ',')) !== false)
         {  
                  if($c!=0){  
                 print_r($col);
                        $col[0] = str_replace("'", "", $col[0]);

                        
               $arr_data = array('name' => $col[1] 

);  print_r($arr_data);

                 $fetch = $this->webservice_model->insert_data('kuwait_areas', $arr_data);
               //  echo $this->db->last_query();

                     }else{ $c++; }
             }
         echo "success";
          $this->session->set_flashdata('msg','CSV file data import successfully');
         // redirect("admin/view_page/productList");


 }else{
          echo "unsuccess";
          $this->session->set_flashdata('msg','The file you are trying to upload is invalid format');
          //redirect("admin/view_page/productList");
       }


}
// end class echo $this->db->last_query(); die;
///////////////////

 

  public  function view_page($page)
  {
     $this->load->view('admin/'.$page);
  }
  

  public  function go()
  {
    
      $result = $this->authentication_model->admin_login();
      if(!$result) {
        $msg = array(
           'msg' =>'<strong>Error!</strong> Invalid Username and Password. Log in failed.','res' => 0
              );
                             $this->session->set_userdata($msg);
                             redirect('admin');
      }
      else {
        redirect('admin/dashboard', $message);
      }
    
  }  

  

  public function forgot_password()
    {
      $email = $this->input->post('email', TRUE);
      $arr_login = ['email' => $email];// print_r($arr_login);die;

     // $login = $this->admin_common_model->fetch_recordbyid('admin', $arr_login);//print_r($login);die; //echo $this->db->last_query();die;
       $login = $this->Webservice_model->get_where('admin', $arr_login);//echo $this->db->last_query();print_r($login);die;

      if ($login)
      { 
        $pass = random_string('alnum', 6);

        $to = $email;
        $subject = "Forgot Password"; //echo $email;die;
        $body = "<div style='max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;'>
        <header style='color: #fff; width: 100%;'>
           <img alt='' src='".base_url('uploads/images/logo.png')."' width ='120' height='120'/>
        </header>
        
        <div style='margin-top: 10px; padding-right: 10px; 
      padding-left: 125px;
      padding-bottom: 20px;'>
          <hr>
          <h3 style='color: #232F3F;'>Hello ".$login->name.",</h3>
          <p>You have requested a new password for your  account.</p>
          <p>Your new password is <span style='background:#2196F3;color:white;padding:0px 5px'>".$pass."</span></p>
          <hr>
          
            <p>Warm Regards<br>Manargiftstore<br>Support Team</p>
            
          </div>
        </div>

    </div>";
//echo $body;die;
       

      //  $headers = "From: info@technorizen.com" . "\r\n";
      //  $headers.= "MIME-Version: 1.0" . "\r\n";
      //  $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";



          //mail($to, $subject, $body, $headers);
          $headers = "From: ". SITE_EMAIL . "\r\n";
$headers.= "MIME-Version: 1.0" . "\r\n";
$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
//echo $headers ; die;
        //mail($to, $subject, $body, $headers);
file_get_contents("http://technorizen.co.in/mail.php?to=".urlencode($to)."&subject=".urlencode($subject)."&body=".urlencode($body)."&headers=".urlencode($headers));


          $this->admin_common_model->update_data('admin',['password'=>$pass],$arr_login);
        
      }
      else
      { 
          $msg = array(
           'msg' =>'<strong>Error!</strong> This email is not registered to sniff.','res' => 0
              );
                             $this->session->set_userdata($msg);
        // redirect('admin/forgot');
      }

        $msg = array(
              'success' =>'<strong>Success!</strong> Your new password has been send your registered email address.'
              );
                             $this->session->set_flashdata($msg);
        redirect('admin/view_page/forgotpassword');
      
    }
    
    function update_password()
  {
      $password = $_POST['password'];
      $id = $_POST['id'];
      $this->admin_common_model->update_data("users",['password'=>$password],['id'=>$id]);
  }



  public function admin_logout(){
        $this->session->unset_userdata('admin');
        return redirect('admin');   
  }

  public function delete_data(){
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $this->admin_common_model->delete_data($table,['id'=>$id]);
  }
  
   public function delete_data1(){
        $table = $this->input->post('table');
        $id = $this->input->post('product_id');
        $this->admin_common_model->delete_data($table,['product_id'=>$id]);
  }

  public function delete_data2(){
        $table = $this->input->post('table');
        $id = $this->input->post('fav_user_id');
        $this->admin_common_model->delete_data($table,['fav_user_id'=>$id]);
  }
  
   public function delete_image(){
        $table = $this->input->post('table');
        $id = $this->input->post('product_id');
        $this->admin_common_model->delete_data($table,['product_id'=>$id]);
  }
 
  
   public function create_owner(){
       
       $user_id = $this->input->post('user_id');
       $shop_id = $this->input->post('shop_id');
       if($shop_id!=''){
         $this->admin_common_model->update_data('shop',['user_id'=>$user_id],['id'=>$shop_id]);
       }
       return redirect('admin/view_page/userList');   
  }

  function updateStatus()
  {
      $status = $_POST['status'];
      $id = $_POST['id'];
      $this->admin_common_model->update_data("place_order",['status'=>$status],['id'=>$id]);
      return redirect('admin/view_page/orderList');
  }
  
  function update_status()
  {
      $status = $_POST['status'];
      $id = $_POST['id'];
      $this->admin_common_model->update_data("users",['status'=>$status],['id'=>$id]);
     // echo $this->db->last_query();
  }


  function upt_cat()
  {
      $status = $this->input->post('status');
      $id = $this->input->post('id');
      $this->admin_common_model->update_data("category",['status'=>$status],['id'=>$id]);
      
  }

  function upt_sub_cat()
  {
      $status = $this->input->post('status');
      $id = $this->input->post('id');
      $this->admin_common_model->update_data("sub_category",['status'=>$status],['id'=>$id]);
      
  }
  
   function upt_user_stt()
  {
      $status = $this->input->post('status');
      $id = $this->input->post('id');
      $this->admin_common_model->update_data("place_order",['status'=>$status],['id'=>$id]);
      header("refresh: 3;");
  }


// end class
}
