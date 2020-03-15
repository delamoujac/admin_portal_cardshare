<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//App::uses('CakeEmail', 'Network/Email');
require __DIR__ . '/CustomEmail.php';
//App::uses('EmailTemplate', 'Utility');


class CustomEmail extends CI_Controller
{
    public function __construct(){
    parent:: __construct();
    
    $this->load->helper('string');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Headers: GET,POST,DELETE,PUT");
    header('Access-Control-Allow-Headers: Accept-Language,Content-Language,Content-Type');
    // {'Content-Type': 'application/x-www-form-urlencoded'}
          header('Access-Control-Allow-Headers: Accept-Language,Content-Language,Content-Type'); 
          header('Content-type:application/x-www-form-urlencoded');
    }

    public static function sendMail($data) {
        $response = null;
        $http_code = null;

        $to_email = $data['to'];


        $email_form['From'] = $data['from'];

        $email_form['To'] = $data['to'];
        $email_form['Subject'] = $data['subject'];
        $email_form['HtmlBody'] = $data['message'];
        $email_form['TextBody'] = $data['message'];
        $email_form['ReplyTo'] = $data['from'];

        /*$json = json_encode(array(
            'From' => SUPPORT_EMAIL,
            'To' => $data['to'],

            'TemplateAlias' => "password-reset",
            'TemplateModel' => $data['message'],
            //'HtmlBody' => '<html><body>But <em>this</em> will be shown to HTML mail clients</body></html>'
            'HtmlBody' => $data['message']

        ));*/

        $json  = json_encode($email_form);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.postmarkapp.com/email');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Postmark-Server-Token: ' . POSTMARK_SERVER_API_TOKEN
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response;
    }

    public static function sendEmailPlaceOrderToUser($data){
        $subject = "Your order has been placed";



        $postmark = new Postmark(POSTMARK_SERVER_API_TOKEN,SUPPORT_EMAIL,SUPPORT_EMAIL);

        if($postmark->to($data['OrderDetail']['User']['email'])->subject($subject)->html_message(EmailTemplate::placeOrderEmailToUser($data))
            ->send()){

            return true;
        }else{

            return false;

        }



    }
    
     public static function testEmail(){
        $subject = "Congratulations! Emails are working";



        $postmark = new Postmark(POSTMARK_SERVER_API_TOKEN,SUPPORT_EMAIL,SUPPORT_EMAIL);

        if($postmark->to(TEST_EMAIL)->subject($subject)->html_message("Email is working.")
            ->send()){

            return true;
        }else{

             return false; 

        }



    }


   public static function sendEmailRestaurantRequest($toEmail,$data){
        $subject = "New Restaurant Request";



        $postmark = new Postmark(POSTMARK_SERVER_API_TOKEN,SUPPORT_EMAIL,SUPPORT_EMAIL);

        if($postmark->to($toEmail)->subject($subject)->html_message(EmailTemplate::emailRestaurantRequest($data))
            ->send()){

            return true;
        }else{

            return false;

        }



    }

public static function sendEmailResetPassword($toEmail, $full_name,$code){
      $subject = "Reset Password Request";


    

   // $url = Router::url( array('controller'=>'api','action'=>'resetPassword'),true).'/?'.'email='.$toEmail.'&token='.$key.'#'.$hash;

    //$url = RESET_PASSWORD_LINK.'?'.'email='.$toEmail.'&token='.$key.'#'.$hash;

   // $ms=$url;
                        //$link=wordwrap($ms,1000);

  $postmark = new Postmark(POSTMARK_SERVER_API_TOKEN,SUPPORT_EMAIL,SUPPORT_EMAIL);


        if($postmark->to($toEmail)->subject($subject)->html_message(EmailTemplate::resetPassword($toEmail, $full_name,$code))
            ->send()){
            
            return true;
        }else{

return false;

        }



    }

    public static function welcomeEmail($email,$key){


        $subject = "Welcome to Foodies";

        $hash=sha1($email .rand(0,100));


        $url = Router::url( array('controller'=>'api','action'=>'emailsuccess'),true).'/?'.'email='.$email.'&token='.$key.'#'.$hash;
        $ms=$url;
        $link=wordwrap($ms,1000);




        $postmark = new Postmark(POSTMARK_SERVER_API_TOKEN,SUPPORT_EMAIL,SUPPORT_EMAIL);

      
        if($postmark->to($email)->subject($subject)->html_message(EmailTemplate::registerEmailToUser($email,$link))
            ->send()){
            //echo "Message sent";
            return true;
        }else{

            return false;

        }




    }


    public static function testPostMarknew(&$response = null, &$http_code = null) {


            $json = json_encode(array(
                'From' => SUPPORT_EMAIL,
                'To' => SUPPORT_EMAIL,

                'Subject' => 'test email',
                'TextBody' => 'This will be shown to plain-text mail clients',
                'HtmlBody' => '<html><body>But <em>this</em> will be shown to HTML mail clients</body></html>'

            ));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Postmark-Server-Token: ' . POSTMARK_SERVER_API_TOKEN
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $response = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $response;

        }








 }   
    ?>
