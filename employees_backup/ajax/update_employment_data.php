<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	// include(DIR.'files/functions.php');


	if(empty($_REQUEST['emp_id'])){exit;}


	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';

	// die();

	// update data in employee table 
	// add a entry in carrer table 

	$noticeDate = date('Y-m-d', strtotime($_REQUEST['notice_day_field']));

	// UPDATE INTO EMPLOYEE TABLE 
	$USQl = $dbc->query("UPDATE ".$cid."_employees SET emp_status='".$_REQUEST['emp_status2']."', resign_reason='".$_REQUEST['end_of_employment_reason']."', notice_date = '".$_REQUEST['notice_day_field']."' WHERE emp_id = '".$_REQUEST['emp_id']."' ");

	// INSERT INRO EMPLOYEE CAREER TABLE 



	// $USQl = $dbc->query("UPDATE ".$cid."_employee_career end_date='".$_REQUEST['end_date_curr']."', attachments='".$_REQUEST['attachments_curr']."', head_branch='".$_REQUEST['head_branch_cur']."', head_division='".$_REQUEST['head_division_cur']."', head_department='".$_REQUEST['head_department_curr']."', team_supervisor='".$_REQUEST['team_supervisor_curr']."', position='".$_REQUEST['position_curr']."' WHERE id = '".$_REQUEST['career_id_curr']."' ");

	
	$data['result'] = 'success';
	echo json_encode($data);


	
?>	
