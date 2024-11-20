<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/payroll_functions.php');

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// die('sdd');
	if($_REQUEST['fi_emp_id'] !=''){

		if(isset($_REQUEST['rate_wages'])){

			$daily_rate = $_REQUEST['day_daily_wage'];
			$paid_hours = decimalHours($_REQUEST['day_daily_hrs']);
			$rate_hrs = ($daily_rate / $paid_hours);
			$rate_hr = round($rate_hrs,2);

			$upsql = "UPDATE $sessionpayrollDbase SET day_daily_wage='".$_REQUEST['day_daily_wage']."', paid_hours='".$_REQUEST['day_daily_hrs']."', rate_hr='".$rate_hr."', rate_wages='".serialize($_REQUEST['rate_wages'])."', thb_wages='".serialize($_REQUEST['thb_wages'])."' WHERE emp_id='".$_REQUEST['fi_emp_id']."' AND payroll_modal_id='".$_REQUEST['fipaymodel_id']."' AND month='".$_SESSION['rego']['cur_month']."' ";
		}else{
			$upsql = "UPDATE $sessionpayrollDbase SET paid_days='".$_REQUEST['fipaiddayss']."', paid_days_manual='".$_REQUEST['fipdmanual']."', paid_days_curr='".$_REQUEST['paiddays_curr']."', paid_days_prev='".$_REQUEST['paiddays_prev']."', incomeCalc_yesno='".serialize($_REQUEST['yeno_ib'])."', incomeCalc_yesno='".serialize($_REQUEST['yeno_ib'])."', incomeCalc_manual='".serialize($_REQUEST['manualAllow'])."', incomeCalc_total='".serialize($_REQUEST['fitotalVal'])."', hrs_curr_wages='".serialize($_REQUEST['hrs_curr_wages'])."', hrs_prev_wages='".serialize($_REQUEST['hrs_prev_wages'])."', times_curr_wages='".serialize($_REQUEST['times_curr_wages'])."' WHERE emp_id='".$_REQUEST['fi_emp_id']."' AND payroll_modal_id='".$_REQUEST['fipaymodel_id']."' AND month='".$_SESSION['rego']['cur_month']."' ";
		}
		
		$dbc->query($upsql);
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}

?>