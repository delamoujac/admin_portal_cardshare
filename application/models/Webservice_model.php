<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowd');
	class Webservice_model extends CI_Model{

		public function get_where($table,$where){
			$data =	$this->db->where($where)
					 		 ->get($table);

			//echo $this->db->last_query();

	 		if($res = $data->result_array()){
	 			return $res;
			}else{
				return FALSE;
			}

			
		}

		public function get_where_like($table,$where){
			$data =	$this->db->like($where)
					 		 ->get($table);

			//echo $this->db->last_query();

	 		if($res = $data->result_array()){
	 			return $res;
			}else{
				return FALSE;
			}

			
		}

		public function insert_data($table,$data){
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}

		public function update_data($table,$data,$where){
			$query = $this->db->where($where)
					 ->update($table,$data);
			if ($query)
			{
				return TRUE;
			}
		  	else
			{
				return FALSE;
			}
		}

		public function get_all($table){
			$data = $this->db->get($table);
			$data = $data->result_array();
			if ($data) {
				return $data;
			}else{
				return FALSE;
			}
		}

		public function update_token($email,$token){
			$data = array('token' => $token);
			$this->db->set($data);
			$this->db->where('email', $email);
			 $this->db->update('users');
			 return $this->db->affected_rows();
		}
	
		public function change_password($token,$newpass){
			$data = array('password' => $newpass,'token'=>'');
			$this->db->set($data);
			$this->db->where('token', $token);
		   $this->db->update('users');
			return $this->db->affected_rows();
	
		}
		
		public function humanTiming($time)
		{
			$time = time() - $time; // to get the time since that moment
			$time = ($time < 1) ? 1 : $time;
			$tokens = array(
				31536000 => 'year',
				2592000 => 'month',
				604800 => 'week',
				86400 => 'day',
				3600 => 'hour',
				60 => 'minute',
				1 => 'second'
			);
			foreach($tokens as $unit => $text)
			{
				if ($time < $unit) continue;
				$numberOfUnits = floor($time / $unit);
				return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
			}
		}

		function delete_data($table, $where)
		{
			$del = $this->db->where($where)
					 ->delete($table);
			if ($del)
			{
				return TRUE;
			}
		  	else
			{
				return FALSE;
			}
		}

               	function generateRandomString($num) {
			$length=$num;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

            function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
	        {
				$pi80 = M_PI / 180;
				$lat1*= $pi80;
				$lng1*= $pi80;
				$lat2*= $pi80;
				$lng2*= $pi80;
				$r = 6372.797; // mean radius of Earth in km
				$dlat = $lat2 - $lat1;
				$dlng = $lng2 - $lng1;
				$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
				$c = 2 * atan2(sqrt($a) , sqrt(1 - $a));
				$km = $r * $c;
				return ($miles ? ($km * 0.621371192) : $km);
	        }

        	function user_apk_notification($registration_ids, $message)
			{

			// Set POST variables
	        //	print_r($message); die;
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

		//	echo $result;

			}
			
			
			function provider_apk_notification($registration_ids, $message)
			{

			// Set POST variables
	//	print_r($registration_ids); 
			$url = 'https://android.googleapis.com/gcm/send';
			$fields = array(
				'registration_ids' => $registration_ids,
				'data' => $message,
			);  
			$headers = array(
				'Authorization: key=' . "AAAAtGSYeI0:APA91bEC-LDufHqDwbrk-TxqHMzEMzOkcSv8Sjgw0nQHrD8llPShD_NJ_RVS_Cu9QdnO5JOpOF8dSjzLhrJFZ9N9x1poVx4D8oHHfuTbZ5UD6Cs5fcRXjyB28DLw23fJZ7SLg8rVHXHq",
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

		//	echo $result;

			}

                      
            function goalkeeper_apk_notification($registration_ids, $message)
			{

			// Set POST variables
	//	print_r($registration_ids); 
			$url = 'https://android.googleapis.com/gcm/send';
			$fields = array(
				'registration_ids' => $registration_ids,
				'data' => $message,
			);  
			$headers = array(
				'Authorization: key=' . "AAAAP8s-S_U:APA91bHYgT3Iiq7_ZsP3wAeFX4n1bg7ql076bfUZjQ6o7WaDmsmyRjmZwsz8TPIqUY2c9JVKSC16eTwk0ej5QNL8YtrSZh-G0my7Jl2z_1vbj2zMh9ZDG9lot-GvAg_abxTGcLnTlrv5",
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

		//	echo $result;

			}

            function user_send_notification($registration_ids, $message)
			{

			// Set POST variables
	        //	print_r($message); die;
			$url = 'https://android.googleapis.com/gcm/send';
			$fields = array(
				'registration_ids' => $registration_ids,
				'data' => $message,
			);
			$headers = array(
				'Authorization: key=' . "AAAAg3S9IVQ:APA91bGBBQYe3rsS6-MJYBtQwpEheLHUB88EXOMKTKsBmvt7afFMvI4r-iMqfeiOPY7HFEAjwzGYZbDkXbSatiY7xmSbf9Ooipb_vrvstoThnMPcH7Q6OM4Ux3sAC8ZrtixxGwCsqSlP",
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

		    //	echo $result;

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

                        function ios_driver_notification($site_url,$message, $ios_id,$sender_id)
			{
                        
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

	}//end class
?>