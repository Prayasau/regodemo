<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;

	$batchId = $_REQUEST['dataID'];
	$fieldValue = $_REQUEST['fieldValue'];




	$sql = "SELECT * FROM ".$cid."_temp_log_history WHERE batch_no = '".$batchId."' AND field = '".$fieldValue."'";

	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$dataArray[] = $row;
		}
	}
	
	

	echo json_encode($dataArray);
	// echo '<pre>';
	// print_r($dataArray);
	// echo '</pre>';
	// die();

?>
