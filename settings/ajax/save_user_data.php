<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	$_REQUEST['firstname'] = '';
	$_REQUEST['lastname'] = '';

	//var_dump($_REQUEST); 
	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// exit;

	$emp_id = $_REQUEST['emp_id'];
	$name = $_REQUEST['name'];
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$phone = $_REQUEST['personal_phone'];
	$img = $_REQUEST['img'];
	$img_data = $_REQUEST['img_data'];
	$type = $_REQUEST['type'];
	$entities = $_REQUEST['entities'];
	$divisions = $_REQUEST['divisions'];
	$branches = $_REQUEST['branches'];
	$departments = $_REQUEST['departments'];
	$groups = $_REQUEST['groups'];
	$teams = $_REQUEST['teams'];
	$accessR = $_REQUEST['access'];
	$access = $_REQUEST['access'];
	$access_selection = $_REQUEST['access_selection'];
	$emp_group = $_REQUEST['emp_group'];
	$comp_activity = $_REQUEST['activity'];

	unset($_REQUEST['id'], $_REQUEST['entities'], $_REQUEST['access'], $_REQUEST['branches'], $_REQUEST['divisions'], $_REQUEST['departments'], $_REQUEST['groups'],$_REQUEST['teams'], $_REQUEST['access_selection'], $_REQUEST['emp_group'], $_REQUEST['status'], $_REQUEST['type'], $_REQUEST['personal_phone'], $_REQUEST['password'], $_REQUEST['username'], $_REQUEST['img'], $_REQUEST['img_data'], $_REQUEST['emp_id'], $_REQUEST['name'], $_REQUEST['activity'], $_REQUEST['firstname'], $_REQUEST['lastname']);

	$permission = $_REQUEST;
	
	$username = preg_replace('/\s+/', '', strtolower($username));
	
	$data = array();
	if($res = $dbc->query("SELECT emp_id, image, firstname, lastname, en_name, th_name, personal_phone FROM ".$cid."_employees WHERE LOWER(personal_email) = '".$username."'")){
		if($row = $res->fetch_assoc()){
			$img = $row['image'];
			if(empty($img)){
				$img = 'images/profile_image.jpg';
			}
			$emp_id = $row['emp_id'];
			$personal_phone = $row['personal_phone'];
			$img = $img;
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$name = $row[$lang.'_name'];
		}
	}
	//var_dump($_REQUEST); exit;
	
	if(isset($img_data) && strlen($img_data) < 20){unset($img_data);}
	if(isset($img_data)){
		$uploadmap = '../../'.$cid.'/';
		if (!file_exists($uploadmap)) {
			mkdir($uploadmap, 0777, true);
		}
		if(!empty($emp_id)){
			$avatar = $emp_id;
		}else{
			$avatar = time();
		}
		$filename = $uploadmap.'user_'.str_replace(' ', '', $avatar).'.jpg';
		$db_filename = $cid.'/user_'.str_replace(' ', '', $avatar).'.jpg';
		$img_data = utf8_decode($img_data);
		$base64img = str_replace('data:image/png;base64,', '', $img_data);
		$data = base64_decode($base64img);
		$source = imagecreatefromstring($data);
		$imageSave = imagejpeg($source,$filename,80);
		imagedestroy($source);
		if(!$imageSave){
			$err_msg .= '<p>Error</p>';
			//var_dump($err_msg);
		}
		$img = $db_filename;
		unset($img_data);
	}

	$last_id = false;
	$text = '';
	
	$a_exist = false;
	if($res = $dbx->query("SELECT * FROM rego_all_users WHERE LOWER(username) = '".$username."'")){
		$a_exist = $res->fetch_assoc();
	}else{
		var_dump(mysqli_error($dbx)); //exit;
	}
	//var_dump($a_exist); //exit;
	
	$c_exist = false;
	if($res = $dbc->query("SELECT * FROM ".$cid."_users WHERE LOWER(username) = '".$username."' AND type = '".$type."'")){
		$c_exist = $res->fetch_assoc();
	}else{
		var_dump(mysqli_error($dbc)); //exit;
	}
	//var_dump($c_exist); //exit;
	
	if($a_exist){
		//var_dump('Exist');

		if($type == 'sys' || $type == 'app'){
			$access = $a_exist['sys_access'];
			if($access == ''){
				$access = $cid;
			}else{
				if(!preg_match("/{$cid}/i", $access)) {
					$access .= ','.$cid;
				}
			}

		}elseif($type == 'comp'){
			$access = $a_exist['com_access'];
			if($access == ''){
				$access = $cid;
			}else{
				if(!preg_match("/{$cid}/i", $access)) {
					$access .= ','.$cid;
				}
			}
		}elseif($type == 'emp'){
			$access = $a_exist['emp_access'];
			if($access == ''){
				$access = $cid;
			}else{
				if(!preg_match("/{$cid}/i", $access)) {
					$access .= ','.$cid;
				}
			}
		}
		
		
		if($type == 'sys' || $type == 'app'){

			$accessCode = "sys_access = '".$access."'";
			$accessstatus = "sys_status = '1'";

		}elseif($type == 'comp'){

			$accessCode = "com_access = '".$access."'";
			$accessstatus = "com_status = '1'";

		}elseif($type == 'emp'){

			$accessCode = "emp_access = '".$access."'";
			$accessstatus = "emp_status = '1'";
		}	
		//var_dump($access); exit;

		if($a_exist['type'] == 'sys'){ $typeNew = 'sys';}else{$typeNew = $type; } //sys is main
			
		if($res = $dbx->query("UPDATE rego_all_users SET phone='".$personal_phone."', img = '".$img."', ".$accessCode.", last = '".$cid."', type = '".$typeNew."', ".$accessstatus." WHERE LOWER(username) = '".$username."'")){
			var_dump('UPDATE rego_all_users SET emp_id, emp_access, img, sys_access, last, type, sys_status');
		}else{
			var_dump(mysqli_error($dbx)); //exit;
		}

		if(!$c_exist){

				$last_id = $a_exist['id'];
				$currentDate = date('d-m-Y');
				$futureDate  = date('d-m-Y', strtotime('+1 year'));
				//save user data with access and permissions...
				$sql = "INSERT INTO ".$cid."_users (ref, firstname, name, phone, username, emp_id, type, access, entities, branches, divisions, departments, teams, groups, access_selection, permissions, activities, emp_group, img, status, access_start, access_end) VALUES ("; 
					$sql .= "'".$dbc->real_escape_string($last_id)."',";
					$sql .= "'".$dbc->real_escape_string($firstname)."',";
					$sql .= "'".$dbc->real_escape_string($name)."',";
					$sql .= "'".$dbc->real_escape_string($phone)."',";
					$sql .= "'".$dbc->real_escape_string($username)."',";
					$sql .= "'".$dbc->real_escape_string($emp_id)."',";
					$sql .= "'".$dbc->real_escape_string($type)."',";
					$sql .= "'".$dbc->real_escape_string($accessR)."',";
					$sql .= "'".$dbc->real_escape_string($entities)."',";
					$sql .= "'".$dbc->real_escape_string($branches)."',";
					$sql .= "'".$dbc->real_escape_string($divisions)."',";
					$sql .= "'".$dbc->real_escape_string($departments)."',";
					$sql .= "'".$dbc->real_escape_string($teams)."',";
					$sql .= "'".$dbc->real_escape_string($groups)."',";
					$sql .= "'".$dbc->real_escape_string($access_selection)."',";
					$sql .= "'".$dbc->real_escape_string(serialize($_REQUEST))."',";
					$sql .= "'".$dbc->real_escape_string(serialize($comp_activity))."',";
					$sql .= "'".$dbc->real_escape_string($emp_group)."',";
					$sql .= "'".$dbc->real_escape_string($img)."',";
					$sql .= "'".$dbc->real_escape_string(1)."',";
					$sql .= "'".$dbc->real_escape_string($currentDate)."',";
					$sql .= "'".$dbc->real_escape_string($futureDate)."')";

				if($dbc->query($sql)){
					var_dump('INSERT INTO $cid_users (ref, firstname, name, username, emp_id, type, img, status');
				}else{
					var_dump(mysqli_error($dbc)); 
				}	
		}

	
	}else{

		if($type == 'sys' || $type == 'app'){
			$accessSYS = $cid;
			$StatusSYS = 1;
		}elseif($type == 'comp'){
			$accessCOM = $cid;
			$StatusCOM = 1;
		}elseif($type == 'emp'){
			$accessEMP = $cid;
			$StatusEMP = 1;
		}else{
			$accessSYS = $accessCOM = $accessEMP = '';
			$StatusSYS = $StatusCOM = $StatusEMP = '';
		}
		//var_dump('Not exist'); //exit;
		$sql = "INSERT INTO rego_all_users (firstname, lastname, phone, username, password, sys_access, com_access, emp_access, last, sys_status, com_status, emp_status, img, type) VALUES ("; 
			$sql .= "'".$dbx->real_escape_string($firstname)."',";
			$sql .= "'".$dbx->real_escape_string($lastname)."',";
			$sql .= "'".$dbx->real_escape_string($personal_phone)."',";
			$sql .= "'".$dbx->real_escape_string($username)."',";
			$sql .= "'".$dbx->real_escape_string(hash('sha256', $password))."',";
			$sql .= "'".$dbx->real_escape_string($accessSYS)."',";
			$sql .= "'".$dbx->real_escape_string($accessCOM)."',";
			$sql .= "'".$dbx->real_escape_string($accessEMP)."',";
			$sql .= "'".$dbx->real_escape_string($cid)."',";
			$sql .= "'".$dbx->real_escape_string($StatusSYS)."',";
			$sql .= "'".$dbx->real_escape_string($StatusCOM)."',";
			$sql .= "'".$dbx->real_escape_string($StatusEMP)."',";
			$sql .= "'".$dbx->real_escape_string($img)."',";
			$sql .= "'".$dbx->real_escape_string($type)."')";
		//echo $sql;
		if(!$dbx->query($sql)){
			echo mysqli_error($dbx);
		}else{
			//var_dump('INSERT INTO rego_all_users (firstname, lastname, username, password, sys_access, last, sys_status, img, type');
			$last_id = $dbx->insert_id;
			
			$template = getEmailTemplate('NEW_COMPANY');
			$txt = $template['body'];
			$text = str_replace('{RECIPIENT}', $firstname, $txt);
			$text = str_replace('{COMPANY}', $compinfo[$lang.'_compname'], $text);
			$text = str_replace('{USERNAME}', '<a href="#" style="text-decoration:none; color:#000; cursor:text">'.$username.'</a>', $text);
			$text = str_replace('{PASSWORD}', '<a href="#" style="text-decoration:none; color:#000; cursor:text">'.$password.'</a>', $text);
			$text = str_replace('{CLICK_HERE_LINK}', $protocol.$_SERVER['SERVER_NAME'], $text);
			$text = str_replace('{SIGNATURE}', $_SESSION['rego']['name'], $text);
			//var_dump($template); //exit;
		}
		
	}
	
	//var_dump($last_id);
	
	
	if(!$c_exist && $last_id){ 

		$currentDate = date('d-m-Y');
		$futureDate  = date('d-m-Y', strtotime('+1 year'));
		//save user data with access and permissions...
		$sql = "INSERT INTO ".$cid."_users (ref, firstname, name, phone, username, emp_id, type, access, entities, branches, divisions, departments, teams, groups, access_selection, permissions, activities, emp_group, img, status, access_start, access_end) VALUES ("; 
			$sql .= "'".$dbx->real_escape_string($last_id)."',";
			$sql .= "'".$dbx->real_escape_string($firstname)."',";
			$sql .= "'".$dbx->real_escape_string($name)."',";
			$sql .= "'".$dbx->real_escape_string($phone)."',";
			$sql .= "'".$dbx->real_escape_string($username)."',";
			$sql .= "'".$dbx->real_escape_string($emp_id)."',";
			$sql .= "'".$dbx->real_escape_string($type)."',";
			$sql .= "'".$dbx->real_escape_string($access)."',";
			$sql .= "'".$dbx->real_escape_string($entities)."',";
			$sql .= "'".$dbx->real_escape_string($branches)."',";
			$sql .= "'".$dbx->real_escape_string($divisions)."',";
			$sql .= "'".$dbx->real_escape_string($departments)."',";
			$sql .= "'".$dbx->real_escape_string($teams)."',";
			$sql .= "'".$dbx->real_escape_string($groups)."',";
			$sql .= "'".$dbx->real_escape_string($access_selection)."',";
			$sql .= "'".$dbx->real_escape_string(serialize($_REQUEST))."',";
			$sql .= "'".$dbx->real_escape_string(serialize($comp_activity))."',";
			$sql .= "'".$dbx->real_escape_string($emp_group)."',";
			$sql .= "'".$dbx->real_escape_string($img)."',";
			$sql .= "'".$dbx->real_escape_string(1)."',";
			$sql .= "'".$dbx->real_escape_string($currentDate)."',";
			$sql .= "'".$dbx->real_escape_string($futureDate)."')";

			//echo $sql; die('abarrrba');
		if($dbc->query($sql)){ 
			var_dump('INSERT INTO $cid_users (ref, firstname, name, username, emp_id, type, img, status');
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
	}else{
		//
	}

	if($type == 'emp'){
	
		if($dbc->query("UPDATE ".$cid."_employees SET allow_login = '1' WHERE emp_id = '".$emp_id."'")){
			var_dump('UPDATE $cid_employees SET allow_login = 1');
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
	}

	if(!empty($text)){
		require DIR.'PHPMailer/PHPMailerAutoload.php';	
		$mail_subject = 'New user Login for '.$name;
		$body = '<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>
						<body style="font-size:16px">'.nl2br($text).'</body>
					</html>';
		
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		$mail->From = 'noreply@regodemo.com';
		$mail->FromName = 'REGO DEMO';
		$mail->addAddress($username, $name); 
		$mail->isHTML(true);                                  
		$mail->Subject = $mail_subject;
		$mail->Body = $body;
		$mail->WordWrap = 100;
		if(!$mail->send()) {
			//echo $mail->ErrorInfo;
		}else{
			//echo 'success';
			//$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp;&nbsp;eMail send to <b>'.$_REQUEST['name'].'</b>.<br>';
		}


		//== Save info into log data ==//
		writeToLogfile('action', 'New user ('.$username.') added in company ('.$cid.')');
	}
	
	ob_clean(); //exit;
	echo 'success';


