<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	require_once DIR.'omise-php/lib/Omise.php';
	//var_dump($_REQUEST); exit;
	
	define('OMISE_PUBLIC_KEY', 'pkey_test_5ibhcak45cr121wkt2l');
	define('OMISE_SECRET_KEY', 'skey_test_5ibh4x3ig39fffijqck');
	define('OMISE_API_VERSION', '2019-05-29');
	
	$charge = OmiseCharge::create(array(
	  'amount' => $_REQUEST['amount'],
	  'currency' => 'THB',
	  'card' => $_REQUEST['data']['id']
	));
	
	$card['object'] = $charge['object'];
	$card['authorized'] = $charge['authorized'];
	$card['capture'] = $charge['capture'];
	$card['captured'] = $charge['captured'];
	$card['status'] = $charge['status'];
	$card['brand'] = $charge['card']['brand'];
	$card['last_digits'] = $charge['card']['last_digits'];
	$card['name'] = $charge['card']['name'];
	$card['amount'] = number_format(($_REQUEST['amount']/100),2);
	$card['invoice'] = $_REQUEST['invoice'];
	
	if($charge['status'] == 'successful'){
		include('payment_success.php');
	}
	
	ob_clean();
	echo $charge['status'];
	exit;
	
	echo '<pre>';
	var_dump($card);
	echo '</pre>';

	//var_dump($_REQUEST['amount']);
	//var_dump($_REQUEST['data']['id']);
	
	
	//var_dump($card);
	//var_dump($card['last_digits']);
	//var_dump($card['name']);
	//var_dump($card['amount']);
	
	//var_dump($charge["_values"]['transaction']); 
	
	//var_dump($charge);
	
	//exit;
	
	
	//echo '</pre>';
	
	/*$body = "<html>
				<head>
				<style type='text/css'>
					body, th, td {font-family:Calibri,Verdana; white-space:nowrap; font-size:16px} 
				</style>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				</head>
				<body>
				<table style='width:100%'>
					<tr>
						<th align='right'>Customer ID : </th>
						<td style='width:90%'>".strtoupper(substr($_SESSION['rego']['cid'],0,4).' '.substr($_SESSION['rego']['cid'],4))."</td>
					</tr><tr>
						<th align='right'>Company : </th>
						<td>".$_REQUEST['company']."</td>
					</tr><tr>
						<th align='right'>Subscription : </th>
						<td>".$_REQUEST['version']."</td>
					</tr><tr>
						<th align='right'>Applicant : </th>
						<td>".$_SESSION['rego']['name']."</td>
					</tr><tr>
						<th align='right'>eMail : </th>
						<td><a href='mailto:".$_SESSION['rego']['username']."'>".$_SESSION['rego']['username']."</a></td>
					</tr><tr>
						<th align='right'>Card : </th>
						<td>".$card['brand']."</td>
					</tr><tr>
						<th align='right'>Last digits : </th>
						<td>".$card['last_digits']."</td>
					</tr><tr>
						<th align='right'>Card holder : </th>
						<td>".$card['name']."</td>
					</tr><tr>
						<th align='right'>Amount paid : </th>
						<td>".$card['amount']."</td>
					</tr>
				</table>
				</body>
				</html>";
	
	require('../PHPMailer/PHPMailerAutoload.php');
	
	$mail = new PHPMailer;
	$mail->CharSet = "UTF-8";
	$mail->From = $_SESSION['rego']['email'];
	$mail->FromName = $_SESSION['rego']['name'];//$lng['Contactform'];
	//$mail->addAddress('admin@regohr.com', 'REHO HR');
	$mail->addAddress('willy@xrayict.com', 'REHO HR');
	//$mail->addBCC('willy@xrayict.com', 'REHO HR');
	//$mail->addReplyTo($_REQUEST['email'], $_REQUEST['name']);
	$mail->isHTML(true);                                  
	$mail->Subject = 'Purchase '.$_REQUEST['version'];
	$mail->Body = $body;
	$mail->WordWrap = 100;   
	
	ob_clean();                           
	if(!$mail->send()) {
		 echo 'err';
	}else{
		 echo 'ok';
	}
*/












