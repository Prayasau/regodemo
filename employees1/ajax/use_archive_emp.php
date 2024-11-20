<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	$UseEmpIds = explode(",", $_REQUEST['empid']);

	foreach ($UseEmpIds as $key => $value) {
	
		$dbc->query("UPDATE ".$cid."_employees SET emp_status = '1' WHERE emp_id = '".$value."'");

		$dbc->query("INSERT INTO ".$cid."_employee_log (emp_id, field, prev, new, user) VALUES ('".$value."','Employee status','0','1','".$_SESSION['rego']['name']."' ) ");
	}

	ob_clean();
	echo "success";
	
?>	
