<?
	if(session_id()==''){session_start();}
	include('../../../dbconnect/db_connect.php');
	include('../../../files/functions.php');


	$getLeaveTimeSettings = getLeaveTimeSettings();
	$working_hours = unserialize($getLeaveTimeSettings['working_hours']);

	// echo '<pre>';
	// print_r($working_hours);
	// echo '</pre>';

	$data = array();
	$ScheduleArr = array();

	foreach($_REQUEST['values'] as $key=>$val){
		foreach($working_hours as $k=>$v){

			if($k == $val){

				$data[$k] = $k;
				$ScheduleArr[$k] = $k;
			}

		}
	}

	$tableRow = '';
	if($data){
		foreach($data as $key=>$val){
			$tableRow .= '<span class="ml-2 font-weight-bold">'.$working_hours[$key]['name'].'</span><br>';
		}
	}


	$result['Allsehedule']  = $ScheduleArr;
	$result['tableRow'] 	= $tableRow;

	echo json_encode($result);

?>