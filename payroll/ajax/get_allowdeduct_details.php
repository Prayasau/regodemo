<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$checkrow = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$_REQUEST['itemid']."' ");
	if($checkrow->num_rows > 0){

		$row = $checkrow->fetch_assoc();
		ob_clean();
		echo json_encode($row);
	}else{

		ob_clean();
		echo 'error';
	}
?>