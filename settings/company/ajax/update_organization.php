<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';

	//die('dd');
	
	if(isset($_REQUEST) && is_array($_REQUEST)){
	
		$sql = "INSERT INTO ".$cid."_organization (apply, company, locations, divisions, departments, teams) VALUES ";
		foreach($_REQUEST['company'] as $k=>$v){

				$loca = isset($_REQUEST['location'][$k]) ? $_REQUEST['location'][$k] : '';
				$divi = isset($_REQUEST['divisions'][$k]) ? $_REQUEST['divisions'][$k] : '';
				$dept = isset($_REQUEST['departments'][$k]) ? $_REQUEST['departments'][$k] : '';
				$team = isset($_REQUEST['teams'][$k]) ? $_REQUEST['teams'][$k] : '';
			
				$sql .= "('1',";
				$sql .= "'".$dbc->real_escape_string($v)."',";
				$sql .= "'".$dbc->real_escape_string($loca)."',";
				$sql .= "'".$dbc->real_escape_string($divi)."',";
				$sql .= "'".$dbc->real_escape_string($dept)."',";
				$sql .= "'".$dbc->real_escape_string($team)."'),";	
		}
		
		$sql = substr($sql,0,-1);
		
		if($dbc->query($sql)){
			ob_clean();
			echo 'success';
		}else{
			ob_clean();
			echo mysqli_error($dbc);
		}
	}else{
		ob_clean();
		echo 'success';
	}

?>