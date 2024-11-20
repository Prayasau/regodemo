<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;

	$fieldsId = $_REQUEST['dataID'];



	$sql = "SELECT DISTINCT emp_id FROM ".$cid."_temp_log_history WHERE batch_no = '".$fieldsId."'";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$dataArray[$row['emp_id']] = $row['emp_id'];
		}
	}
	
	foreach ($dataArray as $key => $value) {

		$sql1 = "SELECT  DISTINCT emp_id, en_name FROM ".$cid."_temp_log_history WHERE emp_id = '".$key."'";
		if($res1 = $dbc->query($sql1)){
			while($row1 = $res1->fetch_assoc()){
				$dataArray2[] = $row1;
			}
		}
	}

	echo json_encode($dataArray2);
	// echo '<pre>';
	// print_r($dataArray2);
	// echo '</pre>';
	// die();

?>
