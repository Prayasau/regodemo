<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	//include(DIR.'files/payroll_functions.php');

	$comp_select = $_REQUEST['comp_select'];
	$selrbbranch = $_REQUEST['selrbbranch'];

	$getCompany = getEntities();
	$data['companyInfo'] = $getCompany[$comp_select];
	$data['companyRB'] = unserialize($getCompany[$comp_select]['revenu_branch']);
	$data['companyBank'] = unserialize($getCompany[$comp_select]['banks']);

	$data['revenuBranch'] = array();
	$sel = $dbc->query("SELECT * FROM ".$cid."_branches_data WHERE entity='".$comp_select."' AND revenu_branch_code='".$selrbbranch."'");
	if($sel->num_rows > 0){
		$row = $sel->fetch_assoc();
		$data['revenuBranch'] = $row;
	}

	ob_clean();
	echo json_encode($data);

?>