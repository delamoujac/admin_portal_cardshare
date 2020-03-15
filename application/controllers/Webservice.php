<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
// define("STRIPE_KEY", 'sk_test_IyGzwVbreQw8xzmQuI8bb5ND00ioWK03Ro');
define("STRIPE_KEY", 'sk_live_UO2dAoiWzADJ1FhjzZJKuI5W00tWZovqB5');
error_reporting('0');


require_once  __DIR__ . '/vendor/stripe/stripe-php/init.php';
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

class Webservice extends CI_Controller{

  public function __construct(){
    parent:: __construct();
    $this->load->model('Webservice_model');
    $this->load->library(['form_validation','email']); 
    $this->load->library('email');
    
    
    
  // define("SITE_URL",'http://yashtechsolutions.com/card_share/'); 
   define("SITE_URL",'https:/galaapp.com.au/'); 
  //  define("SITE_URL",'https://jamesrobert.000webhostapp.com/card_share/'); 
 
   define("SITE_EMAIL",'admin@getgala.com.au');  
    $this->load->helper('string');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Headers: GET,POST,DELETE,PUT");
    header('Access-Control-Allow-Headers: Accept-Language,Content-Language,Content-Type');
    // {'Content-Type': 'application/x-www-form-urlencoded'}
          header('Access-Control-Allow-Headers: Accept-Language,Content-Language,Content-Type'); 
          header('Content-type:application/x-www-form-urlencoded');
    }

  public function index(){

  }

  public function login(){
      $email = $this->input->get_post('email', TRUE);
      $password = md5($this->input->get_post('password', TRUE));
      $device_id = $this->input->get_post('uid', TRUE);

      $where = "password = '$password' AND email='$email'";
      $login = $this->Webservice_model->get_where('users',$where);

      if ($login) {
                
                $arr_login = ['userid' =>$login[0]['id']];
                $device_info = $this->Webservice_model->get_where('user_device',$arr_login);

                if ($device_info){              
                  $arr_data = [ 'device_id'=>  $device_id ];
                  $res = $this->Webservice_model->update_data('user_device',$arr_data,$arr_login);
                }else{
                  $arr_data = [ 'device_id'=>  $device_id,'userid' =>$login[0]['id']] ;

                  $id = $this->Webservice_model->insert_data('user_device',$arr_data);
                  if ($id>0) $res=true;
                  else $res=false;
                }

                 $login[0]['image']=SITE_URL.'uploads/images/'.$login[0]['image'];
                  $ressult['result']=$login[0];
                  $ressult['device_flag']=$res;
                  $ressult['message']='successfull';
                  $ressult['status']='1';
                  $json = $ressult;            
      }else{        
                  $ressult['result']='Your have entered wrong email & password';
                  $ressult['message']='unsuccessfull';
                  $ressult['status']='0';
                  $json = $ressult;       
      }
    
    header('Content-type:application/json');
    echo json_encode($json);
  }
  
  public function signup(){
    $arr_data = [
      'first_name'=>$this->input->get_post('first_name'),
      'last_name'=>$this->input->get_post('last_name'),
      'email'=>$this->input->get_post('email'),
      'mobile'=>$this->input->get_post('mobile'),
      'gender'=>$this->input->get_post('gender'),
      'dob'=>$this->input->get_post('dob'),
      'password'=>md5($this->input->get_post('password')),
      'create_time'=>date("Y-m-d H:i:s")
     ];
     $arr_get = ['email' => $arr_data['email']];
     $login = $this->Webservice_model->get_where('users',$arr_get);
    
     if ($login) {    
        $ressult['result']='Email already exist';
        $ressult['message']='unsuccessfull';
        $ressult['status']='0';
        $json = $ressult;
                          
        header('Content-type:application/json');
        echo json_encode($json);
        die;
    }     
      if (isset($_FILES['image']))
               {
         $n = rand(0, 100000);
         $img = "USER_IMG_" . $n . '.png';
         move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $img);
         $arr_data['image'] = $img;        
           } else{
          $arr_data['image'] = 'nouser.png'; 
          }
        $id = $this->Webservice_model->insert_data('users',$arr_data);

      if ($id=="") {
        $json = ['result'=>'unsuccessfull','status'=>'0','message'=>'data not found'];
      }else{

        $arr_gets = ['id'=>$id];
        $login = $this->Webservice_model->get_where('users',$arr_gets);       
        $login[0]['image']=SITE_URL.'uploads/images/'.$login[0]['image'];
        $ressult['result']=$login[0];
        $ressult['message']='Thank you for register';
        $ressult['status']='1';
        $json = $ressult;
      }

      header('Content-type:application/json');
      echo json_encode($json);
}

/************* forgot_password function *************/

public function forgot_password()
{
  $email = $this->input->get_post('email', TRUE); //echo $email;die;
  $arr_login = ['email' => $email];
  $login = $this->Webservice_model->get_where('users', $arr_login);
  
  if ($login)
  {
        $token=sha1($email);

        //$aa = $login[0]['id']; //echo $aa;die;
        $update_token = $this->Webservice_model->update_token($email,$token);

        $pass = SITE_URL."admin/view_page/newPassword/$token";

        $to=$email;
        $subject="GALA - Forgot Password";
        $message = "<div style='max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;'>
            <header style='color: #fff; width: 100%;'>
            <meta http-equiv='Content-Type' content='text/html charset=utf-8'>
            <img alt='' src='".SITE_URL."/uploads/images/logo.png' width ='120' height='120'/>
            </header>
                  <div style='margin-top: 10px; padding-right: 10px;s padding-left: 55px; padding-bottom: 20px;'>
              <hr>
              <h3 style='color: #232F3F;'>Hello " . $login[0]['first_name'] . ",</h3>
              <p>You have requested a new password for your GALA account.</p>
              <p>Reset your password is <a href='".$pass."' >Click Here</a> </p> 
              <hr>
                <p>Warm Regards<br />GALA<br />Support Team</p>
              </div>
          </div>
        </div>";
        $mail_header="MIME-Version: 1.0 ";
        $mail_header .= "From: ". SITE_EMAIL . "\r\n";
        $mail_header .= "Content-type: text/html;charset=utf-8 ";
        $mail_header .= "X-Priority: 3";
        $mail_header .= "X-Mailer: smail-PHP ".phpversion();

         $retval= mail($to, $subject, $message, $mail_header);
         $retval=true;

          if($retval==true ) {
            $ressult['result'] = "Success! Check your Email for new password.";
            $ressult['message'] = 'successfull';
            $ressult['link']=  $pass ;
            $ressult['status'] = '1';
            $json = $ressult;
          }else{
            $ressult['result'] = 'Failed to send Email';
            $ressult['message'] = 'unsuccessfull';
            $ressult['status'] = '-1';
            $json = $ressult;
          }
    } else    {
        $ressult['result'] = 'Email not exist';
        $ressult['message'] = 'unsuccessfull';
        $ressult['status'] = '0';
        $json = $ressult;
    }

  header('Content-type: application/json');
  echo json_encode($json);
}
  
public function reset_password() {
  $password=$this->input->post('password');
  $token=$this->input->post('token');
  $update_flag = $this->Webservice_model->change_password($token,md5($password));
  
  if ($update_flag){
    $result['message']='success';
    $result['status']='1';
  } else{
    $result['message']='error';
    $result['status']='-1';
  }             
  
  header('Content-type: application/json');
  echo json_encode($result);

}
public  function view_welcomepage()
{
   $this->load->view('welcome');
 //  $this->load->view('homepage', $data);

}

 /************* get_profile function *************/
  public function get_profile(){
  
    $arr_get = ['id'=>$this->input->get_post('user_id')];
  
    $login = $this->Webservice_model->get_where('users',$arr_get);
  
    if($login) {
        $login[0]['file_name']=$login[0]['image'];

        $login[0]['image']=SITE_URL.'uploads/images/'.$login[0]['image'];

        $ressult['result']=$login[0];
        $ressult['message']='successfull';
        $ressult['status']='1';
        $json = $ressult;
  
      }else{
    
          $json = ['result'=>'unsuccessfull','status'=>'0','message'=>'Data Not Found'];
  
          }
  
          header('Content-type: application/json');
          echo json_encode($json);
  }

  public function get_profile_phone(){
  
    $phone=strval($this->input->get_post('phone'));
    $arr_get = ['mobile'=>$phone];
  
    $login = $this->Webservice_model->get_where('users',$arr_get);

    if($login) {
        $login[0]['file_name']=$login[0]['image'];

        $login[0]['image']=SITE_URL.'uploads/images/'.$login[0]['image'];

        $ressult['result']=$login[0];
        $ressult['message']='successfull';
        $ressult['status']='1';
        $json = $ressult;
  
      }else{
    
          $json = ['result'=>'unsuccessfull','status'=>'0','message'=>'Data Not Found'];
  
          }
  
          header('Content-type: application/json');
          echo json_encode($json);
  }



/************* update_profile function *************/
public function update_profile(){
  
  $arr_get = ['id'=>$this->input->get_post('user_id')];

  $login = $this->Webservice_model->get_where('users',$arr_get);

  if ($login[0]['id'] == "")
  {
    $ressult['result']='User Not Found';
    $ressult['message']='unsuccessfull';
    $ressult['status']='0';
    $json = $ressult;

    header('Content-type:application/json');
    echo json_encode($json);
    die;
  }


 $arr_data = [
            'first_name'=>$this->input->get_post('first_name'),
            'last_name'=>$this->input->get_post('last_name'),
            'email'=>$this->input->get_post('email'),
            'mobile'=>$this->input->get_post('mobile'),
            'gender'=>$this->input->get_post('gender'),
            'dob'=>$this->input->get_post('dob'),
            'image'=>$this->input->get_post('image')
           ];
/*
  if (isset($_FILES['image']))
  {   
    $ext = end(explode(".",$_FILES['image']['name']));
    $img = "USER_IMG_" . date('YmdHis') . '.'.$ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/" . $img);
    $arr_data['image'] = $img;        
  }

*/
  $res = $this->Webservice_model->update_data('users',$arr_data,$arr_get);

  if ($res)  {
    $data[0] = $this->Webservice_model->get_where('users',$arr_get)[0];
    $data[0]['image'] = SITE_URL.'uploads/images/'.$data[0]['image'];        

    $ressult['result']=$data[0];
    $ressult['message']='successfull';
    $ressult['status']='1';
    $json = $ressult;
  }
  else  {
    $ressult['result']='Update Fail';
    $ressult['message']='unsuccessfull';
    $ressult['status']='-1';
    $json = $ressult;
  }

  header('Content-type: application/json');
  echo json_encode($json);
}


/*************  get_category *************/
public function get_category()
{
    
    $categoryList = $this->Webservice_model->get_all('category');
   
    if ($categoryList)
    {
        foreach($categoryList as $val){
      
            $img['image']=SITE_URL.'uploads/images/'.$img['image'];
            $data[] = $val;
        }
        $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 
    }
    else
    {
        $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
    }

    header('Content-type: application/json');
    echo json_encode($json);
}


  /*************  get_sub_category *************/
  
public function get_sub_category()
{
    $category= $this->input->get_post('category_id');
    $subcategoryList = $this->Webservice_model->get_where('sub_category' , ['category_id'=>$category]);
   
    if ($subcategoryList)
    {
        foreach($subcategoryList as $val)
        {
        
            // $categoryList = $this->Webservice_model->get_where('category' , ['id'=>$val['category_id']]);  
            // $val['category_name']= $categoryList[0]['category_name'];
            $val['image'] = SITE_URL.'uploads/images/'.$val['image'];   
            $data[] = $val;
    
        }
        $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 
    }
    else
    {
        $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
    }

    header('Content-type: application/json');
    echo json_encode($json);
}

/*===========  get category name =============*/

public function get_category_name()
{
    $id = $this->input->get_post('category_id');
    $categoryList = $this->Webservice_model->get_where('category' , ['id'=>$id]);
    if ($categoryList) {
        $val['cat_name'] = $categoryList[0]['category_name'];
        $val['status'] = 1;
    }
    else {
        $val['error'] = "Couldn't find the category name";
        $val['status'] = 0;
    }
    header('Content-type: application/json');
    echo json_encode($val);
}

public function get_card_detail()
{
  $category= $this->input->get_post('card_kind');
  $subcategoryList = $this->Webservice_model->get_where_like('sub_category' , ['sub_cat_name'=>$category]);
   
  if ($subcategoryList)
  {
    foreach($subcategoryList as $val)
    {
        
     $categoryList = $this->Webservice_model->get_where('category' , ['id'=>$val['category_id']]);  
       $val['category_name']= $categoryList[0]['category_name'];
           $val['image'] = SITE_URL.'uploads/images/'.$val['image'];   
     $data[] = $val;
    
    }
         $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 
      }
           else
       {
    $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
      }

          header('Content-type: application/json');
          echo json_encode($json);
}

  
public function media_upload(){

  $kind=$this->input->get_post('kind'); // 1: profile , 2: card

  if ($kind==1)
   $upload_dir = "uploads/images/";
  else if($kind==2)
    $upload_dir = "uploads/card/";
    else 
      $upload_dir = "uploads/";


  $datetime = date("Y-m-d h:i:s");
  $timestamp = strtotime($datetime);

  if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, TRUE);
  }

  $config['upload_path'] =  $upload_dir;
  $config['allowed_types'] = '*';
  $config['overwrite'] = true;

  if (isset($_FILES['mediafile'])){
      $config['file_name'] =  $timestamp."-".$_FILES['mediafile']['name'];
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      if($this->upload->do_upload('mediafile')){
          $mediafile=$this->upload->data();
          $media_data['file_name']=$mediafile['file_name'] ;        
          $media_data['file_url'] =  SITE_URL.  $upload_dir .$mediafile['file_name'];
          $ressult['result']=$media_data;
          $ressult['message']='success';
          $ressult['status']='1';
      }else{
          $ressult['message']='fail upload';
          $ressult['status']='-1';
      }
  }else{
      $media_data['file_name']='';
      $ressult['message']='no file';
      $ressult['status']='0';
  }

  $json = $ressult;
  header('Content-type:application/json');
  echo json_encode($json);

}

public function stripePayment(){
//    require_once('application/libraries/stripe-php/init.php');
//    require_once('application/libraries/stripe-php/init.php');

    $stripeToken = $this->input->get_post('token');
    $amount = $this->input->get_post('amount');
    $email = $this->input->get_post('email');
    $user_id = $this->input->get_post('user_id');
    $card_number = $this->input->get_post('card_number');
    if($stripeToken){
//        \Stripe\Stripe::setApiKey('sk_test_IblRHJQHrblVBGkmWHYxfi0w00ulab2t8m');
         \Stripe\Stripe::setApiKey('sk_live_UO2dAoiWzADJ1FhjzZJKuI5W00tWZovqB5');

        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source' => $stripeToken
        ));

        $orderID = strtoupper(str_replace('.','', uniqid('',true)));
        $charge = \Stripe\Charge::create(array(
            'customer' =>$customer->id,
            'amount' => $amount * 100,
            'currency' => 'aud',
            'description' => 'gift',
            'metadata' => array(
                'order_id' => $orderID
            )
        ));
        $chargeJson =  $charge->jsonSerialize();
        $now = date("Y-m-d H:i:s");

        if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] ==1 && $chargeJson['captured'] == 1){
            $transactionID = $chargeJson['balance_transaction'];
            $paidAmount = $chargeJson['amount']/100;
            $paidCurrency = $chargeJson['currency'];
            $payment_status = $chargeJson['status'];
            $card_details =[
                'card_number' => $card_number,
                'expiration_month' => $chargeJson['payment_method_details']['exp_month'],
                'expiration_year' => $chargeJson['payment_method_details']['exp_year'],
                'cvc_number' => $chargeJson['payment_method_details']['exp_year']
            ];

            $transaction = [
                'user_id' => $user_id,
                'transactionID' => $transactionID,
                'type' => $chargeJson['payment_method'],
                'amount' => $paidAmount,
                'transaction_type' => 'Stripe',
                'description' => $chargeJson['description'],
                'date_time' => $now,
                'status' => $payment_status
            ];
            $this->Webservice_model->insert_data('transaction',$transaction);

            $payment = [
                'sender_id' => $this->input->get_post('sender_id'),
                'receiver_id' => $this->input->get_post('receiver_id'),
                'card_details_id' => $this->input->get_post('card_id'),
                'amount' => $paidAmount,
                'payment_type' => 'Stripe',
                'date_time' => $now,
                'status' => $payment_status
            ];

            $this->Webservice_model->insert_data('payment',$payment);

            if($payment_status == 'succeeded'){
                $orderStatus = 'success';
                $statusMsg = '';
            }
            else{
                $statusMsg = 'Your Payment has Failed!';
            }
        }
    }else{
        $statusMsg = "Error on form submission, please try again.";
    }
    header('Content-type:application/json');
    echo json_encode($statusMsg);
}

public function paypalPayment(){

  $now = date("Y-m-d H:i:s");

    $transaction = [
        'user_id' => $this->input->get_post('user_id'),
        'transactionID' => $this->input->get_post('transaction_id'),
        'type' => $this->input->get_post('response_type'),
        'amount' => $this->input->get_post('amount'),
        'transaction_type' => 'Paypal',
        'description' => $this->input->get_post('description'),
        'date_time' => $now,
        'status' => $this->input->get_post('payment_state')
    ];
    $this->Webservice_model->insert_data('transaction',$transaction);

    $payment = [
        'sender_id' => $this->input->get_post('sender_id'),
        'receiver_id' => $this->input->get_post('receiver_id'),
        'card_details_id' => $this->input->get_post('card_id'),
        'amount' => $this->input->get_post('amount'),
        'payment_type' => 'Paypal',
        'date_time' => $now,
        'status' => $this->input->get_post('payment_state')
    ];

    $this->Webservice_model->insert_data('payment',$payment);

    $statusMsg = "";

    echo json_encode($statusMsg);
}


public function add_card_details(){
 
      $arr_data = [
        'sender_id'=>$this->input->get_post('sender_id'),
        'receiver_id'=>$this->input->get_post('receiver_id'),
        'message'=>$this->input->get_post('message'),
        'gift_amount'=>$this->input->get_post('gift_amount'),
        'sender_email'=>$this->input->get_post('sender_email'),
        'receiver_email'=>$this->input->get_post('receiver_email'),
        'card_id'=>$this->input->get_post('card_id'),
        'image1'=>$this->input->get_post('image1'),
        'image2'=>$this->input->get_post('image2'),
        'video'=>$this->input->get_post('video')
      ];
      
    
    if ($this->input->get_post('first_name')) {
      $first_name = $this->input->get_post('first_name');
    } else {
      $first_name = "";
    }

    if ($this->input->get_post('last_name')) {
      $last_name = $this->input->get_post('last_name');
    } else {
      $last_name = "";
    }
          
          
    $resultId = $this->Webservice_model->insert_data('card_details',$arr_data);
    
    if ($resultId=="") {
        $json = ['result'=>'unsuccessfull','status'=>0,'message'=>'data not found'];
      }else{
        $arr_gets = ['id'=>$resultId];
        $post_details = $this->Webservice_model->get_where('card_details',$arr_gets); 
        if ($post_details[0]['image1'] !='')
            $post_details[0]['image1'] = SITE_URL.'uploads/images/'.$post_details[0]['image1'];        
        if ($post_details[0]['image2'] !='')
            $post_details[0]['image2'] = SITE_URL.'uploads/images/'.$post_details[0]['image2']; 
        if ($post_details[0]['video'] !='')
            $post_details[0]['video'] = SITE_URL.'uploads/images/'.$post_details[0]['video']; 

  
        //// send notification
         if ($post_details[0]['receiver_id'] >0 ){

          $arr_where= ['userid' =>$post_details[0]['receiver_id']];
          $device_info = $this->Webservice_model->get_where('user_device',$arr_where);
          //$ressult['msg']=  $device_info[0]['device_id'];
          $msg="You received a new card through GALA. Open the app to see who sent it!";
          $ressult['alarm_result']= $this->send_notification($msg,$device_info[0]['device_id']);

         } else if ($post_details[0]['receiver_id'] ==0 ){
           $phone=$post_details[0]['receiver_email'];
           $sendername=$post_details[0]['sender_name'];
        //   $msg='You received a new card from '.$sendername.' through the GALA app! To collect your gift, download the GALA app and sign up with this phone number. Download now: https://onelink.to/dye9tj';
           $msg = "You received a new card from " .$first_name . " " .$last_name ." through the GALA app! To collect your gift, download the GALA app and sign up with this phone number. Download now: https://onelink.to/dye9tj";
           $ressult['alarm_result']=  $this->send_sms($msg,$phone);
         }

        //////
        $ressult['result']=$post_details[0];
        $ressult['message']='successfull';
        $ressult['status']='1';
        $json = $ressult;


      }

      header('Content-type:application/json');
      echo json_encode($json);
}  

public function send_sms($msg,$phone){

  
  // Your Account SID and Auth Token from twilio.com/console
   $account_sid = 'AC6a6a49d2551ac8802c19db8ba6570e06';
   $auth_token = '9ac082c4db7a7409875ffb7fa3ea016e';
  
  // A Twilio number you own with SMS capabilities
   $twilio_number = "+19382382852";
 
  $client = new Client($account_sid, $auth_token);
  $message=$client->messages->create(
      // Where to send a text message (your cell phone?)
      $phone,
      array(
          'from' => $twilio_number,
          'body' => $msg
      )
  );
  if ($message->sid)  return 'success';
  else return 'fail';
}

public function send_notification($msg,$player_id){
  $app_id="ad8452ad-32d5-4492-b132-aa8b62ad08e3";// from onesignal
  $content = array(
    "en" => $msg
  );
  $fields = array(
    'app_id' => $app_id,
    'contents' => $content,
    //'included_segments' => array('Subscribed Users')
    'include_player_ids' => array($player_id)
 );
 $fields = json_encode($fields);
// $result = $this->send_notification($fields);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
      'Authorization: Basic MWEzOWE0YTktY2UwOS00OTA0LTkwOWUtOTYxYmY3NmRhOWEx'));// from onesignal rest api key

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}



public function get_allsentcard(){
  $arr_get = ['sender_id'=>$this->input->get_post('sender_id')];

  $cards = $this->Webservice_model->get_where('card_details',$arr_get);    

  if ($cards) {

          foreach($cards as $val){    
            $arr_get1 = ['id'=>$val['card_id']];
            $sub_category = $this->Webservice_model->get_where('sub_category',$arr_get1);    
            
            if( $sub_category[0]['image'] !='')
            $sub_category[0]['image'] = SITE_URL.'uploads/images/'.$sub_category[0]['image'];
            $val['sub_category']= $sub_category [0];  


            $arr_get2 = ['id'=>$val['receiver_id']];
            $user = $this->Webservice_model->get_where('users',$arr_get2);
            if($user)         
                $user[0]['image']=SITE_URL.'uploads/images/'.$user[0]['image'];
             $val['user']= $user [0];  


              if( $val['image1'] !='')
                $val['image1'] = SITE_URL.'uploads/images/'.$val['image1'];   
              if( $val['image2'] !='')
                $val['image2'] = SITE_URL.'uploads/images/'.$val['image2'];
              if( $val['video'] !='')
                 $val['video'] = SITE_URL.'uploads/images/'.$val['video'];
             $data[] = $val;
         }
      $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 

  }else {
      $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
 }

      header('Content-type: application/json');
      echo json_encode($json);
}

public function get_allreceivecard(){
  $phone=strval($this->input->get_post('phone'));
  $arr_get = ['receiver_email'=>$phone];

  $cards = $this->Webservice_model->get_where('card_details',$arr_get);    
  if ($cards) {
          foreach($cards as $val){    
            $arr_get1 = ['id'=>$val['card_id']];
            $sub_category = $this->Webservice_model->get_where('sub_category',$arr_get1);    
            if( $sub_category[0]['image'] !='')
            $sub_category[0]['image'] = SITE_URL.'uploads/images/'.$sub_category[0]['image'];
            $val['sub_category']= $sub_category [0];            

            $arr_get2 = ['id'=>$val['sender_id']];
            $user = $this->Webservice_model->get_where('users',$arr_get2);
            if($user)         
                $user[0]['image']=SITE_URL.'uploads/images/'.$user[0]['image'];
             $val['user']= $user [0];  
             



              if( $val['image1'] !='')
                $val['image1'] = SITE_URL.'uploads/images/'.$val['image1'];   
              if( $val['image2'] !='')
                $val['image2'] = SITE_URL.'uploads/images/'.$val['image2'];
              if( $val['video'] !='')
                 $val['video'] = SITE_URL.'uploads/images/'.$val['video'];
              

              $data[] = $val;
         }
      $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 

  }else {
      $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
 }

      header('Content-type: application/json');
      echo json_encode($json);

}

public function get_collectable_card(){
  $phone=strval($this->input->get_post('phone'));
  $arr_get = ['receiver_email'=>$phone, 'payment_status'=>'Pending'];

  $cards = $this->Webservice_model->get_where('card_details',$arr_get);    
  if ($cards) {
          foreach($cards as $val){    
            $arr_get1 = ['id'=>$val['card_id']];
            $sub_category = $this->Webservice_model->get_where('sub_category',$arr_get1);    
            if( $sub_category[0]['image'] !='')
            $sub_category[0]['image'] = SITE_URL.'uploads/images/'.$sub_category[0]['image'];
            $val['sub_category']= $sub_category [0];            

            $arr_get2 = ['id'=>$val['sender_id']];
            $user = $this->Webservice_model->get_where('users',$arr_get2);
            if($user)         
                $user[0]['image']=SITE_URL.'uploads/images/'.$user[0]['image'];
             $val['user']= $user [0];  
             



              if( $val['image1'] !='')
                $val['image1'] = SITE_URL.'uploads/images/'.$val['image1'];   
              if( $val['image2'] !='')
                $val['image2'] = SITE_URL.'uploads/images/'.$val['image2'];
              if( $val['video'] !='')
                 $val['video'] = SITE_URL.'uploads/images/'.$val['video'];
              

              $data[] = $val;
         }
      $json = ['result'=>$data,'message'=>'successfull','status'=>'1']; 

  }else {
      $json = ['result'=>'Data Not Found','message'=>'unsuccessfull','status'=>'0']; 
 }

      header('Content-type: application/json');
      echo json_encode($json);

}


/************* update_card_details function *************/
public function update_card_details(){
  
  $arr_get = ['id'=>$this->input->get_post('user_id')];

  $login = $this->Webservice_model->get_where('users',$arr_get);
  if ($login[0]['id'] == "")
  {
    $ressult['result']='Data Not Found';
    $ressult['message']='unsuccessfull';
    $ressult['status']='0';
    $json = $ressult;

    header('Content-type:application/json');
    echo json_encode($json);
    die;
  }
   $card_number=$this->input->get_post('card_number');
   $cvc_number=$this->input->get_post('cvc_number');
   $expiration_month=$this->input->get_post('expiration_month');
   $expiration_year=$this->input->get_post('expiration_year');
    $arr_data = array(
        'card_number' =>$card_number,
         'cvc_number' =>$cvc_number,
         'expiration_month' =>$expiration_month,
         'expiration_year' =>$expiration_year,                          
      );
 $res = $this->Webservice_model->update_data('users',$arr_data,$arr_get);
 if ($res)
 {
  $data[0] = $this->Webservice_model->get_where('users',$arr_get)[0];
  $data[0]['image'] = SITE_URL.'uploads/images/'.$data[0]['image'];        

  $ressult['result']=$data[0];
  $ressult['message']='successfull';
  $ressult['status']='1';
  $json = $ressult;
}
else
{
  $ressult['result']='Data Not Found';
  $ressult['message']='unsuccessfull';
  $ressult['status']='0';
  $json = $ressult;
}

header('Content-type: application/json');
echo json_encode($json);
}


  
  
  function image()
  {
       $image=$this->input->get_post('image1');   
       $datetime = date("Y-m-d h:i:s");
       $timestamp = strtotime($datetime);
       $image = $image;
       $imgdata = base64_decode($image);
       $f = finfo_open();
       $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
       $temp=explode('/',$mime_type);
       $path = "uploads/$timestamp.$temp[1]";
       file_put_contents($path,base64_decode($image));
       echo "Successfully Uploaded->>> $timestamp.$temp[1]";
  }


           
/************* update_card_details_image function *************/
public function update_card_details_image(){
  
  $arr_get = ['id'=>$this->input->get_post('id')];

  $login = $this->Webservice_model->get_where('card_details',$arr_get);
  if ($login[0]['id'] == "")
  {
    $ressult['result']='Data Not Found';
    $ressult['message']='unsuccessfull';
    $ressult['status']='0';
    $json = $ressult;

    header('Content-type:application/json');
    echo json_encode($json);
    die;
  }


 $arr_data = [
            'message'=>$this->input->get_post('message'),
            ];
    

  if (isset($_FILES['image1']))
          {   
           $ext = end(explode(".",$_FILES['image1']['name']));
           $img = "Card1_IMG_" . date('YmdHis') . '.'.$ext;
           move_uploaded_file($_FILES['image1']['tmp_name'], "uploads/images/" . $img);
           $arr_data['image1'] = $img;        
          }

         $res = $this->Webservice_model->update_data('card_details',$arr_data,$arr_get);
         if ($res)
         {
          $data[0] = $this->Webservice_model->get_where('card_details',$arr_get)[0];
          $data[0]['image1'] = SITE_URL.'uploads/images/'.$data[0]['image1'];        
          $data[0]['image2'] = SITE_URL.'uploads/images/'.$data[0]['image2']; 
          $data[0]['video'] = SITE_URL.'uploads/images/'.$data[0]['video']; 
          $ressult['result']=$data[0];
          $ressult['message']='successfull';
          $ressult['status']='1';
          $json = $ressult;
        }
        else
        {
          $ressult['result']='Data Not Found';
          $ressult['message']='unsuccessfull';
          $ressult['status']='0';
          $json = $ressult;
        }
        
        header('Content-type: application/json');
        echo json_encode($json);
        }
        

	
    
           
/************* update_card_details_image_second function *************/
public function update_card_details_image_second(){
  
  $arr_get = ['id'=>$this->input->get_post('id')];

  $login = $this->Webservice_model->get_where('card_details',$arr_get);
  if ($login[0]['id'] == "")
  {
    $ressult['result']='Data Not Found';
    $ressult['message']='unsuccessfull';
    $ressult['status']='0';
    $json = $ressult;

    header('Content-type:application/json');
    echo json_encode($json);
    die;
  }


 $arr_data = [
            'message'=>$this->input->get_post('message'),
            ];
    

  if (isset($_FILES['image2']))
          {   
           $ext = end(explode(".",$_FILES['image2']['name']));
           $img = "Card1_IMG_" . date('YmdHis') . '.'.$ext;
           move_uploaded_file($_FILES['image2']['tmp_name'], "uploads/images/" . $img);
           $arr_data['image2'] = $img;        
          }

         $res = $this->Webservice_model->update_data('card_details',$arr_data,$arr_get);
         if ($res)
         {
          $data[0] = $this->Webservice_model->get_where('card_details',$arr_get)[0];
          $data[0]['image1'] = SITE_URL.'uploads/images/'.$data[0]['image1'];        
          $data[0]['image2'] = SITE_URL.'uploads/images/'.$data[0]['image2']; 
          $data[0]['video'] = SITE_URL.'uploads/images/'.$data[0]['video'];         
        
          $ressult['result']=$data[0];
          $ressult['message']='successfull';
          $ressult['status']='1';
          $json = $ressult;
        }
        else
        {
          $ressult['result']='Data Not Found';
          $ressult['message']='unsuccessfull';
          $ressult['status']='0';
          $json = $ressult;
        }
        
        header('Content-type: application/json');
        echo json_encode($json);
        }
        
        
           
/************* update_card_details_video function *************/
public function update_card_details_video(){
  
  $arr_get = ['id'=>$this->input->get_post('id')];

  $login = $this->Webservice_model->get_where('card_details',$arr_get);
  if ($login[0]['id'] == "")
  {
    $ressult['result']='Data Not Found';
    $ressult['message']='unsuccessfull';
    $ressult['status']='0';
    $json = $ressult;

    header('Content-type:application/json');
    echo json_encode($json);
    die;
  }


 $arr_data = [
            'message'=>$this->input->get_post('message'),
            ];
    

   if (isset($_FILES['video']))
          {   
           $ext = end(explode(".",$_FILES['video']['name']));
           $img = "video_IMG_" . date('YmdHis') . '.'.$ext;
           move_uploaded_file($_FILES['video']['tmp_name'], "uploads/images/" . $img);
           $arr_data['video'] = $img;        
          }
         

         $res = $this->Webservice_model->update_data('card_details',$arr_data,$arr_get);
         if ($res)
         {
          $data[0] = $this->Webservice_model->get_where('card_details',$arr_get)[0];
          $data[0]['image1'] = SITE_URL.'uploads/images/'.$data[0]['image1'];        
          $data[0]['image2'] = SITE_URL.'uploads/images/'.$data[0]['image2']; 
          $data[0]['video'] = SITE_URL.'uploads/images/'.$data[0]['video'];        
        
          $ressult['result']=$data[0];
          $ressult['message']='successfull';
          $ressult['status']='1';
          $json = $ressult;
        }
        else
        {
          $ressult['result']='Data Not Found';
          $ressult['message']='unsuccessfull';
          $ressult['status']='0';
          $json = $ressult;
        }
        
        header('Content-type: application/json');
        echo json_encode($json);
        }
        
	
	
	
	
	 /**************************************************payment************************************************/
    public

    function add_payment1()
    {                     
          
      $arr_data = array(
        'user_id' => $this->input->get_post('user_id'),
        'time' => $this->input->get_post('time'),
        'currency' => $this->input->get_post('currency'),
        'token' => $this->input->get_post('token'),
        'payment_type' => $this->input->get_post('payment_type'), 
        'total_amount' => $this->input->get_post('total_amount')                           
      );

                       
    /*  $time = $this->input->get_post('time');
        $currency = $this->input->get_post('currency');
        $token = $this->input->get_post('token');*/
      
	$url = 'https://api.stripe.com/v1/charges';
        $fields = [
            'amount' => ($arr_data['total_amount']*100),
            'currency' => $arr_data['currency'],
            'source' => $arr_data['token'],
            'metadata' => ['user_id'=>$arr_data['user_id']]
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/charges");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_POST, 1);
       // curl_setopt($ch, CURLOPT_USERPWD, "sk_test_FrClQVG95zp2SnIaCwJWpsI2" . ":" . "");
        curl_setopt($ch, CURLOPT_USERPWD, STRIPE_KEY . ":" . "");
       $headers = array();
       $headers[] = "Content-Type: application/x-www-form-urlencoded";
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

       $response = curl_exec($ch);  
       $response = json_decode($response);
       
       if (isset($response->error)) {
          $ressult['result']=$response;
          $ressult['message']='unsuccessful';
          $ressult['status']='0';
          $json = $ressult;
          header('Content-type: application/json');
          echo json_encode($json);
          die;
       }

       curl_close ($ch);  
       $pay = $this->Webservice_model->insert_data('payment', $arr_data);
       $get_users = $this->Webservice_model->get_where('users',['id'=>$arr_data['user_id']]);
       $times = $get_users[0]['time']+$time;;
      
      $this->Webservice_model->update_data('users',['time'=>$times],['id'=>$arr_data['user_id']]);
          if ($pay != "") {

          $single_data = ['id' => $pay];
          $fetch_order = $this->Webservice_model->get_where('payment',$single_data); 

          $ressult['result']=$response;
          $ressult['message']='successful';
          $ressult['status']='1';
          $json = $ressult;                         
                          
      }
      else {
          $ressult['result']='Data Not Found';
          $ressult['message']='unsuccessful';
          $ressult['status']='0';
          $json = $ressult;
      }

         header('Content-type: application/json');
         echo json_encode($json);
    }











  /************* strips_payment *************/
  public function strips_payment()
  { 
     $transaction_type = $this->input->get_post('transaction_type'); 
     $category_id = $this->input->get_post('category_id');
     $sub_category = $this->Webservice_model->get_where('sub_category', ['id'=>$category_id]); 
     $tip = $sub_category[0]['amount'];
      $arr_data = array(   
      'payment_type' => $this->input->get_post('payment_type'),  
      'card_details_id' => $this->input->get_post('card_details_id'), 
      'amount' => $this->input->get_post('amount'), 
      'tip' => $tip
     );
     $user_id = $this->input->get_post('sender_id');
     $reciever_id = $this->input->get_post('reciever_id');
     $amount = $this->input->get_post('amount');
     $token = $this->input->get_post('token');
     $currency = $this->input->get_post('currency');

   // $customer = $this->input->get_post('customer');

    $url = 'https://api.stripe.com/v1/charges';

    $fields = [
      'amount' => ($arr_data['amount']*100),
      'currency' => $currency,
      'source' => $token,
   //   'customer' => $customer,
      'metadata' => ['payment_type'=>$arr_data['payment_type']]
    ];

    $fields_string = http_build_query($fields);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/charges");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_POST, 1);
 //   curl_setopt($ch, CURLOPT_USERPWD, "sk_test_98vsRGp9xPxB44YFERbKpzOE" . ":" . "");
   curl_setopt($ch, CURLOPT_USERPWD, STRIPE_KEY . ":" . "");

   //curl_setopt($ch, CURLOPT_USERPWD, "sk_test_2ZlaC8gtGQv2RiIGNo4sCTtq" . ":" . "");
   //sk_test_98vsRGp9xPxB44YFERbKpzOE
    $headers = array();
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch); 
    $response = json_decode($response);

    $req = $this->Webservice_model->get_where('card_details', ['id'=>$arr_data['card_details_id']]);
 

    if (isset($response->error)) {
      $this->Webservice_model->update_data('transaction', ['status'=>'Failed'], ['id'=>$trans_id]);
      $json = ['result'=>$response->error,'status'=>0,'message'=>'Data Not Found'];
    }else{
        $this->Webservice_model->update_data('transaction', ['status'=>'Success'], ['id'=>$trans_id]);

      if($transaction_type =='add_to_wallet'){
        $this->db->query("UPDATE users SET amount = amount+".$amount." WHERE id = ".$user_id);
      }else{

         

        $amount = ($amount - $tip);

        $ad_amt = (($amount)/100);
        $ad_amt = number_format($ad_amt,2);
        $dr_amt = number_format(($amount-$ad_amt),2);

         
     //   $driver_id = $arr_data['driver_id'] = $req[0]['driver_id']; 

      

        $pay_req = $this->Webservice_model->get_where('payment', ['card_details_id'=>$arr_data['card_details_id']]);


        if($pay_req){

                $r_id = $arr_data['card_details_id'];
                $res11 =   $this->Webservice_model->update_data('payment', $arr_data, ['id'=>$pay_req[0]['id']]);
                $res = $this->Webservice_model->get_where('payment', ['card_details_id'=>$arr_data['card_details_id']]);

        }else{

                $res11 = $this->Webservice_model->insert_data('payment', $arr_data);
                $res = $this->Webservice_model->get_where('payment', ['card_details_id'=>$arr_data['card_details_id']]);

        }
       
        
        $this->db->query("UPDATE `admin_wallet` SET `amount` = amount+$ad_amt"); 
        
         $driver = $this->Webservice_model->get_where("users", ['id' => $reciever_id]);
            $trasfer_payment = $this->trasfer_payment($driver[0]['stripe_account_id'],($dr_amt+$tip));
            if($trasfer_payment=="successfull"){
                $this->db->query("UPDATE `users` SET `amount` = amount+($dr_amt+$tip), `ride_earning`  WHERE `id` = $reciever_id");
            }else{ 
                $this->db->query("UPDATE `users` SET  `ride_pending_amt` = ride_pending_amt+($dr_amt+$tip) WHERE `id` = $reciever_id");
            }
        //$this->db->query("UPDATE `users` SET `amount` = amount+($dr_amt+$tip) WHERE `id` = $driver_id");

       // $this->webservice_model->update_data('transaction', ['type'=>'payment','type_id'=>$res[0]['id']], ['id'=>$trans_id]);

        /*$arr_data = ['request_id' => $this->input->get_post('request_id') ,
                     'driver_id' => $req[0]['driver_id'],
                     'user_id' => $req[0]['user_id'],
                     'rating' => $this->input->get_post('rating') ,
                     'review' => $this->input->get_post('review'),
                     'date_time' => date('Y-m-d H:i:s')
                    ];

        $get = $this->webservice_model->insert_data('driver_review_rating', $arr_data);*/
        if ($res != '') {

       /* $arr_whr123 = array(
          'id' => $this->input->get_post('request_id')
        );*/
     //   $this->webservice_model->update_data("booking_request", ['user_rating_status' => 'Yes'], $arr_whr123);

          $driver = $this->Webservice_model->get_where("users", ['id' => $req[0]['reciever_id']]);
          $users = $this->Webservice_model->get_where("users", ['id' => $req[0]['sender_id']]);
          $user_message_apk = array(
            "message" => array(
              "result" => "successful",
              "key" => "your payment is successfull",
              'card_details_id' => $this->input->get_post('card_details_id', TRUE) ,
             // 'review' => $this->input->get_post('review', TRUE) ,
            //  'rating' => $this->input->get_post('rating', TRUE) ,
              'user_id' => $users[0]['id'],
             // 'user_firstname' => $users[0]['first_name'],
            //  'user_lastname' => $users[0]['last_name'],
              'payment_type' => $this->input->get_post('payment_type'),
              "user_img" => SITE_URL . "uploads/images/" . $users[0]['image']
            )
          );
          $register_userid = array(
            $driver[0]['register_id']
          );
        //  $this->webservice_model->driver_apk_notification($register_userid, $user_message_apk);
       //   $this->webservice_model->ios_driver_notification(SITE_URL,$user_message_apk['message'], $driver[0]['ios_register_id'],$users[0]['id']);
          $arr_whr = array(
            'id' => $users[0]['id']
          );
          $this->Webservice_model->update_data("users", ['status' => 'Active'], $arr_whr);
          $arr_whr = array(
            'id' => $driver[0]['id']
          );
          $this->Webservice_model->update_data("users", ['status' => 'Active'], $arr_whr);
        }


       $arr_data['amount'] = $amount;
        if($transaction_type =='add_to_wallet'){
          $add_data = ['user_id'=>$arr_data['user_id'],'transaction_type'=>"Credit",'amount'=>$arr_data['amount'],'description'=>"Added to wallet",'time_zone'=>$time_zone];
          $trans_id = $this->Webservice_model->insert_data('transaction', $add_data);
        }else{
          
          $add_data = ['user_id'=>$req[0]['driver_id'],'transaction_type'=>"Credit",'amount'=>$dr_amt,'description'=>"Receive from ride",'time_zone'=>$time_zone];
          $trans_id = $this->Webservice_model->insert_data('transaction', $add_data);

          $add_data = ['user_id'=>$arr_data['user_id'],'transaction_type'=>"Debit",'amount'=>$arr_data['amount'],'description'=>"Paid for ride",'time_zone'=>$time_zone];
          $trans_id = $this->Webservice_model->insert_data('transaction', $add_data);
                     }
                }
       $json = ['result'=>'successfull','transaction_id'=>$trans_id,'status'=>1,'message'=>'payment successfull'];
              }

            header('Content-type: application/json');
            echo json_encode($json);
          }
  


































  
/*-----------------stripe_Express Account-------------------------------*/

public function stripe_payment_form(){
         
        // require_once('stripe_pay/stripe/init.php');
        
        $code = $this->input->get_post('code', TRUE);
        $merchant_id = $this->input->get_post('state', TRUE); 
         
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://connect.stripe.com/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_secret=".STRIPE_KEY."&code=$code&grant_type=authorization_code");
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch); 
        $response = json_decode($response);
         
        curl_close ($ch);
        
        if (isset($response->error)) { 
            
        } else{ 
            
                $stripe_account_id = $response->stripe_user_id;
                
                $this->Webservice_model->update_data('users',['stripe_account_id'=>$stripe_account_id],['id'=>$merchant_id]);
                
                $get_merchant = $this->Webservice_model->get_where('users',['id'=>$merchant_id]);
                $get_merchant = $get_merchant[0]; 
             
        	 	
        		$key = "Your Stripe Connect Account Created Successfully";
                $message = "Your Stripe Connect Account Created Successfully";
                
              //  $username = $get_merchant['first_name'];
                
                $account_id = $response->stripe_user_id;
        		
        		
        		/************ Notification Section Start***********/
        		$user_message_apk = array(
        					"message" => array(
        						"result" => "successful",
        						"key" => $key,
        						"message" => $message,
        						"userid" => $merchant_id,
        					//	"username" => $username,
        						"stripe_account_id" => $response->stripe_user_id
        					)
        				);
        				
        				$register_userid = array($get_merchant['register_id']);
        				
                        $this->Webservice_model->driver_apk_notification($register_userid, $user_message_apk);  
                       // $this->webservice_model->ios_driver_notification(SITE_URL,$user_message_apk['message'], $get_merchant['ios_register_id'],$get_merchant['id']);
            }
       
         
        
    }


 function trasfer_payment($account_id,$total_amount){
          $total_amount = $total_amount*100;   
              
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/transfers');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=$total_amount&currency=usd&destination=$account_id&transfer_group=\"{ORDER10}\"");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, STRIPE_KEY . ':' . '');
            
            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             
            $response = curl_exec($ch); 
            $response = json_decode($response);
            
            curl_close ($ch);
            
            if (isset($response->error)) { 
                return 'unsuccessfull';
            } else{ 
                return 'successfull';
            } 
              
        }
        
  
  
  


/*----------------------------get_payment-----------------------------------------------*/
  public function get_payment(){
       $arr_get = ['user_id'=>$this->input->get_post('user_id')];
     	$payment = $this->Webservice_model->get_where('payment',$arr_get);
  		if ($payment) {
		    foreach($payment as $val){
		        $data[] = $val;
		     } 
           $ressult['result']=$data;
            $ressult['message']='successful';
            $ressult['status']='1';
            $code = $ressult;
     } else      {
          $ressult['result']='Data Not Found';
              $ressult['message']='unsuccessful';
              $ressult['status']='0';
              $code = $ressult;
      }
          header('Content-type: application/json');
              echo json_encode($code);
  }
  
  
  
  
  public function sendEmail() {
    //$this->load->config('email');
    // $this->load->library('email');
    
    $from_email = $this->input->get_post('email', TRUE);
    $sender_name = $this->input->get_post('username');
    $to = "admin@getgala.com.au";
    $subject = "Request Transfer Money";
    $sss = $this->input->get_post('message');
    $data = json_decode($sss, TRUE);

    $amount = $data["amount"];
    $bank_name = $data["bank_name"];
    $bsb = $data["bsb"];
    $account_number = $data["account_number"];
    $account_name = $data["account_name"];
    $address = $data["address"];
    $country = $data["country"];

    $message = "<div style='max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;'>
              <header style='color: #fff; width: 100%;'>
                <img alt='' src='".SITE_URL."/uploads/images/logo.png' width ='120' height='120'/>
              </header>
              <div style='margin-top: 10px; padding-right: 10px; padding-left: 75px; padding-bottom: 20px;'>
                <hr>
                <h3 style='color: #232F3F;'>Payout Request for: " .$sender_name . ".</h3>
                <p>Request Amount: " .$amount . "</p>
                <p>Bank Name: " .$bank_name . "</p>
                <p>BSB: " .$bsb . "</p>
                <p>Account Number: " .$account_number . "</p>
                <p>Account Name: " .$account_name . "</p>
                <p>Address: " .$address . "</p>
                <p>Country: " .$country . "</p>
                <hr>
                <p>Please payout when possible</p> 
                <hr>
                <p>Kind Regards <br />from " .$from_email ."</p>
              </div>
          </div>
        </div>";
        
        $mail_header="MIME-Version: 1.0 ";
        $mail_header .= "From: ".$from_email . "\r\n";
        $mail_header .= "Content-type: text/html;charset=utf-8 ";
        $mail_header .= "X-Priority: 3";
        $mail_header .= "X-Mailer: smail-PHP ".phpversion();

        $retval= mail($to, $subject, $message, $mail_header);
        $retval=true;

        if($retval==true ) {
          $ressult['message']='Your Payout Request has been sent for Processing';
          $ressult['status']='1';
          $code = $ressult;
        }else{
          $ressult['message']='Your Payout Request could not be sent, Please try again';
          $ressult['status']='0';
          $code = $ressult;
        }    

        header('Content-type: application/json');
        echo json_encode($code);
        
        
        ///=================================================================
        

        // $email_form['From'] = "galabackend@getgala.com.au";
        // $email_form['To'] = $to;
        // $email_form['Subject'] = $subject;
        // $email_form['HtmlBody'] = $message;
        // $email_form['TextBody'] = $message;
        // $email_form['ReplyTo'] = $from_email;
        
        // $json  = json_encode($email_form);
        // // $json  = $email_form;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://api.postmarkapp.com/email');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Accept: application/json',
        //     'Content-Type: application/json',
        //     'X-Postmark-Server-Token: "44870d87-45ce-48e6-8424-c19093a466ec"'// . POSTMARK_SERVER_API_TOKEN
        // ));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // $response = json_decode(curl_exec($ch), true);
        // //$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
        
        // header('Content-type: application/json');
        // echo json_encode($response);
        
        
        
        /////////////////==================================================
        
        // $this->load->library('email');

        // $this->email->initialize(array(
        //   'protocol' => 'smtp',
        //   'smtp_host' => 'smtp.sendgrid.net',
        //   'smtp_user' => 'apikey',
        //   'smtp_pass' => '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',
        //   'smtp_port' => 25,
        //   'crlf' => "\r\n",
        //   'newline' => "\r\n",
        //   'mailtype' => 'html',
        //   'charset' => 'iso-8859-1',
        //   'wordwrap' => TRUE
        // ));
        
        // $this->email->from($from_email, $sender_name);
        // $this->email->to($to);
        // $this->email->cc($to);
        // $this->email->bcc($to);
        // $this->email->subject($subject);
        // $this->email->message($message);
        
        // if ($this->email->send()) {
        //   $ressult['message']='Your Email has successfully been sent to admin.';
        //   $ressult['status']='1';
        //   $code = $ressult;
        // }else{
        //   $ressult['message']='Unfortunately failed sending email.';
        //   $ressult['status']='0';
        //   $code = $ressult;
        // }

        // header('Content-type: application/json');
        // echo json_encode($code);
        
        /////////////////=================================
        
        // $email = new \SendGrid\Mail\Mail(); 
        // $email->setFrom("anton.jerker5@outlook.com", "Example User");
        // $email->setSubject("Sending with SendGrid is Fun");
        // $email->addTo("tomasmalix518@gmail.com", "Example User");
        // $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        // $email->addContent(
        //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        // );
        // $sendgrid = new \SendGrid(getenv('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'));
        // try {
        //     $response = $sendgrid->send($email);
        //     print $response->statusCode() . "\n";
        //     print_r($response->headers());
        //     print $response->body() . "\n";
        // } catch (Exception $e) {
        //     echo 'Caught exception: '. $e->getMessage() ."\n";
        // }
  }

  public function updateUserData() {
    $phone = $this->input->get_post('phone', TRUE);
    $arr_get = ['receiver_email'=>$phone];  
    $arr_data = array(
        'payment_status' => 'Accept'                       
      );
    $res = $this->Webservice_model->update_data('card_details', $arr_data, $arr_get);
    header('Content-type: application/json');
    echo "success";
  }
  
  
  
  
  public function sendContactEmail() {
    
    $from_email = $this->input->get_post('email', TRUE);
    $sender_name = $this->input->get_post('username');
    $to = "admin@getgala.com.au";
    // $to = "tomasmalix518@gmail.com";
    $subject = "Have some problems in the app";
    $sss = $this->input->get_post('message');

    $message = "<div style='max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;'>
              <header style='color: #fff; width: 100%;'>
                <img alt='' src='".SITE_URL."/uploads/images/logo.png' width ='120' height='120'/>
              </header>
              <div style='margin-top: 10px; padding-right: 10px; padding-left: 75px; padding-bottom: 20px;'>
                <hr>
                <h3 style='color: #232F3F;'>Support Request For: " .$sender_name . ".</h3>
                <p>The below issue has occured</p>
                <p>" .$sss . "</p>
                <hr>
                <p>Warm Regards. <br />from " .$from_email ."</p>
              </div>
          </div>
        </div>";
        
        $mail_header="MIME-Version: 1.0 ";
        $mail_header .= "From: ".$from_email . "\r\n";
        $mail_header .= "Content-type: text/html;charset=utf-8 ";
        $mail_header .= "X-Priority: 3";
        $mail_header .= "X-Mailer: smail-PHP ".phpversion();

        $retval= mail($to, $subject, $message, $mail_header);
        // $retval=true;

        if($retval==true ) {
          $ressult['message']='Your Support Request has been sent';
          $ressult['status']='1';
          $code = $ressult;
        }else{
          $ressult['message']='Your Support Request could not be sent, Please Try Again';
          $ressult['status']='0';
          $code = $ressult;
        }    

        header('Content-type: application/json');
        echo json_encode($code);
        
  }


}
?>

