<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	// declare months array 
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




	$dateperiod = date('Y-m-d',strtotime($_REQUEST['dateperiod']));
	$from2 = $_REQUEST['from2'];
	$until2 = $_REQUEST['until2'];
	$break = $_REQUEST['break'];
	$hours_field = $_REQUEST['hours_field'];
	$availableTeams = $_REQUEST['availableTeams'];
	$selectShiftplan = $_REQUEST['selectShiftplan'];
	$plan_from = $_REQUEST['plan_from'];
	$plan_until = $_REQUEST['plan_until'];
	$selectedComp = $_REQUEST['selectedComp'];
	$type= 'ot';










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







	$searlizedArray = array(

		'date' => $dateperiod ,
		'shiftteam' => $availableTeams ,
		'plan' => $selectShiftplan ,
		'plan_f1' => $plan_from ,
		'plan_u2' => $plan_until ,
		'ot_from' => $from2 ,
		'ot_until' => $until2 ,
		'ot_break' => $break ,
		'hours' => $hours_field ,
		'type' => $type ,
		'compensations' => $selectedComp ,
		 $selectedComp => '1',

	);




	$sql = "INSERT INTO ".$cid."_ot_plans (date, shiftteam, plan, plan_f1, plan_u2, ot_from,ot_until,ot_break,hours,type,compensations,serialized) VALUES (
		'".$dbc->real_escape_string($dateperiod)."', 
		'".$dbc->real_escape_string($availableTeams)."', 
		'".$dbc->real_escape_string($selectShiftplan)."', 
		'".$dbc->real_escape_string($plan_from)."', 
		'".$dbc->real_escape_string($plan_until)."', 
		'".$dbc->real_escape_string($from2)."', 
		'".$dbc->real_escape_string($until2)."', 
		'".$dbc->real_escape_string($break)."', 
		'".$dbc->real_escape_string($hours_field)."', 
		'".$dbc->real_escape_string($type)."', 
		'".$dbc->real_escape_string($selectedComp)."', 
		'".$dbc->real_escape_string(serialize($searlizedArray))."')";
	
	// ob_clean();
	// $dbc->query($sql1));
	
	
	// die();

	// $sql = "INSERT INTO ".$cid."_employees (ot_plan, month, date, rego_id,emp_id, en_name, th_name, ot_from, ot_until, ot_hours, ot_break, shiftteam, position, ot_compensations) VALUES (
	// 	'".$dbc->real_escape_string($selectShiftplan)."', 
	// 	'".$dbc->real_escape_string($date)."', 
	// 	'".$dbc->real_escape_string($dateperiod)."', 
	// 	'".$dbc->real_escape_string($regoid)."', 
	// 	'".$dbc->real_escape_string($emp_id)."', 
	// 	'".$dbc->real_escape_string($en_name)."', 
	// 	'".$dbc->real_escape_string($th_name)."', 
	// 	'".$dbc->real_escape_string($from2)."', 
	// 	'".$dbc->real_escape_string($until2)."', 
	// 	'".$dbc->real_escape_string($hours_field)."', 
	// 	'".$dbc->real_escape_string($break)."', 
	// 	'".$dbc->real_escape_string($availableTeams)."', 
	// 	'".$dbc->real_escape_string($position)."', 
	// 	'".$dbc->real_escape_string($selectedComp)."', 
	// 	'".$dbc->real_escape_string(serialize($searlizedArray))."')";
	
	ob_clean();
	if($dbc->query($sql)){
		echo 'success';
	}else{
		echo mysqli_error($dbc);
	}
	exit;
	
	
?>
















