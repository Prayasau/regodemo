<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$res = $dba->query("SELECT * FROM rego_rewards_penalties WHERE id = '".$_REQUEST['id']."'"); 
	if($row = $res->fetch_assoc()){
		$data = $row;
		$data['Allposition'] = explode(',', $row['all_position']);
		$data['Allshedule'] = explode(',', $row['all_shedule']);
	}else{
		echo 'Error';
	}
	//var_dump($data); exit;
	ob_clean();
	echo json_encode($data);
	exit;
?>


















