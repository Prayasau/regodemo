<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');


	$empid = $_REQUEST['empid'];
	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];

	$data=array();
	$getMonthdata = $dbc->query("SELECT month, sso_employee, pvf_employee FROM ".$sessionpayrollDbase." WHERE emp_id = '".$empid."' ");
	if($getMonthdata->num_rows > 0){
		while ($row = $getMonthdata->fetch_assoc()) {
			$data[$row['month']] = $row;
		}

		ob_clean();
		echo json_encode($data);
	}else{
		ob_clean();
		echo 'error';
	}
?>