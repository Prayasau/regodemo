<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	//var_dump($_REQUEST); exit;
	//$field = $_REQUEST['field'];
	if(empty($_REQUEST['emp_id'])){exit;}

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';

	// die();
	// echo serialize($_REQUEST['emp_fixa_curr']);
	// echo '<br>';
	// echo serialize($_REQUEST['emp_fixd_curr']);
	// exit;

	//var_dump($_FILES); //exit;
	//$getAllowDedctName = getAllowDedctName();


	$dir = DIR.$cid.'/career/';
  	if(!file_exists($dir)){
   		mkdir($dir);
	}
	
	if(!empty($_FILES['attachment_curr']['tmp_name'][0])){
		$sql = "SELECT attachments FROM ".$cid."_employee_career WHERE id = '".$_REQUEST['career_id_curr']."'";
		if($res = $dbc->query($sql)){
			$row = $res->fetch_assoc();
			if(!empty($row['attachments'])){
				$_REQUEST['attachments'] = unserialize($row['attachments']);
			}
		}
		foreach($_FILES['attachment_curr']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments'][] = $filename;	
			}
		}

		
		$_REQUEST['attachments_curr'] = serialize($_REQUEST['attachments']);
		
				
	}

	
	if(!empty($_FILES['attachment_new']['tmp_name'][0])){
		
		foreach($_FILES['attachment_curr']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments'][] = $filename;	
			}
		}
		
		$_REQUEST['attachments_new'] = serialize($_REQUEST['attachments']);
	}


	//$start_date_curr_month = date('m', strtotime($_REQUEST['start_date_curr']));
	
	$_REQUEST['start_date_curr'] = date('Y-m-d', strtotime($_REQUEST['start_date_curr']));

	if($_REQUEST['career_id_curr'] !=''){

		// $USQl = $dbc->query("UPDATE ".$cid."_employee_career SET start_date='".$_REQUEST['start_date_curr']."', end_date='".$_REQUEST['end_date_curr']."', position='".$_REQUEST['position_curr']."', salary='".$_REQUEST['salary_curr']."', fix_allow='".serialize($_REQUEST['emp_fixa_curr'])."', fix_deduct='".serialize($_REQUEST['emp_fixd_curr'])."', other_benifits='".$_REQUEST['other_benifits_curr']."', remarks='".$_REQUEST['remarks_curr']."', attachments='".$_REQUEST['attachments_curr']."', head_branch='".$_REQUEST['head_branch_cur']."', head_division='".$_REQUEST['head_division_cur']."', head_department='".$_REQUEST['head_department_curr']."', team_supervisor='".$_REQUEST['team_supervisor_curr']."' WHERE id = '".$_REQUEST['career_id_curr']."' ");
		$USQl = $dbc->query("UPDATE ".$cid."_employee_career SET start_date='".$_REQUEST['start_date_curr']."', end_date='".$_REQUEST['end_date_curr']."', position='".$_REQUEST['position_curr']."', salary='".$_REQUEST['salary_curr']."', fix_allow='".serialize($_REQUEST['emp_fixa_curr'])."', fix_deduct='".serialize($_REQUEST['emp_fixd_curr'])."', other_benifits='".$_REQUEST['other_benifits_curr']."', remarks='".$_REQUEST['remarks_curr']."' WHERE id = '".$_REQUEST['career_id_curr']."' ");
	}

	if($_REQUEST['start_date_new'] !=''){



		$_REQUEST['start_date_new'] = date('Y-m-d', strtotime($_REQUEST['start_date_new']));
		$start_date_new_month = date('m', strtotime($_REQUEST['start_date_new']));
		$checkSQl = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$_REQUEST['emp_id']."' AND month = '".$start_date_new_month."' ");
		if($checkSQl->num_rows > 0){
			//nothing to do...
		}else{
			
			// $USQl = $dbc->query("INSERT INTO ".$cid."_employee_career (`month`, `emp_id`, `position`, `fix_allow`, `fix_deduct`, `start_date`, `end_date`, `salary`, `other_benifits`, `remarks`, `attachments`, `head_branch`, `head_division`, `head_department`, `team_supervisor`) VALUES ('".$start_date_new_month."', '".$_REQUEST['emp_id']."', '".$_REQUEST['position_new']."', '".serialize($_REQUEST['emp_fixa_new'])."', '".serialize($_REQUEST['emp_fixd_new'])."', '".$_REQUEST['start_date_new']."', '".$_REQUEST['end_date_new']."', '".$_REQUEST['salary_new']."', '".$_REQUEST['other_benifits_new']."', '".$_REQUEST['remarks_new']."', '".$_REQUEST['attachments_new']."', '".$_REQUEST['head_branch_new']."', '".$_REQUEST['head_division_new']."', '".$_REQUEST['head_department_new']."', '".$_REQUEST['team_supervisor_new']."')"); 
			$USQl = $dbc->query("INSERT INTO ".$cid."_employee_career (`month`, `emp_id`, `position`, `fix_allow`, `fix_deduct`, `start_date`, `end_date`, `salary`, `other_benifits`, `remarks`) VALUES ('".$start_date_new_month."', '".$_REQUEST['emp_id']."', '".$_REQUEST['position_new']."', '".serialize($_REQUEST['emp_fixa_new'])."', '".serialize($_REQUEST['emp_fixd_new'])."', '".$_REQUEST['start_date_new']."', '".$_REQUEST['end_date_new']."', '".$_REQUEST['salary_new']."', '".$_REQUEST['other_benifits_new']."', '".$_REQUEST['remarks_new']."')"); 

			if($_REQUEST['career_id_curr'] !=''){
				$end_date_curr = date('d-m-Y', strtotime($_REQUEST['start_date_new'] . '-1 days'));
				$USQl = $dbc->query("UPDATE ".$cid."_employee_career SET end_date='".$end_date_curr."' WHERE id='".$_REQUEST['career_id_curr']."' ");
			}
		}
	}

	$data['result'] = 'success';
	echo json_encode($data);
	
?>	
