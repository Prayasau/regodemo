<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');

	$sqlR = $dbc->query("SELECT * FROM ".$cid."_payroll_models WHERE id = '".$_REQUEST['row_id']."'");
	if($sqlR->num_rows > 0){
		$sql = "UPDATE ".$cid."_payroll_models SET `payroll_opt`='".$_REQUEST['payroll_opt']."', `field_opt`='".$_REQUEST['field_opt']."', `salary_split`='".$_REQUEST['salary_split']."', `periods_def`='".$_REQUEST['periods_def']."', `periods_set`='".$_REQUEST['periods_set']."', `use_sso_pnd_def`='".$_REQUEST['use_sso_pnd_def']."', `use_manual_rate_def`='".$_REQUEST['use_manual_rate_def']."', `use_othr_setting_def`='".$_REQUEST['use_othr_setting_def']."' WHERE id = '".$_REQUEST['row_id']."' ";
	
		if($dbc->query($sql)){
			ob_clean();
			echo 'success';
		}else{
			ob_clean();
			echo mysqli_error($dbc);
		}
	}else{
		ob_clean();
		echo 'Error: Model not found';
	}

?>