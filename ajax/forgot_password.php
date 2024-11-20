<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');



	/*require '../PHPMailer/PHPMailerAutoload.php';

	$body = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				</head>
				<body style="font-size:16px">TEST MAIL DNS CHECK </body>
			</html>';


	$mail = new PHPMailer;
	$mail->Host ='regodemo.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = false;
	$mail->Username='noreply@regodemo.com';
	$mail->Password ='5cee9e8a871c5ab';
	$mail->setFrom('noreply@regodemo.com', 'RegoDemo');
	$mail->Subject = 'Leave request';
	$mail->addAddress('lovepreet.wartiz@gmail.com');
	$mail->msgHTML($body);
	if (!$mail->send()) 
	{
		$error = "Mailer Error: " . $mail->ErrorInfo;
		echo '<p id="para">'.$error.'</p>';
	}





	// $to = "lovepreet.wartiz@gmail.com";
	// $subject = "My subject";
	// $txt = "Hello world!";
	// $headers = "From: admin@regodemo.com" . "\r\n" ;

	// mail($to,$subject,$txt,$headers);


	$textMessage= 'TEST MAIL DNS CHECK';


	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	$mail->From = 'noreply@regodemo.com';
	$mail->FromName = strtoupper($client_prefix).' ผู้ดูแลระบบ (Admin)';
	$mail->addAddress('test-1jqy5pce9@srv1.mail-tester.com', 'Lovepreet'); 
	$mail->isHTML(true);                                  
	$mail->Subject = 'Leave request';
	$mail->Body = $body;
	$mail->AltBody  =  $textMessage;    # This automatically sets the email to multipart/alternative. This body can be read by mail clients that do not have HTML email capability such as mutt.

	
	$mail->WordWrap = 100;
	//echo $body;
	if(!$mail->send()) {
		echo $mail->ErrorInfo;
	}


	die();*/


	//var_dump('');
	//var_dump($_REQUEST); exit;
	
	//$new_password = 'xxx';
	$new_password = generateStrongPassword();
	$password = hash('sha256', $new_password); 
	
	$my_dbxname = $prefix.'regodemo';
	//var_dump($my_dbxname); exit;
	$dbx = @new mysqli($my_database,$my_username,$my_password,$my_dbxname);
	if($dbx->connect_error){
		 echo 'error'; 
		 exit;
	}else{
		mysqli_set_charset($dbx,"utf8");
	}
	
	$sql = "SELECT * FROM rego_all_users WHERE LOWER(username) = '".strtolower($_REQUEST['forgot_username'])."'";
	if($res = $dbx->query($sql)){
		if($res->num_rows == null){
			ob_clean(); 
			echo 'suspended'; 
			exit;
			//var_dump('suspended');
		}else{
			$row = $res->fetch_assoc();
			$sql = "UPDATE rego_all_users SET password = '".$dbx->real_escape_string($password)."' WHERE LOWER(username) = '".strtolower($_REQUEST['forgot_username'])."'";
			if($dbx->query($sql)){
				require '../PHPMailer/PHPMailerAutoload.php';
				$body = "<html>
						<head>
						<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
						</head>
						<body style='font-size:16px'>
							<p>เรียนคุณ ".$row['firstname'].",</p>
							<p>รหัสผ่านใหม่ของคุณคือ <b>".$new_password."</b><br>
							กรุณาเปลี่ยนรหัสผ่านของคุณในครั้งแรก</p>
							<p>ขอแสดงความนับถือ<br>".strtoupper($client_prefix)." ผู้ดูแลระบบ</p>
						<hr>
							<p>Dear ".$row['firstname'].",</p>
							<p>Your new password is <b>".$new_password."</b><br>
							Please change your password on first visit.</p>
							<p>Kind regards,<br>".strtoupper($client_prefix)." Admin</p>
						</body></html>";

				$mail = new PHPMailer;
				$mail->CharSet = 'UTF-8';
				$mail->From = $from_email;
				$mail->FromName = strtoupper($client_prefix).' ผู้ดูแลระบบ (Admin)';
				$mail->addAddress($row['username'], $row['firstname']);     // Add a recipient
				$mail->isHTML(true);                                  
				$mail->Subject = 'ขอรหัสผ่านใหม่ (New password request)';
				$mail->Body = $body;
				$mail->WordWrap = 100;                                
				if(!$mail->send()) {
					 ob_clean(); 
					 echo 'connection'; 
					 exit;
					 //var_dump('connection');
				}else{
					 ob_clean(); 
					 echo 'success'; 
					 exit;
					 //var_dump('success');
				}
			}
		}
	}else{
		ob_clean(); 
		echo mysqli_error($dbx); 
		exit;
	}
	exit;
	












