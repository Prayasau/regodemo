<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	//include(DIR.'files/payroll_functions.php');

	$comp_select = $_REQUEST['comp_select'];
	$sso_branch = $_REQUEST['sso_branch'];

	$getCompany = getEntities();
	$data['companyInfo'] = $getCompany[$comp_select];
	$data['companySSO'] = unserialize($getCompany[$comp_select]['sso_codes']);
	$data['companyBank'] = unserialize($getCompany[$comp_select]['banks']);

	$data['ssoBranch'] = array();
	$sel = $dbc->query("SELECT * FROM ".$cid."_branches_data WHERE entity='".$comp_select."' AND sso_code='".$sso_branch."'");
	if($sel->num_rows > 0){
		$row = $sel->fetch_assoc();
		$data['ssoBranch'] = $row;
	}

	ob_clean();
	echo json_encode($data);

?>