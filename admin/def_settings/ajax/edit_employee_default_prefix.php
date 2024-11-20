<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");




	// get saved data from database 

		$sql_get = "SELECT * FROM rego_default_settings";
		if($res_get = $dba->query($sql_get)){
			if($row_get = $res_get->fetch_assoc()){
				$data_id_prefix = unserialize($row_get['id_prefix']);
			}
		}


		unset($data_id_prefix[$_REQUEST['keyToUpdate']]);	
		unset($_REQUEST['keyToUpdate']);

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


		$sql = "UPDATE rego_default_settings SET id_prefix = '".$dba->real_escape_string(serialize($output))."' WHERE id = '1' ";
		
		if($dba->query($sql)){
			ob_clean();
			echo 'success';
		}else{
			ob_clean();
			echo mysqli_error($dba);
		}
		














