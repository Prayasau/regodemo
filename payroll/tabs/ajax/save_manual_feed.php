<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// die('stop');

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	foreach($_REQUEST['emp'] as $key => $value) {

			$dataTotal['total'] = array();
			foreach ($value['allow_deduct']['hrs'] as $k => $v) {
				if($v != ''){
					$dataTotal['total'][$k] = str_replace(',', '', $value['total'][$k]);
				}
			}

			foreach ($value['allow_deduct']['times'] as $k => $v) {
				if($v != ''){
					$dataTotal['total'][$k] = str_replace(',', '', $value['total'][$k]);
				}
			}

			foreach ($value['allow_deduct']['thb'] as $k => $v) {
				if($v != ''){
					$dataTotal['total'][$k] = str_replace(',', '', $value['total'][$k]);
				}
			}

			//calculate salary for day contract
			$getpayrollinfoModalWise = getpayrollinfoModalWise($key, $_SESSION['rego']['cur_month'], $_REQUEST['payroll_mdl_id']);

			$condition='';
			if($getpayrollinfoModalWise[0]['contract_type'] == 'day'){
				$paiddays = $value['paidDays'];
				$daily_rate = $getpayrollinfoModalWise[0]['day_daily_wage'];
				$paid_hours = decimalHours($value['paidHours']); 
				//$rate_hrs = ($getpayrollinfoModalWise[0]['day_daily_wage'] / $paid_hours);
				$rate_hr = round($getpayrollinfoModalWise[0]['rate_hr'],2);
				$total_salary = ($paiddays*$daily_rate) + ($paid_hours*$rate_hr);
				if($total_salary <= 0){$total_salary=0;}

				$condition = "mf_salary='".$total_salary."', paid_days='".$paiddays."', ";
			}

			$upsql = "UPDATE ".$sessionpayrollDbase." SET ".$condition." mf_paid_hour = '".$value['paidHours']."',  manual_feed_data = '".serialize($value['allow_deduct'])."', manual_feed_total = '".serialize($dataTotal['total'])."' WHERE emp_id = '".$key."' AND payroll_modal_id = '".$_REQUEST['payroll_mdl_id']."' AND month = '".$_SESSION['rego']['cur_month']."' ";
			$dbc->query($upsql);
		
	}

	ob_clean();
	echo 'success';

?>