<?
	if(session_id()==''){session_start(); ob_start();}
	include("../dbconnect/db_connect.php");
	include(DIR.'admin/files/admin_functions.php');
	//var_dump($_REQUEST); exit;
	
	$password = $_REQUEST['password'];
	
	if(isset($_REQUEST['password'])){$_REQUEST['password'] = hash('sha256', $_REQUEST['password']);}
	if(isset($_REQUEST['img_data']) && strlen($_REQUEST['img_data']) < 20){unset($_REQUEST['img_data']);}
	if(isset($_REQUEST['img_data'])){
		$uploadmap = DIR.'admin/uploads/';
		$filename = $uploadmap.'admin_'.str_replace(' ', '', $_REQUEST['user_id']).'.jpg';
		$db_filename = AROOT.'uploads/admin_'.str_replace(' ', '', $_REQUEST['user_id']).'.jpg';
		$img_data = utf8_decode($_REQUEST['img_data']);
		$base64img = str_replace('data:image/png;base64,', '', $img_data);
		$data = base64_decode($base64img);
		$source = imagecreatefromstring($data);
		$imageSave = imagejpeg($source,$filename,80);
		imagedestroy($source);
		if(!$imageSave){
			$err_msg .= '<p>Error</p>';
		}
		unset($_REQUEST['img_data']);
		$_REQUEST['img'] = $db_filename;
	}
	
	$_REQUEST['img'] = 'admin/uploads/admin_101.jpg';
	$_REQUEST['super_admin'] = 'admin';
	$_REQUEST['as_customers'] = 'a:1:{i:0;s:0:"";}';
	$_REQUEST['as_servcenters'] = 'a:1:{i:0;s:5:"sc101";}';
	$_REQUEST['access'] = 'a:21:{s:8:"customer";a:5:{s:6:"access";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:5:"price";s:1:"0";s:6:"delete";s:1:"1";}s:5:"admin";a:4:{s:6:"access";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:5:"users";a:4:{s:6:"access";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:12:"def_settings";a:4:{s:6:"access";s:1:"1";s:4:"edit";s:1:"1";s:3:"add";s:1:"1";s:6:"delete";s:1:"1";}s:13:"comp_settings";a:2:{s:6:"access";s:1:"1";s:4:"edit";s:1:"1";}s:20:"company_registration";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:17:"platform_settings";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:24:"email_templates_settings";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:14:"parameters_tab";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:15:"layout_settings";a:2:{s:6:"access";s:1:"1";s:4:"edit";s:1:"1";}s:18:"support_help_files";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:16:"legal_conditions";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:15:"software_models";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:9:"users_tab";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:21:"customer_registration";a:2:{s:6:"access";s:1:"0";s:4:"edit";s:1:"0";}s:7:"support";a:4:{s:6:"access";s:1:"1";s:3:"gen";s:1:"1";s:3:"con";s:1:"1";s:3:"bug";s:1:"1";}s:4:"help";a:1:{s:6:"access";s:1:"1";}s:5:"price";a:1:{s:6:"access";s:1:"1";}s:7:"privacy";a:1:{s:6:"access";s:1:"1";}s:8:"language";a:1:{s:6:"access";s:1:"1";}s:6:"agents";a:1:{s:6:"access";s:1:"1";}}';

	foreach($_REQUEST as $k=>$v){
		$fields[] = $k;
	}



	$sql = "INSERT INTO rego_users (";
	foreach($fields as $v){
		$sql .= $v.',';
	}
	$sql = substr($sql,0,-1);
	$sql .= ") VALUES ("; 
	foreach($_REQUEST as $k=>$v){
		$sql .= "'".$dba->real_escape_string($v)."',";
	}
	$sql = substr($sql,0,-1);
	$sql .= ") ON DUPLICATE KEY UPDATE ";
	foreach($fields as $v){
		$sql .= $v.' = VALUES('.$v.'),';
	}
	$sql = substr($sql,0,-1);
	//echo $sql;
	//exit;
		
	if($dba->query($sql)){

		$err_msg = 'ok';
		//writeToLogfile($_SESSION['xhr']['cid'], 'action', 'Update / Add '.$types[$_REQUEST['user_type']].' user : '.$_REQUEST['name'].' ('.$_REQUEST['user_id'].')');
		
		if(isset($_REQUEST['password'])){
			// notify new user ---------------------------------------------------------------------------------
			require DIR.'PHPMailer/PHPMailerAutoload.php';	
			
			$template = getEmailTemplate('NEW_USER');
			$txt = $template['body'];
			
			$link = '<a href="'.AROOT.'index.php">'.AROOT.'index.php</a>';
			$text = str_replace('{RECIPIENT}', $_REQUEST['name'], $txt);
			$text = str_replace('{USERNAME}', $_REQUEST['username'], $text);
			$text = str_replace('{PASSWORD}', $password, $text);
			$text = str_replace('{CLICK_HERE_LINK}', $link, $text);
		
			$body = '<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							</head>
							<body>'.nl2br($text).'</body>
						</html>';
			
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			$mail->From = $from_email;
			$mail->FromName = strtoupper($client_prefix).' ผู้ดูแลระบบ (Admin)';
			$mail->addAddress($_REQUEST['email'], $_REQUEST['name']); 
			$mail->isHTML(true);                                  
			$mail->Subject = $template['subject'];
			$mail->Body = $body;
			$mail->WordWrap = 100;
			if(!$mail->send()) {
				echo $mail->ErrorInfo;
			}
		}
		
	}else{
		$err_msg = '<br><br>error'.mysqli_error($dba);
	}
	echo $err_msg;
	exit;
	
?>














