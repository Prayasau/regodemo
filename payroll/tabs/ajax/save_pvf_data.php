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
	foreach($fixedforMonth as $k1 => $v1) {

		if($k1==58){ //for PVF Employee
			$condition='';
			for ($i=1; $i <=12 ; $i++) { 
				if($i >= $_SESSION['rego']['cur_month']){
					$condition .= " `".$months_column[$i]."`='".$_REQUEST['pvfemp'][$i]."', ";
				}
			}

			$updsql1="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['pvfemp'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['pvfemp'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND allow_deduct_ids='".$k1."'";
			$dbc->query($updsql1);
		}
	}

	if(isset($_REQUEST['pvfcom'])){ //For PVF Employer

		$condition='';
		for ($i=1; $i <=12 ; $i++) { 
			if($i >= $_SESSION['rego']['cur_month']){
				$condition .= " `".$months_column[$i]."`='".$_REQUEST['pvfcom'][$i]."', ";
			}
		}

		$updsql3="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['pvfcom'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['pvfcom'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND classifications='3' ";
		$dbc->query($updsql3);
	}


	if(!empty($_REQUEST)){

		$upsql = "UPDATE ".$sessionpayrollDbase." SET calc_pvf = '".$_REQUEST['pvf_calc_pvf']."', perc_thb_pvf = '".$_REQUEST['pf_paidby_pvf']."', pvf_emp_calc = '".$_REQUEST['pvfemp'][$_SESSION['rego']['cur_month']]."', pvf_employee = '".$_REQUEST['pvfemp'][$_SESSION['rego']['cur_month']]."', pvf_comp_calc = '".$_REQUEST['pvfcom'][$_SESSION['rego']['cur_month']]."', pvf_company = '".$_REQUEST['pvfcom'][$_SESSION['rego']['cur_month']]."' WHERE emp_id = '".$_REQUEST['empid']."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$_REQUEST['mid']."' ";
		$dbc->query($upsql);

		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}

?>