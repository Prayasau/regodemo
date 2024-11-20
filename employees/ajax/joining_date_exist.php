<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	$date = $_REQUEST['joiningDateValue'];
	$emp_idValue = $_REQUEST['emp_idValue'];



	$date_month = date('m', strtotime($date));
	$current_year = $_SESSION['rego']['cur_year']; 

	// $exist = 0;
	$checkSQl = $dbc->query("SELECT * FROM ".$cid."_payroll_".$current_year." WHERE emp_id = '".$emp_idValue."' ");
	if($checkSQl->num_rows > 0){
		$exist = 1;
	}

	ob_clean();
	echo $exist;

?>