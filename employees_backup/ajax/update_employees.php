<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	//var_dump($_REQUEST); exit;
	//var_dump($_FILES); //exit;

	unset($_REQUEST['addComp']);
	$update = 0;
	if(isset($_REQUEST['updateEmp'])){
		$update = $_REQUEST['updateEmp'];
		unset($_REQUEST['updateEmp']);
	}

	//====== emp allow deduct table data========//
	$ADemp_id = $_REQUEST['emp_id'];
	$emp_AD = $_REQUEST['emp_AD'];
	unset($_REQUEST['emp_AD']);
	
	unset($_REQUEST['end_date']);
	unset($_REQUEST['salary']);
	unset($_REQUEST['other_benifits']);
	//====== emp allow deduct table data========//

	
	$teamsValue = $_REQUEST['teams'];
	$teamsNameValue = $_REQUEST['team_name'];


	$teamValArray =  array(

		'teams' => $teamsValue,
		'team_name' => $teamsNameValue,

	);

	$serializeTeam = serialize($teamValArray);

	$_REQUEST['attach4'] = $serializeTeam;



	if(empty($_REQUEST['emp_id'])){echo 'empty'; exit;}
	
	$_REQUEST['emp_id'] = str_replace(' ', '', $_REQUEST['emp_id']);
	$_SESSION['rego']['empID'] = $_REQUEST['emp_id'];
	
	//$_REQUEST['personal_email'] = strtolower($_REQUEST['personal_email']);
	//$_REQUEST['work_email'] = strtolower($_REQUEST['work_email']);
	
	if(isset($_REQUEST['firstname'])){$_REQUEST['th_name'] = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];}
	
	if(isset($_REQUEST['idcard_nr'])){$_REQUEST['idcard_nr'] = str_replace('-','',$_REQUEST['idcard_nr']);}
	
	// if(isset($_REQUEST['joining_date'])){
	// 	if(empty($_REQUEST['joining_date'])){
	// 		unset($_REQUEST['joining_date']);
	// 	}else{
	// 		$_REQUEST['joining_date'] = date('Y-m-d', strtotime($_REQUEST['joining_date']));
	// 	}
	// }
	if(isset($_REQUEST['resign_date'])){
		if(empty($_REQUEST['resign_date'])){
			unset($_REQUEST['resign_date']);
		}else{
			$_REQUEST['resign_date'] = date('Y-m-d', strtotime($_REQUEST['resign_date']));
		}
	}
	if(isset($_REQUEST['start_date'])){
		if(empty($_REQUEST['start_date'])){
			unset($_REQUEST['start_date']);
		}else{
			$_REQUEST['start_date'] = date('Y-m-d', strtotime($_REQUEST['start_date']));
		}
	}

	if(isset($_REQUEST['reg_date_pvf'])){
		if(empty($_REQUEST['reg_date_pvf'])){
			unset($_REQUEST['reg_date_pvf']);
		}else{
			$_REQUEST['reg_date_pvf'] = date('Y-m-d', strtotime($_REQUEST['reg_date_pvf']));
		}
	}
	$_REQUEST['emergency_contacts'] = serialize($_REQUEST['emergency_contacts']);
	$_REQUEST['hospitals'] = serialize($_REQUEST['hospitals']);
	
	/*$history = array();
	$olddata = array();
	$sql = "SELECT joining_date, probation_date, branch, department, team, emp_group, emp_type, resign_date, resign_reason, emp_status, account_code, position, head_branch, head_division, head_department, line_manager, team_supervisor, date_position, shift_team, time_reg, selfie, annual_leave, leave_approve FROM ".$cid."_employees WHERE emp_id = '".$_REQUEST['emp_id']."'";
	if($res = $dbc->query($sql)){
		$olddata = $res->fetch_assoc();
	}else{
		echo mysqli_error($dbc);
	}
	foreach($olddata as $k=>$v){
		if(isset($_REQUEST[$k]) && $_REQUEST[$k] != $v){
			$history[] = array('field'=>$k, 'prev'=>$v, 'new'=>$_REQUEST[$k], 'user'=>$_SESSION['rego']['name']);
		}
	}
	var_dump($history); //exit;
	var_dump($olddata); exit;*/
	
	/*if(!empty($_REQUEST['resign_date'])){
		$_REQUEST['resign_date'] = date('Y-m-d', strtotime($_REQUEST['resign_date']));
	}else{
		$_REQUEST['resign_date'] = '';
	}*/
	
	//var_dump($_REQUEST); exit;
	
	$uploadmap = '../../'.$cid.'/employees/';
  if(!file_exists($uploadmap)){
   	mkdir($uploadmap);
	}
	if(!empty($_FILES['att_idcard']['tmp_name'])){
		$ext = pathinfo($_FILES['att_idcard']['name'], PATHINFO_EXTENSION);		
		$file = $_REQUEST['emp_id'].'_idcard.'.$ext;
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['att_idcard']['tmp_name'],$filename)){
			$_REQUEST['att_idcard'] = $file;
		}
	}
	if(!empty($_FILES['att_housebook']['tmp_name'])){
		$ext = pathinfo($_FILES['att_housebook']['name'], PATHINFO_EXTENSION);		
		$file = $_REQUEST['emp_id'].'_housebook.'.$ext;
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['att_housebook']['tmp_name'],$filename)){
			$_REQUEST['att_housebook'] = $file;
		}
	}
	if(!empty($_FILES['attach1']['tmp_name'])){
		$ext = pathinfo($_FILES['attach1']['name'], PATHINFO_EXTENSION);
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach1']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach1']['tmp_name'],$filename)){
			$_REQUEST['attach1'] = $file;
		}
	}
	if(!empty($_FILES['attach2']['tmp_name'])){
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach2']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach2']['tmp_name'],$filename)){
			$_REQUEST['attach2'] = $file;
		}
	}
	if(!empty($_FILES['attach3']['tmp_name'])){
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach3']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach3']['tmp_name'],$filename)){
			$_REQUEST['attach3'] = $file;
		}
	}
	// if(!empty($_FILES['attach4']['tmp_name'])){
	// 	$file = $_REQUEST['emp_id'].'_'.$_FILES['attach4']['name'];		
	// 	$filename = $uploadmap.$file;
	// 	if(move_uploaded_file($_FILES['attach4']['tmp_name'],$filename)){
	// 		$_REQUEST['attach4'] = $file;
	// 	}
	// }
	
	if(!empty($_FILES['att_bankbook']['tmp_name'])){
		$ext = pathinfo($_FILES['att_bankbook']['name'], PATHINFO_EXTENSION);		
		$file = $_REQUEST['emp_id'].'_bankbook.'.$ext;
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['att_bankbook']['tmp_name'],$filename)){
			$_REQUEST['att_bankbook'] = $file;
		}
	}
	if(!empty($_FILES['att_contract']['tmp_name'])){
		$ext = pathinfo($_FILES['att_contract']['name'], PATHINFO_EXTENSION);		
		$file = $_REQUEST['emp_id'].'_contract.'.$ext;
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['att_contract']['tmp_name'],$filename)){
			$_REQUEST['att_contract'] = $file;
		}
	}
	if(!empty($_FILES['attach5']['tmp_name'])){
		$ext = pathinfo($_FILES['attach5']['name'], PATHINFO_EXTENSION);
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach5']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach5']['tmp_name'],$filename)){
			$_REQUEST['attach5'] = $file;
		}
	}
	if(!empty($_FILES['attach6']['tmp_name'])){
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach6']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach6']['tmp_name'],$filename)){
			$_REQUEST['attach6'] = $file;
		}
	}
	if(!empty($_FILES['attach7']['tmp_name'])){
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach7']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach7']['tmp_name'],$filename)){
			$_REQUEST['attach7'] = $file;
		}
	}
	if(!empty($_FILES['attach8']['tmp_name'])){
		$file = $_REQUEST['emp_id'].'_'.$_FILES['attach8']['name'];		
		$filename = $uploadmap.$file;
		if(move_uploaded_file($_FILES['attach8']['tmp_name'],$filename)){
			$_REQUEST['attach8'] = $file;
		}
	}

	$olddata = array();
	if($update == 1){

		$myarr = array(); 
		$history = array(); 
		$newdata = $_REQUEST;
		unset($newdata['attach4']);
		unset($newdata['emergency_contacts']);
		unset($newdata['hospitals']);

		
		$sql1 = "SELECT * FROM ".$_SESSION['rego']['emp_dbase']." WHERE emp_id = '".$ADemp_id."'";
		if($res1 = $dbc->query($sql1)){
			if($row1 = $res1->fetch_assoc()){
				$olddata = $row1;
			}
		}

		include('db_array/db_array_emp.php');
		foreach($newdata as $k=>$v){
			if($v != $olddata[$k] && isset($emp_db[$k])){
				$history[] = array('field'=>$emp_db[$k], 'prev'=>$olddata[$k], 'new'=>$v, 'user'=>$_SESSION['rego']['name']);
			}
		}

		//update to Emp career log...
		if(!empty($history)){
			foreach($history as $k=>$v){
				$dbc->query("INSERT INTO ".$cid."_employee_log (emp_id, field, prev, new, user) VALUES ('".$ADemp_id."','".$v['field']."','".$v['prev']."','".$v['new']."','".$v['user']."' ) ");
			}
		}
	}

	/*============== Update default values ============== */
	if(!empty($olddata)){
		if(!isset($olddata['position'])){ $_REQUEST['position'] = $sys_settings['position'];}
		if(!isset($olddata['emp_type'])){ $_REQUEST['emp_type'] = $sys_settings['emp_type'];}
		if(!isset($olddata['emp_status'])){ $_REQUEST['emp_status'] = $sys_settings['emp_status'];}
		if(!isset($olddata['calc_tax'])){ $_REQUEST['calc_tax'] = $sys_settings['calc_tax'];}
		if(!isset($olddata['calc_method'])){ $_REQUEST['calc_method'] = $sys_settings['calc_method'];}
		if(!isset($olddata['calc_sso'])){ $_REQUEST['calc_sso'] = $sys_settings['calc_sso'];}
		if(!isset($olddata['contract_type'])){ $_REQUEST['contract_type'] = $sys_settings['contract_type'];}
		if(!isset($olddata['calc_base'])){ $_REQUEST['calc_base'] = $sys_settings['calc_base'];}
		if(!isset($olddata['calc_psf'])){ $_REQUEST['calc_psf'] = $sys_settings['calc_psf'];}
		if(!isset($olddata['calc_pvf'])){ $_REQUEST['calc_pvf'] = $sys_settings['calc_pvf'];}
		if(!isset($olddata['account_code'])){ $_REQUEST['account_code'] = $sys_settings['account_code'];}
	}


	// CHECK IF SCAN ID SETTING IS ENABLED FROM DEFAULTS 

	$scan_idField = $sys_settings['scan_id'];

	if($scan_idField == '1')
	{
		$_REQUEST['sid'] = $ADemp_id;
	}
	

	if($_REQUEST['new_employee_check'] == '1')
	{
		// update default value for some fields 

		$_REQUEST['calc_tax'] = $sys_settings['calc_tax'];
		$_REQUEST['calc_method'] = $sys_settings['calc_method'];
		$_REQUEST['calc_sso'] = $sys_settings['calc_sso'];
		$_REQUEST['contract_type'] = $sys_settings['contract_type'];
		$_REQUEST['calc_base'] = $sys_settings['calc_base'];
		$_REQUEST['calc_psf'] = $sys_settings['calc_psf'];
		$_REQUEST['calc_pvf'] = $sys_settings['calc_pvf'];

	}

	// remove the extra columns which are not in the databse but are used above 

	unset($_REQUEST['new_employee_check']);


	$monthValue = $month=date("m",strtotime($_REQUEST['joining_date']));
	$empIdValue = $_REQUEST['emp_id'];
	$joiningDateValue = date('Y-m-d',strtotime($_REQUEST['joining_date']));
	$headBranchValue = $_REQUEST['branch'];
	$headDivisonValue = $_REQUEST['division'];
	$headDepartmentValue = $_REQUEST['department'];
	$headTeamValue = $_REQUEST['team'];



	$dbc->query("INSERT INTO ".$cid."_employee_career (month, emp_id, start_date, head_branch, head_division,head_department,team_supervisor,position) VALUES ('".$monthValue."','".$empIdValue."','".$joiningDateValue."','".$headBranchValue."','".$headDivisonValue."','".$headDepartmentValue."','".$headTeamValue."','1' ) ");

	$sql = "INSERT INTO ".$cid."_employees (";
	foreach($_REQUEST as $k=>$v){
		$sql .= $k.', ';
	}
	$sql = substr($sql,0,-2);
	$sql .= ") VALUES ("; 
	foreach($_REQUEST as $k=>$v){
		$sql .= "'".mysqli_real_escape_string($dbc,$v)."', ";
	}
	$sql = substr($sql,0,-2).')';
	unset($_REQUEST['emp_id']);
	$sql .= " ON DUPLICATE KEY UPDATE ";
	foreach($_REQUEST as $k=>$v){
		$sql .= $k."=VALUES(".$k."),";
	}
	$sql = substr($sql,0,-1);
	
	//var_dump($sql);
	
	if($dbc->query($sql)){
		//updateEmployeesForPayroll($cid);

		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}
