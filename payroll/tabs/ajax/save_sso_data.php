<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	$sessionpayrollDataTable = $_SESSION['rego']['cid'].'_payroll_data_'.$_SESSION['rego']['cur_year'];
	/*echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';
	die('sd');*/

	$months_column = array(1=>"jan", 2=>"feb", 3=>"mar", 4=>"apr", 5=>"may", 6=>"jun", 7=>"jul", 8=>"aug", 9=>"sep", 10=>"oct", 11=>"nov", 12=>"dec");

	$fixedforMonth = getPayrollfixedAlloDeductMonth($_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']);
	$fullyear_ssoemployee=0;
	$fullyear_ssobycompany=0;
	foreach($fixedforMonth as $k1 => $v1) {

		if($k1==57){ //for SSO Employee
			$condition='';
			for ($i=1; $i <=12 ; $i++) { 
				if($i >= $_SESSION['rego']['cur_month']){
					$condition .= " `".$months_column[$i]."`='".$_REQUEST['ssothb'][$i]."', ";
				}

				$fullyear_ssoemployee += $_REQUEST['ssothb'][$i];
			}

			$updsql1="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['ssothb'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['ssothb'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND allow_deduct_ids='".$k1."'";
			$dbc->query($updsql1);

		}elseif($k1==28){ //for SSO by Company
			$condition='';
			for ($i=1; $i <=12 ; $i++) { 
				if($i >= $_SESSION['rego']['cur_month']){
					$condition .= " `".$months_column[$i]."`='".$_REQUEST['ssobycompany'][$i]."', ";
				}

				$fullyear_ssobycompany += $_REQUEST['ssobycompany'][$i];
			}

			$updsql2="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['ssobycompany'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['ssobycompany'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND allow_deduct_ids='".$k1."'";
			$dbc->query($updsql2);

		}
	}

	if(isset($_REQUEST['ssoemployr'])){ //For SSO Employer

		$condition='';
		for ($i=1; $i <=12 ; $i++) { 
			if($i >= $_SESSION['rego']['cur_month']){
				$condition .= " `".$months_column[$i]."`='".$_REQUEST['ssoemployr'][$i]."', ";
			}
		}

		$updsql3="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['ssoemployr'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['ssoemployr'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND classifications='2' ";
		$dbc->query($updsql3);
	}
	//die('dfdfdf');
	//====== Update in Payroll table ========//
	if(!empty($_REQUEST)){

		$upsql4 = "UPDATE ".$sessionpayrollDbase." SET calc_sso = '".$_REQUEST['ss_calc_sso']."', sso_by = '".$_REQUEST['ss_paidby_sso']."', sso_employee = '".$_REQUEST['ssothb'][$_SESSION['rego']['cur_month']]."', sso_by_company = '".$_REQUEST['ssobycompany'][$_SESSION['rego']['cur_month']]."', sso_company = '".$_REQUEST['ssoemployr'][$_SESSION['rego']['cur_month']]."', full_year_sso_employee = '".$fullyear_ssoemployee."', full_year_sso_by_company = '".$fullyear_ssobycompany."'  WHERE emp_id = '".$_REQUEST['empid']."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$_REQUEST['mid']."' ";
		$dbc->query($upsql4);

		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}

?>