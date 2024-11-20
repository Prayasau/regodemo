<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");




	// get saved data from database 

		$sql_get = "SELECT * FROM ".$cid."_sys_settings";
		if($res_get = $dbc->query($sql_get)){
			if($row_get = $res_get->fetch_assoc()){
				$data_id_prefix = unserialize($row_get['id_prefix']);
			}
		}


		$_REQUEST[$_REQUEST['idPrefix']] = $_REQUEST;
		unset($_REQUEST['idPrefix']);
		unset($_REQUEST['startCount']);


		if($data_id_prefix != '')
		{
			$output = array_merge($data_id_prefix, $_REQUEST);
		}
		else
		{
			$output = $_REQUEST;
		}


		$sql = "UPDATE ".$cid."_sys_settings SET id_prefix = '".$dbc->real_escape_string(serialize($output))."'";
		
		if($dbc->query($sql)){
			ob_clean();
			echo 'success';
		}else{
			ob_clean();
			echo mysqli_error($dbc);
		}
		














