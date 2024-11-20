<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$res = $dbc->query("SELECT * FROM ".$cid."_benefit_models WHERE id = '".$_REQUEST['selectComModel']."'"); 
	if($row = $res->fetch_assoc()){
		$data = $row;
		$data = unserialize($row['all_data']);

	}else{
		$data = 'Error';
	}
	//var_dump($data); exit;
	ob_clean();
	echo json_encode($data);
	exit;
?>