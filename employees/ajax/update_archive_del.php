<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");


	$explodeArr = explode(",", $_REQUEST['empid']);

	foreach ($explodeArr as $key => $value) {
	
		$dbc->query("DELETE FROM ".$cid."_employees WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_allow_deduct WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_career WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_discipline WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_equipment WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_events WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_log WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_medical WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_training WHERE emp_id = '".$value."'");
		$dbc->query("DELETE FROM ".$cid."_employee_privileges WHERE emp_id = '".$value."'");
	}

	ob_clean();
	echo "success";
	
	
?>	
