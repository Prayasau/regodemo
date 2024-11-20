<?
	
	if(session_id()==''){session_start();}
	ob_start();

	include('../../dbconnect/db_connect.php');
	

	$folderName = 'wl';
	$fileName = 'ping_location.php';
	$encodedFolderName = base64_encode($folderName);
	$encodedFileName = base64_encode($fileName);
	$urlLink =  ROOT.''.base64_decode($encodedFolderName).'/'.base64_decode($encodedFileName).'' ;





	// $urlLink  =  $
		// Send email ---------------------------------------------------------------------------------------------------------
		require DIR.'PHPMailer/PHPMailerAutoload.php';	
	
		$body = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				</head>
				<style>
					table {font-size:16px;}
					table th, table td {padding:1px 0 1px 10px; vertical-align:top}
					table th {text-align:right; white-space:nowrap;}
				</style>
				<body>
					<div>
					<p>
					Please follow this link to Ping your current location <a href="'.$urlLink.'">Click Here</a>
					</p>
					</div>
				</body>
			</html>';
	
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		$mail->From = 'lovepreet.wartiz@gmail.com';
		$mail->FromName = 'Developer Test';
		$mail->addAddress($_REQUEST['enteremail'], 'Test Email'); 
		$mail->isHTML(true);                                  
		$mail->Subject = 'Ping Location';
		$mail->Body = $body;
		$mail->WordWrap = 100;
		if(!$mail->send()) {
			echo $mail->ErrorInfo;
		}
	
	
	
	
	
	
	
	
	
	
