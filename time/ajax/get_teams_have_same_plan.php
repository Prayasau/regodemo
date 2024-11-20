<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$selectShiftplan= $_POST['selectShiftplan'];
	$dateperiod= $_POST['dateperiod'];

	$monthArray = array (

		'January' => '1',
		'February' => '2',
		'March' => '3',
		'April' => '4',
		'May' => '5',
		'June' => '6',
		'July' => '7',
		'August' => '8',
		'September' => '9',
		'October' => '10' ,
		'November' => '11',
		'December' => '12',

	);






	$month = date('F', strtotime($dateperiod));
	$date = date('d', strtotime($dateperiod));

	$monthNumeric =  $monthArray[$month];


	if($date == '1' || $date == '2' || $date == '3' || $date == '4' || $date == '5' || $date == '6' || $date == '7' || $date == '8' || $date == '9')
	{
		$date = ltrim($date, '0');
	}
	else
	{
		$date =$date;
	}




	$sql = "SELECT shiftteam_name FROM ".$cid."_monthly_shiftplans_".$cur_year." WHERE month = '".$monthNumeric."' AND D".$date." = '".$selectShiftplan."'";
	
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){

			$teamArray[] = $row['shiftteam_name'];

		
		}
	}



			
	ob_clean();
	echo json_encode($teamArray);


?>
