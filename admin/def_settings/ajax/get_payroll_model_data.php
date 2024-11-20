<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$res = $dba->query("SELECT * FROM rego_payroll_models WHERE id = '".$_REQUEST['id']."'"); 
	if($row = $res->fetch_assoc()){
		$data = $row;
		$data['Napply'] = $row['apply'] ? true : false;
		//$data['Ateams'] = explode(',', $row['teams']);
		//$data['all_data'] = unserialize($row['all_data']);

		$data['Cperiods_def'] = $row['periods_def'] ? true : false;
		$data['Cperiods_set'] = $row['periods_set'] ? true : false;
		$data['Cuse_sso_pnd_def'] = $row['use_sso_pnd_def'] ? true : false;
		$data['Cuse_manual_rate_def'] = $row['use_manual_rate_def'] ? true : false;
		$data['Cuse_othr_setting_def'] = $row['use_othr_setting_def'] ? true : false;
		
	}else{
		echo 'Error';
	}
	//var_dump($data); exit;
	ob_clean();
	echo json_encode($data);
	exit;
?>