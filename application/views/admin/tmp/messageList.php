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
  
  <script>
    $(document).ready(function () {
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
      $("#s_notification").validate();
      $("#s_email_form").validate();


    });
    $('.simplemodal-close').on('click', function(event) {
      alert('closed');
    });
    function sendNotifi(){
      var tmplId = $('#sel_notification').val();
      if(tmplId != ''){
        $('.notification_cnt').css('display','block');
        var ntContent = $('#sel_notification').find(':selected').attr('data-cnt');    
        $('#notifytContent').html('<div class="form_grid_12 notification_container"><h3>Notification Template Preview</h3><p>'+ntContent+'</p></div>');
      } else {
        $('.notification_cnt').css('display','none');
        $('#notifytContent').html('');
      }
      $('.chzn-select1').trigger("chosen:updated");
    }

    function sendEmail(){
      var tmplId = $('#sel_email').val();
      if(tmplId != ''){
        var ntContent = $('#sel_email').find(':selected').attr('data-cnt'); 
        $('.notification_cnt').css('display','block');
        $('#emailContent').html('<div class="form_grid_12 notification_container" ><h3>Email Template Preview</h3><p>'+ntContent+'</p></div>');
      } else {
        $('.notification_cnt').css('display','none');
        $('#emailContent').html('');
      }
    }

    function sendSMS(){
      var tmplId = $('#send_smsDrop').val();
      if(tmplId != ''){
        $('.notification_cnt').css('display','block');
        var ntContent = $('#send_smsDrop').find(':selected').attr('data-cnt');    
        $('#SmsContent').html('<div class="form_grid_12 notification_container"><h3>Message Text</h3><p>'+ntContent+'</p></div>');
      } else {
        $('.notification_cnt').css('display','none');
        $('#SmsContent').html('');
      }
    }


  </script>
  
  

<body class="hold-transition skin-blue sidebar-mini" id="" ng-app="myApp">

<div class="wrapper" >
<?php include 'include/header.php';

      $userList = $this->admin_common_model->get_all('users');
     
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <form action="" method="POST" id="bulk_form">

      <span class="fs30 cdG">Users </span><!-- <a href="<?=base_url('admin/view_page/addUser');?>"><button type="button" class=" btn  btn-info-add btn-md mt-10 ml10" > Add New</button></a>-->

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
            
          
              
           <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg o-modal tipTop" data-content="send_notification"  data-target="#myModal"  data-toggle="modal">Send Notification</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
     <div class="modal-body">
       <div style="     background: #EBEBEB;  z-index: 1002; height: 328px; width: 568px; left: 366px; top: 3px;" class="simplemodal-container" role="dialog" id="simplemodal-container"><a class="modalCloseImg simplemodal-close" title=""></a><div style="height: 100%; outline: 0px none; width: 100%; overflow: visible;" class="simplemodal-wrap" tabindex="-1"><div class="simplemodal-data" id="send_notification" style="">
        <h3>Send Notification</h3>
        <form novalidate="novalidate" accept-charset="UTF-8" action="" class="form_container left_label" id="s_notification" enctype="multipart/form-data" method="post">            <ul>

          <li>
            <input name="userIds" class="tdesc" value="" type="hidden">
            <input name="noti_type" value="NOTIFICATION" type="hidden">
             
              <div class="form_grid_12">  
                <textarea class="form-control" name="description" rows="5" placeholder="Enter description"></textarea> 
              </div>
              <div class="form_grid_12"> 
                <button type="submit" name="submit" class="btn_small btn_blue"  style="margin:8px 0 0 0;background: #E91E63;border: 1px #EBEBEB;" ><span>Send</span></button>  
              </div> 

              </li> 
          </ul>
        </form>        </div></div></div>
      </div>
      
    

  </div>
</div>
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
                             <th class="center">
                    <input  name="checkbox_id[]" type="checkbox" value="on" class="checkall">
                  </th>
                  <th>User Name</th>                  
                  <th>Email </th>
                  <th>Mobile </th>
                  <th>Gender </th>
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
                             <th class="center">
                    <input  name="checkbox_id[]" type="checkbox" value="on" class="checkall">
                  </th>
                  <th>User Name</th>                  
                  <th>Email </th>
                   <th>Mobile </th>
                  <th>Gender </th>
                </tr>
        </tfoot>
         <input type="hidden" name="statusMode" id="statusMode"/>
        <input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
        
        
           <div id="send_notification" style="display:none;">
        <h3>Send Notification</h3>
        <form accept-charset="UTF-8" action="" accept-charset="iso-8859-1" class="form_container left_label" id="s_notification" enctype="multipart/form-data" method="post">            <ul>

          <li>
            <input name="userIds" type="hidden" class="tdesc"  value=""/>
            <input name="noti_type" type="hidden" value="NOTIFICATION"/>
             
              <div class="form_grid_12">  
                <textarea class="form-control" name="description" rows="5" placeholder="Enter description"></textarea> 
              </div>
              <div class="form_grid_12"> 
                <button type="submit" name="submit" class="btn_small btn_blue" style="margin:8px 0 0 0"><span>Send</span></button>  
              </div> 

              </li> 
          </ul>
        </form>        </div>
        
        
        <tbody>
           <?php $i=2; foreach($userList as $row){ 
$users =  $this->session->userdata['admin'];              
           ?>

                <tr>
                <!--<td><div class="[ form-group ] mb0">
                              <input name="user_action[]" id="user<?=$i;?>"  type="checkbox" value="<?= $row['id']; ?>">
                              <div class="[ btn-group ]">
                                  <label for="user<?=$i;?>" class="[ myradioBtn ]">
                                      <span class="[ glyphicon glyphicon-ok ]"></span>
                                      <span></span>
                                  </label>
                              </div>

                        </div> </td>-->
                    
                  <td class="center tr_select ">
                    <input name="checkbox_id[]" class="user_mongo_id" type="checkbox" value="<?=$row['id']?> ">
                  </td> 
                  <td style="min-width:25em">
                  <div class="row">
                    <div class="col-sm-2">
                       <?php
                        if ($row['image'] == ''){
                          $img_url = base_url('uploads/images/user.jpg');
                        }else{
                          $img_url = base_url('uploads/images/'.$row['image']);
                        }
                      ?>
                      <img src="<?=$img_url;?>" alt="" width="50"> 
                    </div><!-- col-sm-2 -->
                    <div class="col-sm-10">
                    <sapn><?= $row['username']?>
                        <div>
                          
                        <span><a href="#" class="cdG" onclick="deleteUsers('<?=$row["id"];?>')">Delete</a></span>
                        </div>
                    </sapn></div><!-- /row -->
                
                  </div><!-- col-sm-10 -->
                </td>

                <td><p><?= $row['email']; ?></p></td>
                <td><p><?= $row['mobile']; ?></p></td>
                <td><p><?= $row['gender']; ?></p></td>
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
function deleteUsers(id)
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
          data: {'table': 'users', 'id': id}, // change this to send js object
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

<style>
  #simplemodal-container {
    /* width: 700px !important; */
  }

  .left_label ul li .form_input {
    margin-left: 20% !important;
  }

  .left_label ul li label.field_title {
    margin-right: 0;    
    width: 20%;
  }
  .mceLayout {
    min-width: 500px !important;
  }


  .btn_blue {
    background: #a7a9ac none repeat scroll 0 0;
    border: 1px solid #000;
    color: #fff;
    float: right;
    font-size: 12px;
    margin-right: 10px;
    margin-top: -32px;
    padding: 0 16px;
    text-shadow: 1px 1px 0 #000;
  }

  .notification_cnt {
    background-image: none;
    border: 1px solid gray !important;
    border-radius: 5px;
    display:none;
  }
  .notification_container {
    height: 193px;
    overflow: auto;
    width: 100% !important;
  }
  
  #simplemodal-container {
    height: 360px;
    width: 600px;
    color: #333;
    background: transparent -moz-linear-gradient(center top , #FFF 0%, #E5E5E5 100%) repeat scroll 0% 0%;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.8), 0px 0px 10px rgba(0, 0, 0, 0.3) inset;
    border: 4px solid #165A91;
    padding: 12px;
}
#simplemodal-container a.modalCloseImg {
    background: transparent url("../uploads/images/x.png") no-repeat scroll 0% 0%;
    width: 25px;
    height: 29px;
    display: inline;
    z-index: 3200;
    position: absolute;
    top: -15px;
    right: -16px;
    cursor: pointer;
}
#simplemodal-container .simplemodal-data {
    padding: 8px;
}
#simplemodal-container h3 {
    color: #06C;
    margin: 0px;
}
.form_container {
    width: 100%;
}
#simplemodal-overlay {
    background-color: #000;
    cursor: wait;
}
#simplemodal-container a {
    color: #DDD;
}
</style>

<script>
  $(document).ready(function () { 

    /* var checkedValues = $('.user_mongo_id:checked').map(function () {
            return this.value;
        }).get();*/
    //$('#sendMailtextarea').tinymce().execCommand('mceRemoveControl', true, 'sendMailtextarea');




    $('.o-modal').click(function(e) { 
      var contentId = $(this).attr("data-content"); 
      
     if ($(".tdesc").val() != '') {
        $('#' + contentId).modal({
          onClose: function(dialog){
            location.reload();
            $.modal.close();
          }
        });
      } else {
        alert("Please select one or more user to send notification");
      }

      return false;
    });
    /*$(".checkall,.user_mongo_id").change(function () {
            checkedValues = $('.user_mongo_id:checked').map(function () {
                return this.value;
            }).get();
            $(".tdesc").val(checkedValues);
        });*/

    $(document).on('change', '.checkall,.user_mongo_id', function() {

     
      var rowcollection = $(this).val();
   
  var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
    $(".tdesc").val(val); 
      });
       

    });

    $(".media_image").change(function (e) {
      e.preventDefault();
      if (typeof (FileReader) != "undefined") {
        var image_holder = $("#image-holder");
        image_holder.empty();
        var reader = new FileReader();
        reader.onload = function (e) {

          var res = e.target.result;
          var ext = res.substring(11, 14);
          extensions = ['jpg', 'jpe', 'gif', 'png', 'bmp'];
          if ($.inArray(ext, extensions) !== -1) {
            var image = new Image();
            image.src = e.target.result;

            image.onload = function () {
              if (this.width >= 75 && this.height >= 42) {
                $("#loadedImg").css("display", "none");
                $("<img />", {
                  "src": e.target.result,
                  "id": "thumb-image",
                  "style": "width:100px;height:100px;margin-top:20px",
                }).appendTo(image_holder);
                $('#ErrNotify').html('');




              } else {
                $('#ErrNotify').html('Upload Image Too Small. Please Upload Image Size More than or Equalto 75 X 42 .');
              }
            };
          }
          else {
            $('#ErrNotify').html('Please Select an Image file');
          }
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
      }
    });

    $(".filtertype").on("change", function () {
      $(".filtervalue").empty();
      var filter_value = [];
      var device_type = new Array('android', 'ios');
      var status = new Array('active', 'inactive');
      var filter_type = new Array();

      $(".filtertype option").each(function () {
        if ($(this).attr('value') != '')
          filter_type.push($(this).attr('value'));
      });
      if ($.inArray(this.value, filter_type) != -1) {
        switch (this.value) {
          case 'device-type':
            filter_value = device_type;
            break;
          case 'status':
            filter_value = status;
            break;
          default:
            filter_value = ' ';
            break;
        }
      }

      $.each(filter_value, function (ind, val) {
        $(".filtervalue").append($("<option>", {
          value: val,
          text: val,
        }));
      });

    });


 


</script>
<script type="text/javascript">
  $(document).ready(function(){
    $.validator.setDefaults({ ignore: ":hidden:not(select)" })
  });

</script>

<?php 
extract($_REQUEST);
if(isset($submit)){
  
    $arr_data = $this->input->post();   //print_r($arr_data);die;
 
    $description = $arr_data['description'];
    $userIds = $arr_data['userIds']; 
    $noti_type = $arr_data['noti_type']; 
 // echo $noti_type;die;
   // $sql = "SELECT * FROM users WHERE id IN($userIds)";  
    //$querys = mysql_query($sql);
    $querys =  $this->db->query("SELECT * FROM users WHERE id IN($userIds)");//print_r($querys);
    
  
       while($row = $querys->row_array()){ 
      foreach($query->result_array() as $row){
     //print_r($row);
      //echo $arr_data['noti_type'];die;
			  /*if($noti_type=='SMS'){

				  $mobile = ltrim($row['mobile'], '0');
				  $mobile = '249'.$mobile;

				  $url = "http://212.0.129.229/bulksms/webacc.aspx?user=admin&pwd=123456&smstext=".urlencode($description)."&Sender=admin&Nums=".$mobile; 
				  $result = file_get_contents($url); 

			  }

			  if($noti_type=='EMAIL'){
				send_email($row['email'],$row['first_name'],$logo,$name,$description);
			  }*/

			  if($arr_data['noti_type'] == 'NOTIFICATION'){  
				  
					$user_message_apk = array(
					"message" => array(
					  "result" => "successful",
					  "key" => "Notification from ManarGiftStore",
					  'description' => $description  
					)
				  );
				  $register_userid = array(
					$row['register_id']
				  );
				  //print_r($row['ios_register_id']);
				  user_apk_notification($register_userid, $user_message_apk);
				 $test = ios_user_notification(SITE_URL,$user_message_apk['message'], $row['ios_register_id'],$users->id);
 // print_r($test);die;
				$this->admin_common_model->insert_data('notification',['title'=>'Notification from Manargiftstore','description'=>$description,'user_id'=>$row['id']]);
		//	echo $this->db->last_query();
				}
       
          }
        
        }
  
  
    echo 
    "<script> swal(
      'Success',
      'Send Notification Successfully',
      'success'
    ); 

    $('.confirm').click(function(){
        window.location='".base_url('admin/view_page/messageList')."';
    });

    </script>"; 
  
  
}


 
  /************* send_email function *************/
 

  function send_email($email,$first_name,$logo,$name,$description)
  {
        
      
    
      $subject = "Notification from manargiftstore";
      $body = "<div style='max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;'>
        <header style='color: #fff; width: 100%;'>
           <img alt='' src='".base_url('uploads/images/'.$logo)."' width ='120' height='120'/>
        </header>

        <div style='margin-top: 10px; padding-right: 10px; 
      padding-left: 125px;
      padding-bottom: 20px;'>
          <hr>
          <h3 style='color: #232F3F;'>Hello " . $first_name . ",</h3>
          <p>".$description.".</p> 
          <hr> 
            <p>Warm Regards<br>".$name."<br>Support Team</p> 
          </div>
        </div>

    </div>";
      $headers = "From: " . SITE_EMAIL . "\r\n";
      $headers.= "MIME-Version: 1.0" . "\r\n";
      $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
      //file_get_contents("http://technorizen.co.in/mail.php?to=" . urlencode($to) . "&subject=" . urlencode($subject) . "&body=" . urlencode($body) . "&headers=" . urlencode($headers));
      mail($email, $subject, $body, $headers);
        
 
  }

function user_apk_notification($registration_ids, $message)
{

	// Set POST variables
	//print_r($registration_ids); die;
	$url = 'https://android.googleapis.com/gcm/send';
	$fields = array(
		'registration_ids' => $registration_ids,
		'data' => $message,
	);
	$headers = array(
		'Authorization: key=' . "AAAAqmDhTSA:APA91bEE8B4eJShWDE0_Zzf27OSTQMQhKRWHgmUvIZSyJIcWoExJg1AXfhNYuwPJbiFC_sORTRa8zZ8-vg1R4B1APXcV90Sg0iCW1BikrnCIEyfMlUIE7JuhIUhuAt9lVCJJSqiasXtN",
		'Content-Type: application/json'
	);

	// print_r($headers);
	// Open connection

	$ch = curl_init();

	// Set the url, number of POST vars, POST data

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Disabling SSL Certificate support temporarly

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	// Execute post

	$result = curl_exec($ch);
	if ($result === FALSE)
	{
		die('Curl failed: ' . curl_error($ch));
	}

	// Close connection

	curl_close($ch);

	//echo $result;

}



                        function ios_user_notification($site_url,$message, $ios_id,$sender_id)
			{
			     

			  /*************** notification ****************/
                          
                          $message['alert'] = $message['key'];
                          $message['content-available'] = 1;
                          $message['badge'] = 1;
                          $message['sender_id'] = $sender_id;
                          $message['sound'] = 'default';
                          $message['ios_id'] = $ios_id;
                          $message['pem_file_name'] = 'Certificates.pem';
                          
                          $fields_string = (http_build_query($message));
                          
                          $url = $site_url.'ios_apk_noti.php';
                                                  
                          $fields_string = urldecode($fields_string);

                          $ch = curl_init();

                          curl_setopt($ch,CURLOPT_URL, $url);
                          curl_setopt($ch,CURLOPT_POST, count($message));
                          curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

                          $exc = curl_exec($ch);
                          curl_close($ch); 

			}

?>


