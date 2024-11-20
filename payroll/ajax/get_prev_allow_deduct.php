<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'files/array_'.$lang.'.php');


	$empid = $_REQUEST['empid'];
	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];

	$data=array();
	$getMonthdata = $dbc->query("SELECT * FROM ".$sessionpayrollDbase." WHERE emp_id = '".$empid."' AND month < '".$_SESSION['rego']['cur_month']."' ");
	if($getMonthdata->num_rows > 0){
		while ($row = $getMonthdata->fetch_assoc()) {
			$data['otherinfo'][$row['month']] = $row;

			$data[$row['month']] = isset($row['manual_feed_data']) ? unserialize($row['manual_feed_data']) : 0;
			$data[$row['month']] = isset($row['manual_feed_total']) ? unserialize($row['manual_feed_total']) : 0;
		}

		ob_clean();
		echo json_encode($data);
	}else{
		ob_clean();
		echo 'error';
	}
?>