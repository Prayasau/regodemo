<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	//var_dump($_REQUEST); exit;
	//$field = $_REQUEST['field'];
	// if(empty($_REQUEST['emp_id'])){exit;}


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
	
	if(!empty($_FILES['attachment_curr2']['tmp_name'][0])){
		$sql = "SELECT attachments FROM ".$cid."_employee_career WHERE id = '".$_REQUEST['career_id_curr2']."'";
		if($res = $dbc->query($sql)){
			$row = $res->fetch_assoc();
			if(!empty($row['attachments'])){
				$_REQUEST['attachments2'] = unserialize($row['attachments']);
			}
		}
		foreach($_FILES['attachment_curr2']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr2']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments2'][] = $filename;	
			}
		}

		
		$_REQUEST['attachments_curr2'] = serialize($_REQUEST['attachments2']);
		
				
	}

	
	if(!empty($_FILES['attachment_new2']['tmp_name'][0])){
		
		foreach($_FILES['attachment_curr2']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr2']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments2'][] = $filename;	
			}
		}
		
		$_REQUEST['attachments_new2'] = serialize($_REQUEST['attachments2']);
	}


	//$start_date_curr_month = date('m', strtotime($_REQUEST['start_date_curr']));
	
	$_REQUEST['start_date_curr2'] = date('Y-m-d', strtotime($_REQUEST['start_date_curr2']));

	if($_REQUEST['career_id_curr2'] !=''){

		 $USQl = $dbc->query("UPDATE ".$cid."_employee_career SET start_date='".$_REQUEST['start_date_curr2']."', end_date='".$_REQUEST['end_date_curr2']."', position='".$_REQUEST['position_curr2']."', salary='".$_REQUEST['salary_curr2']."', fix_allow='".serialize($_REQUEST['emp_fixa_curr2'])."', fix_deduct='".serialize($_REQUEST['emp_fixd_curr2'])."', other_benifits='".$_REQUEST['other_benifits_curr']."', remarks='".$_REQUEST['remarks_curr']."', attachments='".$_REQUEST['attachments_curr2']."', head_branch='".$_REQUEST['head_branch_cur2']."', head_division='".$_REQUEST['head_division_cur2']."', head_department='".$_REQUEST['head_department_curr2']."', team_supervisor='".$_REQUEST['team_supervisor_curr2']."' WHERE id = '".$_REQUEST['career_id_curr2']."' ");
	}

	if($_REQUEST['start_date_new2'] !=''){



		$_REQUEST['start_date_new2'] = date('Y-m-d', strtotime($_REQUEST['start_date_new2']));
		$start_date_new_month = date('m', strtotime($_REQUEST['start_date_new2']));
		$checkSQl = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$_REQUEST['emp_id']."' AND month = '".$start_date_new_month."' ");
		if($checkSQl->num_rows > 0){
			//nothing to do...
		}else{
			
			 $USQl = $dbc->query("INSERT INTO ".$cid."_employee_career (`month`, `emp_id`, `position`, `fix_allow`, `fix_deduct`, `start_date`, `end_date`, `salary`, `other_benifits`, `remarks`, `attachments`, `head_branch`, `head_division`, `head_department`, `team_supervisor`) VALUES ('".$start_date_new_month."', '".$_REQUEST['emp_id']."', '".$_REQUEST['position_new2']."', '".serialize($_REQUEST['emp_fixa_new2'])."', '".serialize($_REQUEST['emp_fixd_new2'])."', '".$_REQUEST['start_date_new2']."', '".$_REQUEST['end_date_new2']."', '".$_REQUEST['salary_new2']."', '".$_REQUEST['other_benifits_new2']."', '".$_REQUEST['remarks_new2']."', '".$_REQUEST['attachments_new2']."', '".$_REQUEST['head_branch_new2']."', '".$_REQUEST['head_division_new2']."', '".$_REQUEST['head_department_new2']."', '".$_REQUEST['team_supervisor_new2']."')"); 
			

			if($_REQUEST['career_id_curr2'] !=''){
				$end_date_curr = date('d-m-Y', strtotime($_REQUEST['start_date_new2'] . '-1 days'));
				$USQl = $dbc->query("UPDATE ".$cid."_employee_career SET end_date='".$end_date_curr."' WHERE id='".$_REQUEST['career_id_curr2']."' ");
			}
		}
	}

	$data['result'] = 'success';
	echo json_encode($data);
	
?>	
