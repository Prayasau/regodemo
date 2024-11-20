<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$availableTeams= $_POST['availableTeams'];


	// get positions from the databse position 

	$sql_positions = "SELECT * FROM ".$cid."_positions  ";


	if($res_positions = $dbc->query($sql_positions)){
		while($row_positions = $res_positions->fetch_assoc()){

			$empPositions[$row_positions['id']] = $row_positions['en'];

		}
	}	


	$sql = "SELECT emp_id_editable,en_name,position,teams FROM ".$cid."_employees WHERE teams = '".$availableTeams."' ";


	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){


			if($row['emp_id_editable'] === NULL){ 
				$employeeID = '';
			}else{
				$employeeID = $row['emp_id_editable'];
			}


			$empArray[] = array(

				'emp_id_editable' =>  $employeeID,
				'en_name' => $row['en_name'],
				'position' => $empPositions[$row['position']],
				'teams' => $row['teams'],
			);

		}
	}





			
	ob_clean();
	echo json_encode($empArray);


?>
