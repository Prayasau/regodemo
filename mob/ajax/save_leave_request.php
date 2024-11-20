<?

	if(session_id()==''){session_start();} 
	ob_start();
	include('../../dbconnect/db_connect.php');
	include('../../files/functions.php');
	
	//var_dump($_REQUEST); //exit;
	//var_dump($_FILES);
	$empinfo = getEmployeeInfo($cid, $_REQUEST['emp_id']);
	
	$uploadmap = DIR.$cid.'/leave/';
	//var_dump($empinfo); exit;
	
	$certificate = 'NA';
	$attachment = '';
	if(!empty($_FILES['attach']['tmp_name'])){
		$ext = pathinfo($_FILES['attach']['name'], PATHINFO_EXTENSION);		
		$file = $_REQUEST['emp_id'].'_'.$_REQUEST['leave_type'].'_'.time().'.'.$ext;
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach']['tmp_name'],$filename)){
			$attachment = ROOT.$cid.'/leave/'.$file;
			$certificate = 'Y';
		}
	}else{
		//$attachment = $_REQUEST['attachment'];
	}
	//var_dump($attachment);
	
	$leave_settings = getLeaveTimeSettings();
	$dayhours = $leave_settings['dayhours'];
	$leave_types = unserialize($leave_settings['leave_types']);

	$dates = $_REQUEST['date'];
	$startdate = $_REQUEST['date'][0];
	$enddate = $_REQUEST['date'][count($dates)-1];


	//check if leave already taken...
	$checkleaves = "SELECT * FROM ".$cid."_leaves_data WHERE date = '".$startdate."'  AND `status`='RQ' AND `emp_id`= '".$_REQUEST['emp_id']."'";
	$resleave = $dbc->query($checkleaves);
	$num_rows = $resleave->num_rows;
	if($num_rows > 0){
		ob_clean();
		echo 'error';
		exit;
	}

	//echo '<pre>';
	//print_r($resleave);
	//echo $startdate;
	//echo '<br>';
	//echo $enddate;
	//echo '</pre>';
	//exit;
	
	$days = $_REQUEST['day'];
	$leave_id = time();
	$tot_days = 0;
	$hours = 0;
	//if(!isset($_REQUEST['certificate'])){$_REQUEST['certificate'] = '';}

	foreach($dates as $k=>$v){
		
		$range[$k]['emp_id'] = $_REQUEST['emp_id'];
		$range[$k]['name'] = $empinfo[$lang.'_name'];
		$range[$k]['phone'] = $empinfo['personal_phone'];
		$range[$k]['leave_type'] = $_REQUEST['leave_type'];
		$range[$k]['date'] = $v;
		$range[$k]['day'] = $days[$k];
		
		if($days[$k] == 'full'){
			$d = 1;
		}else if($days[$k] == 'first' || $days[$k] == 'second'){
			$d = 0.5;
		}else{
			$hrs = explode(' - ', $days[$k]);
			//var_dump($hrs);
			$hourdiff = round((strtotime($hrs[1]) - strtotime($hrs[0]))/3600, 1);
			//var_dump($hourdiff);
			$range[$k]['days'] = $hourdiff/8; //$dayhours
			$d = $hourdiff/8; //$dayhours
		}
		$range[$k]['days'] = $d;
		$range[$k]['status'] = 'RQ';
		$range[$k]['certificate'] = $certificate;
		
		$details[$k]['date'] = $v;
		$details[$k]['day'] = $days[$k];
		$details[$k]['days'] = $d;
		$tot_days += $d;
	}
	$hours = $tot_days * $dayhours;

	//var_dump($details); //exit;

	$email = array();
	$sql = "SELECT name, username FROM ".$cid."_users WHERE type = 'sys'";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){ 
			$email[$row['username']] = $row['name'];
		}
	}
	//var_dump($email); exit;
	
	
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
					<table border="0">
						<tr>
							<th>'.$lng['Employee'].' : </th><td>'.$_REQUEST['emp_id'].' - '.$empinfo[$lang.'_name'].'</td>
						</tr>
						<tr>
							<th>'.$lng['Leave type'].' : </th><td>'.$leave_types[$_REQUEST['leave_type']][$lang].'</td>
						</tr>
						<tr>
							<th>'.$lng['Details'].' : </th>
							<td>';
							foreach($details as $v){
								$tmp = $v['day'];
								if($v['day'] == 'full'){$tmp = $lng['Full day'];}
								if($v['day'] == 'first'){$tmp = $lng['First half'];}
								if($v['day'] == 'second'){$tmp = $lng['Second half'];}
								$body .= date('d-m-Y', strtotime($v['date'])).' &nbsp;&nbsp;&bull;&nbsp;&nbsp; '.$tmp.'<br>';
							}
						$body .= '</td>
						</tr>
						<tr>
							<th>'.$lng['Certificate'].' : </th><td>';
							if(!empty($attachment)){$body .= '<a href="'.$attachment.'">'.$lng['Certificate'].'</a>';}else{$body .= $certificate;}
							//if($_REQUEST['certificate'] == 'H'){$body .= $lng['Handed to HR department or supervisor'];}
							//if($_REQUEST['certificate'] == 'N'){$body .= $lng['No certificate'];}
							//if($_REQUEST['certificate'] == 'NA'){$body .= $lng['NA'];}
						$body .= '</td>
						</tr>
						<tr>
							<th>'.$lng['Reason'].' : </th><td>'.nl2br($_REQUEST['reason']).'</td>
						</tr>
						<tr>
							<th>'.$lng['Date request'].' : </th><td>'.date('d-m-Y @ H:i').'</td>
						</tr>
				</body>
			</html>';

	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	$mail->From = $_SESSION['rego']['username'];
	$mail->FromName = $_SESSION['rego']['name'];
	foreach($email as $k=>$v){
		$mail->addAddress($k, $v); 
	}
	$mail->addReplyTo($_SESSION['rego']['username'], $_SESSION['rego']['name']);
	$mail->isHTML(true);                                  
	$mail->Subject = 'Leave request from '.$empinfo[$lang.'_name'];
	$mail->Body = $body;
	if(!empty($attachment)) {
		$mail->AddAttachment(ROOT.$attachment);
	}	
	$mail->WordWrap = 100;
	//echo $body;
	if(!$mail->send()) {
		echo $mail->ErrorInfo;
	}
	
	//exit;
	
	$sql = "INSERT INTO ".$cid."_leaves (emp_id, name, phone, entity, branch, division, department, team, emp_group, leave_type, start, end, details, days, planned, paid, status, attach, certificate, created, created_by, reason) VALUES (
		'".$dbc->real_escape_string($_REQUEST['emp_id'])."', 
		'".$dbc->real_escape_string($empinfo[$lang.'_name'])."', 
		'".$dbc->real_escape_string($empinfo['personal_phone'])."', 
		
		'".$dbc->real_escape_string($empinfo['entity'])."', 
		'".$dbc->real_escape_string($empinfo['branch'])."', 
		'".$dbc->real_escape_string($empinfo['division'])."', 
		'".$dbc->real_escape_string($empinfo['department'])."', 
		'".$dbc->real_escape_string($empinfo['team'])."', 
		'".$dbc->real_escape_string($empinfo['emp_group'])."', 
		
		'".$dbc->real_escape_string($_REQUEST['leave_type'])."', 
		'".$dbc->real_escape_string($startdate)."', 
		'".$dbc->real_escape_string($enddate)."', 
		'".$dbc->real_escape_string(serialize($details))."', 
		'".$dbc->real_escape_string($tot_days)."',
		
		'".$dbc->real_escape_string($leave_types[$_REQUEST['leave_type']]['planned'])."', 
		'".$dbc->real_escape_string($leave_types[$_REQUEST['leave_type']]['paid'])."', 

		'".$dbc->real_escape_string('RQ')."', 
		'".$dbc->real_escape_string($attachment)."', 
		'".$dbc->real_escape_string($certificate)."', 
		'".$dbc->real_escape_string(date('d-m-Y @ H:i'))."', 
		'".$dbc->real_escape_string($empinfo[$lang.'_name'])."',
		'".$dbc->real_escape_string($_REQUEST['reason'])."')";
	//echo $sql;	
	
	$leave_id = 0;
	if(!$dbc->query($sql)){
		echo mysqli_error($dbc);
	}else{
		$leave_id = $dbc->insert_id;
	}
	//exit;
	
	$sql = "INSERT INTO ".$cid."_leaves_data (emp_id, name, phone, entity, branch, division, department, team, emp_group, leave_type, date, day, days, planned, paid, hours, status, certificate, reason, leave_id) VALUES ";
	foreach($range as $k=>$v){
		$sql .= "
			('".$dbc->real_escape_string($_REQUEST['emp_id'])."', 
			'".$dbc->real_escape_string($empinfo[$lang.'_name'])."', 
			'".$dbc->real_escape_string($empinfo['personal_phone'])."', 
			
			'".$dbc->real_escape_string($empinfo['entity'])."', 
			'".$dbc->real_escape_string($empinfo['branch'])."', 
			'".$dbc->real_escape_string($empinfo['division'])."', 
			'".$dbc->real_escape_string($empinfo['department'])."', 
			'".$dbc->real_escape_string($empinfo['team'])."', 
			'".$dbc->real_escape_string($empinfo['emp_group'])."', 
			
			'".$dbc->real_escape_string($_REQUEST['leave_type'])."', 
			'".$dbc->real_escape_string($v['date'])."', 
			'".$dbc->real_escape_string($v['day'])."', 
			'".$dbc->real_escape_string($v['days'])."',
		
			'".$dbc->real_escape_string($leave_types[$_REQUEST['leave_type']]['planned'])."', 
			'".$dbc->real_escape_string($leave_types[$_REQUEST['leave_type']]['paid'])."', 

			'".$dbc->real_escape_string($hours)."', 
			'".$dbc->real_escape_string($v['status'])."', 
			'".$dbc->real_escape_string($certificate)."', 
			'".$dbc->real_escape_string($_REQUEST['reason'])."', 
			'".$dbc->real_escape_string($leave_id)."'),";
		
	}
	$sql = substr($sql, 0, -1);
	//echo $sql;	
	
	if(!$dbc->query($sql)){
		echo mysqli_error($dbc);
	}



















