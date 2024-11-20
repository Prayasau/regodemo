<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR."files/functions.php");
	//var_dump($_REQUEST); //exit;
	
	$username = preg_replace('/\s+/', '', strtolower($_REQUEST['username']));
	$data = array();
	if($res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$_REQUEST['id']."'")){
		if($row = $res->fetch_assoc()){
			$data['emp_id'] = $row['emp_id'];
			$data['name'] = $row[$lang.'_name'];
			$data['firstname'] = $row['firstname'];
			$data['lastname'] = $row['lastname'];
			$data['img'] = $row['image'];
			if(empty($data['img'])){
				$data['img'] = 'images/profile_image.jpg';
			}
		}
	}
	//var_dump($data); //exit;
	
	$password = generateStrongPassword(8, false);//randomPassword();
	$password = $username;
	
	$a_exist = false;
	if($res = $dbx->query("SELECT * FROM rego_all_users WHERE LOWER(username) = '".$username."'")){
		$a_exist = $res->fetch_assoc();
	}else{
		var_dump(mysqli_error($dbx)); //exit;
	}
	//var_dump($a_exist); //exit;
	
	if($_REQUEST['val'] == '1'){
		$send_mail = false;
		$last_id = false;

		if(!$a_exist){
			
			$sql = "INSERT INTO rego_all_users (firstname, lastname, username, password, last, type, emp_id, emp_access, emp_status, img) VALUES ("; 
				$sql .= "'".$dbx->real_escape_string($data['firstname'])."',";
				$sql .= "'".$dbx->real_escape_string($data['lastname'])."',";
				$sql .= "'".$dbx->real_escape_string($username)."',";
				$sql .= "'".$dbx->real_escape_string(hash('sha256', $password))."',";
				$sql .= "'".$dbx->real_escape_string($cid)."',";
				$sql .= "'".$dbx->real_escape_string('emp')."',";
				$sql .= "'".$dbx->real_escape_string($data['emp_id'])."',";
				$sql .= "'".$dbx->real_escape_string($cid)."',";
				$sql .= "'".$dbx->real_escape_string(1)."',";
				$sql .= "'".$dbx->real_escape_string($data['img'])."')";
			if($dbx->query($sql)){
				$send_mail = true;
				$last_id = $dbx->insert_id;
				//var_dump('INSERT INTO rego_all_users (firstname, lastname, username, password, last, type, emp_id, emp_access, emp_status, img)');
			}else{
				var_dump(mysqli_error($dbx)); //exit;
			}
		}else{

			if($a_exist['sys_status'] == 1){
				$addcondition = '';
			}else{
				$passreset = hash('sha256', $username);
				$addcondition = "password = '".$passreset."',";
			}

			
			$last_id = $a_exist['id'];
			if($dbx->query("UPDATE rego_all_users SET ".$addcondition." emp_id = '".$data['emp_id']."', img = '".$data['img']."', emp_access = '".$cid."', emp_status = '1' WHERE id = '".$a_exist['id']."'")){
				var_dump('UPDATE rego_all_users SET access, emp_id, img, emp_access, emp_status');
			}else{
				var_dump(mysqli_error($dbx)); //exit;
			}
		}
		
		$c_exist = false;
		if($res = $dbc->query("SELECT * FROM ".$cid."_users WHERE LOWER(username) = '".$username."' AND type = 'emp'")){
			$c_exist = $res->fetch_assoc();
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
		//var_dump($c_exist); //exit;
		
		if(!$c_exist && $last_id){
			$sql = "INSERT INTO ".$cid."_users (ref, firstname, name, username, emp_id, type, img, status) VALUES ("; 
				$sql .= "'".$dbx->real_escape_string($last_id)."',";
				$sql .= "'".$dbx->real_escape_string($data['firstname'])."',";
				$sql .= "'".$dbx->real_escape_string($data['name'])."',";
				$sql .= "'".$dbx->real_escape_string($username)."',";
				$sql .= "'".$dbx->real_escape_string($data['emp_id'])."',";
				$sql .= "'".$dbx->real_escape_string('emp')."',";
				$sql .= "'".$dbx->real_escape_string($data['img'])."',";
				$sql .= "'".$dbx->real_escape_string(1)."')";
				//echo $sql;
			if($dbc->query($sql)){
				var_dump('INSERT INTO $cid_users (ref, firstname, name, username, emp_id, type, img, status');
			}else{
				var_dump(mysqli_error($dbc)); //exit;
			}
		}
		
		if($dbc->query("UPDATE ".$cid."_employees SET allow_login = '1' WHERE emp_id = '".$_REQUEST['id']."'")){
			var_dump('UPDATE $cid_employees SET allow_login = 1');
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
		
		if($send_mail){
			$template = getEmailTemplate('NEW_EMP_USER');
			$txt = $template['body'];
			//if(empty($template['sub'])){$template['sub'] = 'ขอรหัสผ่านใหม่ (New employee user)';}
			//var_dump($template); exit;
			$text = str_replace('{RECIPIENT}', $data['name'], $txt);
			$text = str_replace('{COMPANY}', $compinfo[$lang.'_compname'], $text);
			$text = str_replace('{USERNAME}', '<b>'.$username.'</b>', $text);
			$text = str_replace('{PASSWORD}', '<b>'.$password.'</b>', $text);
			$text = str_replace('{CLICK_HERE_LINK}', '<a href="'.$protocol.$_SERVER['SERVER_NAME'].'" style="text-decoration:underline">'.$protocol.$_SERVER['SERVER_NAME'].'</a>', $text);
			$text = str_replace('{REPLY_EMAIL}', '<a href="mailto:'.$comp_settings['comp_email'].'" style="text-decoration:underline">'.$comp_settings['comp_email'].'</a>', $text);
			//var_dump($template); //exit;
			//var_dump($text); //exit;

			require DIR.'PHPMailer/PHPMailerAutoload.php';	
			$link = "<a href='".ROOT."mob'>".ROOT."mob</a>";
			//var_dump($link); exit;
			$body = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					</head>
					<body>".nl2br($text)."</body></html>";
			//echo($body); exit;
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			$mail->From = $from_email;
			$mail->FromName = strtoupper($client_prefix).' ผู้ดูแลระบบ (Admin)';
			$mail->addAddress($username, $data['firstname']);
			$mail->isHTML(true);                                  
			$mail->Subject = $template['sub'];
			$mail->Body = $body;
			$mail->WordWrap = 100;                                
			if(!$mail->send()) {
				 //ob_clean(); echo 'connection'; exit;
			}
		}
		ob_clean();
		echo 'success';
		exit; 
	}
		

	//SET EMPLOYEE ACCESS IS "NO"

	if($_REQUEST['val'] == '0'){

		$c_exist = false;
		if($res = $dbc->query("SELECT * FROM ".$cid."_users WHERE LOWER(username) = '".$username."' AND type = 'emp'")){
			$c_exist = $res->fetch_assoc();
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
		//var_dump($c_exist); exit;
		
		if(!$c_exist){
			if($dbc->query("UPDATE ".$cid."_employees SET allow_login = '0' WHERE emp_id = '".$_REQUEST['id']."'")){
				var_dump('UPDATE $cid_employees SET allow_login = 0'); 
			}else{
				var_dump(mysqli_error($dbc)); //exit;
			}
			ob_clean();
			echo 'success';
			exit; 
		}else{
			if($c_exist['type'] == 'emp'){
				if($dbc->query("DELETE FROM ".$cid."_users WHERE id = '".$c_exist['id']."'")){
					var_dump('DELETE FROM $cid_users');
				}else{
					var_dump(mysqli_error($dbc)); //exit;
				}
			}
		}
		
		if($a_exist){

			//echo 'inside'; //exit;
			if($a_exist['type'] == 'emp'){
				if($dbx->query("DELETE FROM rego_all_users WHERE id = '".$c_exist['ref']."'")){
					var_dump('DELETE FROM rego_all_users');
				}else{
					var_dump(mysqli_error($dbx)); //exit;
				}

			}else{

				//$access = str_replace($cid.',', '', $a_exist['access']);
				// update rego_all_users
				$sqqry = "UPDATE rego_all_users SET emp_id='',emp_access='',emp_status='' WHERE id = '".$c_exist['ref']."'";
				if($dbx->query($sqqry)){
					ob_clean();
					var_dump('UPDATE rego_all_users SET emp_status = 0'); 
					//echo 'updated'; 
					//exit;
				}else{
					var_dump(mysqli_error($dbx)); //exit;
				}
			}
		}

		//echo 'not aexist'; exit;
		
		if($dbc->query("UPDATE ".$cid."_employees SET allow_login = '0' WHERE emp_id = '".$_REQUEST['id']."'")){
			var_dump('UPDATE $cid_employees SET allow_login = 0');
			//echo 'success';
			//exit; 
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
		
		ob_clean();
		echo 'success';
		exit; 
	}
	







