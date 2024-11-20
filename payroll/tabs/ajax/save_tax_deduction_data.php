<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];

	if(!empty($_REQUEST)){

		//$upsql = "UPDATE ".$sessionpayrollDbase." SET `tax_standard_deduction`='".$_REQUEST['subtotal_std']."',`standard_deduction_manual`='".$_REQUEST['td_manual_std']."', `standard_deduction_total`='".$_REQUEST['td_std_deduct']."', `tax_personal_allowance`='".$_REQUEST['subtotal_pcare']."', `personal_care_manual`='".$_REQUEST['td_manual_pcare']."', `personal_care_total`='".$_REQUEST['td_pcare_deduct']."', `tax_allow_pvf`='".$_REQUEST['td_subtotal_pvf']."', `allow_pvf_manual`='".$_REQUEST['td_manual_pvfd']."', `allow_pvf_total`='".$_REQUEST['td_pvf_deduct']."', `tax_allow_sso`='".$_REQUEST['td_subtotal_sso']."', `allow_sso_manual`='".$_REQUEST['td_manual_ssod']."', `allow_sso_total`='".$_REQUEST['td_sso_deduct']."' WHERE emp_id = '".$_REQUEST['empids']."' AND month = '".$_SESSION['rego']['cur_month']."' ";
		$upsql = "UPDATE ".$sessionpayrollDbase." SET `standard_deduction_manual`='".$_REQUEST['td_manual_std']."', `standard_deduction_total`='".$_REQUEST['td_std_deduct']."', `personal_care_manual`='".$_REQUEST['td_manual_pcare']."', `personal_care_total`='".$_REQUEST['td_pcare_deduct']."', `total_yearly_tax_deductions`='".$_REQUEST['total_yearly_tax_deductions']."' WHERE emp_id = '".$_REQUEST['empids']."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$_REQUEST['mid']."' ";
		$dbc->query($upsql);

		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}

?>