<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$selectShiftplan= $_POST['selectShiftplan'];

	


	$sql = "SELECT * FROM ".$cid."_leave_time_settings WHERE id = '1' ";

	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){

			$shiftPlan = unserialize($row['shiftplan']);

		}
	}


	$selectedPlan = $shiftPlan[$selectShiftplan];
	
	// $planValues = $shiftplan[$selectShiftplan];

			
	ob_clean(); 
	echo json_encode($selectedPlan);


?>
