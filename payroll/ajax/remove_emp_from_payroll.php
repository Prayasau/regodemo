<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$id = $_REQUEST['emp_id'];
	$mid = $_REQUEST['mid'];
	$month = $_SESSION['rego']['cur_month'];
	//$result = "DELETE FROM ".$_SESSION['rego']['payroll_dbase']." WHERE id='".$id."' AND month='".$_SESSION['rego']['cur_month']."'";
	$result = "DELETE FROM ".$_SESSION['rego']['cid']."_payroll_".$_SESSION['rego']['cur_year']." WHERE emp_id='".$id."' AND month='".$month."' AND payroll_modal_id='".$mid."' ";
	$dbc->query($result);

	//Remove data from payroll data table
	$result1 = "DELETE FROM ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." WHERE emp_ids='".$id."' AND months='".$month."' AND payroll_modal_ids='".$mid."' ";
	$dbc->query($result1);

	ob_clean();
	echo 'success';

?>