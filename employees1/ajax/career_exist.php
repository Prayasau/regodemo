<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	$date = $_REQUEST['dval'];
	$date_month = date('m', strtotime($date));

	$exist = 0;
	$checkSQl = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE month = '".$date_month."' AND emp_id = '".$_SESSION['rego']['empID']."' ");
	if($checkSQl->num_rows > 0){
		$exist = 1;
	}

	ob_clean();
	echo $exist;

?>