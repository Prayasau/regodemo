<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");


	$sql_get = "SELECT * FROM rego_default_settings";
	if($res_get = $dba->query($sql_get)){
		if($row_get = $res_get->fetch_assoc()){
			$data_id_prefix = unserialize($row_get['id_prefix']);
		}
	}


	echo json_encode($data_id_prefix[$_REQUEST['selectedPrefix']]);









