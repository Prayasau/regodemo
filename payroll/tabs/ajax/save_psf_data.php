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

		if($k1==59){ //for PSF Employee
			$condition='';
			for ($i=1; $i <=12 ; $i++) { 
				if($i >= $_SESSION['rego']['cur_month']){
					$condition .= " `".$months_column[$i]."`='".$_REQUEST['psfemp'][$i]."', ";
				}
			}

			$updsql1="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['psfemp'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['psfemp'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND allow_deduct_ids='".$k1."'";
			$dbc->query($updsql1);
		}
	}

	if(isset($_REQUEST['psfcom'])){ //For PSF Employer

		$condition='';
		for ($i=1; $i <=12 ; $i++) { 
			if($i >= $_SESSION['rego']['cur_month']){
				$condition .= " `".$months_column[$i]."`='".$_REQUEST['psfcom'][$i]."', ";
			}
		}

		$updsql3="UPDATE ".$sessionpayrollDataTable." SET `curr_calc`='".$_REQUEST['psfcom'][$_SESSION['rego']['cur_month']]."', `prev_calc`='0.00', `curr_month`='".$_REQUEST['psfcom'][$_SESSION['rego']['cur_month']]."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$_REQUEST['mid']."' AND emp_ids='".$_REQUEST['empid']."' AND classifications='4' ";
		$dbc->query($updsql3);
	}

	if(!empty($_REQUEST)){

		$upsql = "UPDATE ".$sessionpayrollDbase." SET calc_psf = '".$_REQUEST['psf_calc_sso']."', perc_thb_psf='".$_REQUEST['pf_paidby_psf']."', psf_emp_calc = '".$_REQUEST['psfemp'][$_SESSION['rego']['cur_month']]."', psf_employee = '".$_REQUEST['psfemp'][$_SESSION['rego']['cur_month']]."', psf_comp_calc = '".$_REQUEST['psfcom'][$_SESSION['rego']['cur_month']]."', psf_company = '".$_REQUEST['psfcom'][$_SESSION['rego']['cur_month']]."' WHERE emp_id = '".$_REQUEST['empid']."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$_REQUEST['mid']."'";
		$dbc->query($upsql);

		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}

?>