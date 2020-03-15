<?php
 
// Put your private key's passphrase here:
$passphrase = '';


////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $_POST['pem_file_name']);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

/*

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

*/

// Create the payload body
$body['aps'] = $_POST;
$body['urlImageString'] = $_POST['image'];
$body['title'] = $_POST['offer_title'];

 

// Encode the payload as JSON
$payload = json_encode($body);


// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $_POST['ios_id']) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	/*echo 'Message not delivered' .*/ PHP_EOL;
else
	/*echo 'Message successfully delivered' .*/ PHP_EOL;

// Close the connection to the server
fclose($fp);

